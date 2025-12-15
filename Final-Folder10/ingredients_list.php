<?php
require_once 'config.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isGuest = !$isLoggedIn && (isset($_GET['guest']) || ($_SESSION['guest'] ?? false));

if ($isGuest) {
    // guest list is localStorage only
} elseif (!$isLoggedIn) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'] ?? null;

if ($isLoggedIn) {

    if (isset($_GET['check'])) {
        $id = (int) $_GET['check'];
        $pdo->prepare("
          UPDATE ingredients_cart 
          SET is_checked = 1
          WHERE id = :id AND user_id = :uid
        ")->execute([':id' => $id, ':uid' => $userId]);
    }

    if (isset($_GET['delete'])) {
        $id = (int) $_GET['delete'];
        $pdo->prepare("
          DELETE FROM ingredients_cart
          WHERE id = :id AND user_id = :uid
        ")->execute([':id' => $id, ':uid' => $userId]);
    }

    $stmt = $pdo->prepare("
      SELECT * FROM ingredients_cart
      WHERE user_id = :uid
      ORDER BY created_at DESC
    ");
    $stmt->execute([':uid' => $userId]);
    $items = $stmt->fetchAll();
}
else {
    $items = [];
}
?>
<!DOCTYPE html>
<head>
  <title>Ingredient Shopping List</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include 'nav.php'; ?>

<main class="section">
  <h1>Ingredient Shopping List</h1>

  <a href="home.php<?php echo $isGuest ? '?guest=1' : ''; ?>" class="primary" style="display:inline-block;margin-bottom:1rem;">
  Back to Home
  </a>

  <?php if ($isGuest): ?>
    <p class="guest-banner">
      You are browsing as a guest. Your ingredient list is only stored in this browser (localStorage).
      Login to sync it to your account.
    </p>
    <ul id="guestList" class="shopping-list"></ul>
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const ul = document.getElementById("guestList");
        let list = [];
        try {
          list = JSON.parse(localStorage.getItem("ingredient_list") || "[]");
        } catch { list = []; }
        if (!list.length) {
          ul.innerHTML = "<li>No ingredients in your list yet.</li>";
          return;
        }
        list.forEach(item => {
          const li = document.createElement("li");
          li.textContent = item.name || "Ingredient";
          ul.appendChild(li);
        });
      });
    </script>
  <?php else: ?>
    <?php if (empty($items)): ?>
      <p>No ingredients in your list yet.</p>
    <?php else: ?>
      <ul class="shopping-list">
        <?php foreach ($items as $row): ?>
          <li class="<?php echo $row['is_checked'] ? 'done' : ''; ?>">
            <span><?php echo htmlspecialchars($row['ingredient_name']); ?>
              <?php if ($row['quantity']): ?>
                (<?php echo htmlspecialchars($row['quantity']); ?>)
              <?php endif; ?>
            </span>
            <div class="actions">
              <?php if (!$row['is_checked']): ?>
                <a href="ingredients_list.php?check=<?php echo $row['id']; ?>">Mark done</a>
              <?php endif; ?>
              <a href="ingredients_list.php?delete=<?php echo $row['id']; ?>"
                 onclick="return confirm('Delete this ingredient?');">Delete</a>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  <?php endif; ?>
</main>

</body>
</html>
