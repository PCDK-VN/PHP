<?php
session_start();
require_once '../../../config/database.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        // Lệnh xóa đơn hàng.
        // Lưu ý: Trong thực tế, Kế toán thường không cho xóa đơn hàng mà chỉ đổi status thành 'cancelled'.
        // Ở đây mình viết xóa thẳng từ DB theo đúng yêu cầu CRUD của bạn.
        $sql = "DELETE FROM orders WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        header("Location: ../../index.php?view=orders&msg=deleted");
        exit();

    } catch (PDOException $e) {
        die("Không thể xóa đơn hàng. Lỗi Database: " . $e->getMessage());
    }
} else {
    header("Location: ../../index.php?view=orders");
    exit();
}
?>
