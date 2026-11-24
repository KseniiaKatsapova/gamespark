<?php
require 'db.php';
require 'includes/header.php';

// filters
$zoeken   = $_GET['zoeken']   ?? '';
$platform = $_GET['platform'] ?? '';
$genre    = $_GET['genre']    ?? '';
$status   = $_GET['status']   ?? '';
$rating   = $_GET['rating']   ?? '';

// query filters
$sql = "SELECT * FROM games WHERE 1=1";
$params = [];

if ($zoeken !== '')   { $sql .= " AND title LIKE ?";    $params[] = "%$zoeken%"; }
if ($platform !== '') { $sql .= " AND platform LIKE ?"; $params[] = "%$platform%"; }
if ($genre !== '')    { $sql .= " AND genre = ?";       $params[] = $genre; }
if ($status !== '')   { $sql .= " AND status = ?";      $params[] = $status; }
if ($rating !== '')   { $sql .= " AND rating >= ?";     $params[] = (int)$rating; }

$sql .= " ORDER BY title";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Options for the dropdowns
$platforms = ['PC', 'PlayStation', 'Xbox', 'Switch'];
$genres    = ['Action', 'Adventure', 'RPG'];
$statuses  = ['uitgespeeld' => 'Uitgespeeld', 'speelt nu' => 'Speelt nu', 'wishlist' => 'Wishlist'];
?>

<h1>Overzicht</h1>

<form method="get" class="filters">
  <input type="text" name="zoeken" placeholder="Zoeken" value="<?= e($zoeken) ?>">

  <select name="platform">
    <option value="">Platform</option>
    <?php foreach ($platforms as $p): ?>
      <option value="<?= e($p) ?>" <?= $platform === $p ? 'selected' : '' ?>><?= e($p) ?></option>
    <?php endforeach; ?>
  </select>

  <select name="genre">
    <option value="">Genre</option>
    <?php foreach ($genres as $g): ?>
      <option value="<?= e($g) ?>" <?= $genre === $g ? 'selected' : '' ?>><?= e($g) ?></option>
    <?php endforeach; ?>
  </select>

  <select name="status">
    <option value="">Status</option>
    <?php foreach ($statuses as $value => $label): ?>
      <option value="<?= e($value) ?>" <?= $status === $value ? 'selected' : '' ?>><?= e($label) ?></option>
    <?php endforeach; ?>
  </select>

  <select name="rating">
    <option value="">Rating</option>
    <?php for ($i = 1; $i <= 5; $i++): ?>
      <option value="<?= $i ?>" <?= $rating == $i ? 'selected' : '' ?>><?= $i ?>+ sterren</option>
    <?php endfor; ?>
  </select>

  <button type="submit" class="btn">Filter</button>
</form>

<div class="game-list">
  <?php foreach ($games as $game): ?>
    <div class="game-row">
      <div class="thumb">
        <?php if ($game['image']): ?>
          <img src="/img/<?= e($game['image']) ?>" alt="">
        <?php else: ?>
          img
        <?php endif; ?>
      </div>

      <div class="game-info">
        <strong><?= e($game['title']) ?> (<?= e($game['release_year']) ?>)</strong>
        <small><?= e($game['platform']) ?></small>
      </div>

      <span class="pill"><?= e($statuses[$game['status']]) ?></span>
      <span class="stars"><?= stars($game['rating'] === null ? null : (int)$game['rating']) ?></span>
      <a href="/details.php?id=<?= (int)$game['id'] ?>" class="btn">Details</a>
    </div>
  <?php endforeach; ?>

  <?php if (empty($games)): ?>
    <p>Geen games gevonden.</p>
  <?php endif; ?>
</div>

<?php if ($role === 'bezoeker'): ?>
  <p class="note">Bezoeker: alleen bekijken. Geen knoppen voor toevoegen, bewerken of verwijderen.</p>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>