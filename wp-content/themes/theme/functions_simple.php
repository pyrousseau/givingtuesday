<?php
/* ===== Boot minimal (text-domain: theme) ===== */

// A) i18n au bon moment
add_action('after_setup_theme', function () {
  load_theme_textdomain('theme', get_template_directory() . '/languages');
});

// B) Styles & JS du thème (adapte si besoin)
add_action('wp_enqueue_scripts', function () {
  $style = get_stylesheet_directory() . '/style.css';
  if (file_exists($style)) {
    wp_enqueue_style('theme-style', get_stylesheet_uri(), [], filemtime($style));
  }
  // Optionnel : /assets/css/main.css
  $bundle = get_stylesheet_directory() . '/assets/css/main.css';
  if (file_exists($bundle)) {
    wp_enqueue_style('theme-main', get_stylesheet_directory_uri() . '/assets/css/main.css', ['theme-style'], filemtime($bundle));
  }
  // Optionnel : /assets/js/main.js
  $main_js = get_stylesheet_directory() . '/assets/js/main.js';
  if (file_exists($main_js)) {
    wp_enqueue_script('theme-main', get_stylesheet_directory_uri() . '/assets/js/main.js', [], filemtime($main_js), true);
  }
});

// C) ACF options pages (si ACF actif)
add_action('acf/init', function () {
  if (!function_exists('acf_add_options_page')) return;

  acf_add_options_page([
    'page_title' => __('Paramètres d’accueil', 'theme'),
    'menu_title' => __('Paramètres d’accueil', 'theme'),
    'menu_slug'  => 'params-accueil',
    'capability' => 'manage_options',
    'redirect'   => false,
    'position'   => 59,
  ]);

  acf_add_options_page([
    'page_title' => __('Paramètres généraux', 'theme'),
    'menu_title' => __('Paramètres généraux', 'theme'),
    'menu_slug'  => 'params-generaux',
    'capability' => 'manage_options',
    'redirect'   => false,
    'position'   => 60,
  ]);
});

// D) MIMEs utiles
if (!function_exists('cc_mime_types')) {
  function cc_mime_types($mimes) {
    $mimes['webp'] = 'image/webp';
    $mimes['avif'] = 'image/avif';
    return $mimes;
  }
}
add_filter('upload_mimes', 'cc_mime_types');

// E) Menu admin "Je Rejoins" (optionnel)
function newsletter_function() {
  if (!current_user_can('edit_posts')) wp_die(__('Accès refusé.', 'theme'));
  echo '<div class="wrap"><h1>' . esc_html__('"Je Rejoins" — formulaire', 'theme') . '</h1>';
  echo '<p>' . esc_html__('Ici, affiche ton contenu : tableau, formulaire, etc.', 'theme') . '</p></div>';
}
add_action('admin_menu', function () {
  add_menu_page(
    __('"Je Rejoins" formulaire', 'theme'),
    __('"Je Rejoins" formulaire', 'theme'),
    'edit_posts',
    'newsletter-admin',
    'newsletter_function',
    'dashicons-email-alt',
    6
  );
});

// Shim temporaire si la classe manque, pour éviter le fatal
if (!class_exists('WP_First_Level_Navwalker') && class_exists('Walker_Nav_Menu')) {
  class WP_First_Level_Navwalker extends Walker_Nav_Menu {}
}
