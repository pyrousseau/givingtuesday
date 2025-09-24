<?php
if (!defined('ABSPATH')) exit;

/**
 * Rend non-bloquante la CSS du thème :
 * - supprime la balise <link rel="stylesheet"> standard du handle ciblé
 * - injecte <link rel="preload" as="style" ...> + <noscript>
 */

add_action('wp_print_styles', function () {
  if (is_admin()) return;

  $handle  = 'theme-style'; // ← d'après ton code, ton handle réel
  $styles  = wp_styles();

  if (!$styles || empty($styles->registered[$handle])) return;

  $src = $styles->registered[$handle]->src;
  if (!$src) return;
  if (strpos($src, '//') === 0) $src = (is_ssl() ? 'https:' : 'http:') . $src;

  // 1) Empêcher l’impression du lien bloquant par WP
  wp_dequeue_style($handle);

  // 2) Injecter preload + noscript
  $href = esc_url($src);
  echo "<!-- gt-preload:$handle -->\n";
  echo '<link rel="preload" as="style" href="'.$href.'" onload="this.rel=\'stylesheet\'">'."\n";
  echo '<noscript><link rel="stylesheet" href="'.$href.'"></noscript>'."\n";
}, 9999);

/** (Optionnel) Font Awesome non-bloquant */
add_filter('style_loader_tag', function ($html, $handle, $href, $media) {
  if (is_admin()) return $html;
  if (strpos($href, 'use.fontawesome.com') === false) return $html;

  $href = esc_url($href);
  return "<!-- gt-preload:$handle -->\n".
         '<link rel="preload" as="style" href="'.$href.'" onload="this.rel=\'stylesheet\'">'."\n".
         '<noscript><link rel="stylesheet" href="'.$href.'"></noscript>'."\n";
}, 9999, 4);
