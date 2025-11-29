<?php
session_start();
require 'function.php';

// cek sudah login atau belum (optional, kalau di project kamu dipakai)
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// ambil id buku dari URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = (int) $_GET['id'];

// ambil data buku lama
$buku = query("SELECT * FROM buku WHERE id_buku = $id")[0];

// ambil semua kategori (buat isi dropdown)
$kategori = query("SELECT * FROM kategori");

// kalau tombol simpan diklik
if (isset($_POST['tombol_simpan'])) {

    // tambahin id ke $_POST (buat dipakai di fungsi ubah_buku)
    $_POST['id_buku'] = $id;

    if (ubah_buku($_POST) > 0) {
        echo "<script>
                alert('Data buku berhasil diubah!');
                document.location.href = 'index.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Data buku gagal diubah!');
                document.location.href = 'index.php';
              </script>";
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SIMBS | Ubah Data Buku</title>

    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->

    <!--begin::Primary Meta Tags-->
    <meta name="title" content="SIMBS | Ubah Data Buku" />
    <meta name="author" content="Naquinity" />
    <!--end::Primary Meta Tags-->

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
        <div class="container-fluid">
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

          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="bi bi-search"></i>
              </a>
            </li>

            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img
                  src="dist/assets/img/user2-160x160.jpg"
                  class="user-image rounded-circle shadow"
                  alt="User Image"
                />
                <span class="d-none d-md-inline"><?= $_SESSION['username']; ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <li class="user-header text-bg-primary">
                  <img
                    src="dist/assets/img/user2-160x160.jpg"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                  <p>
                    <?= $_SESSION['username']; ?> - Web Developer
                    <small>Member Naquinity since August 2024</small>
                  </p>
                </li>
                <li class="user-footer">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                  <a href="logout.php" class="btn btn-default btn-flat float-end">Sign out</a>
                </li>
              </ul>
            </li>

          </ul>
        </div>
      </nav>
      <!--end::Header-->

      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
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

        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
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
                    <a href="index.php" class="nav-link">
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
      </aside>
      <!--end::Sidebar-->

      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Ubah Data Buku</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item"><a href="index.php">Data Buku</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Ubah Data</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--end::App Content Header-->

        <!--begin::App Content-->
        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6">
                <!-- FORM UBAH BUKU -->
                <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="id_buku" value="<?= $buku['id_buku']; ?>">
                  <input type="hidden" name="cover_lama" value="<?= $buku['cover_buku']; ?>">

                  <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input 
                      type="text" 
                      class="form-control" 
                      name="judul_buku" 
                      value="<?= $buku['judul_buku']; ?>" 
                      required
                    >
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Kategori Buku</label>
                    <select name="id_kategori" class="form-select" required>
                      <option value="">-- Pilih Kategori --</option>
                      <?php foreach($kategori as $k): ?>
                        <option 
                          value="<?= $k['id_kategori']; ?>" 
                          <?= $k['id_kategori'] == $buku['id_kategori'] ? 'selected' : '' ?>
                        >
                          <?= $k['nama_kategori']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea 
                      class="form-control" 
                      name="deskripsi" 
                      rows="3"
                    ><?= $buku['deskripsi']; ?></textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input 
                      type="text" 
                      class="form-control" 
                      name="tahun_terbit" 
                      value="<?= $buku['tahun_terbit']; ?>"
                    >
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Nama Penulis</label>
                    <input 
                      type="text" 
                      class="form-control" 
                      name="nama_penulis" 
                      value="<?= $buku['nama_penulis']; ?>"
                    >
                  </div>

                  <div class="mb-3">
                    <label class="form-label d-block">Cover Lama</label>
                    <?php if($buku['cover_buku']) : ?>
                      <img 
                        src="img/cover/<?= $buku['cover_buku']; ?>" 
                        alt="Cover" 
                        style="height:120px;border-radius:4px;"
                      >
                    <?php else: ?>
                      <small class="text-muted">Belum ada cover.</small>
                    <?php endif; ?>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Ganti Cover (opsional)</label>
                    <input 
                      type="file" 
                      class="form-control" 
                      name="cover_buku"
                    >
                    <small class="form-text text-muted">
                      Format: jpg/jpeg/png/webp, max 3MB.
                    </small>
                  </div>

                  <div class="mb-3">
                    <button type="submit" class="btn btn-primary btn-sm" name="tombol_simpan">Simpan</button>
                    <a href="index.php" class="btn btn-secondary btn-sm">Kembali</a>
                  </div>
                </form>
                <!-- END FORM -->
              </div>
            </div>
          </div>
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->

      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">Bismillah Tugas Promnet</div>
        <strong>Copyright &copy; 2025</strong>
      </footer>
    </div>

    <!-- JS -->
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
  </body>
</html>