<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AiChatController extends Controller
{
        public function index()
    {
        return view('ai.chat');
    }
  public function send(Request $request, AiChatService $ai)
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
