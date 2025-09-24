<?php
/**
 * GT Lazy & LCP (safe)
 * - LCP (image avec classe is-lcp) : pas de lazy + priorité réseau
 * - Laisse WP mettre loading="lazy" partout ailleurs
 */
if (!defined('ABSPATH')) exit;

if (!function_exists('gt_set_lcp_priority')) {
    function gt_set_lcp_priority($attr, $attachment, $size) {
        if (!empty($attr['class']) && strpos($attr['class'], 'is-lcp') !== false) {
            $attr['loading']       = 'eager';    // ne pas lazy-load
            $attr['decoding']      = 'async';
            $attr['fetchpriority'] = 'high';     // priorité réseau
        }
        return $attr;
    }
    add_filter('wp_get_attachment_image_attributes', 'gt_set_lcp_priority', 10, 3);
}

if (!function_exists('gt_omit_loading_threshold')) {
    function gt_omit_loading_threshold($threshold) {
        return 1; // WordPress pourra "épargner" 1 image du lazy (souvent la LCP)
    }
    add_filter('wp_omit_loading_attr_threshold', 'gt_omit_loading_threshold');
}


// wp-content/mu-plugins/gt-defer-js.php
if (!defined('ABSPATH')) exit;

add_filter('script_loader_tag', function ($tag, $handle, $src) {
  if (is_admin()) return $tag;

  // À ajuster selon ton thème/plugins
  $exclude = [
    'jquery-core', 'jquery', 'jquery-migrate',
    // ajoute ici ton slider si besoin de l'exclure : 'slick', 'swiper', etc.
  ];

  if (in_array($handle, $exclude, true)) return $tag;
  if (strpos($tag, ' defer ') !== false) return $tag;

  return str_replace(' src=', ' defer src=', $tag);
}, 10, 3);

// Mettre un maximum de scripts en footer
add_action('wp_enqueue_scripts', function () {
  global $wp_scripts;
  if (!($wp_scripts instanceof WP_Scripts)) return;
  foreach ($wp_scripts->registered as $h => $obj) {
    // Évite de forcer le footer pour jQuery
    if (in_array($h, ['jquery','jquery-core','jquery-migrate'], true)) continue;
    $wp_scripts->add_data($h, 'group', 1); // 1 = footer
  }
}, 100);
