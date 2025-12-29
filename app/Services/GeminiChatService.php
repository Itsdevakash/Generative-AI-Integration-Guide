<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiChatService
{
    public function ask(string $message): string
    {
        $prompt = <<<PROMPT
You are a School Management AI Assistant.

Answer questions related to:
Students, Fees, Attendance, Exams, Teachers, Homework, School Holidays.

Question:
$message
PROMPT;

        try {
            $response = Http::withHeaders([
                'Content-Type'   => 'application/json',
                'X-goog-api-key' => env('GEMINI_API_KEY'),
            ])->post(
                'https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent',
                [
                    "contents" => [
                        [
                            "role" => "user",
                            "parts" => [
                                ["text" => $prompt]
                            ]
                        ]
                    ]
                ]
            );

            if (! $response->successful()) {
                Log::error('Gemini API Error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                return "AI service temporarily unavailable.";
            }

            return $response->json('candidates.0.content.parts.0.text')
                ?? "No response from AI.";

        } catch (\Throwable $e) {
            Log::error('Gemini Exception', [
                'message' => $e->getMessage(),
            ]);

            return "Something went wrong while processing your request.";
        }
    }
}
 