<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function chat()
    {
        return response()->json(['reply' => 'Xin chào! Wanderlust có thể giúp gì cho bạn?']);
    }

    public function chatStream()
    {
        return response()->json(['reply' => 'Xin chào!']);
    }

    public function history()
    {
        return response()->json(['messages' => []]);
    }
}
