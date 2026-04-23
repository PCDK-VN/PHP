<?php
session_start();
require_once '../../../config/database.php';

if (isset($_POST['submit_edit_order'])) {
    $id = (int)$_POST['id'];
    $status = $_POST['status'];
    $shipping_address = trim($_POST['shipping_address']);
    $note = trim($_POST['note']);

    try {
        $sql = "UPDATE orders SET status = :status, shipping_address = :shipping_address, note = :note WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':shipping_address' => $shipping_address,
            ':note' => $note,
            ':id' => $id
        ]);

        header("Location: ../../index.php?view=orders&msg=updated");
        exit();
    } catch (PDOException $e) {
        die("Lỗi Database: " . $e->getMessage());
    }
} else {
    header("Location: ../../index.php?view=orders");
    exit();
}
?>
