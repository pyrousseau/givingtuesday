<?php

/**
 * Plugin Name: Limb Gallery
 * Plugin URI: http://limbcode.com
 * Description: Limb Gallery is an advanced solution to build gallery with multiple views, create awesome albums, embed social media, view photos and videos via stunning lightboxes and share them to social networks.
 * Version: 1.5.7
 * Author: Limb
 * Author URI: http://limbcode.com
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: limb-gallery
 * Domain Path: /languages
 *
 */

if ( !function_exists( 'lg_fs' ) ) {
    // Create a helper function for easy SDK access.
    function lg_fs()
    {
        global  $lg_fs ;
        
        if ( !isset( $lg_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/vendor/freemius/start.php';
            $lg_fs = fs_dynamic_init( array(
                'id'             => '8924',
                'slug'           => 'limb-gallery',
                'premium_slug'   => 'limb-gallery-paid',
                'type'           => 'plugin',
                'public_key'     => 'pk_4cb0cf8cbd5010d4b74aaeb4b86cb',
                'is_premium'     => false,
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                'slug' => 'galleries_grs',
            ),
                'is_live'        => true,
            ) );
        }
        
        return $lg_fs;
    }
    
    // Init Freemius.
    lg_fs();
    // Signal that SDK was initiated.
    do_action( 'lg_fs_loaded' );
    
    if ( lg_fs() ) {
        class LIMB_Gallery
        {
            // vars
            private  $grsAjaxNonce = '' ;
            // static vars
            public static  $pluginBaseName ;
            public static  $pluginDir ;
            public static  $wpUploadDir ;
            public static  $grsUplDirName = 'limb-gallery' ;
            public static  $aCsOptName = 'LIMB_gallery_act_status' ;
            public static  $vOptName = 'LIMB_gallery_version' ;
            public static  $currentVersion = '1.5.7' ;
            public static  $grsMainFile ;
            public static  $uploadDir ;
            public static  $uploadUrl ;
            public static  $version ;
            public static  $config ;
            public static  $grsCounter ;
            public  $current_plan ;
            /**
             * @var Freemius
             */
            public  $lg_fs ;
            public function __construct()
            {
                global  $lg_fs ;
                $this->registerHooks();
                $this->defineVars();
                $this->createGrsFolder();
                $this->fastUpdateCheck();
                $this->templatesCheck();
                $this->lg_fs = $lg_fs;
                
                if ( $this->lg_fs->is_free_plan() ) {
                    $this->current_plan = 'free';
                } elseif ( $this->lg_fs->is_plan__premium_only( 'personal', true ) ) {
                    $this->current_plan = 'personal';
                } elseif ( $this->lg_fs->is_plan__premium_only( 'pro', true ) ) {
                    $this->current_plan = 'pro';
                } elseif ( $this->lg_fs->is_plan__premium_only( 'elite', true ) ) {
                    $this->current_plan = 'elite';
                } else {
                    $this->current_plan = '';
                }
            
            }
            
            public function defineVars()
            {
                self::$pluginBaseName = plugin_basename( __FILE__ );
                self::$pluginDir = plugin_dir_path( __FILE__ );
                self::$wpUploadDir = wp_upload_dir();
                //TODO enable ssl for gallery
                define( 'GRS_PLG_DIR', WP_PLUGIN_DIR . "/" . plugin_basename( dirname( __FILE__ ) ) );
                // Plugin folder url
                define( 'GRS_PLG_URL', plugins_url( plugin_basename( dirname( __FILE__ ) ) ) );
                self::$grsCounter = 0;
                self::$grsMainFile = __FILE__;
                self::$version = get_option( self::$vOptName, false );
                // Set config var
                $config = GRS_PLG_DIR . '/js/grsConfig.json';
                $handle = fopen( $config, "r" );
                $content = fread( $handle, filesize( $config ) );
                fclose( $handle );
                self::$config = json_decode( $content );
            }
            
            public function createGrsFolder()
            {
                $dirname = self::$wpUploadDir['basedir'] . '/' . self::$grsUplDirName;
                $dirurl = self::$wpUploadDir['baseurl'] . '/' . self::$grsUplDirName;
                // Check if SSL is enabled, then update directory url variable
                if ( is_ssl() ) {
                    $dirurl = set_url_scheme( $dirurl, 'https' );
                }
                
                if ( !is_dir( $dirname ) ) {
                    $ok = wp_mkdir_p( $dirname );
                } else {
                    $ok = true;
                }
                
                self::$uploadDir = $dirname . '/';
                self::$uploadUrl = $dirurl . '/';
                return $ok;
                // If not ok alert it
            }
            
            /**
             * Runtime update check
             */
            public function fastUpdateCheck()
            {
                require_once GRS_PLG_DIR . '/smart/GRSGallerySmart.php';
                new GRSGallerySmart( 'fastUpdateCheck' );
            }
            
            /**
             * Check if accidentally we are not missing working templates
             */
            public function templatesCheck()
            {
                require_once GRS_PLG_DIR . '/smart/GRSGallerySmart.php';
                new GRSGallerySmart( 'templatesCheck' );
            }
            
            public function registerHooks()
            {
                // For admin menu
                add_action( 'admin_menu', array( &$this, 'grs_menu' ) );
                // For ajax calls
                add_action( 'wp_ajax_grsGalleryAjax', array( &$this, 'grsGalleryAjax' ) );
                add_action( 'wp_ajax_nopriv_grsGalleryAjax', array( &$this, 'grsGalleryAjax' ) );
                // For shortcode
                add_shortcode( 'GRS', array( &$this, 'grsShortcode' ) );
                // Load the TinyMCE plugin : editor_plugin.js
                add_filter( 'mce_external_plugins', array( &$this, 'register_tinymce_javascript' ) );
                // GRS mce button
                add_filter( 'mce_buttons', array( &$this, 'register_buttons' ) );
                // Frontend scripts
                add_action( 'wp_enqueue_scripts', array( &$this, 'grsFrontendScripts' ) );
                // For admin head
                add_action( 'admin_head', array( &$this, 'grs_admin_head' ) );
                // Media button hook
                add_action( 'media_buttons', array( &$this, 'grs_media_button' ) );
                // Register widget
                add_action( 'widgets_init', array( &$this, 'grs_register_widgets' ) );
                // translations
                add_action( 'init', array( &$this, 'grsLanguageLoad' ) );
                // Block
                add_action( 'init', array( &$this, 'load_block' ) );
            }
            
            public function grsLanguageLoad()
            {
                load_plugin_textdomain( 'limb-gallery', false, basename( dirname( __FILE__ ) ) . '/languages' );
            }
            
            public function grs_register_widgets()
            {
                require_once GRS_PLG_DIR . '/admin/controllers/LimbGalleryThumbnailWidgetController.php';
                register_widget( 'LimbGalleryThumbnailWidgetController' );
            }
            
            public function grs_media_button()
            {
                $this->setGrsNonce();
                $img = GRS_PLG_URL . '/images/logo/limb-02.png';
                $href = add_query_arg( array(
                    'action'       => 'grsGalleryAjax',
                    'grsAction'    => 'shortcode',
                    'grsAjaxNonce' => $this->grsAjaxNonce,
                    'TB_iframe'    => '1',
                    'height'       => '500',
                ), admin_url( 'admin-ajax.php' ) );
                echo  '<a href="' . $href . '" onclick="if(!tinyMCE.execCommand(\'grsMce\'))tb_click.call(this);return false;" id="grs-media-insert" class="button"><span class="wp-media-buttons-icon" style="background: url(' . $img . ') no-repeat 0 -1px;padding: 0 2px;"></span>Add Limb gallery</a>' ;
            }
            
            public static function grsActivate()
            {
                require_once GRS_PLG_DIR . '/smart/GRSGallerySmart.php';
                new GRSGallerySmart( 'activate' );
            }
            
            // Plugin menu.
            public function grs_menu()
            {
                add_menu_page(
                    'Limb Gallery',
                    'Limb Gallery',
                    'manage_options',
                    'galleries_grs',
                    array( &$this, 'grs_gallery' ),
                    GRS_PLG_URL . '/images/logo/limb-07.png'
                );
                $galleries_page = add_submenu_page(
                    'galleries_grs',
                    'Galleries',
                    'Galleries',
                    'manage_options',
                    'galleries_grs',
                    array( &$this, 'grs_gallery' )
                );
                add_action( 'admin_print_styles-' . $galleries_page, array( &$this, 'grs_styles' ) );
                add_action( 'admin_print_scripts-' . $galleries_page, array( &$this, 'grs_scripts' ) );
            }
            
            public function grs_gallery()
            {
                $file = GRS_PLG_DIR . '/admin/controllers/Controller.php';
                
                if ( file_exists( $file ) ) {
                    require_once $file;
                    $object = new GRSAdminController( $this->lg_fs );
                    $object->display( 'galleries' );
                }
            
            }
            
            public function grs_styles()
            {
                wp_enqueue_style(
                    'bootstrap-colorpicker',
                    GRS_PLG_URL . '/js/colorpicker/css/bootstrap-colorpicker.css',
                    array(),
                    self::$version
                );
                wp_enqueue_style(
                    'jquery-ui-1.10.3.custom.css',
                    GRS_PLG_URL . '/css/jquery-ui-1.10.3.custom.css',
                    array(),
                    self::$version
                );
                wp_enqueue_style(
                    'grsAdmin.css',
                    GRS_PLG_URL . '/css/grsAdmin.css',
                    array(),
                    self::$version
                );
                wp_enqueue_style( 'thickbox' );
                wp_enqueue_style(
                    'grsFontAwesome.css',
                    'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
                    array(),
                    self::$version
                );
            }
            
            public function grs_scripts()
            {
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script( 'jquery-ui-core' );
                wp_enqueue_script( 'jquery-ui-position' );
                wp_enqueue_script( 'jquery-ui-draggable' );
                wp_enqueue_script( 'jquery-ui-sortable' );
                wp_enqueue_script( 'jquery-ui-tooltip' );
                wp_enqueue_script(
                    'bootstrap-colorpicker',
                    GRS_PLG_URL . '/js/colorpicker/js/bootstrap-colorpicker.js',
                    array(),
                    self::$version
                );
                wp_enqueue_script(
                    'angular.min.js',
                    GRS_PLG_URL . '/js/angular.min.js',
                    array(),
                    self::$version
                );
                wp_enqueue_script(
                    'jquery.iframe-transport.js',
                    GRS_PLG_URL . '/js/jquery.iframe-transport.js',
                    array(),
                    self::$version
                );
                wp_enqueue_script(
                    'jquery.fileupload.js',
                    GRS_PLG_URL . '/js/jquery.fileupload.js',
                    array(),
                    self::$version,
                    true
                );
                wp_enqueue_script(
                    'jquery.knob.js',
                    GRS_PLG_URL . '/js/jquery.knob.js',
                    array(),
                    self::$version
                );
                wp_enqueue_media();
                $translations = (include_once GRS_PLG_DIR . '/js/localizations/admin.php');
                
                if ( file_exists( GRS_PLG_DIR . '/js/grsAdmin.js' ) ) {
                    $handler = 'grsAdmin';
                    wp_enqueue_script(
                        'grsAdmin',
                        GRS_PLG_URL . '/js/grsAdmin.js',
                        array(),
                        self::$version
                    );
                    wp_localize_script( 'grsAdmin', 'adminTransObj', $translations );
                } elseif ( file_exists( GRS_PLG_DIR . '/js/grsAdmin.min.js' ) ) {
                    $handler = 'grsAdmin.min';
                    wp_enqueue_script(
                        'grsAdmin.min',
                        GRS_PLG_URL . '/js/grsAdmin.min.js',
                        array(),
                        self::$version
                    );
                    wp_localize_script( 'grsAdmin.min', 'adminTransObj', $translations );
                }
                
                $this->setGrsNonce();
                // Check if the website is SSL
                
                if ( is_ssl() ) {
                    $wpUrl = str_replace( 'http://', 'https://', self::$wpUploadDir['baseurl'] );
                } else {
                    $wpUrl = self::$wpUploadDir['baseurl'];
                }
                
                if ( !empty($handler) ) {
                    wp_localize_script( $handler, 'scriptData', array(
                        'grsPlanName'      => $this->current_plan,
                        'grsIsPremium'     => $this->lg_fs->can_use_premium_code__premium_only(),
                        'grsUpgradeUrl'    => $this->lg_fs->get_upgrade_url(),
                        'grsWpUploaderUrl' => $wpUrl . '/',
                        'grsUploaderUrl'   => self::$uploadUrl,
                        'grsPluginUrl'     => GRS_PLG_URL,
                        'grsPluginVer'     => self::$version,
                        'grsAjaxNonce'     => $this->grsAjaxNonce,
                    ) );
                }
            }
            
            public function grs_admin_head()
            {
                $this->setGrsNonce();
                $shortCodeUrl = add_query_arg( array(
                    'action'       => 'grsGalleryAjax',
                    'grsAction'    => 'shortcode',
                    'grsAjaxNonce' => $this->grsAjaxNonce,
                ), admin_url( 'admin-ajax.php' ) );
                ?>
                <script>
                    var grsAdminAjax = '<?php 
                echo  admin_url( 'admin-ajax.php' ) ;
                ?>';
                    var grsAdminShortCode = '<?php 
                echo  $shortCodeUrl ;
                ?>';
                    var grsBlockIcon = '<?php 
                echo  GRS_PLG_URL . '/images/logo/limb-block.png' ;
                ?>';
                    var grsBlockMiniIcon = '<?php 
                echo  GRS_PLG_URL . '/images/logo/limb-block-mini.png' ;
                ?>';
                </script>
				<?php 
            }
            
            public function grsGalleryAjax()
            {
                require_once GRS_PLG_DIR . '/ajax/GRSGalleryAjax.php';
                // Check nonce
                $object = new GRSGalleryAjax( $this->lg_fs );
                $object->grsCheckAction();
            }
            
            public function grsShortcode( $atts )
            {
                require_once GRS_PLG_DIR . '/admin/controllers/Controller.php';
                $shortcode = new GRSAdminController( $this->lg_fs );
                $atts = $shortcode->filter( $atts );
                ob_start();
                $this->grsFrontend( $atts );
                return str_replace( array( "\r\n", "\n", "\r" ), '', ob_get_clean() );
            }
            
            public function register_buttons( $buttons )
            {
                array_push( $buttons, 'grsMce' );
                return $buttons;
            }
            
            public function register_tinymce_javascript( $plugin_array )
            {
                $plugin_array['grs'] = plugins_url( '/js/grsMce/tinymce-plugin.js?ver=' . self::$version, __FILE__ );
                return $plugin_array;
            }
            
            public function setGrsNonce()
            {
                $this->grsAjaxNonce = wp_create_nonce( "grs-ajax-nonce" );
            }
            
            public function load_block()
            {
                // Skip block registration if Gutenberg is not enabled/merged.
                if ( !function_exists( 'register_block_type' ) ) {
                    return;
                }
                $dir = GRS_PLG_URL . '/js/block/';
                $index_js = 'block.js';
                wp_register_script(
                    'grs-gallery-block',
                    "{$dir}/{$index_js}",
                    array(
                    'wp-blocks',
                    //                'wp-i18n',
                    'wp-element',
                ),
                    self::$version,
                    true
                );
                wp_register_style(
                    'grs-gallery-block',
                    GRS_PLG_URL . '/css/grsBlock.css',
                    array(),
                    self::$version
                );
                require_once GRS_PLG_DIR . '/admin/controllers/Controller.php';
                register_block_type( 'grs-block/grs-gallery', array(
                    'title'           => 'Limb Gallery',
                    'icon'            => GRS_PLG_URL . '/images/logo/limb-block-mini.png',
                    'style'           => 'grs-gallery-block',
                    'editor_script'   => 'grs-gallery-block',
                    'render_callback' => array( &$this, 'renderBlock' ),
                    'attributes'      => array(
                    'id'        => [
                    'type'    => 'number',
                    'default' => 0,
                ],
                    'timestamp' => [
                    'type'    => 'number',
                    'default' => 0,
                ],
                ),
                ) );
            }
            
            public function renderBlock( $atts )
            {
                ob_start();
                $this->grsFrontend( $atts );
                return str_replace( array( "\r\n", "\n", "\r" ), '', ob_get_clean() );
            }
            
            // GRS frontend scripts
            public function grsFrontendScripts()
            {
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script(
                    'angular.min.js',
                    GRS_PLG_URL . '/js/angular.min.js',
                    array(),
                    self::$version
                );
                wp_enqueue_script(
                    'hammer.min.js',
                    GRS_PLG_URL . '/js/hammer.min.js',
                    array(),
                    self::$version
                );
                wp_enqueue_style(
                    'grsFontAwesome.css',
                    'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
                    array(),
                    self::$version
                );
                wp_enqueue_style(
                    'grsFrontend.css',
                    GRS_PLG_URL . '/css/grsFrontend.css',
                    array(),
                    self::$version
                );
                $translations = (include_once GRS_PLG_DIR . '/js/localizations/frontend.php');
                
                if ( file_exists( GRS_PLG_DIR . '/js/grsFrontend.js' ) ) {
                    $handler = 'grsFrontend';
                    wp_enqueue_script(
                        'grsFrontend',
                        GRS_PLG_URL . '/js/grsFrontend.js',
                        array(),
                        self::$version
                    );
                    wp_localize_script( 'grsFrontend', 'frontTransObj', $translations );
                } elseif ( file_exists( GRS_PLG_DIR . '/js/grsFrontend.min.js' ) ) {
                    $handler = 'grsFrontend.min';
                    wp_enqueue_script(
                        'grsFrontend.min',
                        GRS_PLG_URL . '/js/grsFrontend.min.js',
                        array(),
                        self::$version
                    );
                    wp_localize_script( 'grsFrontend.min', 'frontTransObj', $translations );
                }
                
                // Check if the website is SSL
                
                if ( is_ssl() ) {
                    $wpUrl = str_replace( 'http://', 'https://', self::$wpUploadDir['baseurl'] );
                } else {
                    $wpUrl = self::$wpUploadDir['baseurl'];
                }
                
                if ( !empty($handler) ) {
                    wp_localize_script( $handler, 'scriptData', array(
                        'grsPlanName'      => $this->current_plan,
                        'grsIsPremium'     => $this->lg_fs->can_use_premium_code__premium_only(),
                        'grsWpUploaderUrl' => $wpUrl . '/',
                        'grsPluginUrl'     => GRS_PLG_URL,
                        'grsShareUrl'      => add_query_arg( array(
                        "action"    => "grsGalleryAjax",
                        "grsAction" => "share",
                    ), admin_url( "admin-ajax.php" ) ),
                        'grsAjaxUrl'       => admin_url( 'admin-ajax.php' ),
                        'grsUploaderUrl'   => self::$uploadUrl,
                        'grsPluginVer'     => self::$version,
                    ) );
                }
            }
            
            public function grsFrontend( $atts )
            {
                include_once GRS_PLG_DIR . '/frontend/controllers/Controller.php';
                $object = new GRSController( $atts );
                $object->main();
                self::$grsCounter++;
            }
        
        }
        $limb = new LIMB_Gallery();
    }

}

// Activation hook
register_activation_hook( __FILE__, array( 'LIMB_Gallery', 'grsActivate' ) );
// Deactivation hook