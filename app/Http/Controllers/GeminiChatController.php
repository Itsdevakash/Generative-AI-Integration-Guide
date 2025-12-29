<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiChatService;

class GeminiChatController extends Controller
{
    public function index()
    {
        return view('ai.gemini_chat');
    }

    public function send(Request $request, GeminiChatService $ai)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $reply = $ai->ask($request->message);

        return response()->json([
            'reply' => $reply
        ]);
    }
}
