const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const bodyParser = require('body-parser');
const chatController = require('./controllers/chatController');
const { Message, Conversation } = require('./models');
const app = express();
const server = http.createServer(app);
const io = socketIo(server);

app.use(bodyParser.json());

// Socket.io connection
io.on('connection', (socket) => {
    console.log('A user connected');

    // Khi người dùng tham gia một cuộc trò chuyện, chúng ta sẽ join vào room với conversationId
    socket.on('joinConversation', (conversationId) => {
        console.log(`User joined conversation: ${conversationId}`);
        socket.join(conversationId);  // Thêm người dùng vào room theo conversationId
    });

    // Lắng nghe sự kiện gửi tin nhắn từ client
    socket.on('sendMessage', async (data) => {
        const { conversationId, content, userId } = data;

        try {
            // Gửi tin nhắn và mã hóa nó
            const encryptedMessage = await chatController.sendMessage(conversationId, content, userId);

            // Emit tin nhắn đã được gửi cho những người tham gia cuộc trò chuyện này (tức là trong room conversationId)
            io.to(conversationId).emit('message', {
                messageId: encryptedMessage.id,
                content: encryptedMessage.decryptedContent, // Giải mã nội dung trước khi gửi
                userId: encryptedMessage.userId,
                status: encryptedMessage.status
            });
        } catch (error) {
            console.error("Error sending message:", error);
            socket.emit('error', { message: 'Failed to send message' });
        }
    });

    // Lắng nghe sự kiện lấy tin nhắn từ client
    socket.on('getMessages', async (conversationId) => {
        try {
            const messages = await chatController.getMessages(conversationId);
            socket.emit('messages', messages);
        } catch (error) {
            socket.emit('error', { message: 'Failed to retrieve messages' });
        }
    });

    // Đánh dấu tin nhắn là đã đọc
    socket.on('markMessagesAsRead', async (messageIds) => {
        try {
            await chatController.markMessagesAsRead(messageIds);
            io.emit('marked-as-read', { message: 'Messages marked as read' });
        } catch (error) {
            socket.emit('error', { message: 'Failed to mark messages as read' });
        }
    });

    socket.on('disconnect', () => {
        console.log('User disconnected');
    });
});

// Khởi động server
server.listen(3000, () => {
    console.log('Server is running on port 3000');
});
