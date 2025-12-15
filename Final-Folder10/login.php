<?php
require_once 'config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['username_or_email'] ?? '');
    $password   = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("
        SELECT * FROM users
        WHERE username = :id OR email = :id
        LIMIT 1
    ");
    $stmt->execute([':id' => $identifier]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        unset($_SESSION['guest']);
        header('Location: home.php');
        exit;
    } else {
        $errors[] = 'Invalid username/email or password.';
    }
}
?>
<!DOCTYPE html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include 'nav.php'; ?>
<main class="auth-main">
  <h1>Login</h1>

  <?php if (isset($_GET['registered'])): ?>
    <p class="success">Registration successful. You can now log in.</p>
  <?php endif; ?>

  <?php if ($errors): ?>
    <div class="error-box">
      <?php foreach ($errors as $e): ?>
        <p><?php echo htmlspecialchars($e); ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form method="post" class="auth-form">
    <label>
      Username or Email
      <input type="text" name="username_or_email" required>
    </label>
    <label>
      Password
      <input type="password" name="password" required>
    </label>
    <button type="submit">Login</button>
  </form>

  <p>Don’t have an account? <a href="register.php">Register here</a>.</p>
</main>
</body>
</html>
