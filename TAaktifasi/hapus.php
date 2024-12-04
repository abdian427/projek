<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include('db_config.php');

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    $id = intval($id);

    
    $query_pemasukan = "DELETE FROM pemasukan WHERE id = $id";
    $query_pengeluaran = "DELETE FROM pengeluaran WHERE id = $id";
    
    mysqli_begin_transaction($conn);

    try {
        
        if (mysqli_query($conn, $query_pemasukan) && mysqli_query($conn, $query_pengeluaran)) {
            mysqli_commit($conn);
            $message = "Data berhasil dihapus";
            $alert_class = "alert-success"; 
        } else {
            throw new Exception("Gagal menghapus data");
        }
    } catch (Exception $e) {
        mysqli_rollback($conn); 
        $message = $e->getMessage();
        $alert_class = "alert-danger"; 
    }
} else {
    $message = "ID tidak ditemukan";
    $alert_class = "alert-warning"; 
}

mysqli_close($conn);


header("Location: add_expense.php?message=" . urlencode($message) . "&alert_class=" . urlencode($alert_class));
exit();
?>
