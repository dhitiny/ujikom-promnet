<?php
require 'function.php';

// cek login (kalau mau ketat)
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// ambil id dari URL
if (!isset($_GET['id'])) {
    header("Location: kategori.php");
    exit;
}
$id_kategori = (int) $_GET['id'];

// ambil data kategori yang mau diubah
$kategori = query("SELECT * FROM kategori WHERE id_kategori = $id_kategori");
if (count($kategori) === 0) {
    echo "Data kategori tidak ditemukan.";
    exit;
}
$kategori = $kategori[0];

// kalau form disubmit
if (isset($_POST['tombol_submit'])) {
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    $deskripsi     = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // update data
    $sql = "UPDATE kategori 
            SET nama_kategori = '$nama_kategori',
                deskripsi     = '$deskripsi'
            WHERE id_kategori = $id_kategori";

    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
                alert('Data kategori berhasil diubah!');
                document.location.href = 'kategori.php';
              </script>";
    } else {
        echo "<script>
                alert('Data kategori tidak berubah / gagal diubah!');
                document.location.href = 'kategori.php';
              </script>";
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>SIMBS | Ubah Kategori</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />

    <link rel="preload" href="dist/css/adminlte.min.css" as="style" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="dist/css/adminlte.min.css" />
  </head>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <!-- HEADER -->
      <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block">
              <a href="index.php" class="nav-link">Home</a>
            </li>
          </ul>

          <ul class="navbar-nav ms-auto">
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
                <li class="user-header text-bg-primary">
                  <img
                    src="dist/assets/img/user2-160x160.jpg"
                    class="rounded-circle shadow"
                    alt="User Image"
                  />
                  <p>
                    <?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?> - SIMBS User
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

      <!-- SIDEBAR -->
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
                    <a href="kategori.php" class="nav-link active">
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

      <!-- MAIN -->
      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Ubah Kategori</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item"><a href="kategori.php">Data Kategori</a></li>
                  <li class="breadcrumb-item active">Ubah Kategori</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <form action="" method="post">
                      <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input
                          type="text"
                          name="nama_kategori"
                          class="form-control"
                          value="<?= htmlspecialchars($kategori['nama_kategori']); ?>"
                          required
                        >
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea
                          name="deskripsi"
                          class="form-control"
                          rows="4"
                        ><?= htmlspecialchars($kategori['deskripsi']); ?></textarea>
                      </div>
                      <div class="mb-3">
                        <button type="submit" name="tombol_submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a href="kategori.php" class="btn btn-secondary btn-sm">Kembali</a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>  
            </div>
          </div>
        </div>
      </main>

      <footer class="app-footer">
        <div class="float-end d-none d-sm-inline">Bismillah Tugas Promnet</div>
        <strong>Copyright &copy; 2025</strong>
      </footer>
    </div>

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