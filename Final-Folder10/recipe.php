<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    die("Recipe not found.");
}

$recipeId = htmlspecialchars($_GET['id']);
?>
<!DOCTYPE html>
<head>
  <title>Recipe Details</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include 'nav.php'; ?>

<main class="section" id="recipePage">
  <p class="muted">Loading recipe...</p>
  </a>
</main>

<script>
async function loadRecipe() {
  const recipeId = "<?php echo $recipeId; ?>";

  const res = await fetch(
    `https://www.themealdb.com/api/json/v1/1/lookup.php?i=${recipeId}`
  );

  const json = await res.json();
  const recipe = json.meals ? json.meals[0] : null;

  if (!recipe) {
    document.getElementById("recipePage").innerHTML = "<p>Recipe not found.</p>";
    return;
  }

  let ingredientsHTML = "";
  for (let i = 1; i <= 20; i++) {
    const ing = recipe["strIngredient" + i];
    const qty = recipe["strMeasure" + i];
    if (ing && ing.trim()) {
      ingredientsHTML += `<li>${ing} ${qty ? "- " + qty : ""}</li>`;
    }
  }

  document.getElementById("recipePage").innerHTML = `
    <div class="card" style="max-width:760px;margin:auto">
      <img src="${recipe.strMealThumb}" style="height:320px;object-fit:cover">
      <div class="pad">

        <h1>${recipe.strMeal}</h1>
        <p class="muted">${recipe.strArea} • ${recipe.strCategory}</p>

        <h3>Ingredients</h3>
        <ul>${ingredientsHTML}</ul>

        <h3>Instructions</h3>
        <p style="white-space:pre-line">${recipe.strInstructions}</p>

        ${recipe.strYoutube ? `
          <h3>Video</h3>
          <iframe width="100%" height="360"
            src="https://www.youtube.com/embed/${recipe.strYoutube.split("v=")[1]}"
            frameborder="0" allowfullscreen>
          </iframe>
        ` : ""}

        <div class="row" style="margin-top:1rem">
          <button class="primary" onclick="addToFavorites()">Favorite</button>
          <button class="ghost" onclick="addAllToList()">Add Ingredients</button>
        </div>

      </div>
    </div>
  `;
}

function addToFavorites() {
  const recipeId = "<?php echo $recipeId; ?>";
  fetch("import_favorites.php", {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify([{ id: recipeId }])
  });
  alert("Added to favorites!");
}

function addAllToList() {
  alert("Use the main page to add ingredients to list for now.");
}

loadRecipe();
</script>

</body>
</html>