
<?php
/**
 * Dump de la dernière erreur PHP quand ?debug=1 est présent et pour les admins.
 * A SUPPRIMER après dépannage.
 */
add_action('init', function () {
  if (isset($_GET['debug']) && $_GET['debug'] === '1' && current_user_can('manage_options')) {
    @ini_set('display_errors', 1);
    @ini_set('error_reporting', E_ALL);
    register_shutdown_function(function () {
      $e = error_get_last();
      if ($e) {
        if (!headers_sent()) header('Content-Type: text/plain; charset=UTF-8');
        echo "=== LAST PHP ERROR ===\n";
        echo "Type: {$e['type']}\nFile: {$e['file']}\nLine: {$e['line']}\nMessage: {$e['message']}\n";
      } else {
        if (!headers_sent()) header('Content-Type: text/plain; charset=UTF-8');
        echo "Aucune erreur fatale capturée.\n";
      }
    });
  }
});
