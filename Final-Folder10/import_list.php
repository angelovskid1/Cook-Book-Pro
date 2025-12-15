<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit('Not logged in');
}

$userId = (int) $_SESSION['user_id'];

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    exit('no data');
}

// ingredients_cart has UNIQUE (user_id, ingredient_name)
// so we upsert to avoid errors when the same ingredient is added again.
$stmt = $pdo->prepare("
  INSERT INTO ingredients_cart
    (user_id, ingredient_name, quantity, is_checked)
  VALUES 
    (:uid, :name, :qty, 0)
  ON DUPLICATE KEY UPDATE
    quantity = VALUES(quantity),
    is_checked = 0
");

foreach ($data as $ing) {
    $name = trim($ing['name'] ?? '');
    $qty  = trim($ing['quantity'] ?? '');

    if ($name === '') continue;

    $stmt->execute([
        ':uid'  => $userId,
        ':name' => $name,
        ':qty'  => $qty
    ]);
}

echo 'ok';
