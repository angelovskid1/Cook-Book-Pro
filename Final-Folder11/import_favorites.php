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

$stmt = $pdo->prepare("
  INSERT INTO favorites (user_id, recipe_id)
  VALUES (:uid, :rid)
  ON DUPLICATE KEY UPDATE recipe_id = recipe_id
");

foreach ($data as $fav) {
    $recipeId = $fav['id'] ?? ($fav['recipeId'] ?? null);
    if (!$recipeId) continue;

    $stmt->execute([
        ':uid' => $userId,
        ':rid' => $recipeId
    ]);
}

echo 'ok';

