const { Message, Conversation } = require('../models');
const { encrypt, decrypt } = require('../utils/crypto');

// Gửi tin nhắn
async function sendMessage(conversationId, content, userId) {
    // Mã hóa tin nhắn
    const encryptedMessage = encrypt(content);

    // Lưu tin nhắn vào database
    const message = await Message.create({
        conversationId,
        content: encryptedMessage.encryptedData,
        iv: encryptedMessage.iv,
        userId, // ID người gửi tin nhắn
    });

    // Giải mã tin nhắn trước khi gửi đến client
    const decryptedContent = decrypt(message.content, message.iv);

    return {
        id: message.id,
        decryptedContent,
        userId,
        status: message.status,
    };
}

// Lấy tin nhắn trong cuộc trò chuyện
async function getMessages(conversationId) {
    try {
        const messages = await Message.findAll({
            where: { conversationId },
            order: [['createdAt', 'ASC']],
        });

        // Giải mã tất cả tin nhắn trước khi gửi lại
        return messages.map(message => ({
            id: message.id,
            content: decrypt(message.content, message.iv),
            status: message.status,
        }));
    } catch (error) {
        throw new Error('Failed to retrieve messages');
    }
}

// Đánh dấu tin nhắn đã đọc
async function markMessagesAsRead(messageIds) {
    await Message.update(
        { status: 'read' },
        { where: { id: messageIds } }
    );
}

module.exports = {
    sendMessage,
    getMessages,
    markMessagesAsRead,
};
