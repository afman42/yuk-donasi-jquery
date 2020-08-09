<?php
use DB as DBA;
$user = DBA::table('biodata_donatur')->where('user_id', auth()->user()->id)->first();
// dd($user);
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">YKI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          {{-- {{ dd(auth()->user()->biodata_donatur->gambar)}} --}}
          @if ($user !== null)
            <img src="{{ url($user->gambar) }}" class="img-circle elevation-2" alt="User Image">              
          @else
            <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
          @endif
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->username }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          {{-- Admin --}}
          <li class="nav-item">
              <a href="{{ route('penggalang-dana.beranda') }}" class="nav-link" id="beranda">
                  <i class="fas fa-tachometer-alt nav-icon"></i>
                  <p>Beranda</p>
              </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('posting-donasi.index') }}" class="nav-link" id="mel-posting">
                <i class="fas fa-sticky-note nav-icon"></i>
                <p>Postingan Donasi</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('bank.index') }}" class="nav-link" id="bank">
                <i class="fas fa-university nav-icon"></i>
                <p>Bank</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('penggalang-dana.pengaturan-akun') }}" class="nav-link" id="pengaturan">
                <i class="fas fa-cog nav-icon"></i>
                <p>Ubah Password</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('penggalang-dana.biodata') }}" class="nav-link" id="profil">
                <i class="fas fa-user nav-icon"></i>
                <p>Biodata</p>
            </a>
          </li>
          <li class="nav-item">
            <form action="{{ route('penggalang-dana.logout') }}" method="post">
              @csrf
              <button type="submit" class="nav-link btn-block">
                  <i class="fas fa-sign-out-alt nav-icon"></i>Keluar
              </button>
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>