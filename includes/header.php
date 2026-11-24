<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/functions.php';
$role = $_SESSION['role'] ?? 'bezoeker';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>GameSpark</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="page">

  <header class="site-header">
    <strong>GameSpark</strong>
    <span><?= e(ucfirst($role)) ?></span>
  </header>

  <aside class="sidebar">
    <a href="/index.php" class="active">Overzicht</a>
    <div class="sidebar-bottom">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/logout.php">Uitloggen</a>
      <?php else: ?>
        <a href="/login.php">Inloggen</a>
      <?php endif; ?>
    </div>
  </aside>

  <main class="content">