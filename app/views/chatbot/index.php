<div id="ai-chat-container">
    <div id="ai-chat-trigger" class="shadow-lg" onclick="toggleChat()" style="position:fixed; bottom: 30px; right: 30px; z-index: 9999; cursor: pointer; width: 60px; height: 60px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: transform 0.3s; padding: 8px;">
        <img src="/assets/images/lienhoa.png" alt="Liên Hoa Logo" style="width: 100%; height: 100%; object-fit: contain;">
    </div>

    <div id="ai-chat-window" class="card shadow-lg border-0" style="display:none; position:fixed; bottom: 100px; right: 30px; width: 360px; height: 550px; z-index: 9999; border-radius: 20px; overflow: hidden; background: #fff;">
        <div class="card-header bg-primary text-white p-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; padding: 2px; overflow: hidden;">
                    <img src="/assets/images/lienhoa.png" alt="Liên Hoa Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <span class="fw-bold">Trợ lý AI Liên Hoa</span>
            </div>
            <button type="button" class="btn-close btn-close-white" onclick="toggleChat()"></button>
        </div>

        <div id="chat-messages" class="card-body overflow-auto p-3" style="height: 420px; background-color: #f8f9fa;">
            <div class="p-2 mb-2 rounded bg-white border shadow-sm"><small><b>AI Liên Hoa:</b></small><br>👋 Xin chào! Tôi là trợ lý AI của Liên Hoa Medical. Tôi có thể hỗ trợ đặt lịch khám, tư vấn dịch vụ, tra cứu chuyên khoa và giải đáp thông tin cho bạn.</div>
        </div>

        <div class="card-footer p-2 bg-white">
            <div class="input-group">
                <input type="text" id="chat-input" class="form-control rounded-pill border-primary me-2" placeholder="Nhập câu hỏi tại đây..." onkeypress="if(event.key==='Enter') sendMessage()">
                <button class="btn btn-primary rounded-circle" style="width: 40px; height: 40px;" onclick="sendMessage()">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>
    </div>
</div>