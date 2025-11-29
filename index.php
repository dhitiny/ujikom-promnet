<?php
require "function.php";
require_login(); // paksa user login

// konfigurasi paginasi
$limit   = 5; // data per halaman
$page    = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : "";
$offset  = ($page - 1) * $limit;

// ambil data buku & total untuk paginasi
$total_buku = count_buku($keyword);
$total_page = max(1, ceil($total_buku / $limit));

$daftar_buku = get_buku($keyword, $limit, $offset);
?>
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SIMBS | Data Buku</title>

    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Accessibility Features-->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="dist/css/adminlte.min.css" as="style" />
    <!--end::Accessibility Features-->

    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <!--end::Fonts-->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="dist/css/adminlte.min.css" />
    <!--end::Required Plugin(AdminLTE)-->
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block">
              <a href="#" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-md-block">
              <a href="#" class="nav-link">Contact</a>
            </li>
          </ul>
          <!--end::Start Navbar Links-->

          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="bi bi-search"></i>
              </a>
            </li>
            <!--end::Navbar Search-->

            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="dist/assets/img/user2-160x160.jpg"
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                <span class="d-none d-md-inline">
                  <?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary">
                  <img
                    src="dist/assets/img/user2-160x160.jpg"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                  <p>
                    <?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?> - SIMBS User
                    <small>Login SIMBS</small>
                  </p>
                </li>
                <!--end::User Image-->
                <!--begin::Menu Footer-->
                <li class="user-footer">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  <a href="logout.php" class="btn btn-default btn-flat float-end">Sign out</a>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->

      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <a href="index.php" class="brand-link">
            <img
              src="dist/assets/img/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <span class="brand-text fw-light">SIMBS</span>
          </a>
        </div>
        <!--end::Sidebar Brand-->

        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Data Master
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="index.php" class="nav-link active">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Data Buku</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="kategori.php" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Data Kategori</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-header">AUTENTIKASI</li>
              <li class="nav-item">
                <a href="logout.php" class="nav-link">
                  <i class="nav-icon bi bi-box-arrow-right"></i>
                  <p>Sign Out</p>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->

      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-3">Data Buku</h3>
                <a href="tambah_data.php" class="btn btn-primary btn-sm">Tambah Data</a>
              </div>
              <div class="col-sm-6 d-flex flex-column align-items-end">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Data Buku</li>
                </ol>
                <form class="mt-2" method="get">
                  <div class="input-group">
                    <input 
                      type="text" 
                      class="form-control" 
                      name="keyword" 
                      placeholder="Cari buku..."
                      value="<?= htmlspecialchars($keyword); ?>"
                    >
                    <button class="btn btn-primary" type="submit">
                      <i class="bi bi-search"></i> Cari
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!--end::App Content Header-->

        <!--begin::App Content-->
        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col">
                <!-- TABEL DATA BUKU -->
                <div class="card">
                  <div class="card-body">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>ID Buku</th>
                          <th>Judul Buku</th>
                          <th>Deskripsi</th>
                          <th>Tahun Terbit</th>
                          <th>Penulis</th>
                          <th>Cover</th>
                          <th>Kategori</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($daftar_buku) === 0): ?>
                          <tr>
                            <td colspan="9" class="text-center">Data buku belum ada.</td>
                          </tr>
                        <?php else: ?>
                          <?php foreach($daftar_buku as $i => $buku): ?>
                            <tr>
                              <td><?= $offset + $i + 1; ?></td>
                              <td><?= $buku['id_buku']; ?></td>
                              <td><?= htmlspecialchars($buku['judul_buku']); ?></td>
                              <td><?= htmlspecialchars($buku['deskripsi']); ?></td>
                              <td><?= htmlspecialchars($buku['tahun_terbit']); ?></td>
                              <td><?= htmlspecialchars($buku['nama_penulis']); ?></td>
                              <td>
                                <?php if(!empty($buku['cover_buku'])): ?>
                                  <img 
                                    src="img/<?= htmlspecialchars($buku['cover_buku']); ?>" 
                                    alt="Cover"
                                    style="width:60px; height:auto; object-fit:cover;"
                                  >
                                <?php else: ?>
                                  -
                                <?php endif; ?>
                              </td>
                              <td><?= htmlspecialchars($buku['nama_kategori']); ?></td>
                              <td>
                                <a href="ubah_buku.php?id=<?= $buku['id_buku']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="hapus_buku.php?id=<?= $buku['id_buku']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin hapus buku ini?');">
                                   Hapus
                                </a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </tbody>
                    </table>

                    <!-- PAGINASI -->
                    <nav>
                      <ul class="pagination">
                        <?php for($p = 1; $p <= $total_page; $p++): ?>
                          <li class="page-item <?= ($p == $page) ? 'active' : ''; ?>">
                            <a class="page-link"
                              href="?page=<?= $p; ?>&keyword=<?= urlencode($keyword); ?>">
                              <?= $p; ?>
                            </a>
                          </li>
                        <?php endfor; ?>
                      </ul>
                    </nav>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->

      <!--begin::Footer-->
      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">Bismillah Tugas Promnet</div>
        <strong>Copyright &copy; 2025</strong>
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->

    <!--begin::Scripts-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <script src="dist/js/adminlte.js"></script>
    <!--end::Scripts-->
  </body>
  <!--end::Body-->
</html>