<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// KONEKSI DATABASE (PAKAI DB SIMBS)
$conn = mysqli_connect("localhost", "root", "", "simbs");

// Helper query umum
function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

/* ============================================================
   FUNGSI BUKU (dipakai di index.php, tambah_data, dst)
   Tabel: buku
   Kolom: id_buku, judul_buku, id_kategori, deskripsi,
          cover_buku, tahun_terbit, nama_penulis, tanggal_input
   ============================================================ */

// Ambil semua buku (+ join kategori), bisa pakai keyword & limit (buat paginasi)
function get_buku($keyword = "", $limit = 5, $offset = 0){
    global $conn;

    $keyword = mysqli_real_escape_string($conn, $keyword);

    $where = "";
    if($keyword !== ""){
        $where = "WHERE 
            b.judul_buku LIKE '%$keyword%' OR
            b.nama_penulis LIKE '%$keyword%' OR
            k.nama_kategori LIKE '%$keyword%'";
    }

    $sql = "SELECT b.*, k.nama_kategori 
            FROM buku b
            LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
            $where
            ORDER BY b.tanggal_input DESC
            LIMIT $limit OFFSET $offset";

    return query($sql);
}

// Hitung total baris buku (buat paginasi)
function count_buku($keyword = ""){
    global $conn;
    $keyword = mysqli_real_escape_string($conn, $keyword);

    $where = "";
    if($keyword !== ""){
        $where = "WHERE 
            judul_buku LIKE '%$keyword%' OR
            nama_penulis LIKE '%$keyword%'";
    }

    $sql = "SELECT COUNT(*) AS total FROM buku $where";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return (int)$row['total'];
}

