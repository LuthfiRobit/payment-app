 <!-- Nav header start -->
 <div class="nav-header">
     <!-- Brand logo with different images for various screen sizes -->
     <a href="index.html" class="brand-logo">
         <!-- Logo for abbreviated view (e.g., mobile) -->
         <!-- <img class="logo-abbr" src="images/logo.png" alt="" /> -->
         <img class="logo-abbr" src="{{ asset('template/images/logo_mi.png') }}" alt="" />
         <!-- Compact logo with text (e.g., for sidebar) -->
         <!-- <img class="logo-compact" src="images/logo-text.png" alt="" /> -->
         <img class="logo-compact" src="{{ asset('template/images/logo_mi.png') }}" alt="" />
         <!-- Full brand title logo -->
         <!-- <img class="brand-title" src="images/logo-text.png" alt="" /> -->
         <!-- <img class="brand-title" src="images/logo-text.png" alt="" /> -->
     </a>

     <!-- Navigation control for mobile view -->
     <div class="nav-control">
         <div class="hamburger">
             <!-- Hamburger menu lines for toggling navigation -->
             <span class="line"></span><span class="line"></span><span class="line"></span>
         </div>
     </div>
 </div>
 <!-- Nav header end -->

 <!-- Header start -->
 <div class="header">
     <div class="header-content">
         <!-- Navbar with expandable and collapsible features -->
         <nav class="navbar navbar-expand">
             <div class="collapse navbar-collapse justify-content-between">
                 <!-- Left side of the header -->
                 <div class="header-left">
                     <!-- Dashboard bar placeholder -->
                     <div class="dashboard_bar"></div>
                 </div>
                 <!-- Right side of the header with navigation items -->
                 <ul class="navbar-nav header-right">
                     <!-- Weather detail item -->
                     <li class="nav-item">
                         <div class="d-flex weather-detail">
                             <span><i class="las la-cloud"></i></span>
                             Probolinggo, IDN
                         </div>
                     </li>
                     <!-- Theme mode toggle dropdown -->
                     <li class="nav-item dropdown notification_dropdown">
                         <a class="nav-link bell dz-theme-mode" href="javascript:void(0);">
                             <i id="icon-light" class="fas fa-sun"></i>
                             <i id="icon-dark" class="fas fa-moon"></i>
                         </a>
                     </li>
                     <!-- User profile dropdown -->
                     <li class="nav-item dropdown header-profile">
                         <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                             <div class="header-info">
                                 <span class="text-black">Hello,<strong>Franklin</strong></span>
                                 <p class="fs-12 mb-0">Super Admin</p>
                             </div>
                             <img src="{{ asset('template/images/profile/17.jpg') }}" width="20"
                                 alt="User Profile Picture" />
                         </a>
                         <!-- Dropdown menu with profile and logout options -->
                         <div class="dropdown-menu dropdown-menu-end">
                             <a href="app-profile.html" class="dropdown-item ai-icon">
                                 <i class="fas fa-user text-primary" style="font-size: 18px"></i>
                                 <span class="ms-2">Profile</span>
                             </a>
                             <a href="page-login.html" class="dropdown-item ai-icon">
                                 <i class="fas fa-sign-out-alt text-danger" style="font-size: 18px"></i>
                                 <span class="ms-2">Logout</span>
                             </a>
                         </div>
                     </li>
                 </ul>
             </div>
         </nav>
     </div>
 </div>
 <!-- Header end -->
