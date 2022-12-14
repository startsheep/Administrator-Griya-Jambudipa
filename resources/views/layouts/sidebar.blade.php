
     <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <img src="{{ asset('assets/images/logo.png') }}"  class="avatar img-responsive"  alt="">
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">AGJ</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Menu Utama</li>

              <li class="nav-item {{ (request()->is('dashboard')) ? 'active' : '' }}">
                <a href="/dashboard" class="nav-link"><i class="fa-solid fa-chart-line"></i><span>Dashboard</span></a>
              </li>
              <li class="nav-item {{ (request()->is('pegawai')) ? 'active' : '' }}">
                <a href="/pegawai" class="nav-link"><i class="fa-solid fa-people-group"></i><span>Data Pegawai</span></a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="fa-solid fa-people-roof"></i><span>Data Customer</span></a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="fa-solid fa-cash-register"></i><span>Transaksi</span></a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="fa-solid fa-wallet"></i><span>Pembayaran</span></a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="fa-solid fa-id-card-clip"></i><span>Dokumen Customer</span></a>
              </li>
              <li class="menu-header">Data Master</li>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="fa-solid fa-building"></i><span>Profile Perusahaan</span></a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="fa-solid fa-building-columns"></i><span>Harga Dasar Bangunan</span></a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="fa-solid fa-signs-post"></i><span>Harga Dasar Tanah</span></a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="fa-solid fa-maximize"></i><span>Luas Tanah</span></a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link"><i class="fa-solid fa-house-circle-check"></i><span>Tipe Rumah</span></a>
              </li>
              <li>
                <a href="#" class="nav-link"><i class="fas fa-gear"></i><span>Settings</span></a></li>
            </ul>

        </aside>
      </div>
