const { Sequelize } = require('sequelize');

// Kết nối đến cơ sở dữ liệu đã có trong Laravel
const sequelize = new Sequelize({
    host: 'localhost',   // Địa chỉ máy chủ cơ sở dữ liệu của bạn
    dialect: 'mysql',    // Hoặc 'postgres', 'mariadb', ...
    username: 'root',    // Tên người dùng cơ sở dữ liệu
    password: '',        // Mật khẩu cơ sở dữ liệu
    database: 'chat_db', // Tên cơ sở dữ liệu
    logging: false,
});

module.exports = sequelize;
