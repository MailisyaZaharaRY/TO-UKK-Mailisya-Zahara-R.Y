<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Barang WHERE ID = $id";
    $result = $conn->query($sql);
    $barang = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $tanggal = $_POST['tanggal'];

    $sql = "UPDATE Barang SET NamaBarang = '$nama', KategoriID = '$kategori', Stok = '$stok', Harga = '$harga', TanggalMasuk = '$tanggal' WHERE ID = $id";
    $conn->query($sql);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2>Edit Barang</h2>
        <form method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Barang</label>
                <input type="text" name="nama" class="form-control" value="<?php echo $barang['NamaBarang']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select name="kategori" class="form-control" required>
                    <?php
                    $res = $conn->query("SELECT * FROM Kategori");
                    while ($kat = $res->fetch_assoc()) {
                        $selected = ($kat['ID'] == $barang['KategoriID']) ? 'selected' : '';
                        echo "<option value='{$kat['ID']}' $selected>{$kat['NamaKategori']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="<?php echo $barang['Stok']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" value="<?php echo $barang['Harga']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo $barang['TanggalMasuk']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <br>
        <a href="index.php" class="btn btn-secondary">⬅️ Kembali</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
