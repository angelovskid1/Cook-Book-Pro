<?php


$isLoggedIn = isset($_SESSION['user_id']);
$isGuest = !$isLoggedIn && (isset($_GET['guest']) || ($_SESSION['guest'] ?? false));

if (isset($_GET['guest'])) {
  $_SESSION['guest'] = true;
}

$guestQuery = $isGuest ? '?guest=1' : '';
?>

<nav class="main-nav">
  <div class="nav-left">
    <a href="home.php<?php echo $guestQuery; ?>" class="logo">Recipe Finder</a>
  </div>

  <ul class="nav-links">
    <li><a href="home.php<?php echo $guestQuery; ?>">Home</a></li>
    <li><a href="search.php<?php echo $guestQuery; ?>">Search</a></li>
    <li><a href="meal_plan.php<?php echo $guestQuery; ?>">Meal Plan</a></li>
    <li><a href="favorites.php<?php echo $guestQuery; ?>">Favorites</a></li>
    <li><a href="ingredients_list.php<?php echo $guestQuery; ?>">Ingredient List</a></li>

    <?php if ($isLoggedIn): ?>
      <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a></li>
    <?php else: ?>
      <li><a href="login.php<?php echo $guestQuery; ?>">Login</a></li>
    <?php endif; ?>
  </ul>
</nav>
