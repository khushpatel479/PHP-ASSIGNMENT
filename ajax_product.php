<?php
require_once __DIR__ . '/../lib/db.php';

$cat = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$page = isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
$perPage = 6;
$offset = ($page-1) * $perPage;

$totalStmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
$totalStmt->execute([$cat]);
$total = $totalStmt->fetchColumn();
$pages = ceil($total / $perPage);

$stmt = $pdo->prepare("SELECT id, name, price, thumb_path FROM products WHERE category_id = ? ORDER BY id DESC LIMIT ? OFFSET ?");
$stmt->bindValue(1, $cat, PDO::PARAM_INT);
$stmt->bindValue(2, $perPage, PDO::PARAM_INT);
$stmt->bindValue(3, $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode(['products' => $products, 'pages' => $pages, 'page' => $page]);
