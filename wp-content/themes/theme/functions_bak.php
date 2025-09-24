<?php
/*
 *  Author: Eugene Nikulin based on Todd Motto
 *  URL: http://nikulin.com.ua
 */
/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/
function add_export_posts_button(){

    if (isset($_GET['post_type']) && $_GET['post_type'] == 'action-a-decouvrir') {
        echo '<a href="/wp-content/themes/theme/export-action.php" target="_blank" class="export button" style="display: inline-block;float:right;">Exporter Actions</a>';
    }
}
add_action( 'restrict_manage_posts', 'add_export_posts_button', 0 );


function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['zip'] = 'application/zip';
    $mimes['gz'] = 'application/x-gzip';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page('Paramètres d\'accueil');
    acf_add_options_page('Paramètres généraux');
}

add_action('init', 'remove_content_editor');

function remove_content_editor() {
    remove_post_type_support( 'page', 'editor' );
}

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page('Paramètres d\'accueil');
    acf_add_options_page('Paramètres généraux');
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
    load_theme_textdomain('theme', get_template_directory() . '/languages');
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
        ob_start();
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
        }
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

?>