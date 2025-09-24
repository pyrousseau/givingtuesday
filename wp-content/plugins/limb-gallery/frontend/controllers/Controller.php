<?php
/**
 * LIMB gallery
 * Frontend
 * Controller
 */

class GRSController extends LIMB_Gallery {

	/**
	 * @var $atts
	 */
	private $atts;

	/**
	 * GRSController constructor.
	 *
	 * @param $atts
	 */
	public function __construct( $atts ) {
		$this->atts = $atts;
	}

	// method declaration
	public function main() {
		global $wpdb;
		try {
			if ( empty( $this->atts['widget'] ) ) {
				$params = $wpdb->get_var( $wpdb->prepare( "SELECT `params` FROM `" . $wpdb->prefix . "limb_gallery_shortcodes` WHERE `id`=%d", $this->atts['id'] ) );
			} else {
				unset( $this->atts['widget'] );
				$params = json_encode( $this->atts );
			}
			if ( $params && preg_match( '/"view":"([[:alnum:]]+)"/', $params, $matches ) && ! empty( $matches ) ) {
				$view = $matches[1];
				include_once GRS_PLG_DIR . '/frontend/models/Model.php';
				if ( file_exists( GRS_PLG_DIR . '/frontend/views/View' . $view . '.php' ) ) {
					include_once GRS_PLG_DIR . '/frontend/views/View' . $view . '.php';
					$model     = new GRSModel( $params );
					$viewClass = 'GRSView' . $view;
					$view      = new $viewClass( $model );
					$view->display( parent::$grsCounter );
				} else {
					?>
                    <p> <?php echo __( 'There is no layout chosen', 'limb-gallery' ); ?> </p>
					<?php
				}
			} else {
				?>
                <p> <?php echo __( 'There is no gallery matching your id or it was deleted', 'limb-gallery' ); ?> </p>
				<?php
			}
		}
		catch ( \Exception $e ) {
			?>
            <p> <?php echo __( 'Unable to get galleries data', 'limb-gallery' ); ?> </p>
			<?php
		}
	}

}