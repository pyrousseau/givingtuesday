<?php
if (!defined('ABSPATH')) exit;

/**
 * Rend non-bloquantes les feuilles Font Awesome (kits ou CDN).
 * Si ton optimiseur “mange” le preload, remplace `return $preload` par `$fallback`.
 */
add_filter('style_loader_tag', function($html, $handle, $href, $media){
  if (is_admin()) return $html;

  // Détecte FA : kit.fontawesome.com (JS -> CSS générée), use.fontawesome.com, cdnjs…
  $is_fa = strpos($href, 'fontawesome') !== false || strpos($href, 'use.fontawesome.com') !== false || strpos($href, 'cdnjs.cloudflare.com/ajax/libs/font-awesome') !== false;
  if (!$is_fa) return $html;

  $href = esc_url($href);

  $preload  = "<!-- gt-fa:preload:$handle -->\n";
  $preload .= '<link rel="preload" as="style" href="'.$href.'" onload="this.rel=\'stylesheet\'">'."\n";
  $preload .= '<noscript><link rel="stylesheet" href="'.$href.'"></noscript>'."\n";

  // Fallback robuste si un plugin réécrit le preload
  $fallback  = "<!-- gt-fa:fallback:$handle -->\n";
  $fallback .= '<link rel="stylesheet" href="'.$href.'" media="print" onload="this.media=\'all\'">'."\n";
  $fallback .= '<noscript><link rel="stylesheet" href="'.$href.'"></noscript>'."\n";

  return $preload; // ou $fallback;
}, 9999, 4);
