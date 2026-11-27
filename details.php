<?php
require 'db.php';
require 'includes/header.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);

$statuses = ['uitgespeeld' => 'Uitgespeeld', 'speelt nu' => 'Speelt nu', 'wishlist' => 'Wishlist'];
?>

<?php if (!$game): ?>
  <p>Game niet gevonden.</p>
<?php else: ?>
  <h1><?= e($game['title']) ?> (<?= e($game['release_year']) ?>)</h1>
  <p>
    <span class="pill"><?= e($statuses[$game['status']]) ?></span>
    <span class="stars"><?= stars($game['rating'] === null ? null : (int)$game['rating']) ?></span>
  </p>
  <p>Platform: <?= e($game['platform']) ?> | Genre: <?= e($game['genre']) ?></p>
  <p><?= nl2br(e($game['story'] ?? 'Nog geen verhaal toegevoegd.')) ?></p>
<?php endif; ?>

<p><a href="/index.php" class="btn">← Terug</a></p>

<?php require 'includes/footer.php'; ?>