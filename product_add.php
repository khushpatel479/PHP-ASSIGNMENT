<?php
session_start();
require_once __DIR__ . '/../lib/db.php';
require_once __DIR__ . '/../lib/image_utils.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $cat = (int)$_POST['category_id'];
    $desc = $_POST['description'] ?? '';

    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $origPath = __DIR__ . '/../public/uploads/originals/' . $basename . '.' . $ext;
        $thumbPath = __DIR__ . '/../public/uploads/thumbs/' . $basename . '.' . $ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $origPath);

        resize_image($origPath, $thumbPath, 300, 300);

        $relOrig = 'uploads/originals/' . $basename . '.' . $ext;
        $relThumb = 'uploads/thumbs/' . $basename . '.' . $ext;

        $stmt = $pdo->prepare("INSERT INTO products (category_id, name, description, price, image_path, thumb_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$cat, $name, $desc, $price, $relOrig, $relThumb]);
        header('Location: products.php'); exit;
    } else {
        $error = "Upload failed";
    }
}
