<?php
if (!defined('ABSPATH')) exit;

/** 1) Émojis WordPress (JS/CSS inutiles) */
add_action('init', function () {
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('admin_print_styles', 'print_emoji_styles');
  add_filter('emoji_svg_url', '__return_false');
});

/** 2) Embeds oEmbed (désactive le JS wp-embed) */
add_action('wp_footer', function () {
  wp_deregister_script('wp-embed');
}, 11);

/** 3) Dashicons (icônes admin) hors admin/loggé */
add_action('wp_enqueue_scripts', function () {
  if (!is_user_logged_in()) {
    wp_deregister_style('dashicons');
  }
}, 20);

/** 4) Styles Gutenberg (si ton front n’utilise pas l’éditeur) */
add_action('wp_enqueue_scripts', function () {
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
  wp_dequeue_style('global-styles');
}, 100);
