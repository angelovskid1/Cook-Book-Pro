<?php
require_once 'config.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isGuest = !$isLoggedIn && (isset($_GET['guest']) || ($_SESSION['guest'] ?? false));
?>
<!DOCTYPE html>
<head>
  <title>Weekly Meal Plan - Cook-Book Pro</title>
  <link rel="stylesheet" href="assets/style.css">
  <script defer src="assets/main.js"></script>
</head>
<body>
<?php include 'nav.php'; ?>

<header class="hero">
  <div class="hero-content">
    <h1>Weekly Meal Plan</h1>
    <p>Plan your week. Add recipes from the Search page, then come back here to review.</p>

    <?php if ($isGuest): ?>
      <p class="guest-banner">Guest mode saves your plan in this browser only.</p>
    <?php endif; ?>
  </div>
</header>

<main>
  <section class="section">
    <div class="row">
      <h2>Your Week</h2>
      <button id="savePlanBtn" class="primary">Save Weekly Plan</button>
    </div>

    <div id="weekGrid" class="week-grid"></div>

    <div class="hint">
      Tip: Go to <a href="search.php<?php echo $isGuest ? '?guest=1' : ''; ?>">Search</a>, then use the “Add to day…” dropdown on a recipe card.
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
