<!-- Sidebar start -->
<div class="deznav">
    <div class="deznav-scroll">
        <!-- Sidebar menu -->
        <ul class="metismenu" id="menu">
            <!-- Main section -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-chart-line fw-bold"></i>
                    <span class="nav-text">Main</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="index.html" class="fs-6">Dashboard</a></li>
                </ul>
            </li>
            <!-- Payment section -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-money-check-alt fw-bold"></i>
                    <span class="nav-text">Payment</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="payment_create.html" class="fs-6">Create Payment</a>
                    </li>
                    <li>
                        <a href="payment_history.html" class="fs-6">History Payment</a>
                    </li>
                </ul>
            </li>
            <!-- Master section -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-server fw-bold"></i>
                    <span class="nav-text">Master</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('master-data.tahun-akademik.index') }}" class="fs-6">Tahun Akademik</a></li>
                    <li><a href="{{ route('master-data.iuran.index') }}" class="fs-6">Iuran</a></li>
                    <li><a href="{{ route('master-data.potongan.index') }}" class="fs-6">Potongan</a></li>
                    <li><a href="{{ route('master-data.siswa.index') }}" class="fs-6">Siswa</a></li>
                </ul>
            </li>
            <!-- Fees section -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-rupiah-sign fw-bold"></i>
                    <span class="nav-text">Fees</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="fee_setting.html" class="fs-6">Fee Setting</a></li>
                    <li>
                        <a href="fee_exemption.html" class="fs-6">Fee Exemption</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Footer with copyright information -->
        <div class="copyright">
            <p><strong>Payment App</strong> © 2024 All Rights Reserved</p>
            <p>Developed by _LnH'79</p>
        </div>
    </div>
</div>
<!-- Sidebar end -->
