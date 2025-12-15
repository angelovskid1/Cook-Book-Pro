<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Recipe Finder & Meal Planner</title>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    body {
      display:flex;align-items:center;justify-content:center;
      min-height:100vh;background:#f5f5ff;margin:0;
      font-family:"Segoe UI", sans-serif;
    }
    .splash {
      text-align:center;padding:2rem 3rem;border-radius:24px;
      background:white;box-shadow:0 18px 45px rgba(15,23,42,.18);
      animation: floatIn .6s ease-out;
    }
    .splash h1 { margin-bottom:.5rem; }
    .splash p { margin-top:0;color:#555; }
    .loader {
      margin:1.5rem auto 0;width:64px;height:4px;
      background:#e5e7eb;border-radius:999px;overflow:hidden;
    }
    .loader span {
      display:block;width:30%;height:100%;border-radius:999px;
      background:#4f46e5;animation:load 1.2s infinite;
    }
    @keyframes load {
      0%{transform:translateX(-100%);}
      50%{transform:translateX(100%);}
      100%{transform:translateX(300%);}
    }
    @keyframes floatIn {
      from {opacity:0;transform:translateY(10px) scale(.98);}
      to   {opacity:1;transform:translateY(0) scale(1);}
    }
  </style>
  <script>
    setTimeout(() => { window.location.href = 'start.php'; }, 2000);
  </script>
</head>
<body>
  <div class="splash">
    <h1>Recipe Finder &amp; Meal Planner</h1>
    <p>Loading</p>
    <div class="loader"><span></span></div>
  </div>
</body>
</html>
