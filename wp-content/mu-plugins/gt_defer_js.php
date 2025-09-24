<?php
if (!defined('ABSPATH')) exit;

/** Mettre un max de scripts en footer */
add_action('wp_enqueue_scripts', function () {
  global $wp_scripts;
  if (!($wp_scripts instanceof WP_Scripts)) return;
  foreach ($wp_scripts->registered as $h => $obj) {
    if (in_array($h, ['jquery','jquery-core','jquery-migrate'], true)) continue;
    $wp_scripts->add_data($h, 'group', 1); // 1 = footer
  }
}, 100);

/** Ajouter defer à tout sauf exceptions */
add_filter('script_loader_tag', function ($tag, $handle) {
  if (is_admin()) return $tag;

  // Ajoute ici ce qui NE doit PAS être defer si besoin (ex: un polyfill inline dépendant)
  $exclude = ['jquery','jquery-core','jquery-migrate'];

  foreach ($exclude as $ex) {
    if ($handle === $ex) return $tag;
  }
  if (strpos($tag, ' defer ') !== false) return $tag;
  return str_replace(' src=', ' defer src=', $tag);
}, 10, 2);
