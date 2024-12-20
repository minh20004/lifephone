<!-- LOGO -->
<div class="navbar-brand-box">
    <!-- Dark Logo-->
    <a href="#" class="logo logo-dark" style="color: #FFF; font-size: 23px;">
        <span >
            LIFEPHONE
        </span>
    </a>
    <!-- Light Logo-->
    <a href="#" class="logo logo-light" style="color: #FFF; font-size: 23px;">
        <span>
            LIFEPHONE
        </span>
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
                            <a href="dashboard-analytics.html" class="nav-link" data-key="t-analytics"> Analytics </a>
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
                                Tất cả người dùng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.hoso') }}" class="nav-link" data-key="t-signin"> 
                                Hồ sơ
                            </a>
                        </li>
                    </ul>
                </div>
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
                            <a href="{{route('product.index')}}" class="nav-link" data-key="t-team"> Sản phẩm  </a>
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
                            <a href="{{ route('chat') }}" class="nav-link" data-key="t-one-page"> chat </a>
                        </li>
                        <li class="nav-item">
                            <a href="nft-landing.html" class="nav-link" data-key="t-nft-landing"> NFT Landing </a>
                        </li>
                        <li class="nav-item">
                            <a href="job-landing.html" class="nav-link" data-key="t-job">Job</a>
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
</div>
<!-- Sidebar -->
</div>

<div class="sidebar-background"></div>