<?php
include 'db.php';

// Proses tambah barang
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $tanggal = $_POST['tanggal'];

    // Query untuk menambah barang baru
    $sql = "INSERT INTO Barang (NamaBarang, KategoriID, Stok, Harga, TanggalMasuk) 
            VALUES ('$nama', '$kategori', '$stok', '$harga', '$tanggal')";
    $conn->query($sql);

    // Redirect ke halaman daftar barang setelah menambah
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px; /* Membuat lebar kontainer lebih kecil */
        }
        .form-label {
            font-weight: 600; /* Membuat label lebih tegas */
        }
        .form-control {
            font-size: 14px; /* Memperkecil ukuran font pada input */
        }
        .btn {
            font-size: 14px; /* Memperkecil ukuran font pada tombol */
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Tambah Barang</h2>
        <form method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Barang</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select name="kategori" class="form-control" required>
                    <?php
                    $sql = "SELECT * FROM Kategori";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['ID']}'>{$row['NamaKategori']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Tambah Barang</button>
                <a href="index.php" class="btn btn-secondary">⬅️ Kembali</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
