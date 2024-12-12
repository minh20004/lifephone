<!-- LOGO -->
<div class="navbar-brand-box">
    <!-- Dark Logo-->
    <a href="{{ route('admin.home') }}" class="logo logo-dark" style="color: #FFF; font-size: 23px;">
        <h1 class="text-white mt-3" style="color: #FFF; font-size: 23px;">Lifephone</h1>
    </a>
    <!-- Light Logo-->
    <a href="{{ route('admin.home') }}" class="logo logo-light" style="color: #FFF; font-size: 23px;">
        <h1 class="text-white mt-3" style="color: #FFF; font-size: 23px;">Lifephone</h1>
    </a>
    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
        <i class="ri-record-circle-line"></i>
    </button>
</div>

<div id="scrollbar">
    <div class="container-fluid">
        <div id="two-column-menu">
        </div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">Menu</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                    <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarDashboards">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link" data-key="t-analytics"> Xem trang </a>
                            <a href="{{ route('admin.home') }}" class="nav-link" data-key="t-analytics"> Thống kê </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('vouchers.index') }}" class="nav-link" data-key="t-job">Vouchers</a>
                        </li>
                    </ul>
                </div>
            </li> <!-- end Dashboard Menu -->
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                    <i class="ri-apps-2-line"></i> <span data-key="t-apps">Vouchers</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarApps">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('vouchers.index') }}" class="nav-link" data-key="t-chat"> Tất cả </a>
                        </li>
                        <li class="nav-item">
                            <a href="#sidebarEmail" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarEmail" data-key="t-email">
                                Email
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarEmail">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="apps-mailbox.html" class="nav-link" data-key="t-mailbox"> Mailbox </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#sidebaremailTemplates" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebaremailTemplates" data-key="t-email-templates">
                                            Email Templates
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebaremailTemplates">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="apps-email-basic.html" class="nav-link" data-key="t-basic-action"> Basic Action </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="apps-email-ecommerce.html" class="nav-link" data-key="t-ecommerce-action"> Ecommerce Action </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                    <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Layouts</span> <span class="badge badge-pill bg-danger" data-key="t-hot">Hot</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarLayouts">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="layouts-horizontal.html" target="_blank" class="nav-link" data-key="t-horizontal">Horizontal</a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts-detached.html" target="_blank" class="nav-link" data-key="t-detached">Detached</a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts-two-column.html" target="_blank" class="nav-link" data-key="t-two-column">Two Column</a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts-vertical-hovered.html" target="_blank" class="nav-link" data-key="t-hovered">Hovered</a>
                        </li>
                    </ul>
                </div>
            </li> <!-- end Dashboard Menu -->

            <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Pages</span></li>

            <li class="nav-item">
                @if (Auth::user()->role === 'admin')
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Thành viên</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.them-thanh-vien') }}" class="nav-link" data-key="t-signin">
                                    Thêm thành viên mới
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admins.index') }}" class="nav-link" data-key="t-signin">
                                    Tất cả Thành viên
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                    <i class="ri-pages-line"></i> <span data-key="t-pages">Quản lý Sản phẩm</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarPages">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{route('category.index')}}" class="nav-link" data-key="t-starter"> Danh mục </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('product-admin.index')}}" class="nav-link" data-key="t-team"> Sản phẩm  </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('product.trashed') }}" class="nav-link" data-key="t-timeline"> Sản phẩm đã bị xóa  </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('category.trashed') }}" class="nav-link" data-key="t-faqs"> Danh mục đã bị xóa </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('color.index')}}" class="nav-link" data-key="t-pricing"> Màu Sắc </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('capacity.index')}}" class="nav-link" data-key="t-gallery"> Dung lượng </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarPages1" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages1">
                    <i class="ri-pages-line"></i> <span data-key="t-pages">Quản lý tin tức</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarPages1">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{route('category_news.index')}}" class="nav-link" data-key="t-starter"> Danh mục tin tức </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('new_admin.index')}}" class="nav-link" data-key="t-team"> Tin tức </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('new_admin.create')}}" class="nav-link" data-key="t-team"> Thêm mới </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLanding">
                    <i class="ri-rocket-line"></i> <span data-key="t-landing">Quản lý đơn hàng</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarLanding">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('orders.index') }}" class="nav-link" data-key="t-one-page"> Đơn hàng </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('order.cancelRequests')}}" class="nav-link" data-key="t-nft-landing"> Hủy đơn hàng </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.notifications')}}" class="nav-link" data-key="t-job">Thông báo</a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- form --}}
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarForms" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarForms">
                    <i class="ri-file-list-3-line"></i> <span data-key="t-forms">Form nhận thông báo</span>
                </a>
                <div class="collapse menu-dropdown" id="sidebarForms">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{route('subscriptions.index')}}" class="nav-link" data-key="t-basic-elements">Danh sách người đăng kí</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('subscriptions.create') }}" class="nav-link" data-key="t-form-select">Gửi thông báo</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('subscriptions.index') }}" class="nav-link" data-key="t-checkboxs-radios">Danh sách tin đã gửi</a>
                        </li>
                        <li class="nav-item">
                            <a href="forms-pickers.html" class="nav-link" data-key="t-pickers"> Pickers </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="{{ route('admin.chatBoard') }}" style="position: relative;">
                    <i class="ri-pages-line"></i> <span data-key="t-pages">Chăm sóc khách hàng</span>
                    <span id="unreadMess" style="position:absolute; top: 50%; right:5%; border-radius: 50%; background-color: rgb(240 101 72); line-height:1; width:20px; height:20px; display:grid; place-items:center;font-weight:700;color:white; transform:translateY(-50%)">0</span>
                </a>
            </li>
            <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Components</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#sidebarUI" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUI">
                    <i class="ri-pencil-ruler-2-line"></i> <span data-key="t-base-ui">Base UI</span>
                </a>
                <div class="collapse menu-dropdown mega-dropdown-menu" id="sidebarUI">
                    <div class="row">
                        <div class="col-lg-4">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="ui-alerts.html" class="nav-link" data-key="t-alerts">Alerts</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-badges.html" class="nav-link" data-key="t-badges">Badges</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-buttons.html" class="nav-link" data-key="t-buttons">Buttons</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-colors.html" class="nav-link" data-key="t-colors">Colors</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-cards.html" class="nav-link" data-key="t-cards">Cards</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-carousel.html" class="nav-link" data-key="t-carousel">Carousel</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-dropdowns.html" class="nav-link" data-key="t-dropdowns">Dropdowns</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-grid.html" class="nav-link" data-key="t-grid">Grid</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="ui-images.html" class="nav-link" data-key="t-images">Images</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-tabs.html" class="nav-link" data-key="t-tabs">Tabs</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-accordions.html" class="nav-link" data-key="t-accordion-collapse">Accordion & Collapse</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-modals.html" class="nav-link" data-key="t-modals">Modals</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-offcanvas.html" class="nav-link" data-key="t-offcanvas">Offcanvas</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-placeholders.html" class="nav-link" data-key="t-placeholders">Placeholders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-progress.html" class="nav-link" data-key="t-progress">Progress</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-notifications.html" class="nav-link" data-key="t-notifications">Notifications</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="ui-media.html" class="nav-link" data-key="t-media-object">Media
                                        object</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-embed-video.html" class="nav-link" data-key="t-embed-video">Embed
                                        Video</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-typography.html" class="nav-link" data-key="t-typography">Typography</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-lists.html" class="nav-link" data-key="t-lists">Lists</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-links.html" class="nav-link"><span data-key="t-links">Links</span> <span class="badge badge-pill bg-success" data-key="t-new">New</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-general.html" class="nav-link" data-key="t-general">General</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-ribbons.html" class="nav-link" data-key="t-ribbons">Ribbons</a>
                                </li>
                                <li class="nav-item">
                                    <a href="ui-utilities.html" class="nav-link" data-key="t-utilities">Utilities</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>

    <li class="nav-item">
        <a class="nav-link menu-link" href="#sidebarAdvanceUI" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAdvanceUI">
            <i class="ri-stack-line"></i> <span data-key="t-advance-ui">Advance UI</span>
        </a>
        <div class="collapse menu-dropdown" id="sidebarAdvanceUI">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="advance-ui-sweetalerts.html" class="nav-link" data-key="t-sweet-alerts">Sweet
                        Alerts</a>
                </li>
                <li class="nav-item">
                    <a href="advance-ui-nestable.html" class="nav-link" data-key="t-nestable-list">Nestable
                        List</a>
                </li>
                <li class="nav-item">
                    <a href="advance-ui-scrollbar.html" class="nav-link" data-key="t-scrollbar">Scrollbar</a>
                </li>
                <li class="nav-item">
                    <a href="advance-ui-animation.html" class="nav-link" data-key="t-animation">Animation</a>
                </li>
                <li class="nav-item">
                    <a href="advance-ui-tour.html" class="nav-link" data-key="t-tour">Tour</a>
                </li>
                <li class="nav-item">
                    <a href="advance-ui-swiper.html" class="nav-link" data-key="t-swiper-slider">Swiper
                        Slider</a>
                </li>
                <li class="nav-item">
                    <a href="advance-ui-ratings.html" class="nav-link" data-key="t-ratings">Ratings</a>
                </li>
                <li class="nav-item">
                    <a href="advance-ui-highlight.html" class="nav-link" data-key="t-highlight">Highlight</a>
                </li>
                <li class="nav-item">
                    <a href="advance-ui-scrollspy.html" class="nav-link" data-key="t-scrollSpy">ScrollSpy</a>
                </li>
            </ul>
        </div>
    </li>

            <li class="nav-item">
                <a class="nav-link menu-link" href="widgets.html">
                    <i class="ri-honour-line"></i> <span data-key="t-widgets">Widgets</span>
                </a>
            </li>
        </ul>
    </div>
    </li>
    </li>

    </ul>

  <div class="toast-container position-fixed top-50 end-0 p-3">
      <div id="toast_new_mess" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
          <strong class="me-auto">Tin nhắn mới</strong>
          <small>Vừa xong</small>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
          Bạn có một tin nhắn mới!
        </div>
      </div>
    </div>
