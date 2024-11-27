<style>
  /* Cấu hình cho nút chat */
  .chat-buttonC {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: rgb(34, 41, 52);
      color: white;
      border: none;
      padding: 15px;
      border-radius: 50%;
      font-size: 18px;
      cursor: pointer;
      z-index: 5000;
  }

  /* Cấu hình cho cửa sổ chat */
  .chat-boxC {
      position: fixed;
      bottom: 20px;
      right: 80px;
      width: 300px;
      height: 100%;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 10px;
      display: none;  /* Ẩn cửa sổ chat ban đầu */
      flex-direction: column;
      z-index: 5000;
  }

  .chat-headerC {
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      background-color: rgb(34, 41, 52);;
      color: white !important;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 16px !important;
  }

  .messagesC {
      padding: 10px;
      flex-grow: 1;
      overflow-y: auto;
      background-color: #f9f9f9;
  }

  #messageInputC {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
  }

  .send-btnC {
      width: 100%;
      padding: 10px;
      background-color: rgb(34, 41, 52);;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
  }

  .close-btnC {
      background: none;
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
  }

  @media (max-width: 767px) {
    /* Giảm kích thước nút chat trên màn hình nhỏ */
    .chat-buttonC {
        padding: 10px;
        font-size: 20px;  /* Giảm kích thước icon */
        bottom: 15px;
        right: 15px;
    }

    /* Điều chỉnh cửa sổ chat cho màn hình nhỏ */
    .chat-boxC {
        width: 250px;  /* Rút gọn chiều rộng cửa sổ chat */
        height: 350px; /* Rút gọn chiều cao cửa sổ chat */
        right: 60px;
    }

    /* Điều chỉnh header của cửa sổ chat */
    .chat-headerC {
        font-size: 14px;  /* Giảm kích thước font header */
    }

    /* Các tin nhắn sẽ được hiển thị với khoảng cách nhỏ hơn */
    .messagesC {
        padding: 8px;
    }

    #messageInputC {
        padding: 8px;
        font-size: 14px;  /* Giảm kích thước font input */
    }

    .send-btnC {
        padding: 8px;
        font-size: 14px;  /* Giảm kích thước font button */
    }

    .close-btnC {
        font-size: 16px;  /* Giảm kích thước close button */
    }
  }

  @media (max-width: 1024px) {
    .chat-button {
        padding: 12px;
        font-size: 22px;  /* Giảm kích thước icon ở máy tính bảng */
    }

    .chat-box {
        width: 280px;
        height: 380px;
    }

    .chat-header {
        font-size: 15px;
    }

    #messageInput {
        padding: 10px;
        font-size: 15px;
    }

    .send-btn {
        padding: 10px;
        font-size: 15px;
    }
  }

