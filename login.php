<?php
require 'db.php';
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([trim($_POST['username'])]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($_POST['password'], $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['name'] = $user['name']; 
    $_SESSION['role'] = $user['role'];
    header('Location: /index.php');
    exit;
  }
  $error = 'Verkeerde gebruikersnaam or wachtwoord.';
}

require 'includes/header.php';
?>
<h1>Inloggen</h1>
<form method="post" class="filters">
  <input name="username" placeholder="Gebruikersnaam" required>
  <input name="password" type="password" placeholder="Wachtwoord" required>
  <button class="btn">Inloggen</button>
</form>
<p><?= e($error) ?></p>
<p><a href="/register.php">Nog geen account? Registreren</a></p>
<?php require 'includes/footer.php'; ?>