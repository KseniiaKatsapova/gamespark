<?php
// Safely print text (prevents XSS)
function e($text) {
  return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8');
}

// Turn 4 into ★★★★☆, and NULL into a dash
function stars($rating) {
  if ($rating === null) return '–';
  return str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
}