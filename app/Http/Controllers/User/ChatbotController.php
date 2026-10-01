<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Tour;
use App\Models\TourSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Handle incoming chat requests from user interface.
     */
    public function chat(Request $request)
    {
        $message = trim($request->input("message", ""));

        if (!$message) {
            return response()->json([
                "reply" => "Chào bạn! Bạn cần WanderBot tư vấn tour du lịch nào hôm nay ạ?",
                "message" => "Chào bạn! Bạn cần WanderBot tư vấn tour du lịch nào hôm nay ạ?",
            ]);
        }

        $session = $this->getOrCreateSession();
        $this->saveUserMessage($session->id, $message);

        $reply = null;

        // 1. Thử gọi Google Gemini API (Miễn phí 100% nếu có GEMINI_API_KEY trong .env)
        $geminiKey = env("GEMINI_API_KEY") ?: config("services.gemini.key");
        if (!empty($geminiKey)) {
            $reply = $this->callGeminiAPI($message, $session->id, $geminiKey);
        }

        // 2. Thử gọi Groq Cloud API (Miễn phí nếu có GROQ_API_KEY trong .env)
        if (!$reply) {
            $groqKey = env("GROQ_API_KEY") ?: config("services.groq.key");
            if (!empty($groqKey)) {
                $reply = $this->callGroqAPI($message, $session->id, $groqKey);
            }
        }

        // 3. Fallback: Bộ máy tư vấn thông minh tích hợp sẵn (100% Free, tra cứu trực tiếp Tour DB, không cần API Key)
        if (!$reply) {
            $reply = $this->smartFallbackReply($message);
        }

        $this->saveBotMessage($session->id, $reply);

        return response()->json([
            "status" => "success",
            "reply" => $reply,
            "message" => $reply,
        ]);
    }

    /**
     * Server-Sent Events stream support
     */
    public function chatStream(Request $request)
    {
        $message = trim($request->input("message", ""));

        if (!$message) {
            return response('data: {"content": "Chào bạn! Bạn muốn mình tư vấn tour nào ạ?"}' . "\n\n", 200, [
                "Content-Type" => "text/event-stream",
                "Cache-Control" => "no-cache",
                "Connection" => "keep-alive",
            ]);
        }

        $session = $this->getOrCreateSession();
        $this->saveUserMessage($session->id, $message);

        $reply = $this->smartFallbackReply($message);
        $this->saveBotMessage($session->id, $reply);

        return response()->stream(function () use ($reply) {
            $words = explode(" ", $reply);
            $chunk = "";
            foreach ($words as $index => $w) {
                $chunk .= ($index > 0 ? " " : "") . $w;
                if ($index % 4 === 0 || $index === count($words) - 1) {
                    echo "data: " . json_encode(["content" => $chunk]) . "\n\n";
                    $chunk = "";
                    if (ob_get_level() > 0) ob_flush();
                    flush();
                    usleep(30000);
                }
            }
            echo "data: " . json_encode(["content" => "[DONE]"]) . "\n\n";
            if (ob_get_level() > 0) ob_flush();
            flush();
        }, 200, [
            "Content-Type" => "text/event-stream",
            "Cache-Control" => "no-cache",
            "Connection" => "keep-alive",
            "X-Accel-Buffering" => "no",
        ]);
    }

    /**
     * Lấy lịch sử hội thoại
     */
    public function history()
    {
        $session = $this->getOrCreateSession();

        $messages = ChatMessage::where("session_id", $session->id)
            ->orderBy("id", "asc")
            ->get()
            ->map(fn ($m) => [
                "role" => $m->sender_type,
                "message" => $m->message,
            ]);

        return response()->json([
            "status" => "success",
            "history" => $messages,
            "messages" => $messages,
        ]);
    }

    /**
     * Tích hợp Google Gemini 1.5 Flash (Free Tier: 15 RPM, 1500 req/ngày từ aistudio.google.com)
     */
    private function callGeminiAPI($userMessage, $sessionId, $apiKey)
    {
        try {
            $context = $this->buildTourContext();
            $recentHistory = $this->getRecentHistoryFromDB($sessionId);

            $systemPrompt = "Bạn là WanderBot - Trợ lý du lịch và tư vấn viên bán tour chuyên nghiệp của WanderVibe.\n"
                . "Mục tiêu: Tư vấn nhiệt tình, thân thiện, dùng ngôi xưng 'mình' và gọi khách là 'bạn'.\n"
                . "QUY TẮC:\n"
                . "- Dựa vào danh sách tour thực tế dưới đây để cung cấp tên tour, giá vé, thời gian, điểm đến chính xác.\n"
                . "- Nếu khách hỏi tour không có trong danh sách, giải thích khéo léo và gợi ý tour tương đương.\n"
                . "- Hotline: 1900 888 999 | Email tư vấn: hello@wandervibe.me | Hỗ trợ đặt tour và thanh toán MoMo/VNPay/PayPal.\n"
                . "- Trả lời ngắn gọn, súc tích (dưới 150 từ), dùng định dạng **in đậm** cho tên tour và giá vé. Luôn kết thúc bằng một câu gợi ý chốt đơn / giữ chỗ.\n\n"
                . "DANH SÁCH TOUR HIỆN CÓ:\n" . $context . "\n\n"
                . "LỊCH SỬ TRAO ĐỔI:\n" . $recentHistory . "\n\n"
                . "KHÁCH HỎI: " . $userMessage;

            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . urlencode($apiKey);

            $res = Http::timeout(10)->post($endpoint, [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => $systemPrompt]
                        ]
                    ]
                ],
                "generationConfig" => [
                    "temperature" => 0.7,
                    "maxOutputTokens" => 500,
                ]
            ]);

            if ($res->successful()) {
                $data = $res->json();
                $text = $data["candidates"][0]["content"]["parts"][0]["text"] ?? null;
                if (!empty($text)) {
                    return trim($text);
                }
            }
        } catch (\Throwable $e) {
            Log::warning("Gemini API call failed: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Tích hợp Groq API (Free Tier qua console.groq.com)
     */
    private function callGroqAPI($userMessage, $sessionId, $apiKey)
    {
        try {
            $context = $this->buildTourContext();
            $recentHistory = $this->getRecentHistoryFromDB($sessionId);

            $systemPrompt = "Bạn là WanderBot - Trợ lý du lịch của WanderVibe. Xưng 'mình', gọi 'bạn'. Tư vấn tour ngắn gọn, hấp dẫn dựa trên danh sách tour sau:\n"
                . $context . "\n"
                . "Hotline: 1900 888 999 | Email: hello@wandervibe.me.\n"
                . "Lịch sử trò chuyện gần nhất:\n" . $recentHistory;

            $endpoint = "https://api.groq.com/openai/v1/chat/completions";
            $models = ["qwen/qwen3.8-27b", "openai/gpt-oss-120b", "llama-3.3-70b-versatile"];

            foreach ($models as $model) {
                $res = Http::timeout(10)->withToken($apiKey)->post($endpoint, [
                    "model" => $model,
                    "messages" => [
                        ["role" => "system", "content" => $systemPrompt],
                        ["role" => "user", "content" => $userMessage],
                    ],
                    "temperature" => 0.7,
                    "max_tokens" => 500,
                ]);

                if ($res->successful()) {
                    $data = $res->json();
                    $text = $data["choices"][0]["message"]["content"] ?? null;
                    if (!empty($text)) {
                        return trim($text);
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning("Groq API call failed: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Bộ máy tư vấn thông minh Local (Hoàn toàn Miễn phí, 100% Offline, không phụ thuộc API key ngoài)
     */
    private function smartFallbackReply($rawMessage)
    {
        $normalized = $this->removeAccents($rawMessage);

        // 1. Chào hỏi
        if (preg_match("/\\b(chao|hi|hello|alo|xin chao|helo|hey|tro ly|bot|wanderbot)\\b/i", $normalized)) {
            return "Chào bạn! 👋 Mình là **WanderBot** - Trợ lý du lịch ảo của **WanderVibe**.\n\n"
                . "Mình có thể hỗ trợ bạn:\n"
                . "• 🏝️ Gợi ý các tour hot theo điểm đến (Đà Lạt, Sa Pa, Phú Quốc, Hạ Long, Miền Tây...)\n"
                . "• 💰 Tìm tour theo tầm giá hoặc ngân sách tiết kiệm\n"
                . "• 📅 Cung cấp lịch trình chi tiết và hướng dẫn đặt chỗ 24/7\n\n"
                . "Bạn đang lên kế hoạch du lịch ở đâu hoặc có ngân sách khoảng bao nhiêu để mình tư vấn ngay nhé! ✨";
        }

        // 2. Hotline, Email, Liên hệ, Văn phòng
        if (preg_match("/\\b(lien he|hotline|sdt|so dien thoai|tong dai|email|dia chi|van phong|tu van)\\b/i", $normalized)) {
            return "Đội ngũ CSKH **WanderVibe** luôn sẵn sàng hỗ trợ bạn:\n\n"
                . "📞 **Hotline tư vấn 24/7:** 1900 888 999 (Nhánh 1)\n"
                . "📧 **Email tư vấn & báo giá:** hello@wandervibe.me\n"
                . "📍 **Văn phòng:** Tòa nhà Landmark 81, P. 22, Q. Bình Thạnh, TP. Hồ Chí Minh\n\n"
                . "Bạn cũng có thể gửi yêu cầu ở mục **Nhận tư vấn** ngay trên trang chủ để chuyên viên liên hệ lại qua SĐT/Zalo trong ít phút nhé!";
        }

        // 3. Quy trình đặt tour & thanh toán
        if (preg_match("/\\b(dat tour|dat ve|thanh toan|momo|vnpay|paypal|tien mat|chuyen khoan|huy tour|hoan tien)\\b/i", $normalized)) {
            return "Đặt tour tại **WanderVibe** cực kỳ đơn giản qua 3 bước:\n\n"
                . "1. Chọn tour ưng ý trên website và bấm **Đặt Tour**.\n"
                . "2. Chọn ngày khởi hành, số khách và phương tiện (máy bay, ô tô hoặc tàu hỏa).\n"
                . "3. Thanh toán tiện lợi và bảo mật qua **MoMo, VNPay, PayPal** hoặc thanh toán trực tiếp.\n\n"
                . "Hóa đơn điện tử và mã vé sẽ được gửi ngay về email của bạn sau khi hoàn tất. Bạn cần mình hướng dẫn thêm gì không ạ?";
        }

        // 4. Lọc theo ngân sách (Ví dụ: "dưới 2 triệu", "3tr", "5 triệu", "giá rẻ")
        $maxPrice = null;
        if (preg_match("/(\\d+(?:\\.\\d+)?)\\s*(tr|trieu)/i", $normalized, $m)) {
            $maxPrice = floatval($m[1]) * 1000000;
        } elseif (preg_match("/(\\d{1,4})\\s*(k|nghin)/i", $normalized, $m)) {
            $maxPrice = intval($m[1]) * 1000;
        } elseif (str_contains($normalized, "gia re") || str_contains($normalized, "tiet kiem") || str_contains($normalized, "sinh vien")) {
            $maxPrice = 3000000;
        }

        if ($maxPrice) {
            $cheapTours = Tour::where("status", 1)
                ->where("sale_price", "<=", $maxPrice)
                ->orderBy("sale_price", "asc")
                ->take(3)
                ->get();

            if ($cheapTours->count() > 0) {
                $out = "Dưới đây là các tour có mức giá cực tốt (dưới " . number_format($maxPrice, 0, ",", ".") . " VNĐ) dành cho bạn:\n\n";
                foreach ($cheapTours as $t) {
                    $priceStr = number_format($t->sale_price, 0, ",", ".") . "đ";
                    $out .= "🌟 **{$t->name}**\n"
                        . "• ⏱ Thời gian: {$t->time}\n"
                        . "• 💰 Giá ưu đãi: **{$priceStr}**\n"
                        . "• 📍 Điểm đến: {$t->end_location}\n\n";
                }
                $out .= "Bạn muốn mình giữ chỗ tour nào hay cần xem chi tiết lịch trình từng ngày không ạ? 😊";
                return $out;
            }
        }

        // 5. Tìm kiếm theo địa danh / Điểm đến
        $destinations = [
            "da lat" => ["da lat", "dalat", "lam dong"],
            "phu quoc" => ["phu quoc", "phuquoc", "kien giang"],
            "sa pa" => ["sa pa", "sapa", "lao cai", "fansipan"],
            "ha giang" => ["ha giang", "hagiang", "dong van", "ma pi leng"],
            "ha long" => ["ha long", "halong", "quang ninh"],
            "da nang" => ["da nang", "danang", "ba na"],
            "nha trang" => ["nha trang", "nhatrang", "khanh hoa"],
            "hoi an" => ["hoi an", "hoian", "quang nam"],
            "hue" => ["hue", "thua thien hue"],
            "ninh binh" => ["ninh binh", "trang an", "tam coc"],
            "quy nhon" => ["quy nhon", "quynhon", "binh dinh"],
            "mien tay" => ["mien tay", "can tho", "ben tre", "an giang"],
            "thai lan" => ["thai lan", "bangkok", "pattaya"],
        ];

        $matchedKey = null;
        foreach ($destinations as $key => $synonyms) {
            foreach ($synonyms as $syn) {
                if (str_contains($normalized, $syn)) {
                    $matchedKey = $key;
                    break 2;
                }
            }
        }

        $toursQuery = Tour::where("status", 1);

        if ($matchedKey) {
            $tours = $toursQuery->where(function ($q) use ($matchedKey) {
                $q->where("name", "LIKE", "%{$matchedKey}%")
                  ->orWhere("end_location", "LIKE", "%{$matchedKey}%")
                  ->orWhere("description", "LIKE", "%{$matchedKey}%");
            })->take(3)->get();
        } else {
            $words = explode(" ", trim($rawMessage));
            $foundTours = collect();
            foreach ($words as $w) {
                if (mb_strlen($w) >= 3) {
                    $matches = Tour::where("status", 1)
                        ->where("name", "LIKE", "%{$w}%")
                        ->take(2)
                        ->get();
                    $foundTours = $foundTours->merge($matches);
                }
            }
            $tours = $foundTours->unique("id")->take(3);
        }

        if ($tours->count() > 0) {
            $out = "WanderVibe có tour rất tuyệt vời phù hợp với mong muốn của bạn đây ạ:\n\n";
            foreach ($tours as $t) {
                $priceStr = number_format($t->sale_price, 0, ",", ".") . "đ";
                $oldPriceStr = number_format($t->price, 0, ",", ".") . "đ";
                $out .= "✨ **{$t->name}**\n"
                    . "• ⏱ Thời gian: {$t->time}\n"
                    . "• 📍 Điểm khởi hành: {$t->start_location} → Đến: **{$t->end_location}**\n"
                    . "• 💰 Giá trọn gói: **{$priceStr}** (Giá gốc: {$oldPriceStr})\n\n";
            }
            $out .= "Bạn muốn mình giữ chỗ ngay hay cần gửi thêm lịch trình chi tiết từng ngày cho bạn ạ? 🚀";
            return $out;
        }

        // 6. Gợi ý mặc định các tour nổi bật nhất
        $featuredTours = Tour::where("status", 1)->orderBy("id", "desc")->take(3)->get();
        $out = "Hiện tại WanderVibe đang có các tour du lịch được yêu thích nhất mùa này:\n\n";
        foreach ($featuredTours as $t) {
            $priceStr = number_format($t->sale_price, 0, ",", ".") . "đ";
            $out .= "🔥 **{$t->name}** ({$t->time}) - Giá ưu đãi: **{$priceStr}**\n";
        }
        $out .= "\nBạn thích đi biển, khám phá vùng cao hay du lịch nghỉ dưỡng? Hãy nhắn cho mình điểm đến hoặc mức ngân sách để mình tư vấn chuẩn nhất nhé! 😊";

        return $out;
    }

    /**
     * Tạo chuỗi dữ liệu tóm tắt tour thực tế để đưa vào context LLM
     */
    private function buildTourContext()
    {
        $tours = Tour::where("status", 1)->take(12)->get();
        $lines = [];

        foreach ($tours as $t) {
            $price = number_format($t->sale_price, 0, ",", ".") . "đ";
            $lines[] = "- Tên tour: {$t->name} | Lịch trình: {$t->time} | Điểm đến: {$t->end_location} | Giá sale: {$price} | Khởi hành: {$t->start_location}";
        }

        return implode("\n", $lines);
    }

    private function getOrCreateSession()
    {
        $id = session("chat_session_id");
        $session = $id ? ChatSession::find($id) : null;

        if (!$session) {
            $session = ChatSession::create([
                "user_id" => Auth::id(),
                "started_at" => now(),
                "status" => 1,
            ]);
            session()->put("chat_session_id", $session->id);
        }

        return $session;
    }

    private function saveUserMessage($sessionId, $text)
    {
        return ChatMessage::create([
            "session_id" => $sessionId,
            "sender_type" => "user",
            "message" => $text,
        ]);
    }

    private function saveBotMessage($sessionId, $text)
    {
        return ChatMessage::create([
            "session_id" => $sessionId,
            "sender_type" => "bot",
            "message" => $text,
        ]);
    }

    private function getRecentHistoryFromDB($sessionId)
    {
        return ChatMessage::where("session_id", $sessionId)
            ->latest("id")
            ->limit(4)
            ->get()
            ->reverse()
            ->map(fn ($m) => ($m->sender_type === "user" ? "Khách: " : "WanderBot: ") . $m->message)
            ->implode("\n");
    }

    private function removeAccents($str)
    {
        $accents = [
            "a" => ["à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ"],
            "e" => ["è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ"],
            "i" => ["ì","í","ị","ỉ","ĩ"],
            "o" => ["ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ"],
            "u" => ["ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ"],
            "y" => ["ỳ","ý","ỵ","ỷ","ỹ"],
            "d" => ["đ"],
        ];

        $str = mb_strtolower($str, "UTF-8");
        foreach ($accents as $nonAccent => $accentList) {
            $str = str_replace($accentList, $nonAccent, $str);
        }
        return $str;
    }
}
