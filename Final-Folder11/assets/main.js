// assets/js/main.js
const API_BASE = "https://www.themealdb.com/api/json/v1/1/search.php";

const searchInput   = document.getElementById("q");
const searchBtn     = document.getElementById("searchBtn");
const clearDataBtn  = document.getElementById("clearData");
const cultureSelect = document.getElementById("cultureFilter");
const dietSelect    = document.getElementById("dietFilter");

const resultsDiv    = document.getElementById("results");
const favsDiv       = document.getElementById("favs");
const weekGridDiv   = document.getElementById("weekGrid");
const savePlanBtn   = document.getElementById("savePlanBtn");

let favorites = [];
let weeklyPlan = {};
const days = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];

function loadLocal() {
  try {
    const f = JSON.parse(localStorage.getItem("favorites") || "[]");
    const w = JSON.parse(localStorage.getItem("weeklyPlan") || "{}");
    favorites = Array.isArray(f) ? f : [];
    weeklyPlan = typeof w === "object" && w !== null ? w : {};
  } catch {
    favorites = [];
    weeklyPlan = {};
  }
}

function saveLocal() {
  localStorage.setItem("favorites", JSON.stringify(favorites));
  localStorage.setItem("weeklyPlan", JSON.stringify(weeklyPlan));
}

function clearLocal() {
  localStorage.removeItem("favorites");
  localStorage.removeItem("weeklyPlan");
  favorites = [];
  weeklyPlan = {};
  makeFavorites();
  makeWeek();
}

function makeResults(recipes) {
  if (!resultsDiv) return;
  resultsDiv.innerHTML = "";

  if (!recipes || recipes.length === 0) {
    resultsDiv.innerHTML = "<p>No recipes found.</p>";
    return;
  }

  recipes.forEach(recipe => {
    const card = document.createElement("article");
    card.className = "card";

    const img = document.createElement("img");
    img.src = recipe.strMealThumb || "images/burger.jpg";
    img.alt = recipe.strMeal || "Recipe";

    const pad = document.createElement("div");
    pad.className = "pad";

    const title = document.createElement("h3");
    title.textContent = recipe.strMeal || "Untitled recipe";

    const info = document.createElement("p");
    info.className = "muted";
    info.textContent = recipe.strArea
      ? `Cuisine: ${recipe.strArea}`
      : "Cuisine info unavailable";

    const row = document.createElement("div");
    row.className = "row";

    const left = document.createElement("div");
    const right = document.createElement("div");

    const cultureTag = document.createElement("span");
    cultureTag.className = "tag";
    cultureTag.textContent = recipe.strArea || "Any culture";

    const dietTag = document.createElement("span");
    dietTag.className = "tag alt";
    dietTag.textContent = recipe.strCategory || "Any diet";

    left.appendChild(cultureTag);
    left.appendChild(dietTag);

    
    const favBtn = document.createElement("button");
    favBtn.className = "ghost";
    favBtn.textContent = "Favorite";
    favBtn.onclick = (e) => {
      e.stopPropagation();
      addFavorite(recipe);
    };

    
    const listBtn = document.createElement("button");
    listBtn.className = "primary";
    listBtn.textContent = "Add ingredients to list";
    listBtn.onclick = (e) => {
      e.stopPropagation();
      addIngredientsToList(recipe);
    };

    
    const viewBtn = document.createElement("button");
    viewBtn.className = "ghost";
    viewBtn.textContent = "View Recipe";
    viewBtn.onclick = (e) => {
      e.stopPropagation();
      window.location.href = `recipe.php?id=${recipe.idMeal}`;
    };

    const daySelect = document.createElement("select");
    const defaultOpt = document.createElement("option");
    defaultOpt.value = "";
    defaultOpt.textContent = "Add to day…";
    daySelect.appendChild(defaultOpt);

    days.forEach(d => {
      const opt = document.createElement("option");
      opt.value = d;
      opt.textContent = d;
      daySelect.appendChild(opt);
    });

    daySelect.onchange = () => {
      if (!daySelect.value) return;
      weeklyPlan[daySelect.value] = recipe;
      saveLocal();
      makeWeek();
      daySelect.value = "";
    };

    right.appendChild(favBtn);
    right.appendChild(listBtn);
    right.appendChild(viewBtn);
    right.appendChild(daySelect);

    row.appendChild(left);
    row.appendChild(right);

    pad.appendChild(title);
    pad.appendChild(info);
    pad.appendChild(row);

    card.appendChild(img);
    card.appendChild(pad);
    resultsDiv.appendChild(card);
  });
}

