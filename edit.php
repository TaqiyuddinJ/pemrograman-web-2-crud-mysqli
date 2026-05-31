<?php
include 'koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

$pesan_error = "";

// 1. Ambil data lama berdasarkan ID 
$stmt_get = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$stmt_get->bind_param("i", $id);
$stmt_get->execute();
$result = $stmt_get->get_result();
$data = $result->fetch_assoc();
$stmt_get->close();

if (!$data) {
    die("Data mahasiswa tidak ditemukan.");
}

// 2. Proses pembaruan data jika form disubmit
if (isset($_POST['update'])) {
    $nim     = $_POST['nim'];
    $nama    = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $email   = $_POST['email'];

    $stmt_update = $conn->prepare("UPDATE mahasiswa SET nim = ?, nama = ?, jurusan = ?, email = ? WHERE id = ?");
    
    if ($stmt_update) {
        $stmt_update->bind_param("ssssi", $nim, $nama, $jurusan, $email, $id);
        
        if ($stmt_update->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $pesan_error = "Gagal memperbarui data: " . $stmt_update->error; // 
        }
        $stmt_update->close();
    } else {
        $pesan_error = "Gagal mempersiapkan query: " . $conn->error; // 
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Edit Data Mahasiswa</h4>
            </div>
            <div class="card-body">
                <?php if ($pesan_error): ?>
                    <div class="alert alert-danger"><?= $pesan_error; ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">NIM</label>
                        <input type="text" name="nim" class="form-control" value="<?= htmlspecialchars($data['nim']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" value="<?= htmlspecialchars($data['jurusan']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']); ?>" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" name="update" class="btn btn-warning fw-bold">Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>