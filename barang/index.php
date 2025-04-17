<?php
include 'db.php';

// Menentukan jumlah barang per halaman
$itemsPerPage = 10;

// Mendapatkan halaman saat ini dari URL (default ke halaman 1)
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Menghitung offset berdasarkan halaman yang dipilih
$offset = ($page - 1) * $itemsPerPage;

// Proses pencarian
$search = "";
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Query untuk menampilkan barang sesuai pencarian dan pagination
$sql = "SELECT Barang.*, Kategori.NamaKategori FROM Barang 
        LEFT JOIN Kategori ON Barang.KategoriID = Kategori.ID 
        WHERE Barang.NamaBarang LIKE '%$search%' OR Kategori.NamaKategori LIKE '%$search%' 
        LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

// Menghitung total jumlah barang untuk pagination
$sqlCount = "SELECT COUNT(*) AS total FROM Barang 
             LEFT JOIN Kategori ON Barang.KategoriID = Kategori.ID 
             WHERE Barang.NamaBarang LIKE '%$search%' OR Kategori.NamaKategori LIKE '%$search%'";
$countResult = $conn->query($sqlCount);
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $itemsPerPage); // Menghitung total halaman
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">📦 Daftar Barang</h2>
    
    <!-- Form Pencarian -->
    <form method="GET" class="mb-3">
        <div class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari Barang atau Kategori..." value="<?php echo htmlspecialchars($search); ?>" style="max-width: 300px;">
            <button type="submit" class="btn btn-primary btn-sm">🔍 Cari</button>
        </div>
    </form>

    <!-- Tambah Barang & Kategori -->
    <a href="tambah_barang.php" class="btn btn-success btn-sm">➕ Tambah Barang</a> |
    <a href="tambah_kategori.php" class="btn btn-success btn-sm">➕ Tambah Kategori</a>
    <br><br>

    <!-- Tabel Daftar Barang -->
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Tanggal Masuk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Menampilkan barang-barang yang dicari
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['NamaBarang']}</td>
                    <td>{$row['NamaKategori']}</td>
                    <td>{$row['Stok']}</td>
                    <td>Rp " . number_format($row['Harga']) . "</td>
                    <td>{$row['TanggalMasuk']}</td>
                    <td>
                        <a href='edit_barang.php?id={$row['ID']}' class='btn btn-warning btn-sm'>✏️ Edit</a> |
                        <a href='hapus_barang.php?id={$row['ID']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin mau hapus barang ini?');\">🗑️ Hapus</a>
                    </td>
                </tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php echo ($page == $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