function makeFavorites() {
  if (!favsDiv) return;
  favsDiv.innerHTML = "";
  if (!favorites.length) {
    favsDiv.innerHTML = "<p>You have no favorites yet.</p>";
    return;
  }

  favorites.forEach((recipe, index) => {
    const div = document.createElement("div");
    div.className = "fav-item";
    div.textContent = recipe.title || "Favorite recipe";

    const removeBtn = document.createElement("button");
    removeBtn.className = "ghost";
    removeBtn.textContent = "Remove";
    removeBtn.onclick = () => {
      favorites.splice(index, 1);
      saveLocal();
      makeFavorites();
    };

    div.appendChild(removeBtn);
    favsDiv.appendChild(div);
  });
}

function makeWeek() {
  if (!weekGridDiv) return;
  weekGridDiv.innerHTML = "";
  days.forEach(day => {
    const cell = document.createElement("div");
    cell.className = "week-cell";

    const title = document.createElement("h4");
    title.textContent = day;
    cell.appendChild(title);

    const recipe = weeklyPlan[day];
    if (recipe) {
      const p = document.createElement("p");
      p.textContent = recipe.strMeal || "Recipe";
      cell.appendChild(p);

      const clearBtn = document.createElement("button");
      clearBtn.className = "ghost";
      clearBtn.textContent = "Clear";
      clearBtn.onclick = () => {
        delete weeklyPlan[day];
        saveLocal();
        makeWeek();
      };

      cell.appendChild(clearBtn);
    } else {
      const p = document.createElement("p");
      p.className = "muted";
      p.textContent = "No recipe chosen yet.";
      cell.appendChild(p);
    }

    weekGridDiv.appendChild(cell);
  });
}

function addFavorite(recipe) {
  const id = recipe.idMeal;
  if (id && favorites.some(r => r.id === id)) return;

  favorites.push({
    id: id,
    title: recipe.strMeal,
    image: recipe.strMealThumb
  });

  saveLocal();
  makeFavorites();

  if (window.APP_STATE && window.APP_STATE.isLoggedIn) {
    fetch("import_favorites.php", {
      method: "POST",
      headers: {"Content-Type": "application/json"},
      body: JSON.stringify([favorites[favorites.length - 1]])
    });
  }
}

function addIngredientsToList(recipe) {
  let ingredients = [];

  for (let i = 1; i <= 20; i++) {
    const ing = recipe[`strIngredient${i}`];
    const qty = recipe[`strMeasure${i}`];
    if (ing && ing.trim()) {
      ingredients.push({ name: ing.trim(), quantity: qty ? qty.trim() : "" });
    }
  }

  let list = [];
  try {
    list = JSON.parse(localStorage.getItem("ingredient_list") || "[]");
  } catch {
    list = [];
  }

  list = list.concat(ingredients);
  localStorage.setItem("ingredient_list", JSON.stringify(list));

  if (window.APP_STATE && window.APP_STATE.isLoggedIn && ingredients.length) {
    fetch("import_list.php", {
      method: "POST",
      headers: {"Content-Type": "application/json"},
      body: JSON.stringify(ingredients)
    });
  }

  alert("Ingredients added to list!");
}

async function handleSearch() {
  if (!resultsDiv) return;

  const q = searchInput.value.trim().toLowerCase();
  const culture = cultureSelect.value;
  const category = dietSelect.value;

  resultsDiv.innerHTML = "<p>Loading recipes...</p>";

  try {
    const res = await fetch(
      `https://www.themealdb.com/api/json/v1/1/search.php?s=${encodeURIComponent(q || "")}`
    );
    const json = await res.json();
    let recipes = json.meals || [];

    if (culture) recipes = recipes.filter(r => r.strArea === culture);
    if (category) recipes = recipes.filter(r => r.strCategory === category);

    if (!recipes.length) {
      resultsDiv.innerHTML = "<p>No recipes match your filters.</p>";
      return;
    }

    makeResults(recipes);

  } catch (err) {
    console.error(err);
    resultsDiv.innerHTML = "<p>There was a problem loading recipes.</p>";
  }
}

function importLocalToServer() {
  if (!window.APP_STATE || !window.APP_STATE.isLoggedIn) return;

  if (favorites.length) {
    fetch("import_favorites.php", {
      method: "POST",
      headers: {"Content-Type": "application/json"},
      body: JSON.stringify(favorites)
    });
  }

  try {
    const theList = JSON.parse(localStorage.getItem("ingredient_list") || "[]");
    if (theist.length) {
      fetch("import_list.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(theList)
      });
    }
  } catch {}
}

if (searchBtn) searchBtn.addEventListener("click", handleSearch);
if (searchInput) {
  searchInput.addEventListener("keydown", e => {
    if (e.key === "Enter") handleSearch();
  });
}
if (clearDataBtn) {
  clearDataBtn.addEventListener("click", () => {
    if (confirm("Clear saved favorites and weekly plan?")) clearLocal();
  });
}
if (savePlanBtn) {
  savePlanBtn.addEventListener("click", () => {
    saveLocal();
    alert("Weekly plan saved!");
  });
}

loadLocal();
makeFavorites();
makeWeek();
importLocalToServer();
