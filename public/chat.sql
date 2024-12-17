CREATE TABLE conversations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  userId INT,  -- Admin hiện tại
  customerId INT,  -- Customer tham gia cuộc trò chuyện
  status ENUM('on', 'off') DEFAULT 'on',  -- Trạng thái cuộc trò chuyện
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,  -- Admin tham gia
  FOREIGN KEY (customerId) REFERENCES customers(id) ON DELETE CASCADE
);

CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  conversationId INT,  -- Liên kết với bảng conversations
  senderId INT,  -- ID người gửi
  senderType ENUM('admin', 'customer') NOT NULL,  -- Xác định người gửi là admin hay customer
  content TEXT NOT NULL,  -- Nội dung tin nhắn (sẽ mã hóa)
  iv VARCHAR(32) NOT NULL,  -- Vector khởi tạo (IV) cho mã hóa
  status ENUM('unread', 'read') DEFAULT 'unread',  -- Trạng thái tin nhắn
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (conversationId) REFERENCES conversations(id) ON DELETE CASCADE,
-- Liên kết với bảng customers
);
