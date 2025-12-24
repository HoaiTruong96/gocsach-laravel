<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Post;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private $apiKey;
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    /**
     * Tìm kiếm sách trong database dựa trên message của user
     */
    private function searchBooks($message)
    {
        $message = mb_strtolower($message);
        $results = [];

        // Tìm theo tác giả
        if (preg_match('/(sách|tác phẩm|của|tác giả|author)\s+(.+)/ui', $message, $matches)) {
            $keyword = trim($matches[2]);
            $books = Book::where('is_approved', true)
                ->where(function($q) use ($keyword) {
                    $q->where('author_name', 'like', "%{$keyword}%")
                      ->orWhereHas('author', function($q) use ($keyword) {
                          $q->where('name', 'like', "%{$keyword}%");
                      });
                })
                ->select('title', 'author_name', 'average_rating')
                ->limit(10)
                ->get();
            
            if ($books->count() > 0) {
                $results['type'] = 'author_books';
                $results['keyword'] = $keyword;
                $results['books'] = $books->toArray();
            }
        }

        // Tìm theo thể loại
        if (preg_match('/(thể loại|category|loại sách|sách về|sách thuộc)\s+(.+)/ui', $message, $matches)) {
            $keyword = trim($matches[2]);
            $books = Book::where('is_approved', true)
                ->whereHas('categories', function($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                })
                ->select('title', 'author_name', 'average_rating')
                ->limit(10)
                ->get();
            
            if ($books->count() > 0) {
                $results['type'] = 'category_books';
                $results['keyword'] = $keyword;
                $results['books'] = $books->toArray();
            }
        }

        // Tìm sách theo tên
        if (preg_match('/(tìm sách|sách|tìm|có cuốn|cuốn)\s+(.+)/ui', $message, $matches) && empty($results)) {
            $keyword = trim($matches[2]);
            $books = Book::where('is_approved', true)
                ->where('title', 'like', "%{$keyword}%")
                ->select('title', 'author_name', 'average_rating')
                ->limit(10)
                ->get();
            
            if ($books->count() > 0) {
                $results['type'] = 'search_books';
                $results['keyword'] = $keyword;
                $results['books'] = $books->toArray();
            }
        }

        // Đếm số lượng sách
        if (preg_match('/(bao nhiêu|tổng số|có mấy|đếm)\s*(sách|cuốn)/ui', $message)) {
            $totalBooks = Book::where('is_approved', true)->count();
            $results['type'] = 'count_books';
            $results['total'] = $totalBooks;
        }

        // Thống kê chung
        if (preg_match('/(thống kê|thong ke|tổng quan|overview)/ui', $message)) {
            $results['type'] = 'statistics';
            $results['stats'] = [
                'total_books' => Book::where('is_approved', true)->count(),
                'total_reviews' => Post::where('status', 'published')->whereNotNull('book_id')->count(),
                'total_categories' => Category::count(),
                'total_authors' => Author::count(),
            ];
        }

        // Sách hay nhất
        if (preg_match('/(sách hay|top|nổi tiếng|được đánh giá cao|best|rating cao)/ui', $message)) {
            $books = Book::where('is_approved', true)
                ->where('average_rating', '>', 0)
                ->orderByDesc('average_rating')
                ->select('title', 'author_name', 'average_rating')
                ->limit(10)
                ->get();
            
            if ($books->count() > 0) {
                $results['type'] = 'top_books';
                $results['books'] = $books->toArray();
            }
        }

        return $results;
    }

    /**
     * Tạo context từ kết quả tìm kiếm
     */
    private function buildDatabaseContext($searchResults)
    {
        if (empty($searchResults)) {
            return '';
        }

        $context = "\n\n[DỮ LIỆU TỪ DATABASE GÓC SÁCH]\n";

        switch ($searchResults['type']) {
            case 'author_books':
                $context .= "Tìm thấy " . count($searchResults['books']) . " sách của \"{$searchResults['keyword']}\":\n";
                foreach ($searchResults['books'] as $book) {
                    $rating = $book['average_rating'] ? " (⭐ " . number_format($book['average_rating'], 1) . ")" : "";
                    $context .= "- {$book['title']} - {$book['author_name']}{$rating}\n";
                }
                break;

            case 'category_books':
                $context .= "Sách thể loại \"{$searchResults['keyword']}\":\n";
                foreach ($searchResults['books'] as $book) {
                    $rating = $book['average_rating'] ? " (⭐ " . number_format($book['average_rating'], 1) . ")" : "";
                    $context .= "- {$book['title']} - {$book['author_name']}{$rating}\n";
                }
                break;

            case 'search_books':
                $context .= "Kết quả tìm kiếm \"{$searchResults['keyword']}\":\n";
                foreach ($searchResults['books'] as $book) {
                    $rating = $book['average_rating'] ? " (⭐ " . number_format($book['average_rating'], 1) . ")" : "";
                    $context .= "- {$book['title']} - {$book['author_name']}{$rating}\n";
                }
                break;

            case 'count_books':
                $context .= "Tổng số sách trên Góc Sách: {$searchResults['total']} cuốn\n";
                break;

            case 'statistics':
                $stats = $searchResults['stats'];
                $context .= "Thống kê Góc Sách:\n";
                $context .= "- Tổng sách: {$stats['total_books']} cuốn\n";
                $context .= "- Tổng bài review: {$stats['total_reviews']} bài\n";
                $context .= "- Thể loại: {$stats['total_categories']} loại\n";
                $context .= "- Tác giả: {$stats['total_authors']} người\n";
                break;

            case 'top_books':
                $context .= "Top sách được đánh giá cao nhất:\n";
                foreach ($searchResults['books'] as $index => $book) {
                    $rank = $index + 1;
                    $context .= "{$rank}. {$book['title']} - {$book['author_name']} (⭐ " . number_format($book['average_rating'], 1) . ")\n";
                }
                break;
        }

        $context .= "\nHãy dựa vào dữ liệu trên để trả lời người dùng một cách chính xác và hữu ích.";
        
        return $context;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        // Tìm kiếm trong database
        $searchResults = $this->searchBooks($userMessage);
        $databaseContext = $this->buildDatabaseContext($searchResults);

        // Tạo context cho chatbot
        $systemPrompt = "Bạn là trợ lý AI của website Góc Sách - một cộng đồng yêu sách Việt Nam. Hãy:
- Trả lời bằng tiếng Việt, thân thiện và hữu ích
- Khi có dữ liệu từ database, hãy sử dụng chính xác thông tin đó
- Gợi ý sách hay khi được hỏi
- Giúp người dùng tìm sách theo thể loại, tác giả
- Trả lời ngắn gọn, dễ hiểu (tối đa 4-5 câu)
- Sử dụng emoji phù hợp để tạo không khí vui vẻ
- Nếu không tìm thấy trong database, hãy nói rõ là 'Góc Sách chưa có sách này' và gợi ý sách tương tự nếu có thể" . $databaseContext;

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
                    'maxOutputTokens' => 800,
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
