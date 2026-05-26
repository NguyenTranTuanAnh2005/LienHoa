<?php
// app/controllers/ChatbotController.php

require_once 'BaseController.php';

class ChatbotController extends BaseController {

    public function handleChat() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJson(['error' => 'Chỉ hỗ trợ phương thức POST.'], 405);
            return;
        }

        $rawInput = file_get_contents('php://input');
        $requestData = json_decode($rawInput, true);

        $userMessage = $requestData['message'] ?? '';
        if (empty($userMessage)) {
            $this->sendJson(['error' => 'Nội dung tin nhắn không được để trống.'], 400);
            return;
        }

        // --- BƯỚC 1: CẤU HÌNH API OLLAMA ---
        // Mặc định Ollama chạy ở localhost port 11434
        $apiUrl = 'http://localhost:11434/api/chat'; 
        
        // Payload dữ liệu chuẩn bị gửi cho Ollama
        $payload = [
            'model' => 'gemma3:1b', // Tên model bạn đã tải trên Ollama (có thể là gemma:2b hoặc gemma:7b)
            'messages' => [
                ['role' => 'system', 'content' => 'Bạn là trợ lý y tế ảo của Bệnh viện Liên Hoa. Hãy tư vấn ngắn gọn, lịch sự và chính xác bằng tiếng Việt.'],
                ['role' => 'user', 'content' => $userMessage]
            ],
            'stream' => false, // Rất quan trọng: Yêu cầu Ollama trả về toàn bộ câu trả lời một lần (không stream)
            'options' => [
                'temperature' => 0.7
            ]
        ];

        // --- BƯỚC 2: KHỞI TẠO VÀ CẤU HÌNH cURL ---
        $ch = curl_init($apiUrl);

        // Với Ollama chạy local, chúng ta chỉ cần header Content-Type
        $headers = [
            'Content-Type: application/json'
        ];

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        // Thời gian chờ có thể cần nới lỏng tùy cấu hình máy tính của bạn khi chạy AI local
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); 

        // --- BƯỚC 3: THỰC THI cURL VÀ XỬ LÝ KẾT QUẢ ---
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $errorMsg = curl_error($ch);
            curl_close($ch);
            $this->sendJson(['error' => 'Không thể kết nối với Ollama. Hãy chắc chắn Ollama đang chạy! Lỗi: ' . $errorMsg], 500);
            return;
        }
        curl_close($ch);

        $responseData = json_decode($response, true);

        if ($httpCode >= 400) {
            $apiError = $responseData['error'] ?? 'Lỗi không xác định từ Ollama.';
            $this->sendJson(['error' => 'Lỗi Ollama: ' . $apiError], $httpCode);
            return;
        }

        // --- BƯỚC 4: LẤY CÂU TRẢ LỜI VÀ TRẢ VỀ FRONTEND ---
        // Cấu trúc response của Ollama chat API
        $aiReply = $responseData['message']['content'] ?? 'Xin lỗi, tôi không thể xử lý yêu cầu lúc này.';

        $this->sendJson([
            'success' => true,
            'reply' => $aiReply
        ]);
    }

    private function sendJson($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
?>