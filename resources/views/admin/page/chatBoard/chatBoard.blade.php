<style>
  ::-webkit-scrollbar {
    width: 12px;  /* Chiều rộng của thanh cuộn */
    height: 12px; /* Chiều cao của thanh cuộn ngang */
}

::-webkit-scrollbar-thumb {
    background-color: #888;  /* Màu sắc của phần "thumb" (phần di chuyển của thanh cuộn) */
    border-radius: 10px;  /* Bo tròn góc của phần thumb */
}

::-webkit-scrollbar-thumb:hover {
    background-color: #555;  /* Thay đổi màu khi hover */
}

::-webkit-scrollbar-track {
    background-color: #f1f1f1;  /* Màu nền của khu vực thanh cuộn */
    border-radius: 10px;  /* Bo tròn góc của thanh cuộn */
}

::-webkit-scrollbar-track:hover {
    background-color: #e0e0e0;  /* Thay đổi màu khi hover */
}

/* Tạo một lớp mới cho phần chứa (div) để tạo giao diện đẹp */
.custom-textarea-wrapper {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 10px; /* Bo tròn các góc */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Thêm bóng mờ nhẹ */
}

/* Tùy chỉnh textarea */
.custom-textarea {
    background-color: #f8f9fa; /* Màu nền nhẹ cho textarea */
    border: 1px solid #ced4da; /* Viền nhẹ */
    border-radius: 8px; /* Bo tròn góc */
    padding: 8px 12px; /* Padding vừa phải */
    resize: none; /* Tắt khả năng thay đổi kích thước */
    width: 100%; /* Đảm bảo textarea chiếm hết chiều rộng */
    height: 40px; /* Đảm bảo chiều cao hợp lý */
    box-sizing: border-box; /* Bao gồm padding trong chiều rộng */
    transition: border-color 0.2s ease-in-out; /* Thêm hiệu ứng khi thay đổi viền */
}

.custom-textarea:focus {
    border-color: #80bdff; /* Màu viền khi focus */
    outline: none; /* Xóa viền ngoài khi focus */
}

/* Tùy chỉnh nút gửi */
.custom-send-btn {
    background-color: #17a2b8; /* Màu nền của nút gửi */
    border-radius: 50%; /* Bo tròn nút */
    padding: 12px; /* Cung cấp padding để nút lớn hơn */
    border: none; /* Xóa viền mặc định */
    color: white; /* Màu chữ */
    font-size: 20px; /* Tăng kích thước biểu tượng */
    transition: background-color 0.3s ease; /* Thêm hiệu ứng khi hover */
}

.custom-send-btn:hover {
    background-color: #138496; /* Màu nền khi hover */
}

/* Tùy chỉnh nút chọn ảnh */
.custom-attach-btn {
    background-color: #f8f9fa; /* Màu nền cho nút chọn ảnh */
    border-radius: 50%; /* Bo tròn nút */
    padding: 12px; /* Padding cho nút */
    border: 1px solid #ced4da; /* Viền nhẹ */
    color: #495057; /* Màu chữ */
    font-size: 20px; /* Kích thước biểu tượng */
    transition: background-color 0.3s ease, border-color 0.3s ease; /* Thêm hiệu ứng khi hover */
}

.custom-attach-btn:hover {
    background-color: #e9ecef; /* Màu nền khi hover */
    border-color: #80bdff; /* Thay đổi màu viền khi hover */
}

/* Ẩn input file */
.custom-file-input {
    display: none;
}
</style>
@extends('admin.layout.master')

