const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const mysql = require('mysql2');
const crypto = require('crypto');
const cors = require('cors'); // Import gói cors
const { type } = require('os');

// Tạo một ứng dụng Express
const app = express();
const server = http.createServer(app);
const io = socketIo(server, {
  cors: {
    origin: '*', // Thay bằng URL frontend của bạn
    methods: ['GET', 'POST']
  }
});

// Kết nối với cơ sở dữ liệu MySQL
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '0202',
  database: 'lifephone',
});

db.connect(err => {
  if (err) {
    console.error('Lỗi kết nối MySQL: ', err);
    return;
  }
  console.log('Đã kết nối tới MySQL');
});

// Định nghĩa khóa bí mật và IV (sử dụng cùng một giá trị khóa cho mã hóa và giải mã)
const password = 'my_super_secret_password_123'; // Đây là mật khẩu cố định của bạn

// Sử dụng PBKDF2 để tạo khóa từ mật khẩu và salt
const salt = Buffer.from('my_custom_salt_value', 'utf8'); // Salt cố định hoặc có thể sinh ngẫu nhiên
const secretKey = crypto.pbkdf2Sync(password, salt, 100000, 32, 'sha256');  // 32 bytes cho AES-256

const ivLength = 16; // AES-256 sử dụng IV có độ dài 16 byte (128 bit)

// Hàm mã hóa (encrypt)
function encryptMessage(content) {
  const iv = crypto.randomBytes(ivLength); // Tạo IV ngẫu nhiên
  const cipher = crypto.createCipheriv('aes-256-cbc', Buffer.from(secretKey, 'utf-8'), iv);
  let encrypted = cipher.update(content, 'utf-8', 'hex');
  encrypted += cipher.final('hex');
  return { encryptedContent: encrypted, iv: iv.toString('hex') }; // Trả về nội dung mã hóa và IV
}

// Hàm giải mã (decrypt)
function decryptMessage(encryptedContent, iv) {
  const decipher = crypto.createDecipheriv('aes-256-cbc', Buffer.from(secretKey, 'utf-8'), Buffer.from(iv, 'hex'));
  let decrypted = decipher.update(encryptedContent, 'hex', 'utf-8');
  decrypted += decipher.final('utf-8');
  return decrypted;
}

