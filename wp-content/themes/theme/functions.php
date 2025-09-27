<?php
/*
 *  Author: Eugene Nikulin based on Todd Motto
 *  URL: http://nikulin.com.ua
 */
/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/
// --- Menu admin "Je Rejoins" (protégé contre les doublons) ---
if (!function_exists('wpdocs_register_my_custom_menu_page')) {
  function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
      __('"Je Rejoins" formulaire', 'mon-theme'),
      __('"Je Rejoins" formulaire', 'mon-theme'),
      'edit_posts',
      'newsletter-admin',
      'newsletter_function',
      'dashicons-email-alt',
      6
    );
  }
}
if (!has_action('admin_menu', 'wpdocs_register_my_custom_menu_page')) {
  add_action('admin_menu', 'wpdocs_register_my_custom_menu_page');
}

if (!function_exists('newsletter_function')) {
  function newsletter_function() {
    if (!current_user_can('edit_posts')) {
      wp_die(__('Accès refusé.', 'mon-theme'));
    }
    echo '<div class="wrap"><h1>'.esc_html__('"Je Rejoins" — formulaire', 'mon-theme').'</h1>';
    echo '<p>'.esc_html__('Ici, affiche ton contenu : tableau, formulaire, etc.', 'mon-theme').'</p></div>';
  }
}

function add_export_posts_button(){

    if (isset($_GET['post_type']) && $_GET['post_type'] == 'action-a-decouvrir') {
        echo '<a href="/wp-content/themes/theme/export-action.php" target="_blank" class="export button" style="display: inline-block;float:right;">Exporter Actions</a>';
    }
}
add_action( 'restrict_manage_posts', 'add_export_posts_button', 0 );

// ---- Upload MIMEs (défini et attaché une seule fois) ----
if (!function_exists('cc_mime_types')) {
  function cc_mime_types($mimes) {
    $mimes['webp'] = 'image/webp';
    $mimes['avif'] = 'image/avif';
    return $mimes;
  }
}
if (!has_filter('upload_mimes', 'cc_mime_types')) {
  add_filter('upload_mimes', 'cc_mime_types');
}

add_action('init', 'remove_content_editor');

function remove_content_editor() {
    remove_post_type_support( 'page', 'editor' );
}


