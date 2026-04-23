<?php
session_start();
require_once '../../../config/database.php';

if (isset($_POST['submit_edit_product'])) {

    $id = $_POST['id']; // ID của sản phẩm cần sửa
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $price = $_POST['price'];
    $sale_price = !empty($_POST['sale_price']) ? $_POST['sale_price'] : 0;
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $brand_id = $_POST['brand_id'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    // Mặc định dùng lại đường dẫn ảnh cũ
    $thumbnail_path = $_POST['old_thumbnail'];

    // Nếu người dùng có chọn upload ảnh MỚI thì xử lý lưu ảnh
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../assets/uploads/products/';
        $file_name = time() . '_' . basename($_FILES['thumbnail']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file)) {
            // Thay thế đường dẫn bằng ảnh mới
            $thumbnail_path = 'assets/uploads/products/' . $file_name;
        }
    }

    try {
        $sql = "UPDATE products SET 
                    name = :name, 
                    slug = :slug, 
                    thumbnail = :thumbnail, 
                    category_id = :category_id, 
                    brand_id = :brand_id, 
                    price = :price, 
                    sale_price = :sale_price, 
                    stock = :stock, 
                    description = :description, 
                    status = :status 
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':slug' => $slug,
            ':thumbnail' => $thumbnail_path,
            ':category_id' => $category_id,
            ':brand_id' => $brand_id,
            ':price' => $price,
            ':sale_price' => $sale_price,
            ':stock' => $stock,
            ':description' => $description,
            ':status' => $status,
            ':id' => $id
        ]);

        header("Location: ../../index.php?view=products&msg=updated");
        exit();

    } catch (PDOException $e) {
        die("Lỗi Database khi cập nhật sản phẩm: " . $e->getMessage());
    }
} else {
    header("Location: ../../index.php?view=products");
    exit();
}
?>
