<?php
require_once 'config.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isGuest = !$isLoggedIn && (isset($_GET['guest']) || ($_SESSION['guest'] ?? false));
?>
<!DOCTYPE html>
<head>
  <title>Cook-Book Pro</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include 'nav.php'; ?>

<header class="top">
  <div class="topstuff">
    <h1>Cook-Book Pro</h1>
    <p>Search, save favorites, plan your week, and build an ingredient shopping list.</p>

    <?php if ($isGuest): ?>
      <p class="guest-banner">You’re browsing as a guest. Log in to sync your data to your account.</p>
    <?php endif; ?>
  </div>
</header>

<main>
  <section class="section">
    <h2>Quick Links</h2>

    <div class="grid">
      <article class="card">
        <div class="pad">
          <h3>Search Recipes</h3>
          <p class="muted">Find meals by name/ingredient, filter by culture and category.</p>
          <a class="primary" href="search.php<?php echo $isGuest ? '?guest=1' : ''; ?>">Go to Search</a>
        </div>
      </article>

      <article class="card">
        <div class="pad">
          <h3>Weekly Meal Plan</h3>
          <p class="muted">Pick recipes for each day of the week.</p>
          <a class="primary" href="meal_plan.php<?php echo $isGuest ? '?guest=1' : ''; ?>">Go to Meal Plan</a>
        </div>
      </article>

      <article class="card">
        <div class="pad">
          <h3>Favorites</h3>
          <p class="muted">Save recipes you want to keep.</p>
          <a class="primary" href="favorites.php<?php echo $isGuest ? '?guest=1' : ''; ?>">Go to Favorites</a>
        </div>
      </article>

      <article class="card">
        <div class="pad">
          <h3>Ingredient Shopping List</h3>
          <p class="muted">Build a list from any recipe and check items off.</p>
          <a class="primary" href="ingredients_list.php<?php echo $isGuest ? '?guest=1' : ''; ?>">Go to Ingredient List</a>
        </div>
      </article>
    </div>
  </section>
</main>

</body>
</html>