</div>
<!-- Sidebar -->
</div>

<div class="sidebar-background"></div>

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
    console.log('dashboard_data',data);
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
                    <img src="/storage/${conversation.customerAvatar}" alt="avatar"
                      class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                    <div class="pt-1">
                      <p class="fw-bold mb-0">${conversation.customerEmail}</p>
                      <p class="small text-muted">${conversation.lastMessageContent}</p>
                    </div>
                  </div>
                  <div class="pt-1">
                    <p class="small text-muted mb-1">${timeAgo}</p>
                    <span class="badge bg-danger float-end count-mess-unread" data-id="${conversation.conversationId}">${conversation.unreadMessagesCount}</span>
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
              <img src="/storage/${customer_info.customerAvatar}" alt="avatar"
                class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
              <div class="card">
                <div class="card-header d-flex justify-content-between p-3">
                  <p class="fw-bold mb-0 mx-3">${customer_info.customerEmail}</p>
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
              <img src="/storage/${customer_info.customerAvatar}" alt="avatar"
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

    // $('.count-mess-unread').each((item) => {
    //     if (item.parentElement.parentElement.parentElement.dataset.id == ConId) {
    //         $('#unreadMess').text(parseInt($('#unreadMess').text()) - parseInt(item.innerText));
    //         item.innerText = 0;
    //     }
    // });
    var elements = document.querySelectorAll('.count-mess-unread[data-id="' + ConId + '"]');
    let number_mess = parseInt($('#unreadMess').text()) - parseInt(elements[0].innerText);
    number_mess = number_mess > 0 ? number_mess : 0;
    $('#unreadMess').text();
    elements.innerText = 0;

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
              <p class="fw-bold mb-0 mx-3">${customer_info.customerEmail}</p>
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
    socket.emit('getDashboard');
    if (!window.location.href.includes('/admin/chatBoard')) {
        document.getElementById('unreadMess').innerText = parseInt(document.getElementById('unreadMess').innerText) + 1;
    }

    const messageContainer = document.querySelector('.message-customer');
    let new_img = '';
    if (data.senderType === 'customer') {
      new_img += `
        <li class="d-flex justify-content-start mb-4">
          <img src="${customer_info.customerAvatar}" alt="avatar"
            class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
          <div class="card">
            <div class="card-header d-flex justify-content-between p-3">
              <p class="fw-bold mb-0 mx-3">${customer_info.customerEmail}</p>
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
  });

  socket.on('broadcast_message', (data) => {
    console.log('broadcast_message', data);
    socket.emit('getDashboard');
    if (!window.location.href.includes('/admin/chatBoard')) {
        document.getElementById('unreadMess').innerText = parseInt(document.getElementById('unreadMess').innerText) + 1;
    }
    var toastEl = document.getElementById('toast_new_mess');
    var toast = new bootstrap.Toast(toastEl);
    toast.show();
  });

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
      socket.emit('join', conversationId, 'admin');
        $('.chat_btn_list').css('visibility', 'visible');
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

    const userId = @json(Auth::id());

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
