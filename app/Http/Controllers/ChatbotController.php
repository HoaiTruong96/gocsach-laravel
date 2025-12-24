<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private $apiKey;
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.0-pro:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        // Tạo context cho chatbot
        $systemPrompt = "Bạn là trợ lý AI của website Góc Sách - một cộng đồng yêu sách. Hãy:
- Trả lời bằng tiếng Việt, thân thiện và hữu ích
- Gợi ý sách hay khi được hỏi
- Giúp người dùng tìm sách theo thể loại, tác giả
- Trả lời ngắn gọn, dễ hiểu (tối đa 3-4 câu)
- Sử dụng emoji phù hợp để tạo không khí vui vẻ";

        // Build conversation history
        $contents = [];
        
        // Add system context as first message
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $systemPrompt]]
        ];
        $contents[] = [
            'role' => 'model',
            'parts' => [['text' => 'Xin chào! 📚 Tôi là trợ lý AI của Góc Sách. Tôi có thể giúp bạn tìm sách hay, gợi ý đọc theo sở thích, hoặc trò chuyện về văn học. Bạn cần gì nào?']]
        ];

        // Add conversation history
        foreach ($history as $msg) {
            $contents[] = [
                'role' => $msg['role'] === 'user' ? 'user' : 'model',
                'parts' => [['text' => $msg['content']]]
            ];
        }

        // Add current user message
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => $contents,
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 500,
                ],
                'safetySettings' => [
                    ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
                    ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
                    ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
                    ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'],
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, tôi không thể trả lời lúc này.';
                
                return response()->json([
                    'success' => true,
                    'reply' => $reply
                ]);
            } else {
                Log::error('Gemini API Error', ['response' => $response->body()]);
                return response()->json([
                    'success' => false,
                    'reply' => 'Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau! 🙏'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Chatbot Exception', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'reply' => 'Xin lỗi, không thể kết nối đến AI. Vui lòng thử lại! 🙏'
            ], 500);
        }
    }
}
