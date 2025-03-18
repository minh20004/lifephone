// models/conversation.js
module.exports = (sequelize, DataTypes) => {
  const Conversation = sequelize.define('Conversation', {
      userId: {
          type: DataTypes.INTEGER,
          allowNull: false,
      },
      adminId: {
          type: DataTypes.INTEGER,
          allowNull: false,
      },
  });

  Conversation.associate = (models) => {
      // Một Conversation có nhiều Message
      Conversation.hasMany(models.Message, { foreignKey: 'conversationId' });
  };

  return Conversation;
};
