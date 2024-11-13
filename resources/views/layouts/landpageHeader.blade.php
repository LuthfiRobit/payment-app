 <!-- Navbar start -->
 <nav class="navbar navbar-expand-lg shadow-lg border boder-button-2 sticky-top">
     <div class="container-fluid">
         <!-- Navbar brand (logo) -->
         <a class="navbar-brand" href="javascript:void(0);">
             <img src="{{ asset('template/images/logo_mi.png') }}" style="height: 45px" alt="" />
         </a>

         <!-- Navbar toggler (hamburger icon) on the right of brand in mobile view -->
         <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav"
             aria-controls="offcanvasNav" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>

         <!-- Main menu items (for large screen) -->
         <div class="collapse navbar-collapse justify-content-end d-none d-lg-flex" id="navbarNav">
             <ul class="navbar-nav">
                 <li class="nav-item nav-item-main">
                     <a class="nav-link nav-link-main fs-5" href="{{ url('/') }}#section-home">Beranda</a>
                 </li>
                 <li class="nav-item nav-item-main">
                     <a class="nav-link nav-link-main fs-5"
                         href="{{ url('/') }}#section-pendaftaran">Pendaftaran</a>
                 </li>
                 <li class="nav-item nav-item-main">
                     <a class="nav-link nav-link-main fs-5" href="{{ url('/') }}#section-tentang">Tentang</a>
                 </li>
             </ul>
         </div>

         <!-- Right side of navbar with theme toggle -->
         <div class="d-flex align-items-center ms-auto">
             <!-- Theme mode toggle dropdown -->
             <li class="nav-item dropdown notification_dropdown me-3">
                 <a class="nav-link bell dz-theme-mode" href="javascript:void(0);">
                     <i id="icon-light" class="fas fa-sun"></i>
                     <i id="icon-dark" class="fas fa-moon"></i>
                 </a>
             </li>
         </div>

         <!-- Offcanvas for mobile menu (nav-item-main) -->
         <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasNav"
             aria-labelledby="offcanvasNavLabel">
             <div class="offcanvas-header">
                 <img src="{{ asset('template/images/logo_mi.png') }}" style="height: 45px" alt="" />
                 <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
             </div>
             <div class="offcanvas-body">
                 <ul class="navbar-nav">
                     <li class="nav-item nav-item-main mb-3">
                         <a class="nav-link nav-link-main fs-5" href="{{ url('/') }}#section-home">Beranda</a>
                     </li>
                     <li class="nav-item nav-item-main mb-3">
                         <a class="nav-link nav-link-main fs-5"
                             href="{{ url('/') }}#section-pendaftaran">Pendaftaran</a>
                     </li>
                     <li class="nav-item nav-item-main mb-3">
                         <a class="nav-link nav-link-main fs-5" href="{{ url('/') }}#section-tentang">Tentang</a>
                     </li>
                 </ul>
             </div>
         </div>

     </div>
 </nav>
 <!-- Navbar end -->
