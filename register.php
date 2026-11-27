<?php
require 'db.php';
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

  try {
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hash]);
    header('Location: /login.php');
    exit;
  } catch (PDOException $ex) {
    $error = 'Deze gebruikersnaam bestaat al.';
  }
}

require 'includes/header.php';
?>
<h1>Registreren</h1>
<form method="post" class="filters">
  <input name="username" placeholder="Gebruikersnaam" required>
  <input name="password" type="password" placeholder="Wachtwoord" required>
  <button class="btn">Registreren</button>
</form>
<p><?= e($error) ?></p>
<?php require 'includes/footer.php'; ?>