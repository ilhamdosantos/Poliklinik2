<div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../app/dist/img/dokter.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['nama_dokter'];?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="../dokter/dashboard.php" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <span class="badge badge-danger right">Dokter</span>
              </p>
            </a>
              <li class="nav-item">
                <a href="../dokter/jadwal_periksa.php" class="nav-link ">
                  <span class="badge badge-danger right">Dokter</span>
                  <i class="nav-icon fas fa-calendar-alt"></i>
                  <p>Jadwal Periksa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../dokter/periksa_pasien.php" class="nav-link">
                <span class="badge badge-danger right">Dokter</span>
                <i class="nav-icon fas fa-stethoscope"></i>
                
                  <p>Periksa Pasien</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../dokter/riwayat_pasien.php" class="nav-link">
                <span class="badge badge-danger right">Dokter</span>
                <i class="nav-icon fa fa-history"></i>
                  <p>Riwayat Pasien</p>
                </a>
              </li>
          </li>
          <li class="nav-item">
            <a href="../dokter/profil.php" class="nav-link">
            <i class="nav-icon fa fa-user-md"></i>
              <p>
                Profil
                <span class="badge badge-danger right">Dokter</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>