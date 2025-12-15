<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
  <link rel="stylesheet" href="assets/style.css">

  <style>
  body {
    margin: 0;
    background: #9dbebb; /* matches global body bg */
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    font-family: Arial, sans-serif;
  }

  .start-card {
    background: whitesmoke;
    border-radius: 14px;
    padding: 32px 36px;
    max-width: 420px;
    width: 100%;
    text-align: center;
    border: 2px solid #e5e7eb;
  }

  .start-card h1 {
    margin-bottom: 8px;
    color: black;
  }

  .start-card p {
    color: darkgray;
    font-size: 14px;
    line-height: 1.5;
  }

  .start-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 24px;
  }

  .btn {
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    padding: 10px 12px;
    cursor: pointer;
    font-weight: 500;
    text-decoration: none;
    display: block;
    background: #3b82f6;
    color: white;
  }

  .btn:hover {
    opacity: 0.9;
  }

  .btn.secondary {
    background: #3b82f6;
    color: white;
  }
</style>
</head>
<body>

  <div class="start-card">
    <h1>Cook-Book Pro</h1>
    <p>
      Search recipes, plan your week, and build an ingredient shopping list.
      Save everything if you log in.
    </p>

    <div class="start-buttons">
      <a href="login.php" class="btn primary">
        Log in / Register
      </a>

      <a href="home.php?guest=1" class="btn secondary">
        Continue as Guest
      </a>
    </div>
  </div>

</body>
</html>
