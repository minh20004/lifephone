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
          <li class="nav flex-nowrap align-items-center position-relative">
            <img src="{{asset('client/img/home/electronics/vlog/01.jpg')}}" class="rounded" width="140" alt="Video cover">
            <div class="ps-3">
              <div class="fs-xs text-body-secondary lh-sm mb-2">6:16</div>
              <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="#!">5 New Cool Gadgets You Must See on Cartzilla - Cheap Budget</a>
            </div>
          </li>
          <li class="nav flex-nowrap align-items-center position-relative">
            <img src="{{asset('client/img/home/electronics/vlog/02.jpg')}}" class="rounded" width="140" alt="Video cover">
            <div class="ps-3">
              <div class="fs-xs text-body-secondary lh-sm mb-2">10:20</div>
              <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="#!">5 Super Useful Gadgets on Cartzilla You Must Have in 2023</a>
            </div>
          </li>
          <li class="nav flex-nowrap align-items-center position-relative">
            <img src="{{asset('client/img/home/electronics/vlog/03.jpg')}}" class="rounded" width="140" alt="Video cover">
            <div class="ps-3">
              <div class="fs-xs text-body-secondary lh-sm mb-2">8:40</div>
              <a class="nav-link fs-sm hover-effect-underline stretched-link p-0" href="#!">Top 5 New Amazing Gadgets on Cartzilla You Must See</a>
            </div>
          </li>
        </ul>
        <div class="nav ps-md-4 ps-lg-0">
          <a class="btn nav-link animate-underline text-decoration-none px-0" href="#!">
            <span class="animate-target">View all</span>
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
      <script type="module">
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
    </script>