</style>
<!-- Subscription form + Vlog -->
<section class="bg-body-tertiary py-5">
  <div class="container pt-sm-2 pt-md-3 pt-lg-4 pt-xl-5">
    <div class="row">
      <div class="col-md-6 col-lg-5 mb-5 mb-md-0">
        <h2 class="h4 mb-2">Đăng ký nhận bản tin của chúng tôi</h2>
        <p class="text-body pb-2 pb-ms-3">Nhận thông tin cập nhật mới nhất về sản phẩm và chương trình khuyến mãi của chúng tôi</p>
        <form class="d-flex needs-validation pb-1 pb-sm-2 pb-md-3 pb-lg-0 mb-4 mb-lg-5"
              action="{{ route('subscriptions.store') }}" method="POST" novalidate="">
            @csrf
            <div class="position-relative w-100 me-2">
                <input type="email" name="email" class="form-control form-control-lg" placeholder="Your email" required="">
            </div>
            <button type="submit" class="btn btn-lg btn-primary">Nhận thông báo</button>
        </form>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="d-flex gap-3">
          <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Instagram">
            <i class="ci-instagram fs-base"></i>
          </a>
          <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Facebook">
            <i class="ci-facebook fs-base"></i>
          </a>
          <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="YouTube">
            <i class="ci-youtube fs-base"></i>
          </a>
          <a class="btn btn-icon btn-secondary rounded-circle" href="#!" aria-label="Telegram">
            <i class="ci-telegram fs-base"></i>
          </a>
        </div>
      </div>
      <div class="col-md-6 col-lg-5 col-xl-4 offset-lg-1 offset-xl-2">
        <ul class="list-unstyled d-flex flex-column gap-4 ps-md-4 ps-lg-0 mb-3">
          @foreach($latestNews as $news)
          <li class="nav flex-nowrap align-items-center position-relative">
              <!-- Hình ảnh bài viết -->
              <img src="{{ asset('storage/' . $news->thumbnail) }}" class="rounded" width="140" alt="{{ $news->title }}">

              <!-- Thông tin bài viết -->
              <div class="ps-3">
                  <!-- Thời gian đăng bài -->
                  <div class="fs-xs text-body-secondary lh-sm mb-2">
                      {{ $news->created_at->format('H:i') }}
                  </div>

                  <!-- Tiêu đề bài viết -->
                  <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="{{ route('news.show', $news->slug) }}">
                      {{ $news->title }}
                  </a>
              </div>
          </li>
      @endforeach
        </ul>
        <div class="nav ps-md-4 ps-lg-0">
          <a class="btn nav-link animate-underline text-decoration-none px-0" href="{{ route('news.index') }}">
            <span class="animate-target">Xem tất cả</span>
            <i class="ci-chevron-right fs-base ms-1"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<span class="position-absolute top-0 start-0 w-100 h-100 bg-body d-none d-block-dark"></span>
      <div class="container position-relative z-1 pt-sm-2 pt-md-3 pt-lg-4" data-bs-theme="dark">

        <!-- Columns with links that are turned into accordion on screens < 500px wide (sm breakpoint) -->
        <div class="accordion py-5" id="footerLinks">
          <div class="row">
            <div class="col-md-4 d-sm-flex flex-md-column align-items-center align-items-md-start pb-3 mb-sm-4">
              <h4 class="mb-sm-0 mb-md-4 me-4">
                <a class="text-dark-emphasis text-decoration-none" href="index.html">Cartzilla</a>
              </h4>
              <p class="text-body fs-sm text-sm-end text-md-start mb-sm-0 mb-md-3 ms-0 ms-sm-auto ms-md-0 me-4">Got questions? Contact us 24/7</p>
              <div class="dropdown" style="max-width: 250px">
                <button type="button" class="btn btn-light dropdown-toggle justify-content-between w-100 d-none-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Help and consultation
                </button>
                <button type="button" class="btn btn-secondary dropdown-toggle justify-content-between w-100 d-none d-flex-dark" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Help and consultation
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#!">Help center &amp; FAQ</a></li>
                  <li><a class="dropdown-item" href="#!">Support chat</a></li>
                  <li><a class="dropdown-item" href="#!">Open support ticket</a></li>
                  <li><a class="dropdown-item" href="#!">Call center</a></li>
                </ul>
              </div>
            </div>
            <div class="col-md-8">
              <div class="row row-cols-1 row-cols-sm-3 gx-3 gx-md-4">
                <div class="accordion-item col border-0">
                  <h6 class="accordion-header" id="companyHeading">
                    <span class="text-dark-emphasis d-none d-sm-block">Company</span>
                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#companyLinks" aria-expanded="false" aria-controls="companyLinks">Company</button>
                  </h6>
                  <div class="accordion-collapse collapse d-sm-block" id="companyLinks" aria-labelledby="companyHeading" data-bs-parent="#footerLinks">
                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">About company</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Our team</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Careers</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Contact us</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">News</a>
                      </li>
                    </ul>
                  </div>
                  <hr class="d-sm-none my-0">
                </div>
                <div class="accordion-item col border-0">
                  <h6 class="accordion-header" id="accountHeading">
                    <span class="text-dark-emphasis d-none d-sm-block">Account</span>
                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#accountLinks" aria-expanded="false" aria-controls="accountLinks">Account</button>
                  </h6>
                  <div class="accordion-collapse collapse d-sm-block" id="accountLinks" aria-labelledby="accountHeading" data-bs-parent="#footerLinks">
                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Your account</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Shipping rates &amp; policies</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Refunds &amp; replacements</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Delivery info</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Order tracking</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Taxes &amp; fees</a>
                      </li>
                    </ul>
                  </div>
                  <hr class="d-sm-none my-0">
                </div>
                <div class="accordion-item col border-0">
                  <h6 class="accordion-header" id="customerHeading">
                    <span class="text-dark-emphasis d-none d-sm-block">Customer service</span>
                    <button type="button" class="accordion-button collapsed py-3 d-sm-none" data-bs-toggle="collapse" data-bs-target="#customerLinks" aria-expanded="false" aria-controls="customerLinks">Customer service</button>
                  </h6>
                  <div class="accordion-collapse collapse d-sm-block" id="customerLinks" aria-labelledby="customerHeading" data-bs-parent="#footerLinks">
                    <ul class="nav flex-column gap-2 pt-sm-3 pb-3 mt-n1 mb-1">
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Payment methods</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Money back guarantee</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Product returns</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Support center</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Shipping</a>
                      </li>
                      <li class="d-flex w-100 pt-1">
                        <a class="nav-link animate-underline animate-target d-inline fw-normal text-truncate p-0" href="#!">Terms &amp; conditions</a>
                      </li>
                    </ul>
                  </div>
                  <hr class="d-sm-none my-0">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Category / tag links -->
        <div class="d-flex flex-column gap-3 pb-3 pb-md-4 pb-lg-5 mt-n2 mt-sm-n4 mt-lg-0 mb-4">
          <ul class="nav align-items-center text-body-tertiary gap-2">
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Computers</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Smartphones</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">TV, Video</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Speakers</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Cameras</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Printers</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Video Games</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Headphones</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Wearable</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">HDD/SSD</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Smart Home</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Apple Devices</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Tablets</a>
            </li>
          </ul>
          <ul class="nav align-items-center text-body-tertiary gap-2">
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Monitors</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Scanners</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Servers</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Heating and Cooling</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">E-readers</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Data Storage</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Networking</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Power Strips</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Plugs and Outlets</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Detectors and Sensors</a>
            </li>
            <li class="px-1">/</li>
            <li class="animate-underline">
              <a class="nav-link fw-normal p-0 animate-target" href="#!">Accessories</a>
            </li>
          </ul>
        </div>

        <!-- Copyright + Payment methods -->
        <div class="d-md-flex align-items-center border-top py-4">
          <div class="d-flex gap-2 gap-sm-3 justify-content-center ms-md-auto mb-4 mb-md-0 order-md-2">
            <div>
              <img src="client/img/payment-methods/visa-dark-mode.svg" alt="Visa">
            </div>
            <div>
              <img src="client/img/payment-methods/mastercard.svg" alt="Mastercard">
            </div>
            <div>
              <img src="client/img/payment-methods/paypal-dark-mode.svg" alt="PayPal">
            </div>
            <div>
              <img src="client/img/payment-methods/google-pay-dark-mode.svg" alt="Google Pay">
            </div>
            <div>
              <img src="client/img/payment-methods/apple-pay-dark-mode.svg" alt="Apple Pay">
            </div>
          </div>
          <p class="text-body fs-xs text-center text-md-start mb-0 me-4 order-md-1">© All rights reserved. Made by <span class="animate-underline"><a class="animate-target text-dark-emphasis fw-medium text-decoration-none" href="https://createx.studio/" target="_blank" rel="noreferrer">Createx Studio</a></span></p>
        </div>
      </div>

      <button id="chatButtonC" class="chat-buttonC" style="line-height: 1;"><i class="fa-regular fa-comment"></i></button>
      <div id="chatBoxC" class="chat-boxC">
        <div class="chat-headerC">
            <p class="m-0">Chat with Admin</p>
            <button id="closeChatC" class="close-btnC">X</button>
        </div>
        <div id="messagesC" class="messagesC"></div>
        <input id="messageInputC" type="text" placeholder="Type your message..." />
        <!-- Nút gửi tin nhắn -->
        <div class="d-flex">
          <button id="sendMessageC" class="send-btnC w-75">Send</button>
          <button id="uploadImageC" class="upload-btnC w-25" style="border: none; border-radius:10px;">📷 <span id="imageCount">0</span></button>
        </div>
        <!-- Nút tải ảnh -->
        <input type="file" id="imageInputC" class="image-input" accept="image/*" />
      </div>

      <!-- <script type="module">
        // Import Firebase SDKs
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-app.js";
        import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-auth.js";
        import { getDatabase, ref, push, set, onValue } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-database.js";

        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyBLLwzBZbaTTFXyFQivnv5Nr3PQSNU-Gaw",
            authDomain: "lifephone-3cf47.firebaseapp.com",
            projectId: "lifephone-3cf47",
            storageBucket: "lifephone-3cf47.firebasestorage.app",
            messagingSenderId: "327624309067",
            appId: "1:327624309067:web:1dacaecec6351c889750ce",
            measurementId: "G-0L8MLP1BX9"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const database = getDatabase(app);

        // Handle User Sign Up
        function signUp() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            createUserWithEmailAndPassword(auth, email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    console.log('User signed up: ', user);
                })
                .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                    console.error(errorCode, errorMessage);
                });
        }

        // Handle User Sign In
        function signIn() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            signInWithEmailAndPassword(auth, email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    console.log('User signed in: ', user);
                })
                .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                    console.error(errorCode, errorMessage);
                });
        }

        // Listen for Auth State Change (if user is logged in)
        onAuthStateChanged(auth, (user) => {
            const chatContainer = document.getElementById('chatContainer');
            if (user) {
                chatContainer.style.display = 'block'; // Show chat container when logged in
            } else {
                chatContainer.style.display = 'none'; // Hide chat when not logged in
            }
        });

        // Handle Sign Out
        function signOutUser() {
            signOut(auth).then(() => {
                console.log('User signed out');
            }).catch((error) => {
                console.error('Error signing out:', error);
            });
        }

        // Send Message Function
        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const messageContent = messageInput.value;

            if (messageContent.trim() !== "") {
                const messagesRef = ref(database, 'messages');
                const newMessageRef = push(messagesRef);
                set(newMessageRef, {
                    content: messageContent,
                    timestamp: Date.now()
                });

                // Clear the input field
                messageInput.value = "";
            }
        }

        // Listen for New Messages
        function listenForMessages() {
            const messagesRef = ref(database, 'messages');
            onValue(messagesRef, (snapshot) => {
                const messages = snapshot.val();
                const chatBox = document.getElementById('chatBox');
                chatBox.innerHTML = ""; // Clear existing messages

                // Display each message
                for (const messageId in messages) {
                    const message = messages[messageId];
                    const messageElement = document.createElement('div');
                    messageElement.textContent = message.content;
                    chatBox.appendChild(messageElement);
                }
            });
        }

        // Listen for new messages when the page loads
        window.onload = listenForMessages;
    </script> -->
  <script>
    // Kết nối tới server Socket.IO
    var socket = null;
    var conversationId = null;
    var customerId = null;

    // Lấy các phần tử DOM
    const chatButton = document.getElementById("chatButtonC");
    const chatBox = document.getElementById("chatBoxC");
    const closeChat = document.getElementById("closeChatC");
    const sendMessage = document.getElementById("sendMessageC");
    const messageInput = document.getElementById("messageInputC");
    const messagesDiv = document.getElementById("messagesC");
    const messageImg = document.getElementById('imageInputC');

    document.getElementById('uploadImageC').addEventListener('click', function() {
        document.getElementById('imageInputC').click(); // Kích hoạt ô chọn tệp khi nhấn nút
    });

    let imageCount = 0;
    document.getElementById('imageInputC').addEventListener('change', function(event) {
    const files = event.target.files;  // Lấy các tệp được chọn
    if (files.length > 0) {
        imageCount += files.length;  // Cập nhật số lượng ảnh đã tải lên
        console.log(imageCount)
        // Cập nhật hiển thị số lượng ảnh trên nút tải ảnh
        document.getElementById('imageCount').textContent = imageCount;
    }
});

    // Khi người dùng bấm nút "Chat with Admin"
    chatButton.addEventListener("click", () => {
        // Gửi yêu cầu join vào room với admin
        // socket.emit('join', conversationId, userId, senderType);
        console.log('Chat with Admin');
        customerId = @json(Auth::guard('customer')->check() ? Auth::guard('customer')->user()->id : null);
        chatBox.style.display = "flex";  // Mở cửa sổ chat
        $.ajax({
          url: 'http://localhost:8000/api/getConversation',
          type: 'POST',
          data: {
            customerId: customerId,
          },
          success: function(data) {
            console.log(data);
            conversationId = data.conversationId;
            socket = io('http://localhost:3000');
            socket.emit('join',conversationId, 'customer')

            socket.on('previous_messages', (data) => {
              console.log('--------------')
              console.log('previous_messages', data);
              console.log('--------------')

              data.forEach((message) => {
                const messageElement = document.createElement("div");

                // Kiểm tra senderType để quyết định kiểu hiển thị
                if(message.type == 'text'){
                  if (message.senderType === 'customer') {
                      // Nếu là admin, căn trái và áp dụng các lớp CSS cho admin
                      messageElement.classList.add('d-flex', 'justify-content-end', 'mb-3');
                      messageElement.innerHTML = `
                          <div class="message-bubble text-white p-2 rounded" style="max-width: 75%;background-color:rgb(77 87 103);">
                              ${message.content}
                          </div>
                      `;
                  } else {
                      // Nếu là customer, căn phải và áp dụng các lớp CSS cho customer
                      messageElement.classList.add('d-flex', 'justify-content-star', 'mb-3');
                      messageElement.innerHTML = `
                          <div class="message-bubble text-dark p-2 rounded" style="max-width: 75%;background-color:rgb(222 222 222);">
                              ${message.content}
                          </div>
                      `;
                  }
                }else if(message.type == 'img'){
                  if (message.senderType === 'customer') {
                      // Nếu là admin, căn trái và áp dụng các lớp CSS cho admin
                      messageElement.classList.add('d-flex', 'justify-content-end', 'mb-3');
                      messageElement.innerHTML = `
                          <div class="message-bubble text-white p-2 rounded" style="max-width: 75%;background-color:rgb(77 87 103);">
                            <img src="${message.content}" class="w-100" alt="">
                          </div>
                      `;
                  } else {
                      // Nếu là customer, căn phải và áp dụng các lớp CSS cho customer
                      messageElement.classList.add('d-flex', 'justify-content-star', 'mb-3');
                      messageElement.innerHTML = `
                          <div class="message-bubble text-dark p-2 rounded" style="max-width: 75%;background-color:rgb(222 222 222);">
                            <img src="${message.content}" class="w-100" alt="">
                          </div>
                      `;
                  }
                }

                // Thêm phần tử tin nhắn vào phần tử DOM chứa tin nhắn (messagesDiv)
                messagesDiv.appendChild(messageElement);
              });
              messagesDiv.scrollTop = messagesDiv.scrollHeight;  // Cuộn xuống cuối tin nhắn
            });

            socket.on('new_message', (data) => {
              console.log('++++++++++++++++');
              console.log('new_message', data);
              console.log('++++++++++++++++');

              let messageElement;

              if (data.senderType === 'customer') {
                    // Nếu là admin, căn trái và áp dụng các lớp CSS cho admin
                    messageElement = `
                        <div class="d-flex justify-content-end mb-3">
                          <div class="message-bubble text-white p-2 rounded" style="max-width: 75%;background-color:rgb(77 87 103);">
                              ${data.message}
                          </div>
                      </div>
                    `;
                } else {
                    // Nếu là customer, căn phải và áp dụng các lớp CSS cho customer
                    messageElement = `
                        <div class="d-flex justify-content-star mb-3">
                          <div class="message-bubble text-dark p-2 rounded" style="max-width: 75%;background-color:rgb(222 222 222);">
                              ${data.message}
                          </div>
                      </div>
                    `;
                }
                messagesDiv.innerHTML += messageElement;
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            });

            socket.on('new_img', (data) => {
              let messageElement = document.createElement("div");

              if (data.senderType === 'customer') {
                    // Nếu là admin, căn trái và áp dụng các lớp CSS cho admin
                    messageElement.classList.add('d-flex', 'justify-content-end', 'mb-3');
                    messageElement.innerHTML = `
                        <div class="message-bubble text-white p-2 rounded" style="max-width: 75%;background-color:rgb(77 87 103);">
                           <img src="${data.content}" class="w-100" alt="">
                        </div>
                    `;
                } else {
                    // Nếu là customer, căn phải và áp dụng các lớp CSS cho customer
                    messageElement.classList.add('d-flex', 'justify-content-star', 'mb-3');
                    messageElement.innerHTML = `
                        <div class="message-bubble text-dark p-2 rounded" style="max-width: 75%;background-color:rgb(222 222 222);">
                            <img src="${data.content}" class="w-100" alt="">
                        </div>
                    `;
                }
              messagesDiv.innerHTML += messageElement;
              messagesDiv.scrollTop = messagesDiv.scrollHeight;
            })
          },
          error: function(e) {
            console.log(e);
          }
        });
    });

    // Khi người dùng đóng cửa sổ chat
    closeChat.addEventListener("click", () => {
        chatBox.style.display = "none";  // Ẩn cửa sổ chat
    });

    // Khi người dùng gửi tin nhắn
    sendMessage.addEventListener("click", () => {
        const message = messageInput.value.trim();
        const fileInput = messageImg.files[0];
        if (message) {
            // Gửi tin nhắn tới server
            socket.emit("sendMessage", {
              conversationId: conversationId,
              senderId: customerId,
              senderType: 'customer',
              content: message,
              type: 'text',
            });
            console.log('sendMessage', message);
            messageInput.value = "";  // Xóa nội dung sau khi gửi
        }
        if(fileInput){
          const reader = new FileReader();
          reader.onloadend = function() {
              const base64Image = reader.result;

              // Gửi ảnh qua socket
              socket.emit("sendImg", {
                  conversationId: conversationId,
                  senderId: customerId,
                  senderType: 'customer',
                  content: base64Image, // Dữ liệu ảnh base64
                  type: 'img'
              });
          };
          console.log('send img', fileInput)
          reader.readAsDataURL(fileInput); // Đọc ảnh thành base64
          document.getElementById('imageInputC').value = "";  // Reset input ảnh
          imageCount = 0;  // Reset số lượng ảnh
          document.getElementById('imageCount').textContent = imageCount;
        }
    });

    // Nhận các tin nhắn từ server
    // socket.on("receive_message", (message) => {
    //     const messageElement = document.createElement("div");
    //     messageElement.textContent = message;
    //     messagesDiv.appendChild(messageElement);
    //     messagesDiv.scrollTop = messagesDiv.scrollHeight;  // Cuộn xuống cuối tin nhắn
    // });

  </script>
