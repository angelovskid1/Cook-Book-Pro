<?php
require_once 'config.php';

$isLoggedIn = isset($_SESSION['user_id']);
$isGuest = !$isLoggedIn && (isset($_GET['guest']) || ($_SESSION['guest'] ?? false));
?>
<!DOCTYPE html>
<head>
  <title>Search Recipes - Cook-Book Pro</title>
  <link rel="stylesheet" href="assets/style.css">
  <script defer src="assets/main.js"></script>
</head>
<body>
<?php include 'nav.php'; ?>

<header class="top">
  <div class="topstuff">
    <h1>Search Recipes</h1>
    <p>Search by name or ingredient, then filter by culture and category.</p>

    <?php if ($isGuest): ?>
      <p class="guest-banner">You’re browsing as a guest. Log in to sync favorites and your ingredient list.</p>
    <?php endif; ?>

    <div class="row" id="search">
      <input id="q" type="text"
             placeholder="Search by name or ingredient (e.g., 'chicken', 'garlic')" />
      <select id="cultureFilter">
        <option value="">Any culture</option>
        <option value="American">American</option>
        <option value="Argentinian">Argentinian</option>
        <option value="Australian">Australian</option>
        <option value="British">British</option>
        <option value="Canadian">Canadian</option>
        <option value="Chinese">Chinese</option>
        <option value="Croatian">Croatian</option>
        <option value="Dutch">Dutch</option>
        <option value="Egyptian">Egyptian</option>
        <option value="Filipino">Filipino</option>
        <option value="French">French</option>
        <option value="Greek">Greek</option>
        <option value="Indian">Indian</option>
        <option value="Irish">Irish</option>
        <option value="Italian">Italian</option>
        <option value="Jamaican">Jamaican</option>
        <option value="Japanese">Japanese</option>
        <option value="Kenyan">Kenyan</option>
        <option value="Malaysian">Malaysian</option>
        <option value="Mexican">Mexican</option>
        <option value="Moroccan">Moroccan</option>
        <option value="Polish">Polish</option>
        <option value="Portuguese">Portuguese</option>
        <option value="Russian">Russian</option>
        <option value="Saudi Arabian">Saudi Arabian</option>
        <option value="Spanish">Spanish</option>
        <option value="Thai">Thai</option>
        <option value="Tunisian">Tunisian</option>
        <option value="Turkish">Turkish</option>
        <option value="Ukrainian">Ukrainian</option>
        <option value="Uruguayan">Uruguayan</option>
        <option value="Vietnamese">Vietnamese</option>
      </select>

      <select id="dietFilter">
        <option value="">Any category</option>
        <option value="Vegetarian">Vegetarian</option>
        <option value="Seafood">Seafood</option>
        <option value="Chicken">Chicken</option>
        <option value="Beef">Beef</option>
        <option value="Dessert">Dessert</option>
      </select>

      <button id="searchBtn" class="primary">Search</button>
      <button id="clearData" class="clear" title="Clear saved plan &amp; favorites">
        Clear Saved Data
      </button>
    </div>
  </div>
</header>

<main>
  <section class="section">
    <h2>Results</h2>
    <div id="results" class="grid"></div>
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
