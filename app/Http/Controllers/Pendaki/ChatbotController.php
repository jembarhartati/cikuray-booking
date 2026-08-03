<?php

namespace App\Http\Controllers\Pendaki;

use App\Http\Controllers\Controller;
use App\Services\ChatbotService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function ask(Request $request, ChatbotService $chatbot)
    {
        $request->validate(['message' => 'required|string|max:500']);

        $result = $chatbot->processMessage($request->message);

        return response()->json($result);
    }
}
