const sequelize = require('../config/database');
const Conversation = require('./Conversation');
const Message = require('./Message');

// Quan hệ giữa các bảng
Conversation.hasMany(Message, { foreignKey: 'conversationId' });
Message.belongsTo(Conversation, { foreignKey: 'conversationId' });

module.exports = {
    sequelize,
    Conversation,
    Message,
};
