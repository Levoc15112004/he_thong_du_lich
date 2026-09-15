<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChatmessageController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $chats = ChatSession::with('user')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('status', 'desc') // phiên đang mở lên trước
            ->orderBy('started_at', 'desc')
            ->paginate(7);

        return view('admin.chat.home', compact('chats', 'search'));
    }


    public function show($id)
    {
        $session = ChatSession::with('user')->findOrFail($id);

        $messages = ChatMessage::where('session_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.chat.home', [
            'session'  => $session,
            'messages' => $messages,
        ]);
    }


    public function endSession($id)
    {
        $session = ChatSession::findOrFail($id);

        $session->update([
            'status'   => 0,
            'ended_at'=> Carbon::now(),
        ]);

        return redirect()
            ->route('admin.chat.home')
            ->with('success', 'Phiên chat đã được kết thúc.');
    }


    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            ChatMessage::where('session_id', $id)->delete();
            ChatSession::where('id', $id)->delete();
        });

        return redirect()
            ->route('admin.chat.home')
            ->with('success', 'Đã xóa phiên chat và toàn bộ tin nhắn.');
    }


    public function sendMessage(Request $request, $sessionId)
    {
        $request->validate([
            'message' => 'required|string'
        ], [
            'message.required' => 'Nội dung tin nhắn không được để trống'
        ]);

        ChatMessage::create([
            'session_id' => $sessionId,
            'sender_type'=> 'admin',
            'message'    => $request->message,
        ]);

        return redirect()->back()->with('success', 'Đã gửi tin nhắn.');
    }
}
