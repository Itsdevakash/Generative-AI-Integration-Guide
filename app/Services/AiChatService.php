<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatService
{
    public function ask($message, $userRole = 'admin')
    {
        $systemPrompt = "
You are a Vidyaan School Management AI Assistant.
Answer only school-related questions:
Students, Fees, Attendance, Exams, Teachers, Homework, Holidays.
Reply in simple and clear language.
";

        try {
            $response = Http::withToken(env('OPENAI_API_KEY'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    "model" => "gpt-4o-mini",
                    "messages" => [
                        ["role" => "system", "content" => $systemPrompt],
                        ["role" => "user", "content" => $message]
                    ],
                    "temperature" => 0.3
                ]);

            if (!$response->successful()) {
                Log::error('OpenAI API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return "AI service temporarily unavailable.";
            }

            return $response->json('choices.0.message.content')
                ?? "No response from AI.";

        } catch (\Exception $e) {
            Log::error('OpenAI Exception', [
                'message' => $e->getMessage()
            ]);

            return "Something went wrong while processing your request.";
        }
    }
}
