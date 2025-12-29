<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\GeminiChatController;

Route::get('open-ai', [AiChatController::class, 'index']);
Route::post('/ai-gpt-chat/send', [AiChatController::class, 'send']);



Route::get('/', [GeminiChatController::class, 'index']);
Route::post('/ai-gemini-chat/send', [GeminiChatController::class, 'send']);


