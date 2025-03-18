const express = require('express');
const chatController = require('../controllers/chatController');

const router = express.Router();

// Route lấy danh sách tin nhắn cho một cuộc trò chuyện
router.get('/conversation/:conversationId/messages', chatController.getMessages);

// Route gửi tin nhắn mới
router.post('/conversation/:conversationId/message', chatController.sendMessage);

// Route đánh dấu tin nhắn là đã đọc
router.put('/message/:messageId/read', chatController.markMessageAsRead);

module.exports = router;