@section('content')
  <div class="page-content">
    <div class="row pt-3">

      <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

        <h5 class="font-weight-bold mb-3 text-center text-lg-start">Member</h5>

        <div class="card">
          <div class="card-body">

            <ul class="list-unstyled mb-0">
            </ul>

          </div>
        </div>

      </div>

      <div class="col-md-6 col-lg-7 col-xl-8" style="border-radius:20px;background-color: #d8cccc36;">

        <ul class="list-unstyled message-customer" style="max-height: 78vh;overflow-y:scroll;">
          <li class="d-flex justify-content-between mb-4">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
              class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
            <div class="card">
              <div class="card-header d-flex justify-content-between p-3">
                <p class="fw-bold mb-0">Brad Pitt</p>
                <p class="text-muted small mb-0"><i class="far fa-clock"></i> 12 mins ago</p>
              </div>
              <div class="card-body">
                <p class="mb-0">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                  labore et dolore magna aliqua.
                </p>
              </div>
            </div>
          </li>
          <li class="d-flex justify-content-between mb-4">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
              class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
            <div class="card">
              <div class="card-header d-flex justify-content-between p-3">
                <p class="fw-bold mb-0">Brad Pitt</p>
                <p class="text-muted small mb-0"><i class="far fa-clock"></i> 12 mins ago</p>
              </div>
              <div class="card-body">
                <p class="mb-0">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                  labore et dolore magna aliqua.
                </p>
              </div>
            </div>
          </li>
          <li class="d-flex justify-content-between mb-4">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
              class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
            <div class="card">
              <div class="card-header d-flex justify-content-between p-3">
                <p class="fw-bold mb-0">Brad Pitt</p>
                <p class="text-muted small mb-0"><i class="far fa-clock"></i> 12 mins ago</p>
              </div>
              <div class="card-body">
                <p class="mb-0">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                  labore et dolore magna aliqua.
                </p>
              </div>
            </div>
          </li>
          <li class="d-flex justify-content-between mb-4">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
              class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
            <div class="card">
              <div class="card-header d-flex justify-content-between p-3">
                <p class="fw-bold mb-0">Brad Pitt</p>
                <p class="text-muted small mb-0"><i class="far fa-clock"></i> 12 mins ago</p>
              </div>
              <div class="card-body">
                <p class="mb-0">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                  labore et dolore magna aliqua.
                </p>
              </div>
            </div>
          </li>
          <li class="d-flex justify-content-between mb-4">
            <div class="card w-100">
              <div class="card-header d-flex justify-content-between p-3">
                <p class="fw-bold mb-0">Lara Croft</p>
                <p class="text-muted small mb-0"><i class="far fa-clock"></i> 13 mins ago</p>
              </div>
              <div class="card-body">
                <p class="mb-0">
                  Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                  laudantium.
                </p>
              </div>
            </div>
          </li>
          <li class="d-flex justify-content-between mb-4">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
              class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
            <div class="card">
              <div class="card-header d-flex justify-content-between p-3">
                <p class="fw-bold mb-0">Brad Pitt</p>
                <p class="text-muted small mb-0"><i class="far fa-clock"></i> 10 mins ago</p>
              </div>
              <div class="card-body">
                <p class="mb-0">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                  labore et dolore magna aliqua.
                </p>
              </div>
            </div>
          </li>

        </ul>

          <div class="custom-textarea-wrapper mb-3">
            <div class="d-flex align-items-center">
                <!-- Textarea để nhập tin nhắn -->
                <textarea class="form-control custom-textarea" style="outline: none;" id="textAreaExample2" rows="1" placeholder="Type a message"></textarea>

                <!-- Input file để chọn ảnh -->
                <input type="file" id="fileInput" class="custom-file-input" accept="image/*">

                <!-- Nút Gửi -->
                <button type="button" id="sendButton" onclick="sendMess()" class="btn custom-send-btn ms-2">
                    <i class="fas fa-paper-plane"></i>
                </button>

                <!-- Nút Chọn Ảnh -->
                <button type="button" id="attachButton" class="btn custom-attach-btn ms-2">
                    <i class="fas fa-paperclip"></i>
                </button>
            </div>
        </div>
      </div>

    </div>
  </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.8.1/socket.io.js" integrity="sha512-8BHxHDLsOHx+flIrQ0DrZcea7MkHqRU5GbTHmbdzMRnAaoCIkZ97PqZcXJkKZckMMhqfoeaJE+DNUVuyoQsO3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  const socket = io('http://localhost:3000');
  console.log(socket);
  socket.emit('getDashboard');
  var listConversations = [];
  var ConId = null;
  var customer_info = null;

  socket.on('dashboard_data',(data)=>{
    let list_conservations = '';
    listConversations = data;
    data.forEach(conversation => {
      const lastMessageDate = new Date(conversation.lastMessageCreatedAt);
      const now = new Date();

      // Tính toán sự chênh lệch thời gian giữa hiện tại và lastMessageCreatedAt
      const timeDifference = now - lastMessageDate;
      let timeAgo = 'Just now';

      const seconds = Math.floor(timeDifference / 1000); // Chuyển đổi sang giây
      const minutes = Math.floor(seconds / 60); // Chuyển đổi sang phút
      const hours = Math.floor(minutes / 60); // Chuyển đổi sang giờ
      const days = Math.floor(hours / 24); // Chuyển đổi sang ngày

      // Tính toán thời gian chênh lệch và hiển thị
      if (seconds < 60) {
        timeAgo = `${seconds} second${seconds === 1 ? '' : 's'} ago`;
      } else if (minutes < 60) {
        timeAgo = `${minutes} minute${minutes === 1 ? '' : 's'} ago`;
      } else if (hours < 24) {
        timeAgo = `${hours} hour${hours === 1 ? '' : 's'} ago`;
      } else if (days < 30) {
        timeAgo = `${days} day${days === 1 ? '' : 's'} ago`;
      } else {
        timeAgo = lastMessageDate.toLocaleDateString(); // Hiển thị theo định dạng ngày nếu quá 30 ngày
      }
      let item_html = ` <li class="p-2 border-bottom bg-body-tertiary con-item" data-id = "${conversation.conversationId}">
                <a href="#!" class="d-flex justify-content-between">
                  <div class="d-flex flex-row">
                    <img src="${conversation.customerAvatar}" alt="avatar"
                      class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                    <div class="pt-1">
                      <p class="fw-bold mb-0">${conversation.customerName}</p>
                      <p class="small text-muted">${conversation.lastMessageContent}</p>
                    </div>
                  </div>
                  <div class="pt-1">
                    <p class="small text-muted mb-1">${timeAgo}</p>
                    <span class="badge bg-danger float-end count-mess-unread">${conversation.unreadMessagesCount}</span>
                  </div>
                </a>
              </li>`
      list_conservations += item_html;
    });
    document.querySelector('.list-unstyled').innerHTML = list_conservations;
  });

  socket.on('previous_messages', (data) => {
    console.log('--------------')
    console.log('previous_messages', data);
    console.log('--------------')


    const messageContainer = document.querySelector('.message-customer'); // Đây là phần tử chứa danh sách tin nhắn
    customer_info = listConversations.find(conversation => conversation.conversationId == data[0].conversationId);
    ConId = data[0].conversationId;
    let messageHtml = '';
    data.forEach((message) => {
      messageContainer.innerHTML = '';
      // Kiểm tra xem người gửi là admin hay customer để tạo HTML tương ứng
      if(message.type == 'text'){
        if (message.senderType === 'customer') {
          messageHtml += `
            <li class="d-flex justify-content-start mb-4">
              <img src="${customer_info.customerAvatar}" alt="avatar"
                class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
              <div class="card">
                <div class="card-header d-flex justify-content-between p-3">
                  <p class="fw-bold mb-0 mx-3">${customer_info.customerName}</p>
                  <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${calTime(message.created_at)}</p>
                </div>
                <div class="card-body">
                  <p class="mb-0">${message.content}</p>
                </div>
              </div>
            </li>
          `;
        } else if (message.senderType === 'admin') {
          messageHtml += `
            <li class="d-flex justify-content-end mb-4">
              <div class="card">
                <div class="card-header d-flex justify-content-between p-3">
                  <p class="fw-bold mb-0 mx-3">Admin</p>
                  <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${calTime(message.created_at)}</p>
                </div>
                <div class="card-body">
                  <p class="mb-0">${message.content}</p>
                </div>
              </div>
            </li>
          `;
        }
      }else if(message.type == 'img'){
        if (message.senderType === 'customer') {
          messageHtml += `
            <li class="d-flex justify-content-start mb-4">
              <img src="${customer_info.customerAvatar}" alt="avatar"
                class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
              <div class="card">
                <div class="card-header d-flex justify-content-between p-3">
                  <p class="fw-bold mb-0 mx-3">${customer_info.customerName}</p>
                  <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${calTime(message.created_at)}</p>
                </div>
                <div class="card-body">
                  <img src="${message.content}" class="w-100" alt="">
                </div>
              </div>
            </li>
          `;
        } else if (message.senderType === 'admin') {
          messageHtml += `
            <li class="d-flex justify-content-end mb-4">
              <div class="card">
                <div class="card-header d-flex justify-content-between p-3">
                  <p class="fw-bold mb-0 mx-3">Admin</p>
                  <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${calTime(message.created_at)}</p>
                </div>
                <div class="card-body">
                  <img src="${message.content}" class="w-100" alt="">
                </div>
              </div>
            </li>
          `;
        }
      }
    });
    $('.count-mess-unread').text(0);
    messageContainer.innerHTML += messageHtml;
    var list = document.querySelector('.message-customer');
    list.scrollTop = list.scrollHeight;  // Cuộn đến cuối cùng
  });


  socket.on('new_message', (data) => {
    console.log('++++++++++++++++');
    console.log('new_message', data);
    console.log('++++++++++++++++');

    const messageContainer = document.querySelector('.message-customer'); // Đây là phần tử chứa danh sách tin nhắn
    let messageHtml = '';
    // Kiểm tra xem người gửi là admin hay customer để tạo HTML tương ứng
    if (data.senderType === 'customer') {
      messageHtml += `
        <li class="d-flex justify-content-start mb-4">
          <img src="${customer_info.customerAvatar}" alt="avatar"
            class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
          <div class="card">
            <div class="card-header d-flex justify-content-between p-3">
              <p class="fw-bold mb-0 mx-3">${customer_info.customerName}</p>
              <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${calTime(data.created_at)}</p>
            </div>
            <div class="card-body">
              <p class="mb-0">${data.message}</p>
            </div>
          </div>
        </li>
      `;
    } else if (data.senderType === 'admin') {
      messageHtml += `
        <li class="d-flex justify-content-end mb-4">
          <div class="card">
            <div class="card-header d-flex justify-content-between p-3">
              <p class="fw-bold mb-0 mx-3">Admin</p>
              <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${calTime(data.created_at)}</p>
            </div>
            <div class="card-body">
              <p class="mb-0">${data.message}</p>
            </div>
          </div>
        </li>
      `;
    }
    messageContainer.innerHTML += messageHtml;
    var list = document.querySelector('.message-customer');
    list.scrollTop = list.scrollHeight;  // Cuộn đến cuối cùng
  });

  socket.on('new_img', (data) => {
    console.log('++++++++++++++++');
    console.log('new_img', data);
    console.log('++++++++++++++++');

    const messageContainer = document.querySelector('.message-customer');
    let new_img = '';
    if (data.senderType === 'customer') {
      new_img += `
        <li class="d-flex justify-content-start mb-4">
          <img src="${customer_info.customerAvatar}" alt="avatar"
            class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
          <div class="card">
            <div class="card-header d-flex justify-content-between p-3">
              <p class="fw-bold mb-0 mx-3">${customer_info.customerName}</p>
              <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${calTime(data.created_at)}</p>
            </div>
            <div class="card-body">
              <img src="${data.img}" class="w-100" alt="">
            </div>
          </div>
        </li>
      `;
    } else if (data.senderType === 'admin') {
      new_img += `
        <li class="d-flex justify-content-end mb-4">
          <div class="card">
            <div class="card-header d-flex justify-content-between p-3">
              <p class="fw-bold mb-0 mx-3">Admin</p>
              <p class="text-muted small mb-0"><i class="far fa-clock"></i> ${calTime(data.created_at)}</p>
            </div>
            <div class="card-body">
              <img src="${data.img}" class="w-100" alt="">
            </div>
          </div>
        </li>
      `;
    }

    messageContainer.innerHTML += new_img;
    var list = document.querySelector('.message-customer');
    list.scrollTop = list.scrollHeight;  // Cuộn đến cuối cùng
  })

  setTimeout(() => {
    document.querySelector('.message-customer').addEventListener('scroll', function() {
      var list = this;
      if (list.scrollTop == 0) {
          console.log('Đã đến đầu danh sách');
          // Thực hiện hành động bạn muốn khi cuộn đến đầu
      }
    });
  }, 200);


  // Xử lý khi nhấn nút gửi
  document.addEventListener('DOMContentLoaded', function() {
    // Mở input file khi nhấn vào nút đính kèm
    document.getElementById('attachButton').addEventListener('click', function() {
      console.log('Attach button clicked');
      document.getElementById('fileInput').click();
      document.getElementById('fileInput').classList.remove('d-none');
    });

    $('.con-item').click(function(){
      const conversationId = $(this).data('id');
      console.log(conversationId);
      // socket.emit('getMessages',conversationId);
      socket.emit('join', conversationId, 'admin');

    });
  })

  function calTime(createAt){
    const lastMessageDate = new Date(createAt);
    const now = new Date();

    // Tính toán sự chênh lệch thời gian giữa hiện tại và lastMessageCreatedAt
    const timeDifference = now - lastMessageDate;
    let timeAgo = 'Just now';

    const seconds = Math.floor(timeDifference / 1000); // Chuyển đổi sang giây
    const minutes = Math.floor(seconds / 60); // Chuyển đổi sang phút
    const hours = Math.floor(minutes / 60); // Chuyển đổi sang giờ
    const days = Math.floor(hours / 24); // Chuyển đổi sang ngày

    // Tính toán thời gian chênh lệch và hiển thị
    if (seconds < 60) {
      timeAgo = `${seconds} second${seconds === 1 ? '' : 's'} ago`;
    } else if (minutes < 60) {
      timeAgo = `${minutes} minute${minutes === 1 ? '' : 's'} ago`;
    } else if (hours < 24) {
      timeAgo = `${hours} hour${hours === 1 ? '' : 's'} ago`;
    } else if (days < 30) {
      timeAgo = `${days} day${days === 1 ? '' : 's'} ago`;
    } else {
      timeAgo = lastMessageDate.toLocaleDateString(); // Hiển thị theo định dạng ngày nếu quá 30 ngày
    }
    return timeAgo;
  }

  function sendMess(){
    const textMessage = document.getElementById('textAreaExample2').value;
    const fileInput = document.getElementById('fileInput').files[0];

    const userId = @json($admin->id);

    if (textMessage) {
        socket.emit("sendMessage", {
            conversationId: ConId,
            senderId: userId,
            senderType: 'admin',
            content: textMessage,
            type: 'text',
        });
    }

    if (fileInput) {
        const reader = new FileReader();
        reader.onloadend = function() {
            const base64Image = reader.result;

            // Gửi ảnh qua socket
            socket.emit("sendImg", {
                conversationId: ConId,
                senderId: userId,
                senderType: 'admin',
                content: base64Image, // Dữ liệu ảnh base64
                type: 'img'
            });
        };
        reader.readAsDataURL(fileInput); // Đọc ảnh thành base64
    }
    document.getElementById('textAreaExample2').value = '';
    document.getElementById('fileInput').value = '';
    console.log('Send button clicked',textMessage, ConId, fileInput);
  }






</script>
