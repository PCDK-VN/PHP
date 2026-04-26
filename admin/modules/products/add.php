<?php
// Bật session để thông báo lỗi (nếu cần)
session_start();

// Nhúng file kết nối CSDL của Khoa.
// Chú ý: Vì file này nằm ở modules/products/ nên phải lùi 3 cấp (../../../) để tìm thư mục assets
require_once '../../../config/database.php';

// Kiểm tra xem user có bấm nút Submit không
if (isset($_POST['submit_add_product'])) {

    // 1. Lấy dữ liệu từ Form
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $price = $_POST['price'];
    $sale_price = !empty($_POST['sale_price']) ? $_POST['sale_price'] : 0; // Nếu để trống thì cho bằng 0
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $brand_id = $_POST['brand_id'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    // 2. Xử lý Upload Ảnh Thumbnail
    $thumbnail_path = '';
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {

        // Thư mục lưu ảnh (Khoa nhớ tạo thư mục này trong project nhé: assets/uploads/products)
        $upload_dir = '../../../assets/uploads/products/';

        // Đổi tên file cho khỏi trùng (Ví dụ: 1700000000_cpu.jpg)
        $file_name = time() . '_' . basename($_FILES['thumbnail']['name']);
        $target_file = $upload_dir . $file_name;

        // Di chuyển file từ thư mục tạm vào thư mục chính thức
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $target_file)) {
            // Lưu đường dẫn TƯƠNG ĐỐI vào Database để HTML dễ đọc
            $thumbnail_path = 'assets/uploads/products/' . $file_name;
        }
    }

    // 3. Thực thi lệnh INSERT vào Database
    try {
        $sql = "INSERT INTO products (name, slug, thumbnail, category_id, brand_id, price, sale_price, stock, description, status) 
                VALUES (:name, :slug, :thumbnail, :category_id, :brand_id, :price, :sale_price, :stock, :description, :status)";

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
            ':status' => $status
        ]);

        // Thêm thành công, quay về trang danh sách sản phẩm
        header("Location: ../../index.php?view=products&msg=success");
        exit();

    } catch (PDOException $e) {
        die("Lỗi Database khi thêm sản phẩm: " . $e->getMessage());
    }
} else {
    // Nếu ai đó truy cập trực tiếp file này mà không qua Form thì đuổi về
    header("Location: ../../index.php?view=products");
    exit();
}
?>