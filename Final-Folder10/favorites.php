<?php
require_once 'config.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isGuest = !$isLoggedIn && (isset($_GET['guest']) || ($_SESSION['guest'] ?? false));
?>
<!DOCTYPE html>
<head>
  <title>Favorites - Cook-Book Pro</title>
  <link rel="stylesheet" href="assets/style.css">
  <script defer src="assets/main.js"></script>
</head>
<body>
<?php include 'nav.php'; ?>

<header class="hero">
  <div class="hero-content">
    <h1>Favorite Recipes</h1>
    <p>All your saved recipes in one place.</p>

    <?php if ($isGuest): ?>
      <p class="guest-banner">Guest mode saves favorites in this browser only.</p>
    <?php endif; ?>
  </div>
</header>

<main>
  <section class="section">
    <h2>Your Favorites</h2>
    <div id="favs" class="pad"></div>

    <div class="hint">
      Tip: Add favorites from <a href="search.php<?php echo $isGuest ? '?guest=1' : ''; ?>">Search</a>.
    </div>
  </section>
</main>

<script>
  window.APP_STATE = {
    isLoggedIn: <?php echo $isLoggedIn ? 'true' : 'false'; ?>,
    isGuest: <?php echo $isGuest ? 'true' : 'false'; ?>,
    importOnLoad: <?php echo $isLoggedIn ? 'true' : 'false'; ?>
  };
</script>

</body>
</html>