// ======================================
// Tambah buku (dipanggil dari tambah_data.php)
// ======================================
function tambah_buku($data){
    global $conn;

    $judul       = htmlspecialchars($data['judul_buku']);
    $id_kategori = (int)$data['id_kategori'];
    $deskripsi   = htmlspecialchars($data['deskripsi']);
    $tahun       = htmlspecialchars($data['tahun_terbit']);
    $penulis     = htmlspecialchars($data['nama_penulis']);

    // upload cover
    $nama_file = upload_cover();
    if(!$nama_file){
        return 0;
    }

    $query = "INSERT INTO buku 
                (judul_buku, id_kategori, deskripsi, tahun_terbit, nama_penulis, cover_buku, tanggal_input)
              VALUES
                ('$judul', '$id_kategori', '$deskripsi', '$tahun', '$penulis', '$nama_file', NOW())";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function ubah_buku($data){
    global $conn;

    $id          = (int)$data['id_buku'];
    $judul       = htmlspecialchars($data['judul_buku']);
    $id_kategori = (int)$data['id_kategori'];
    $deskripsi   = htmlspecialchars($data['deskripsi']);
    $tahun       = htmlspecialchars($data['tahun_terbit']);
    $penulis     = htmlspecialchars($data['nama_penulis']);
    $cover_lama  = $data['cover_lama'];

    // cek: user upload cover baru atau nggak
    if (!isset($_FILES['cover_buku']) || $_FILES['cover_buku']['error'] === 4) {
        // nggak upload → pakai cover lama
        $nama_file = $cover_lama;
    } else {
        // upload baru
        $nama_file = upload_cover();

        // kalau upload berhasil & ada cover lama → hapus file lama
        if ($nama_file && $cover_lama && file_exists('img/' . $cover_lama)) {
            unlink('img/' . $cover_lama);
        }
    }

    $query = "UPDATE buku SET
                judul_buku   = '$judul',
                id_kategori  = '$id_kategori',
                deskripsi    = '$deskripsi',
                tahun_terbit = '$tahun',
                nama_penulis = '$penulis',
                cover_buku   = '$nama_file'
              WHERE id_buku = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// Ambil 1 buku by id (buat halaman edit nanti kalau kamu bikin)
function get_buku_by_id($id_buku){
    global $conn;
    $id_buku = (int)$id_buku;
    $result = mysqli_query($conn, "SELECT * FROM buku WHERE id_buku = $id_buku");
    return mysqli_fetch_assoc($result);
}

// Ubah data buku (kalau kamu bikin halaman edit)
function ubah_data($data){
    global $conn;

    $id_buku    = (int)$data['id_buku'];
    $judul      = mysqli_real_escape_string($conn, $data['judul_buku']);
    $id_kat     = (int)$data['id_kategori'];
    $deskripsi  = mysqli_real_escape_string($conn, $data['deskripsi']);
    $cover      = mysqli_real_escape_string($conn, $data['cover_buku']);
    $tahun      = mysqli_real_escape_string($conn, $data['tahun_terbit']);
    $penulis    = mysqli_real_escape_string($conn, $data['nama_penulis']);

    $query = "UPDATE buku SET
                judul_buku   = '$judul',
                id_kategori  = $id_kat,
                deskripsi    = '$deskripsi',
                cover_buku   = '$cover',
                tahun_terbit = '$tahun',
                nama_penulis = '$penulis'
              WHERE id_buku = $id_buku";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// Hapus buku
function hapus_data($id_buku){
    global $conn;
    $id_buku = (int)$id_buku;
    mysqli_query($conn, "DELETE FROM buku WHERE id_buku = $id_buku");
    return mysqli_affected_rows($conn);
}

/* ============================================================
   FUNGSI KATEGORI
   Tabel: kategori
   Kolom: id_kategori, nama_kategori, deskripsi, tanggal_input
   ============================================================ */

function get_kategori($keyword = "", $limit = 5, $offset = 0){
    global $conn;

    $keyword = mysqli_real_escape_string($conn, $keyword);
    $where = "";
    if($keyword !== ""){
        $where = "WHERE nama_kategori LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%'";
    }

    $sql = "SELECT * FROM kategori
            $where
            ORDER BY tanggal_input DESC
            LIMIT $limit OFFSET $offset";

    return query($sql);
}

function count_kategori($keyword = ""){
    global $conn;
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $where = "";
    if($keyword !== ""){
        $where = "WHERE nama_kategori LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%'";
    }
    $sql = "SELECT COUNT(*) AS total FROM kategori $where";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return (int)$row['total'];
}

function tambah_kategori($data){
    global $conn;
    $nama = mysqli_real_escape_string($conn, $data['nama_kategori']);
    $desk = mysqli_real_escape_string($conn, $data['deskripsi']);

    $sql = "INSERT INTO kategori (nama_kategori, deskripsi, tanggal_input)
            VALUES('$nama', '$desk', NOW())";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}

function get_kategori_by_id($id){
    global $conn;
    $id = (int)$id;
    $result = mysqli_query($conn, "SELECT * FROM kategori WHERE id_kategori = $id");
    return mysqli_fetch_assoc($result);
}

function ubah_kategori($data){
    global $conn;
    $id   = (int)$data['id_kategori'];
    $nama = mysqli_real_escape_string($conn, $data['nama_kategori']);
    $desk = mysqli_real_escape_string($conn, $data['deskripsi']);

    $sql = "UPDATE kategori 
            SET nama_kategori = '$nama', deskripsi = '$desk'
            WHERE id_kategori = $id";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}

function hapus_kategori($id){
    global $conn;
    $id = (int)$id;
    mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori = $id");
    return mysqli_affected_rows($conn);
}

/* ============================================================
   FUNGSI AUTH (REGISTER & LOGIN)
   Tabel: user
   Kolom: id_user, username, email, password, tanggal_register
   (ingat: di phpMyAdmin kolom 'prodi' tadi sudah kamu ganti ke 'password')
   ============================================================ */

// REGISTER
function register($data){
    global $conn;

    $username = strtolower(trim($data['username']));
    $email    = trim($data['email']);
    $password = mysqli_real_escape_string($conn, $data['password']);
    $confirm  = mysqli_real_escape_string($conn, $data['confirm_password']);

    // username / email sudah dipakai?
    $cek = mysqli_query(
        $conn,
        "SELECT * FROM user 
         WHERE username = '$username' OR email = '$email'
         LIMIT 1"
    );

    if(mysqli_num_rows($cek) > 0){
        return "username atau email sudah terdaftar, gunakan yang lain";
    }

    // panjang password minimal 8
    if(strlen($password) < 8){
        return "password harus mengandung minimal 8 karakter";
    }

    // konfirmasi password
    if($password !== $confirm){
        return "konfirmasi password tidak sesuai";
    }

    // hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query(
        $conn,
        "INSERT INTO user (username, email, password, tanggal_register)
         VALUES('$username', '$email', '$hash', NOW())"
    );

    return true;
}

// LOGIN
function login($data){
    global $conn;

    $username = trim($data['username']);
    $password = $data['password'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM user WHERE username = '$username' LIMIT 1"
    );

    // username tidak ada
    if(mysqli_num_rows($result) === 0){
        return "username salah";
    }

    $row = mysqli_fetch_assoc($result);

    // cek password
    if(!password_verify($password, $row['password'])){
        return "salah password";
    }

    // sukses login
    $_SESSION['login']    = true;
    $_SESSION['username'] = $row['username'];
    $_SESSION['id_user']  = $row['id_user'];

    return 1;
}

// Cek & paksa login
function require_login(){
    if(!isset($_SESSION['login']) || $_SESSION['login'] !== true){
        header("Location: login.php");
        exit;
    }
}