function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        '"Je Rejoins" formulaire ',
        '"Je Rejoins" formulaire',
        'edit_posts',
        'newsletter-admin',
        'newsletter_function',
        'dashicons-email-alt',
        6
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );
function newsletter_function() {
    global $title;

    print '<div class="wrap">';
    print "<h1>$title</h1>";

    $file = plugin_dir_path(__FILE__) . "newsletter-admin.php";
    if (file_exists($file)) {
        require $file;
    }
}
/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('monde', 125, 125, false); // Small Thumbnail
    add_image_size('paricipant', 241, 137, false); // Small Thumbnail
    add_image_size('actu', 769, 442, false); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
    add_image_size('actu-thumb', 314, 181, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
// Charger les traductions du thème au bon moment
add_action('after_setup_theme', function () {
  load_theme_textdomain(
    'theme', // ⚠️ Remplace par le text domain exact de TON thème (cf. en-tête style.css)
    get_template_directory() . '/languages'
  );
});

}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// theme navigation
function theme_nav($location, $locationClass)
{
	wp_nav_menu(
	array(
		'theme_location'  => $location,
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul class="'.$locationClass.'">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load theme scripts (header.php)
function theme_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
        wp_register_script('cookieconsent', '//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js', array(), '1.0.0'); // Custom scripts
        wp_enqueue_script('cookieconsent'); // Enqueue it!


        wp_deregister_script( 'jquery-core' );
        wp_register_script( 'jquery-core', "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js", array(), '3.1.1' );
        wp_deregister_script( 'jquery-migrate' );
        wp_register_script( 'jquery-migrate', "https://code.jquery.com/jquery-migrate-3.0.0.min.js", array(), '3.0.0' );

        wp_register_script( 'jquery-cookie', get_template_directory_uri() . "/js/jquery.cookie.js", array('jquery'), '3.0.0' );
        wp_enqueue_script('jquery-cookie'); // Enqueue it!

        wp_register_script( 'slick', get_template_directory_uri() . "/js/slick.min.js", array('jquery'), '3.0.0' );
        wp_enqueue_script('slick'); // Enqueue it!
        wp_register_script( 'selectric', get_template_directory_uri() . "/js/jquery.selectric.min.js", array('jquery'), '3.0.0' );
        wp_enqueue_script('selectric'); // Enqueue it!
        wp_register_script( 'mask', get_template_directory_uri() . "/js/jquery.mask.js", array('jquery'), '3.0.0' );
        wp_enqueue_script('mask'); // Enqueue it!
        wp_register_script('themescripts', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('themescripts'); // Enqueue it!
        wp_register_script('form', get_template_directory_uri() . '/js/form.js', array('jquery'),
            '1.0.0'); // Custom scripts
        wp_enqueue_script('form'); // Enqueue it!

    }
}

// Load theme conditional scripts
function theme_conditional_scripts()
{
//    if (is_page('pagenamehere')) {
//        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
//        wp_enqueue_script('scriptname'); // Enqueue it!
//    }
}

// Load theme styles
function theme_styles()
{


    wp_register_style('theme', get_template_directory_uri() . '/css/style.css', array(), '1.0', 'all');
    wp_enqueue_style('theme'); // Enqueue it!
    wp_register_style('fonts', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900', array(), '1.0', 'all');
    wp_enqueue_style('fonts'); // Enqueue it!
    wp_register_style('oswald', 'https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700', array(), '1.0', 'all');
    wp_enqueue_style('oswald'); // Enqueue it!
    wp_register_style('fontawesome', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css', array(), '1.0', 'all');
    wp_enqueue_style('fontawesome'); // Enqueue it!
    wp_register_style('fontawesome2', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css', array(), '1.0', 'all');
    wp_enqueue_style('fontawesome2'); // Enqueue it!

}

// Register theme Navigation
function register_theme_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'theme'), // Main Navigation
        'footer-1' => __('Footer 1', 'theme'), // Sidebar Navigation
        'footer-2' => __('Footer 2', 'theme') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'theme'),
        'description' => __('Description for this widget-area...', 'theme'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'theme'),
        'description' => __('Description for this widget-area...', 'theme'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function themewp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function themewp_index($length) // Create 20 Word Callback for Index page Excerpts, call using themewp_excerpt('themewp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using themewp_excerpt('themewp_custom_post');
function themewp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function themewp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function theme_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'theme') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function theme_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function themegravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function themecomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'theme_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'theme_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'theme_styles'); // Add Theme Stylesheet
add_action('init', 'register_theme_menu'); // Add theme Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'themewp_pagination'); // Add our theme Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'themegravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'theme_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'theme_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('theme_shortcode_demo', 'theme_shortcode_demo'); // You can place [theme_shortcode_demo] in Pages, Posts now.
add_shortcode('theme_shortcode_demo_2', 'theme_shortcode_demo_2'); // Place [theme_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [theme_shortcode_demo] [theme_shortcode_demo_2] Here's the page title! [/theme_shortcode_demo_2] [/theme_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/
// Register Custom Post Type
function CPT_faqpage() {

    $labels = array(
        'name'                  => _x( 'FAQs', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'FAQ', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'FAQ', 'text_domain' ),
        'name_admin_bar'        => __( 'FAQ', 'text_domain' ),
        'archives'              => __( 'FAQ pages Archives', 'text_domain' ),
        'attributes'            => __( 'FAQ pages Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent FAQ page:', 'text_domain' ),
        'all_items'             => __( 'Toutes les pages FAQ', 'text_domain' ),
        'add_new_item'          => __( 'Ajouter une page FAQ', 'text_domain' ),
        'add_new'               => __( 'Ajouter nouvelle page FAQ', 'text_domain' ),
        'new_item'              => __( 'Nouvelle page FAQ', 'text_domain' ),
        'edit_item'             => __( 'Modifier page FAQ', 'text_domain' ),
        'update_item'           => __( 'Mettre à jour page FAQ', 'text_domain' ),
        'view_item'             => __( 'Voir page FAQ', 'text_domain' ),
        'view_items'            => __( 'Voir pages FAQ', 'text_domain' ),
        'search_items'          => __( 'Recherch page FAQ', 'text_domain' ),
        'not_found'             => __( 'Pas trouvé', 'text_domain' ),
        'not_found_in_trash'    => __( 'Pas trouvé', 'text_domain' ),
        'featured_image'        => __( 'L\'image sélectionnée', 'text_domain' ),
        'set_featured_image'    => __( 'Installer l\'image sélectionnée', 'text_domain' ),
        'remove_featured_image' => __( 'Déplacer l\'image sélectionnée', 'text_domain' ),
        'use_featured_image'    => __( 'Utiliser l\'image sélectionnée', 'text_domain' ),
        'insert_into_item'      => __( 'Insérer dans la page FAQ', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Téléchargé sur cette page FAQ', 'text_domain' ),
        'items_list'            => __( 'Liste de pages FAQ', 'text_domain' ),
        'items_list_navigation' => __( 'Liste de pages FAQ navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filtrer liste de pages FAQ', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'FAQ', 'text_domain' ),
        'description'           => __( 'FAQ', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title' ),
        'taxonomies'            => array(  ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-editor-help',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'faqpage', $args );

}
add_action( 'init', 'CPT_faqpage', 0 );
// Register Custom Post Type
function CPT_participant() {

    $labels = array(
        'name'                  => _x( 'Ils participent', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Participant', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Ils participent', 'text_domain' ),
        'name_admin_bar'        => __( 'Ils participent', 'text_domain' ),
        'archives'              => __( 'Participants Archives', 'text_domain' ),
        'attributes'            => __( 'Participants Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Participant:', 'text_domain' ),
        'all_items'             => __( 'Toutes les Participants', 'text_domain' ),
        'add_new_item'          => __( 'Ajouter un Participant', 'text_domain' ),
        'add_new'               => __( 'Ajouter nouveau Participant', 'text_domain' ),
        'new_item'              => __( 'Nouveau Participant', 'text_domain' ),
        'edit_item'             => __( 'Modifier Participant', 'text_domain' ),
        'update_item'           => __( 'Mettre à jour Participant', 'text_domain' ),
        'view_item'             => __( 'Voir Participant', 'text_domain' ),
        'view_items'            => __( 'Voir Participants', 'text_domain' ),
        'search_items'          => __( 'Rechercher Participant', 'text_domain' ),
        'not_found'             => __( 'Pas trouvé', 'text_domain' ),
        'not_found_in_trash'    => __( 'Pas trouvé', 'text_domain' ),
        'featured_image'        => __( 'L\'image sélectionnée', 'text_domain' ),
        'set_featured_image'    => __( 'Installer l\'image sélectionnée', 'text_domain' ),
        'remove_featured_image' => __( 'Déplacer l\'image sélectionnée', 'text_domain' ),
        'use_featured_image'    => __( 'Utiliser l\'image sélectionnée', 'text_domain' ),
        'insert_into_item'      => __( 'Insérer dans Participant', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Téléchargé sur cette Participant', 'text_domain' ),
        'items_list'            => __( 'Liste des Participants', 'text_domain' ),
        'items_list_navigation' => __( 'Liste des Participants', 'text_domain' ),
        'filter_items_list'     => __( 'Filtrer liste des Participants', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Ils participent', 'text_domain' ),
        'description'           => __( 'Ils participent', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title' ),
        'taxonomies'            => array(  ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-businessman',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'participant', $args );

}
add_action( 'init', 'CPT_participant', 0 );

// Register Custom Post Type
function CPT_actions() {

    $labels = array(
        'name'                  => _x( 'Actions', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Action', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Actions', 'text_domain' ),
        'name_admin_bar'        => __( 'Actions', 'text_domain' ),
        'archives'              => __( 'Actions Archives', 'text_domain' ),
        'attributes'            => __( 'Actions Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Action:', 'text_domain' ),
        'all_items'             => __( 'Toutes les Actions', 'text_domain' ),
        'add_new_item'          => __( 'Ajouter une Action', 'text_domain' ),
        'add_new'               => __( 'Ajouter nouvelle Action', 'text_domain' ),
        'new_item'              => __( 'Nouvelle Action', 'text_domain' ),
        'edit_item'             => __( 'Modifier Action', 'text_domain' ),
        'update_item'           => __( 'Mettre à jour Action', 'text_domain' ),
        'view_item'             => __( 'Voir Action', 'text_domain' ),
        'view_items'            => __( 'Voir Actions', 'text_domain' ),
        'search_items'          => __( 'Rechercher Action', 'text_domain' ),
        'not_found'             => __( 'Pas trouvé', 'text_domain' ),
        'not_found_in_trash'    => __( 'Pas trouvé', 'text_domain' ),
        'featured_image'        => __( 'L\'image sélectionnée', 'text_domain' ),
        'set_featured_image'    => __( 'Installer l\'image sélectionnée', 'text_domain' ),
        'remove_featured_image' => __( 'Déplacer l\'image sélectionnée', 'text_domain' ),
        'use_featured_image'    => __( 'Utiliser l\'image sélectionnée', 'text_domain' ),
        'insert_into_item'      => __( 'Insérer dans Action', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Téléchargé sur cette Action', 'text_domain' ),
        'items_list'            => __( 'Liste des Actions', 'text_domain' ),
        'items_list_navigation' => __( 'Liste des Actions', 'text_domain' ),
        'filter_items_list'     => __( 'Filtrer liste des Actions', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Actions', 'text_domain' ),
        'description'           => __( 'Actions', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title' ),
        'taxonomies'            => array(  ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-chat',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'action-a-decouvrir', $args );

}
add_action( 'init', 'CPT_actions', 0 );


add_filter( 'wp_mail_from_name', 'my_mail_from_name' );
function my_mail_from_name( $name ) {
    return "Giving Tuesday France";
}

add_filter( 'wp_mail_from', 'my_mail_from' );
function my_mail_from( $email ) {
    return "contact@givingtuesday.fr";
}

/* load more */
function load_more_cpts() {
    $paged = $_POST['page'] + 1; // Page suivante

    $args = array(
        'post_type' => 'action-a-decouvrir',
        'posts_per_page' => 6,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $categorie_event_value = isset($_POST['categorie_event']) ? sanitize_text_field($_POST['categorie_event']) : '';

    if (!empty($categorie_event_value)) {
        $args['meta_query'] = array(
            array(
                'key' => 'categorie_event',
                'value' => $categorie_event_value,
                'compare' => '=',
            )
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        /* ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="li">
                <div class="action-block-container categorie-<?php the_field('categorie_event'); ?>">
                    <div class="icon-block-container">
                        <div class="icon-block"></div>
                    </div>
                    <div class="action-block categorie-<?php the_field('categorie_event'); ?>"
                        id="<?php echo get_the_ID(); ?>" data-date="<?php echo get_field('event_date'); ?>">
                        <?php
                        $image_infos = get_field('event_photo');
                        if (isset($image_infos['url']) && ($image_infos['url'] != '')) {
                            ?>
                            <img src="<?php echo $image_infos['url']; ?>" title="Présentation"
                                style="margin-bottom:20px;min-height: 175px; width: 100%; max-height: 175px;object-fit: cover;object-position: top center;" />
                            <?php
                        }
                        ?>
                        <div class="head-block" style="<?php echo $padding_head; ?>">
                            <div class="title-block">
                                <div class="info-block">
                                    <div class="date-block">
                                        <?php echo strftime('%d %B %Y', strtotime(get_field('event_date'))); ?>
                                    </div>
                                    <div class="loc-block">
                                        <?php
                                        $region = get_field('region');
                                        $ville = get_field('ville');
                                        echo ($region && $region != '-') ? $region : '';
                                        echo $ville ? ' / '.$ville : '';
                                        ?>
                                    </div>
                                </div>
                                <div class="title">
                                    <?php echo get_the_title(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="text-block">
                            <?php the_field('event_description'); ?>...
                            <?php if (get_field('url')) { ?>
                            <div class="link-wrap">
                                <a href="<?php echo get_field('url'); ?>" target="_blank" class="enSav">En savoir plus</a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="social-block mediasocial">
                            <span>Partager cette action :</span>
                            <ul>
                                <li>
                                    <a class="fab-click" href="#"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a class="twi-click" href="#"
                                        data-text="<?php echo trim(preg_replace('/ss+/', ' ', get_the_title())); ?>"
                                        data-url="<?php echo get_permalink(); ?>"><i class="fab fa-x-twitter"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } */
        $response = ob_get_clean();
        wp_send_json_success($response);
    } else {
        wp_send_json_error('Aucun post trouvé');
    }

    wp_die();
}

add_action('wp_ajax_nopriv_load_more_cpts', 'load_more_cpts');
add_action('wp_ajax_load_more_cpts', 'load_more_cpts');


function my_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_localize_script('jquery', 'ajaxurl', array('url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');
/* adapter le liste de premier nuveau pour le menu footer */
class WP_First_Level_Navwalker extends Walker_Nav_Menu {
    // Commence le niveau
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // Ne rien faire pour les sous-niveaux
    }

    // Terminé le niveau
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        // Ne rien faire pour les sous-niveaux
    }

    // Commence un élément de menu
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        if ($depth == 0) {
            $output .= sprintf( "\n<li class='%s'><a href='%s'>%s</a></li>\n",
                implode(" ", $item->classes),
                $item->url,
                $item->title
            );
        }
    }

    // Terminé un élément de menu
    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ($depth == 0) {
            $output .= '';
        }
    }
}

// 3.1 Enqueue du script
add_action('wp_enqueue_scripts', function () {
    $ver = wp_get_environment_type() === 'production' ? '1.0.0' : time();
    wp_enqueue_script(
        'gt-lazy-io',
        get_stylesheet_directory_uri() . '/assets/js/lazy-io.js',
        [],
        $ver,
        true // in footer
    );
});

// 3.2 LCP: forcer fetchpriority=high et désactiver lazy pour la toute 1ère image du contenu/hero.
add_filter('wp_get_attachment_image_attributes', function ($attr, $attachment, $size) {
    if (!isset($GLOBALS['gt_lcp_done'])) {
        $attr['fetchpriority'] = 'high';
        $attr['decoding'] = 'async';
        // Supprime l'attribut loading ajouté par WP si présent
        unset($attr['loading']);
        $GLOBALS['gt_lcp_done'] = true;
    }
    return $attr;
}, 10, 3);

// 3.3 Optionnel: garder loading="lazy" natif comme filet de sécurité
add_filter('wp_img_tag_add_loading_attr', function ($value, $img, $context) {
    // On NE met pas lazy sur la toute 1ère image (déjà gérée ci-dessus)
    if (empty($GLOBALS['gt_first_content_image_skipped'])) {
        $GLOBALS['gt_first_content_image_skipped'] = true;
        return false;
    }
    return $value; // lazy par défaut pour les autres (double filet)
}, 10, 3);
add_action('wp_enqueue_scripts', function () {
    $ver = (wp_get_environment_type() === 'production') ? '1.0.1' : time();
    wp_enqueue_script(
        'gt-lazy-io',
        get_stylesheet_directory_uri() . '/assets/js/lazy-io.js',
        [],
        $ver,
        true // footer
    );
    // Ajoute l’attribut defer proprement
    if (function_exists('wp_script_add_data')) {
        wp_script_add_data('gt-lazy-io', 'defer', true);
    }
});

// Lazy IO – enqueue uniquement
add_action('wp_enqueue_scripts', function () {
    $ver = (wp_get_environment_type()==='production') ? '1.0.3' : time();
    wp_enqueue_script(
        'gt-lazy-io',
        get_stylesheet_directory_uri().'/assets/js/lazy-io.js',
        [],
        $ver,
        true // footer
    );
    if (function_exists('wp_script_add_data')) {
        wp_script_add_data('gt-lazy-io','defer',true);
    }
});

// (Optionnel) Protéger l’image LCP : pas de lazy natif + fetchpriority
add_filter('wp_get_attachment_image_attributes', function ($attr) {
    if (!isset($GLOBALS['gt_lcp_done'])) {
        $attr['fetchpriority'] = 'high';
        unset($attr['loading']);
        $GLOBALS['gt_lcp_done'] = true;
    }
    return $attr;
}, 10, 1);

// functions.php
add_action('wp_enqueue_scripts', function () {
  $ver = (wp_get_environment_type()==='production') ? '1.0.3' : time();
  wp_enqueue_script('gt-lazy-io', get_stylesheet_directory_uri().'/assets/js/lazy-io.js', [], $ver, true);
  if (function_exists('wp_script_add_data')) wp_script_add_data('gt-lazy-io','defer',true);
});

add_action('wp_enqueue_scripts', function () {
  $ver = (wp_get_environment_type()==='production') ? '1.0.4' : time();
  wp_enqueue_script(
    'gt-lazy-io',
    get_stylesheet_directory_uri() . '/assets/js/lazy-io.js',
    [],
    $ver,
    true
  );
  if (function_exists('wp_script_add_data')) {
    wp_script_add_data('gt-lazy-io','defer',true);
  }
});
add_action('wp_enqueue_scripts', function () {
  $ver = (wp_get_environment_type()==='production') ? '1.0.6' : time();
  wp_enqueue_script(
    'gt-lazy-io',
    get_stylesheet_directory_uri() . '/assets/js/lazy-io.js',
    ['jquery'], // on déclare jQuery si ton slider l’utilise
    $ver,
    true
  );
  if (function_exists('wp_script_add_data')) {
    wp_script_add_data('gt-lazy-io','defer',true);
  }
});

add_action('wp_enqueue_scripts', function () {
  $ver = (wp_get_environment_type()==='production') ? '1.0.7' : time();
  wp_enqueue_script(
    'gt-lazy-io',
    get_stylesheet_directory_uri() . '/assets/js/lazy-io.js',
    ['jquery'], // si ton slider est en Slick
    $ver,
    true
  );
  if (function_exists('wp_script_add_data')) {
    wp_script_add_data('gt-lazy-io','defer',true);
  }
});

add_action('wp_enqueue_scripts', function () {
  $ver = (wp_get_environment_type()==='production') ? '1.0.8' : time();
  wp_enqueue_script(
    'gt-lazy-io',
    get_stylesheet_directory_uri() . '/assets/js/lazy-io.js',
    ['jquery'], // si ton slider est en Slick
    $ver,
    true
  );
  if (function_exists('wp_script_add_data')) {
    wp_script_add_data('gt-lazy-io','defer',true);
  }
});

add_action('wp_enqueue_scripts', function () {
  $ver = (wp_get_environment_type()==='production') ? '1.1.0' : time();
  wp_enqueue_script(
    'gt-lazy-io',
    get_stylesheet_directory_uri() . '/assets/js/lazy-io.js',
    ['jquery'], // Slick utilise jQuery
    $ver,
    true
  );
  if (function_exists('wp_script_add_data')) {
    wp_script_add_data('gt-lazy-io','defer',true);
  }
});

add_action('wp_enqueue_scripts', function () {
  // Lazy IO (déjà en place)
  wp_enqueue_script('gt-lazy-io', get_stylesheet_directory_uri().'/assets/js/lazy-io.js', ['jquery'], wp_get_environment_type()==='production'?'1.1.0':time(), true);
  wp_script_add_data('gt-lazy-io','defer',true);

  // Exemple: forcer 'defer' sur d'autres handles si besoin
  foreach (['slick-js-handle','autoptimize_js','theme-main-js'] as $h) {
    if (wp_script_is($h, 'registered')) wp_script_add_data($h, 'defer', true);
  }
}, 20);

// Emojis
add_action('init', function(){
  remove_action('wp_head','print_emoji_detection_script',7);
  remove_action('wp_print_styles','print_emoji_styles');
});

// oEmbed & RSD & WLW
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','rest_output_link_wp_head');
remove_action('wp_head','rsd_link');
remove_action('wp_head','wlwmanifest_link');

// Block library CSS (si pas de blocs Gutenberg sur la home)
add_action('wp_enqueue_scripts', function() {
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
  wp_dequeue_style('global-styles');
}, 100);

add_filter('wp_lazy_loading_enabled', function($default, $tag, $context){
  static $first=false;
  if (!$first && in_array($context, ['the_content','wp_get_attachment_image'], true)) {
    $first = true;           // première image = pas de lazy
    return false;
  }
  return $default;
}, 10, 3);


// Helpers
function gt_cached($key, $ttl, $cb){
  $html = get_transient($key);
  if(false === $html){
    $html = call_user_func($cb);
    // Propreté : strip whitespace externe
    $html = trim(preg_replace('/>\s+</', '><', $html));
    set_transient($key, $html, $ttl);
  }
  return $html;
}

// functions.php (thème ou mu-plugin)
add_action('acf/init', function () {
  // ✅ Tous tes appels ACF ici (options pages, field groups dynamiques, etc.)
  // Exemple:
  acf_add_options_page(array(
    'page_title' => __('Réglages du site', 'theme'),
    'menu_title' => __('Réglages', 'theme'),
    'menu_slug'  => 'site-settings',
    'capability' => 'manage_options',
    'redirect'   => false,
  ));
});

add_action('after_setup_theme', function () {
  load_theme_textdomain('theme', get_template_directory() . '/languages');
});


/* ----------------------------
 * Réglages safe & ordonnés
 * ---------------------------- */

/** 1) Textdomain du thème (si tu utilises des __() ) */
add_action('after_setup_theme', function () {
  // ⚠️ remplace 'mon-theme' par le textdomain de ton thème (cf. style.css)
  load_theme_textdomain('theme', get_template_directory() . '/languages');
});

/** 2) MIMEs upload (déclare le callback AVANT de l’attacher) */
function cc_mime_types($mimes) {
  // Ajoute/ajuste ce dont tu as besoin
  $mimes['webp'] = 'image/webp';
  $mimes['avif'] = 'image/avif';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


/** 3) ACF: options pages → après init d’ACF (sinon warning “chargé trop tôt”) */
add_action('acf/init', function () {
  if (!function_exists('acf_add_options_page')) return;

  acf_add_options_page(array(
    'page_title' => __('Paramètres d’accueil', 'theme'),
    'menu_title' => __('Paramètres d’accueil', 'theme'),
    'menu_slug'  => 'params-accueil',
    'capability' => 'manage_options',
    'redirect'   => false,
    'position'   => 59
  ));

  acf_add_options_page(array(
    'page_title' => __('Paramètres généraux', 'theme'),
    'menu_title' => __('Paramètres généraux', 'theme'),
    'menu_slug'  => 'params-generaux',
    'capability' => 'manage_options',
    'redirect'   => false,
    'position'   => 60
  ));
});


/** 4) Retirer l’éditeur de contenu pour les pages (faire ça en admin_init) */
function gt_remove_content_editor() {
  remove_post_type_support('page', 'editor');
}
add_action('admin_init', 'gt_remove_content_editor');


/* ====== I18N & ACF — CHARGEMENT PROPRE ====== */

/** A) Charger les traductions du thème au bon moment */
add_action('after_setup_theme', function () {
  load_theme_textdomain('theme', get_template_directory() . '/languages');
});

/** B) Déclarer les pages d’options ACF APRÈS l’init d’ACF */
add_action('acf/init', function () {
  if (!function_exists('acf_add_options_page')) return;

  // Exemple : "Paramètres d’accueil"
  if (!function_exists('gt_register_acf_options_home')) {
    function gt_register_acf_options_home() {
      acf_add_options_page(array(
        'page_title' => __('Paramètres d’accueil', 'theme'),
        'menu_title' => __('Paramètres d’accueil', 'theme'),
        'menu_slug'  => 'params-accueil',
        'capability' => 'manage_options',
        'redirect'   => false,
        'position'   => 59
      ));
    }
  }
  gt_register_acf_options_home();

  // Exemple : "Paramètres généraux"
  if (!function_exists('gt_register_acf_options_general')) {
    function gt_register_acf_options_general() {
      acf_add_options_page(array(
        'page_title' => __('Paramètres généraux', 'theme'),
        'menu_title' => __('Paramètres généraux', 'theme'),
        'menu_slug'  => 'params-generaux',
        'capability' => 'manage_options',
        'redirect'   => false,
        'position'   => 60
      ));
    }
  }
  gt_register_acf_options_general();
});

/** C) Éviter toute trad au niveau global : initialiser les libellés à init */
add_action('init', function () {
  // Exemple : si tu avais des variables traduites globales, mets-les ici
  // $GLOBALS['gt_labels']['partners'] = __('Partenaires', 'mon-theme');
});

// ✅ functions.php
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

add_action('after_setup_theme', function () {
  load_theme_textdomain('theme', get_template_directory() . '/languages');
});


/* ===== Fragments HTML + Lazy-IO (stable) ===== */


// 2) Petit cache transients
if (!function_exists('gt_cached_html')) {
  function gt_cached_html($key, $ttl, $cb) {
    $html = get_transient($key);
    if ($html === false) {
      $html = (string) call_user_func($cb);
      $html = trim(preg_replace('/>\s+</', '><', $html));
      set_transient($key, $html, $ttl);
    }
    return $html;
  }
}

// 3) Callback: liste d’actus (HTML prêt)
if (!function_exists('gt_fragment_news')) {
  function gt_fragment_news($req) {
    $count = max(1, (int) ($req->get_param('count') ?: 6));
    $html = gt_cached_html('frag_news_' . $count, 300, function () use ($count) {
      $q = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => $count,
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
        'fields' => 'ids'
      ));
      ob_start(); ?>
      <ul class="cards cards--news">
        <?php foreach ($q->posts as $pid): ?>
          <li class="card">
            <a href="<?php echo esc_url(get_permalink($pid)); ?>">
              <?php
                echo wp_get_attachment_image(
                  get_post_thumbnail_id($pid),
                  'medium_large',
                  false,
                  array('loading' => 'lazy', 'decoding' => 'async', 'class' => 'card__img')
                );
              ?>
              <h3 class="card__title"><?php echo esc_html(get_the_title($pid)); ?></h3>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php return ob_get_clean();
    });
    return new WP_REST_Response($html, 200, array(
      'Content-Type' => 'text/html; charset=UTF-8',
      'Cache-Control' => 'public, max-age=120'
    ));
  }
}

// 4) Loader JS (lazy-io)
add_action('wp_enqueue_scripts', function () {
  wp_register_script('lazy-io', false, array(), null, true);
  $js = <<<'JS'
(function(){
  var KEY='__io1';
  var frags=document.querySelectorAll('.ssr-fragment[data-fragment]');
  if(!frags.length) return;

  function load(el){
    if(el[KEY]) return; el[KEY]=1;
    var url=el.getAttribute('data-fragment');
    var ctrl=('AbortController' in window)? new AbortController(): null;
    var to=setTimeout(function(){ if(ctrl) ctrl.abort(); }, +(el.dataset.timeout||8000));
    fetch(url, { credentials:'same-origin', signal: ctrl? ctrl.signal: undefined })
      .then(function(r){ if(!r.ok) throw new Error(r.status); return r.text(); })
      .then(function(html){ el.innerHTML=html; el.removeAttribute('aria-busy'); })
      .catch(function(e){ el.innerHTML='<p class="frag-error">⚠️ Contenu indisponible.</p>'; el.removeAttribute('aria-busy'); console.error('[lazy-io]', url, e); })
      .finally(function(){ clearTimeout(to); });
  }

  if('IntersectionObserver' in window){
    var io=new IntersectionObserver(function(es){
      es.forEach(function(e){ if(e.isIntersecting){ io.unobserve(e.target); load(e.target); } });
    }, { rootMargin:'600px 0px' });
    frags.forEach(function(el){ io.observe(el); });
  } else {
    frags.forEach(load);
  }
})();
JS;
  wp_add_inline_script('lazy-io', $js, 'after');
  wp_enqueue_script('lazy-io');
}, 20);


// ===== Fragment INTRO (propre, avec sources ACF -> front page -> fallback) =====


if (!function_exists('gt_fragment_intro')) {
  function gt_fragment_intro($req) {
    // -- CACHE court et clé unique pour éviter collisions --
    $cache_key = 'frag_intro_v1';
    $html = get_transient($cache_key);
    if ($html !== false && !isset($_GET['nocache'])) {
$resp = new WP_REST_Response($html, 200);
$resp->header('Content-Type', 'text/html; charset=utf-8');
return $resp;

    }

    // -- 1) Source ACF (options) --
    $title = $text = $cta_url = $cta_title = '';
    if (function_exists('get_field')) {
      $title     = (string) get_field('intro_title', 'option');
      $text      = (string) get_field('intro_text',  'option');
      $cta       = get_field('intro_cta', 'option'); // group: ['url','title']
      $cta_url   = is_array($cta) && !empty($cta['url'])   ? $cta['url']   : '';
      $cta_title = is_array($cta) && !empty($cta['title']) ? $cta['title'] : '';
    }

    // -- 2) Source front-page si ACF vide --
    if ($title === '' && $text === '') {
      $front_id = (int) get_option('page_on_front');
      if ($front_id) {
        $title = get_the_title($front_id) ?: '';
        $raw   = get_post_field('post_excerpt', $front_id);
        if (!$raw) $raw = wp_strip_all_tags(apply_filters('the_content', get_post_field('post_content', $front_id)));
        $text = wp_trim_words(wp_strip_all_tags($raw), 40, '…');
        $cta_url   = get_permalink($front_id);
        $cta_title = $cta_title ?: __('En savoir plus', 'theme');
      }
    }

    // -- 3) Fallback final si tout est vide --
    if ($title === '' && $text === '') {
      $title = 'Giving Tuesday France';
      $text  = 'Mobilisons‑nous pour faire rayonner la générosité.';
      $cta_url   = home_url('/');
      $cta_title = $cta_title ?: __('Je participe', 'theme');
    }

    // -- Rendu HTML compact --
    ob_start(); ?>
    <div class="intro__inner container">
      <h2 class="intro__title"><?php echo esc_html($title); ?></h2>
      <?php if ($text !== ''): ?>
        <p class="intro__text"><?php echo esc_html($text); ?></p>
      <?php endif; ?>
      <?php if ($cta_url !== ''): ?>
        <p class="intro__actions">
          <a class="btn" href="<?php echo esc_url($cta_url); ?>">
            <?php echo esc_html($cta_title ?: __('Découvrir', 'theme')); ?>
          </a>
        </p>
      <?php endif; ?>
    </div>
    <?php
    $html = trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    set_transient($cache_key, $html, 120);

$resp = new WP_REST_Response($html, 200);
$resp->header('Content-Type', 'text/html; charset=utf-8');
return $resp;

  }
}

add_action('wp_enqueue_scripts', function () {
  // Adapte selon ton modèle exact (ex: page-thematique.php)
  if ( is_page_template('page-thematique.php') || is_page(array('la-sante','la-culture','la-planete')) ) {
    // Handles déjà enregistrés ? sinon registre-les avant.
    wp_enqueue_style('slick-css', get_stylesheet_directory_uri().'/assets/vendor/slick/slick.css', [], null);
    wp_enqueue_style('slick-theme', get_stylesheet_directory_uri().'/assets/vendor/slick/slick-theme.css', ['slick-css'], null);
    wp_enqueue_script('slick-js', get_stylesheet_directory_uri().'/assets/vendor/slick/slick.min.js', ['jquery'], null, true);

    // Ton init (voir 3) :
    wp_enqueue_script('gt-partners-init', get_stylesheet_directory_uri().'/assets/js/gt-partners-init.js', ['jquery','slick-js'], null, true);
  }
});

add_action('wp_enqueue_scripts', function () {
  // Charge Slick UNIQUEMENT sur les pages thématiques (adapte selon ton site)
  if ( is_page(array('la-sante','la-planete','la-culture')) || is_page_template('page-thematique.php') ) {
    wp_enqueue_script('jquery'); // jQuery WP, pas de CDN

    // Chemins à adapter à ton thème
    $base = get_stylesheet_directory_uri();
    wp_enqueue_style('slick', $base.'/assets/vendor/slick/slick.css', [], null);
    wp_enqueue_style('slick-theme', $base.'/assets/vendor/slick/slick-theme.css', ['slick'], null);
    wp_enqueue_script('slick', $base.'/assets/vendor/slick/slick.min.js', ['jquery'], null, true);

    // Petit init robuste
    $init = <<<JS
    (function($){
      function tryInit(){
        var \$list = $('.js-gt-partners');
        if (!\$list.length) return false;
        // On attend qu'il y ait au moins 2 logos (sinon slider inutile)
        if (\$list.find('img').length < 2) return false;
        // Déjà initialisé ?
        if (\$list.hasClass('slick-initialized')) return true;

        // Init slick
        \$list.slick({
          slidesToShow: 5,
          slidesToScroll: 1,
          arrows: true,
          dots: false,
          autoplay: true,
          autoplaySpeed: 3000,
          responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 4 } },
            { breakpoint: 992,  settings: { slidesToShow: 3 } },
            { breakpoint: 768,  settings: { slidesToShow: 2 } },
            { breakpoint: 480,  settings: { slidesToShow: 1 } }
          ]
        });
        return true;
      }

      // 1) au DOM ready
      $(function(){
        // boucle de retry ultra légère (max 20 essais sur 10s)
        var tries = 0, max = 20;
        (function tick(){
          if (tryInit() || ++tries >= max) return;
          setTimeout(tick, 500);
        })();
      });

      // 2) si ton contenu est injecté plus tard via Ajax, tu peux déclencher :
      // document.dispatchEvent(new CustomEvent('gt:partners:ready'));
      document.addEventListener('gt:partners:ready', function(){ tryInit(); });
    })(jQuery);
    JS;

    wp_add_inline_script('slick', $init, 'after');
  }
});

// functions.php
add_filter('the_content', function ($html) {
  if ( is_admin() || stripos($html, '<ul') === false ) return $html;

  // très simple : ajoute la classe sur UL qui ne l'a pas déjà
  // et qui contient au moins 3 <img> (vérif approximative par regex)
  $html = preg_replace_callback(
    '#<ul([^>]*)>(.*?)</ul>#is',
    function ($m) {
      $attrs = $m[1];
      $inner = $m[2];

      // déjà slické / déjà classé ?
      if (preg_match('#class=["\'][^"\']*js-gt-partners[^"\']*["\']#i', $attrs)) return $m[0];

      // au moins 3 <img> ?
      if (substr_count(strtolower($inner), '<img') < 3) return $m[0];

      // ajoute la classe
      if (preg_match('#class=["\']([^"\']*)["\']#i', $attrs, $c)) {
        $new = preg_replace('#class=["\']([^"\']*)["\']#i', 'class="$1 js-gt-partners"', $attrs);
      } else {
        $new = $attrs.' class="js-gt-partners"';
      }
      return '<ul'.$new.'>'.$inner.'</ul>';
    },
    $html
  );

  return $html;
}, 12);

// --- Detect & tag partner lists in post content ---
add_filter('the_content', function ($html) {
  if (is_admin() || empty($html)) return $html;

  // Quick path: skip if there is no <img> at all
  if (stripos($html, '<img') === false) return $html;

  $modified = false;

  // Add class js-gt-partners to any UL/OL that has >=3 <img>
  $html = preg_replace_callback('#<(ul|ol)(\s[^>]*)?>(.*?)</\1>#is', function ($m) use (&$modified) {
    $tag   = $m[1];
    $attrs = $m[2] ?? '';
    $inner = $m[3] ?? '';

    // Only treat lists that look like logo lists (>=3 images)
    if (substr_count(strtolower($inner), '<img') < 3) return $m[0];

    // Already has the class?
    if (preg_match('#class=["\'][^"\']*js-gt-partners[^"\']*["\']#i', $attrs)) {
      $modified = true;
      return $m[0];
    }

    // Inject class
    if (preg_match('#class=["\']([^"\']*)["\']#i', $attrs, $c)) {
      $newAttrs = preg_replace('#class=["\']([^"\']*)["\']#i', 'class="$1 js-gt-partners"', $attrs);
    } else {
      $newAttrs = ($attrs ?: '') . ' class="js-gt-partners"';
    }

    $modified = true;
    return "<{$tag}{$newAttrs}>{$inner}</{$tag}>";
  }, $html);

  if ($modified) {
    // Set a flag for this request to enqueue assets + init only when needed
    global $gt_partners_on_page;
    $gt_partners_on_page = true;
  }

  return $html;
}, 12);

// --- Conditional enqueue & init when partners are present ---
add_action('wp_enqueue_scripts', function () {
  global $gt_partners_on_page;
  if (empty($gt_partners_on_page)) return;

  wp_enqueue_script('jquery');

  $base = get_stylesheet_directory_uri();
  wp_enqueue_style('slick',       $base.'/assets/vendor/slick/slick.css', [], null);
  wp_enqueue_style('slick-theme', $base.'/assets/vendor/slick/slick-theme.css', ['slick'], null);
  wp_enqueue_script('slick',      $base.'/assets/vendor/slick/slick.min.js', ['jquery'], null, true);

  // Minimal CSS so the list looks fine even before init
  $css = "
  .js-gt-partners{display:flex;gap:16px;align-items:center;flex-wrap:wrap;list-style:none;padding:0;margin:1rem 0}
  .js-gt-partners li{list-style:none}
  .js-gt-partners img{max-height:60px;height:auto;width:auto;display:block}
  ";
  wp_add_inline_style('slick', $css);

  // Init with retry (up to 6s), guard double-init, and optional manual event
  $init = <<<JS
  (function($){
    function tryInit(){
      var $lists = $('.js-gt-partners').filter(function(){
        return !$(this).hasClass('slick-initialized') && $(this).find('img').length >= 2;
      });
      if (!$lists.length) return false;

      $lists.each(function(){
        var $el = $(this);
        if ($el.hasClass('slick-initialized')) return;
        $el.slick({
          slidesToShow:5, slidesToScroll:1, arrows:true, dots:false, autoplay:true, autoplaySpeed:3000,
          responsive:[
            {breakpoint:1200,settings:{slidesToShow:4}},
            {breakpoint:992, settings:{slidesToShow:3}},
            {breakpoint:768, settings:{slidesToShow:2}},
            {breakpoint:480, settings:{slidesToShow:1}}
          ]
        });
      });
      return true;
    }

    $(function(){
      var tries = 0, max = 12; // 12 * 500ms = 6s
      (function tick(){ if (tryInit() || ++tries >= max) return; setTimeout(tick, 500); })();
    });

    // If you inject content via JS, you can trigger:
    // document.dispatchEvent(new CustomEvent('gt:partners:ready'));
    document.addEventListener('gt:partners:ready', function(){ tryInit(); });
  })(jQuery);
  JS;

  wp_add_inline_script('slick', $init, 'after');
});



// ===== [GT] REST: intro-test, fragment/intro, routes dump =====

/**
 * Rend un fragment HTML et le retourne en text/html
 */
if (!function_exists('gt_rest_render_fragment')) {
  function gt_rest_render_fragment($rel_path) {
    $child  = trailingslashit(get_stylesheet_directory()) . ltrim($rel_path, '/');
    $parent = trailingslashit(get_template_directory())   . ltrim($rel_path, '/');
    $path   = file_exists($child) ? $child : (file_exists($parent) ? $parent : '');

    if (!$path) {
      $res = new WP_REST_Response('<!-- GT: fragment not found -->', 404);
      $res->header('Content-Type','text/html; charset=utf-8');
      return $res;
    }

    // Empêche les warnings PHP de polluer l’HTML
    ob_start();
    $prev = ini_get('display_errors');
    @ini_set('display_errors','0');

    include $path; // <<< le fragment imprime du HTML pur

    $html = trim(ob_get_clean());
    @ini_set('display_errors',$prev);

    if ($html === '') { $html = '<!-- GT: empty -->'; }

    // Sécurité: un fragment ne doit pas renvoyer un document complet
    if (stripos($html,'<body') !== false || stripos($html,'</html>') !== false) {
      $res = new WP_REST_Response('<!-- GT: invalid full document -->', 500);
      $res->header('Content-Type','text/html; charset=utf-8');
      return $res;
    }

    $res = new WP_REST_Response($html, 200);
    $res->header('Content-Type','text/html; charset=utf-8');
    $res->header('Cache-Control','no-store, no-cache, must-revalidate, max-age=0');
    $res->header('Pragma','no-cache');
    $res->header('Expires','0');
    $res->header('X-GT-Path',$path);
    return $res;
  }
}

add_action('rest_api_init', function () {

  // 0) Ping simple HTML
  register_rest_route('gt/v1','/intro-test', [
    'methods'=>'GET','permission_callback'=>'__return_true',
    'callback'=>function(){
      return new WP_REST_Response('<div>INTRO TEST 42 ✅</div>',200,[
        'Content-Type'=>'text/html; charset=utf-8'
      ]);
    }
  ]);

  // 1) Fragment INTRO
  register_rest_route('gt/v1','/fragment/intro', [
    'methods'=>'GET','permission_callback'=>'__return_true',
    'callback'=>function(WP_REST_Request $r){
      // Optionnel : compteur dispo dans le template via $GLOBALS
      $GLOBALS['gt_fragment_count'] = intval($r->get_param('count') ?: 0);
      return gt_rest_render_fragment('template-parts/home/intro.php');
    }
  ]);

  // 2) Fragment ACTUS
  register_rest_route('gt/v1','/fragment/actus', [
    'methods'=>'GET','permission_callback'=>'__return_true',
    'callback'=>function(WP_REST_Request $r){
      $GLOBALS['gt_actus_count'] = max(1, intval($r->get_param('count') ?: 3));
      return gt_rest_render_fragment('template-parts/home/actus.php');
    }
  ]);

  // 3) Dump routes GT (debug)
  register_rest_route('gt/v1','/routes', [
    'methods'=>'GET','permission_callback'=>'__return_true',
    'callback'=>function(){
      $srv = rest_get_server(); $out=[];
      foreach($srv->get_routes() as $route=>$handlers){
        if(strpos($route,'/gt/v1/')===0){ $out[$route] = array_keys((array)$handlers); }
      }
      return rest_ensure_response($out);
    }
  ]);
});

/**
 * Ultime filet: si un plugin ré‑encode en JSON, on force le service en text/html
 */
add_filter('rest_pre_serve_request', function($served,$result,$request,$server){
  $route = $request->get_route();
  if (strpos($route,'/gt/v1/fragment/') === 0) {
    $html = ($result instanceof WP_REST_Response) ? $result->get_data() : (string)$result;
    header('Content-Type: text/html; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache'); header('Expires: 0');
    echo is_string($html) ? $html : '';
    return true; // court-circuite la sérialisation JSON
  }
  return $served;
}, 10, 4);

// ===== [GT] Enqueue du JS fragments (jQuery avant) =====
add_action('wp_enqueue_scripts', function(){
  $uri  = get_stylesheet_directory_uri();
  $path = get_stylesheet_directory().'/assets/js/gt-fragments.js';
  if (file_exists($path)) {
    wp_enqueue_script('gt-fragments', $uri.'/assets/js/gt-fragments.js', ['jquery'], filemtime($path), true);
  }
}, 20);

add_action('wp_enqueue_scripts', function () {
  $uri  = get_stylesheet_directory_uri();

  // 1) Slick CSS + JS (avant gt-fragments)
  wp_enqueue_style('slick', $uri.'/assets/slick/slick.css', [], '1.8.1');
  wp_enqueue_style('slick-theme', $uri.'/assets/slick/slick-theme.css', ['slick'], '1.8.1');
  wp_enqueue_script('slick', $uri.'/assets/slick/slick.min.js', ['jquery'], '1.8.1', true);

  // 2) JS fragments (dépend de jQuery, et arrive APRÈS slick)
  $path = get_stylesheet_directory().'/assets/js/gt-fragments.js';
  if (file_exists($path)) {
    wp_enqueue_script('gt-fragments', $uri.'/assets/js/gt-fragments.js', ['jquery','slick'], filemtime($path), true);
  }
}, 20);

add_action('wp_enqueue_scripts', function () {
  // Slick depuis jsDelivr
  wp_enqueue_style('slick',  'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
  wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', ['slick'], '1.8.1');
  wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);

  // ton fichier
  $uri  = get_stylesheet_directory_uri();
  $path = get_stylesheet_directory().'/assets/js/gt-fragments.js';
  if (file_exists($path)) {
    wp_enqueue_script('gt-fragments', $uri.'/assets/js/gt-fragments.js', ['jquery','slick'], filemtime($path), true);
  }
}, 20);
add_action('wp_enqueue_scripts', function () {
  // Slick (CSS + JS)
  wp_enqueue_style('slick',       'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
  wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', ['slick'], '1.8.1');
  wp_enqueue_script('slick',      'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);

  // Ton JS fragments, dépend de slick
  $uri  = get_stylesheet_directory_uri();
  $path = get_stylesheet_directory().'/assets/js/gt-fragments.js';
  if (file_exists($path)) {
    wp_enqueue_script('gt-fragments', $uri.'/assets/js/gt-fragments.js', ['jquery','slick'], filemtime($path), true);
  }
}, 20);

add_action('wp_enqueue_scripts', function () {
  // Slick (CDN propre)
  wp_enqueue_style('slick',       'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
  wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', ['slick'], '1.8.1');
  wp_enqueue_script('slick',      'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);

  // Ton JS (après slick)
  $uri  = get_stylesheet_directory_uri();
  $path = get_stylesheet_directory().'/assets/js/gt-fragments.js';
  if (file_exists($path)) {
    wp_enqueue_script('gt-fragments', $uri.'/assets/js/gt-fragments.js', ['jquery','slick'], filemtime($path), true);
  }
}, 20);
// Injecte un CSS "anti-superposition" *après* tout le reste
add_action('wp_head', function () {
  ?>
  <style id="gt-slick-nuke" type="text/css">
    /* force slick à n'afficher qu'1 slide */
    .block__frontpage--actus__slider .slick-slide{display:none!important;visibility:hidden!important;opacity:0!important;float:left!important;width:100%!important;min-height:1px!important;position:relative!important}
    .block__frontpage--actus__slider .slick-slide.slick-active{display:block!important;visibility:visible!important;opacity:1!important}

    /* empêche le thème de casser le layout en desktop (flex/grid/height) */
    .block__frontpage--actus__slider__inner{display:block!important}
    .block__frontpage--actus__slider,
    .block__frontpage--actus__slider .slick-list,
    .block__frontpage--actus__slider .slick-track{height:auto!important}
    .block__frontpage--actus__slider .slick-track:before,
    .block__frontpage--actus__slider .slick-track:after{content:""!important;display:table!important}
    .block__frontpage--actus__slider .slick-track:after{clear:both!important}

    /* images propres */
    .block__frontpage--actus__slider .slide-block__img img{display:block!important;max-width:100%!important;height:auto!important}
  </style>
  <?php
}, 999);

add_action('wp_enqueue_scripts', function(){
  // Slick CSS/JS (CDN) — OK pour dev
  wp_enqueue_style('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
  wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', ['slick'], '1.8.1');
  wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);

  // Ton JS des fragments (si présent)
  $path = get_stylesheet_directory().'/assets/js/gt-fragments.js';
  if (file_exists($path)) {
    wp_enqueue_script('gt-fragments', get_stylesheet_directory_uri().'/assets/js/gt-fragments.js', ['jquery','slick'], filemtime($path), true);
  }
}, 20);

add_action('wp_enqueue_scripts', function(){
  $p = get_stylesheet_directory().'/assets/js/gt-counter.js';
  if (file_exists($p)) {
    wp_enqueue_script('gt-counter', get_stylesheet_directory_uri().'/assets/js/gt-counter.js', [], filemtime($p), true);
  }
}, 20);


// functions.php (ou un mu-plugin)
add_filter('wp_image_editors', function() {
  return ['WP_Image_Editor_GD', 'WP_Image_Editor_Imagick'];
});

