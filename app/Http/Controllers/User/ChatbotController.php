<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Tour;
use App\Models\TourSchedule;
use App\Services\AIService;
use App\Services\IntentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    private function preparePrompt(Request $request, AIService $ai, IntentService $intentService)
    {
        $message = trim($request->message);

        if (! $message) {
            return null;
        }

        $session = $this->getOrCreateSession();
        $this->saveUserMessage($session->id, $message);
        $historyText = $this->getRecentHistoryFromDB($session->id);

        $intentData = $intentService->detectIntent($message);

        $location = strtolower($intentData['location'] ?? '');
        $tourName = strtolower($intentData['tour_name'] ?? '');
        $hobby = strtolower($intentData['hobby'] ?? '');
        $price = intval($intentData['price'] ?? 0);

        $allTours = Tour::where('status', 1)->get();
        $tours = $allTours;

        if ($location) {
            $byLocation = $tours->filter(function ($t) use ($location) {
                return str_contains(strtolower($t->name), $location)
                    || str_contains(strtolower($t->description), $location)
                    || str_contains(strtolower($t->end_location), $location);
            });
            if ($byLocation->count() > 0) {
                $tours = $byLocation;
            }
        }

        if ($tourName) {
            $byName = $tours->filter(function ($t) use ($tourName) {
                return str_contains(strtolower($t->name), $tourName);
            });
            if ($byName->count() > 0) {
                $tours = $byName;
            }
        }

        if ($hobby) {
            $byHobby = $tours->filter(function ($t) use ($hobby) {
                return str_contains(strtolower($t->description), $hobby);
            });
            if ($byHobby->count() > 0) {
                $tours = $byHobby;
            }
        }

        $priceWarning = '';
        if ($price > 0) {
            $byPrice = $tours->filter(function ($t) use ($price) {
                return $t->sale_price <= $price;
            });
            if ($byPrice->count() > 0) {
                $tours = $byPrice;
            } else {
                $priceWarning = "Khách yêu cầu giá dưới $price nhưng không có tour đúng giá. Hãy tư vấn tour gần nhất.";
            }
        }

        if ($tours->count() == 0) {
            $priceWarning .= ' Không có tour đúng yêu cầu. Hãy gợi ý tour gần giống.';
            $tours = $allTours->take(5);
        }

        if ($tours->count() > 5) {
            $keywords = $ai->getEmbedding($message);
            if ($keywords) {
                $topTours = $ai->searchSimilarTours($keywords, $tours, 8);
                $tours = collect(array_map(fn ($x) => $x['tour'], $topTours));
            }
        }

        $context = '';
        foreach ($tours as $t) {
            $context .= "Tên tour: $t->name\n".
                "Điểm đi: $t->start_location\n".
                "Điểm đến: $t->end_location\n".
                "Giá: $t->sale_price\n".
                "Thời gian: $t->time\n".
                "Số chỗ: $t->quantity\n".
                "Mô tả: $t->description\n";

            $schedules = TourSchedule::where('tour_id', $t->id)->orderBy('day_number')->get();
            foreach ($schedules as $s) {
                $context .= "Ngày {$s->day_number}: {$s->title} - {$s->description}\n";
            }
            $context .= "\n";
        }

        return "
            Bạn là nhân viên tư vấn & sale tour chuyên nghiệp của TravelGo, có kinh nghiệm bán hàng thực tế.
            =====================
             MỤC TIÊU
            =====================
            - Tư vấn chính xác dựa trên dữ liệu tour được cung cấp
            - Thuyết phục khách hàng lựa chọn tour phù hợp
            - Tăng khả năng chốt đơn

            =====================
             NGUYÊN TẮC BẮT BUỘC
            =====================
            - CHỈ sử dụng dữ liệu trong 'Danh sách tour'
            - TUYỆT ĐỐI KHÔNG bịa tour, giá, lịch trình
            - Nếu KHÔNG có tour phù hợp → nói rõ + đề xuất tour gần nhất
            - Nếu giá KHÁCH yêu cầu:
                + Thấp hơn nhiều → nói KHÔNG có, gợi ý tour gần nhất
                + Gần đúng → giới thiệu tour phù hợp và giải thích chênh lệch
            - Không trả lời chung chung, phải cụ thể

            =====================
            PHONG CÁCH TRẢ LỜI
            =====================
            - Giống nhân viên sale thật (thân thiện, tự nhiên, có cảm xúc)
            - BẮT BUỘC xưng: 'mình' và gọi khách là 'bạn' trong mọi trường hợp
            - TUYỆT ĐỐI không dùng 'em', 'anh/chị'
            - Ưu tiên trả lời ngắn gọn, tập trung vào nội dung chính nhưng đầy đủ (100 từ)
            - Tránh lan man, không nói lý thuyết

            =====================
            CÁCH XỬ LÝ TÌNH HUỐNG
            =====================
            1. Nếu tìm thấy tour phù hợp:
            - Giới thiệu tên tour
            - Nêu điểm nổi bật (địa điểm, trải nghiệm)
            - Giá + lợi ích (đáng tiền ở đâu)
            - Gợi ý chốt: hỏi khách có muốn giữ chỗ / tư vấn thêm

            2. Nếu không có tour đúng:
            - Nói rõ: hiện chưa có tour đúng yêu cầu
            - Gợi ý 1–2 tour gần nhất
            - Giải thích vì sao nên chọn

            3. Nếu khách hỏi giá rẻ:
            - So sánh nhẹ nhàng
            - Nhấn mạnh giá trị (khách sạn, lịch trình, dịch vụ)

            4. Nếu khách chưa rõ nhu cầu:
            - Hỏi thêm 1–2 câu ngắn để khai thác (ngân sách, địa điểm, thời gian)

            =====================
            KỸ THUẬT BÁN HÀNG
            =====================
            - Ưu tiên highlight:
                + Ưu đãi
                + Điểm đặc biệt của tour
                + Số lượng chỗ (nếu có thể)
            - Có thể tạo cảm giác khan hiếm nhẹ (nhưng KHÔNG bịa)
            - Luôn kết thúc bằng CTA:
                → “Bạn muốn mình giữ chỗ không ạ?”
                → “Mình gửi lịch chi tiết cho bạn nhé?”

            =====================
            THÔNG TIN THAM KHẢO
            =====================
            $priceWarning

            =====================
            LỊCH SỬ CHAT
            =====================
            $historyText

            =====================
            DANH SÁCH TOUR
            =====================
            $context

            =====================
            KHÁCH HỎI
            =====================
            $message

            =====================
            YÊU CẦU CUỐI
            =====================
            Trả lời như một nhân viên sale thực thụ, tự nhiên, thuyết phục, ưu tiên chốt đơn.
            ";
    }

    public function chat(Request $request, AIService $ai, IntentService $intentService)
    {
        $prompt = $this->preparePrompt($request, $ai, $intentService);

        if (! $prompt) {
            return response()->json([
                'reply' => 'Anh/chị muốn tư vấn tour nào ạ?',
            ]);
        }

        $reply = $ai->chat($prompt);

        $session = $this->getOrCreateSession();
        $this->saveBotMessage($session->id, $reply);

        return response()->json([
            'reply' => $reply,
        ]);
    }

    public function chatStream(Request $request, AIService $ai, IntentService $intentService)
    {
        $prompt = $this->preparePrompt($request, $ai, $intentService);

        if (! $prompt) {
            return response('data: {"content": "Anh/chị muốn tư vấn tour nào ạ?"}'."\n\n", 200, [
                'Content-Type' => 'text/event-stream',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive',
            ]);
        }

        return response()->stream(function () use ($ai, $prompt) {
            $allText = '';
            $chunks = $ai->chatStream($prompt);

            foreach ($chunks as $chunk) {
                // Gemini returns JSON array or parts.

                echo "data: ".json_encode(['content' => $chunk])."\n\n";
                $allText .= $chunk;

                if (ob_get_level() > 0) {
                    ob_flush();
                }
                flush();
            }

            $session = $this->getOrCreateSession();
            // We should ideally save the full text after completion
            $this->saveBotMessage($session->id, $allText);
            
            echo "data: " . json_encode(['content' => '[DONE]']) . "\n\n";
            if (ob_get_level() > 0) {
                ob_flush();
            }
            flush();

        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    private function getOrCreateSession()
    {
        $id = session('chat_session_id');

        $session = $id ? ChatSession::find($id) : null;

        if (! $session) {
            $session = ChatSession::create([
                'user_id' => Auth::id(),
                'started_at' => now(),
                'status' => 1,
            ]);

            session()->put('chat_session_id', $session->id);
        }

        return $session;
    }

    private function saveUserMessage($sessionId, $text)
    {
        ChatMessage::create([
            'session_id' => $sessionId,
            'sender_type' => 'user',
            'message' => $text,
        ]);
    }

    private function saveBotMessage($sessionId, $text)
    {
        ChatMessage::create([
            'session_id' => $sessionId,
            'sender_type' => 'bot',
            'message' => $text,
        ]);
    }

    private function getRecentHistoryFromDB($sessionId)
    {
        return ChatMessage::where('session_id', $sessionId)
            ->latest()
            ->limit(5)
            ->get()
            ->reverse()
            ->map(fn ($m) => "{$m->sender_type}: {$m->message}")
            ->implode("\n");
    }

    public function history()
{
    $session = $this->getOrCreateSession();

    $messages = ChatMessage::where('session_id', $session->id)
        ->orderBy('id')
        ->get()
        ->map(fn ($m) => [
            'role' => $m->sender_type,
            'message' => $m->message,
        ]);

    return response()->json(['history' => $messages]);
}
}
