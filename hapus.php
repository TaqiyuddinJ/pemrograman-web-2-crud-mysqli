<?php
include 'koneksi.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Menggunakan Prepared Statement untuk mencegah SQL injection melalui URL 
    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Berhasil dihapus, arahkan kembali ke index.php
            header("Location: index.php");
            exit();
        } else {
            // Tampilkan pesan error jika query eksekusi gagal 
            die("Gagal menghapus data: " . $stmt->error);
        }
    } else {
        die("Gagal mempersiapkan query: " . $conn->error);
    }
} else {
    header("Location: index.php");
    exit();
}
?>