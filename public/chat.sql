CREATE TABLE conversations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  userId INT,  -- Liên kết với bảng users (admin)
  customerId INT,  -- Liên kết với bảng customers (người dùng)
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
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
  FOREIGN KEY (senderId) REFERENCES users(id) ON DELETE CASCADE,  -- Liên kết với bảng users
  FOREIGN KEY (senderId) REFERENCES customers(id) ON DELETE CASCADE -- Liên kết với bảng customers
);
