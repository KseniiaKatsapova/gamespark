<?php
require 'db.php';

$hash = password_hash('Test123', PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE users SET username = ?, password = ?, role = 'admin', name = 'Liam de Waal' WHERE id = 1");
$stmt->execute(['Test123', $hash]);

$row = $pdo->query("SELECT * FROM users WHERE id = 1")->fetch(PDO::FETCH_ASSOC);

echo 'Username: ' . $row['username'] . '<br>';
echo 'Role: ' . $row['role'] . '<br>';
echo 'Name: ' . $row['name'] . '<br>';
echo 'Stored hash length: ' . strlen($row['password']) . ' (should be 60)<br>';
echo 'Password check: ' . (password_verify('Test123', $row['password']) ? 'OK' : 'FAILED');