// Lắng nghe sự kiện "join"
io.on('connection', socket => {
  console.log('Có người dùng mới kết nối: ' + socket.id);

  // Khi người dùng tham gia vào cuộc trò chuyện
  socket.on('join', (conversationId, senderType) => {
    console.log(`User ${socket.id} joined conversation ${conversationId}`);

    socket.join(conversationId);
        console.log(`User ${socket.id} joined existing conversation ${conversationId}`);

      // Lấy tin nhắn của cuộc trò chuyện này từ database
      const query = `
        SELECT * FROM messages
        WHERE conversationId = ?
        ORDER BY created_at ASC LIMIT 50;
      `;
      db.query(query, [conversationId], (err, messages) => {
        if (err) {
          console.error('Lỗi khi lấy tin nhắn:', err);
          return;
        }
        let decryptedMessages = [];
        let decryptedContent ;

        if(messages.length > 0){
          decryptedMessages = messages.map(message => {
            decryptedContent = decryptMessage(message.content, message.iv); // Giải mã tin nhắn
            return {
              ...message,
              content: decryptedContent, // Thay đổi nội dung đã giải mã
            };
          });
          io.to(conversationId).emit('previous_messages', decryptedMessages);

        }else {
          io.to(conversationId).emit('previous_messages', []);
        }

        console.log('-------------')
        console.log('emit du lieu ve trong join',conversationId, decryptedMessages, messages)
        console.log('-------------')


        const updateQuery = `
          UPDATE messages
          SET status = 'read'
          WHERE conversationId = ?
            AND senderType = ?
            AND status = 'unread';
        `;

        const oppositeSenderType = senderType === 'admin' ? 'customer' : 'admin';

        db.query(updateQuery, [conversationId, oppositeSenderType], (updateErr) => {
          if (updateErr) {
            console.error('Lỗi khi cập nhật tin nhắn:', updateErr);
          } else {
            console.log(`Cập nhật trạng thái tin nhắn thành 'read' cho senderType ${oppositeSenderType}`);
          }
        });
    });
  });

  // Khi có một tin nhắn mới từ người dùng
  socket.on('sendMessage', (data) => {
    const { conversationId, senderId, senderType, content, type } = data;

    // Mã hóa tin nhắn trước khi lưu vào cơ sở dữ liệu
    console.log('content client emit:::::::::::',content)
    const { encryptedContent, iv } = encryptMessage(content);

    const room = io.sockets.adapter.rooms[conversationId];
    const lengthPeers = room ? room.length : 0;
    const status_mess = lengthPeers == 2 ? 'read' : 'unread'

    // Lưu tin nhắn vào cơ sở dữ liệu (tin nhắn đã mã hóa)
    const query = `
    INSERT INTO messages (conversationId, senderId, senderType, content, iv, status, type, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, NOW());
    `;
    db.query(query, [conversationId, senderId, senderType, encryptedContent, iv, status_mess, type], (err, results) => {
      if (err) {
          console.error('Lỗi khi lưu tin nhắn:', err);
          return;
      }

      // Tin nhắn mới đã được lưu, phát lại cho tất cả những người tham gia cuộc trò chuyện
      const newMessage = {
          id: results.insertId,
          conversationId,
          senderId,
          senderType,
          message: content,
          created_at: new Date(),
          type: type,
      };

      // Phát tin nhắn mới đến tất cả những người tham gia trong room (conversationId)
      io.to(conversationId).emit('new_message', newMessage);
    });
  });

  socket.on('sendImg', (data) => {
    const { conversationId, senderId, senderType, content, type } = data;

    const { encryptedContent, iv } = encryptMessage(content);

    const room = io.sockets.adapter.rooms[conversationId];
    const lengthPeers = room ? room.length : 0;
    const status_mess = lengthPeers == 2 ? 'read' : 'unread'

    const query = `
    INSERT INTO messages (conversationId, senderId, senderType, content, iv, status, type, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, NOW());
    `;
    db.query(query, [conversationId, senderId, senderType, encryptedContent, iv, status_mess, type], (err, results) => {
      if (err) {
          console.error('Lỗi khi lưu tin nhắn:', err);
          return;
      }

      // Tin nhắn mới đã được lưu, phát lại cho tất cả những người tham gia cuộc trò chuyện
      const newMessage = {
          id: results.insertId,
          conversationId,
          senderId,
          senderType,
          img: content,
          created_at: new Date(),
          type: type,
      };

      // Phát tin nhắn mới đến tất cả những người tham gia trong room (conversationId)
      io.to(conversationId).emit('new_img', newMessage);
    });
  })

  socket.on('getDashboard',(data) => {
    console.log('get dash board')
      // Query để lấy 10 cuộc trò chuyện gần nhất với customer và tin nhắn cuối cùng
      const query = `
      SELECT
          c.id AS conversationId,
          c.customerId,
          cu.name AS customerName,
          cu.avatar AS customerAvatar,
          m.content AS lastMessageContent,
          m.iv AS lastMessageIV,
          m.created_at AS lastMessageCreatedAt,
          IFNULL(
              (SELECT COUNT(*)
              FROM messages m2
              WHERE m2.conversationId = c.id
              AND m2.status = 'unread'
              AND m2.senderType = 'customer'), 0) AS unreadMessagesCount
      FROM conversations c
      JOIN customers cu ON c.customerId = cu.id
      JOIN messages m ON m.conversationId = c.id
      WHERE m.id = (
          SELECT m2.id
          FROM messages m2
          WHERE m2.conversationId = c.id
          ORDER BY m2.created_at DESC
          LIMIT 1
      )
      ORDER BY c.updated_at DESC
      LIMIT 10;
    `;

    db.query(query, (err, results) => {
      if (err) {
        console.error('Lỗi khi lấy dashboard:', err);
        return;
      }
      let decryptedContent = [];
      let decryptedResults = [];
      console.log(results,'000000000000000000000000')
      if(results.length > 0){
        decryptedResults = results.map(result => {
          decryptedContent = decryptMessage(result.lastMessageContent, result.lastMessageIV); // Giải mã tin nhắn cuối
          return {
            ...result,
            lastMessageContent: decryptedContent,  // Thay thế nội dung đã giải mã
          };
        });
      }

      // Trả lại danh sách cuộc trò chuyện
      console.log('emit du lieu ve trong get dashboard', decryptedResults)
      socket.emit('dashboard_data', decryptedResults);
    });
  })

  // Khi người dùng ngắt kết nối
  socket.on('disconnect', () => {
    console.log('User disconnected: ' + socket.id);
  });
});

// Cấu hình Express để lắng nghe trên cổng 3000
server.listen(3000, () => {
  console.log('Server đang chạy trên cổng 3000');
});