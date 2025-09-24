<?php
/**
 * LIMB gallery
 * Thumbnail Widget
 */

class LimbGalleryThumbnailWidgetController extends WP_Widget {

	function __construct() {
		// Instantiate the parent object
		parent::__construct( 'limb_gallery_thumbnail_widget', 'Limb Gallery Thumbnail Widget' );
	}

	function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );

		$atts = array(
			'id'                => (string) ( isset( $instance['gallery'] ) ? $instance['gallery'] : 0 ),
			'view'              => 'Thumbnail',
			'theme'             => (string) ( isset( $instance['theme'] ) ? $instance['theme'] : 2 ),
			'width'             => (string) ( isset( $instance['width'] ) ? $instance['width'] : 100 ),
			'height'            => (string) ( isset( $instance['height'] ) ? $instance['height'] : 75 ),
			'contwidth'         => "100",
			'imagesperpage'     => (string) ( isset( $instance['count'] ) ? $instance['count'] : 5 ),
			'pagination'        => 'none',
			'title'             => 'no',
			'orderby'           => (string) ( isset( $instance['order_by'] ) ? $instance['order_by'] : 'order' ),
			'ordering'          => (string) ( isset( $instance['ordering'] ) ? $instance['ordering'] : 'DESC' ),
			'polaroid'          => "0",
			'clickaction'       => 'openLightbox',
			'openlinktarget'    => '_self',
			'lightboxwidth'     => "1000",
			'lightboxheight'    => "800",
			'lightboxfilmstrip' => "0",
			'lightboxcontbutts' => "1",
			'lightboxfbutt'     => "0",
			'lightboxgbutt'     => "0",
			'lightboxtbutt'     => "0",
			'lightboxpbutt'     => "0",
			'lightboxtbbutt'    => "0",
			'lightboxlibutt'    => "0",
			'lightboxreddbutt'  => "0",
			'lightboxfsbutt'    => "1",
			'lightboxap'        => "1",
			'lightboxapin'      => "3",
			'lightboximinf'     => "1",
			'lightboxcomment'   => "0",
			'lightboxswipe'     => "1",
			'lightboximcn'      => "1",
			'lightboxfullw'     => "0",
			'lightboxeffect'    => 'fade',
			'widget'            => 1
		);

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		include_once GRS_PLG_DIR . '/frontend/controllers/Controller.php';
		$object = new GRSController( $atts );
		$object->main();
		LIMB_Gallery::$grsCounter ++;

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance             = array();
		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['gallery']  = ( ! empty( $new_instance['gallery'] ) ) ? (int) strip_tags( $new_instance['gallery'] ) : '';
		$instance['theme']    = ( ! empty( $new_instance['theme'] ) ) ? (int) strip_tags( $new_instance['theme'] ) : 0;
		$instance['width']    = ( ! empty( $new_instance['width'] ) ) ? (int) strip_tags( $new_instance['width'] ) : 100;
		$instance['height']   = ( ! empty( $new_instance['height'] ) ) ? (int) strip_tags( $new_instance['height'] ) : 100;
		$instance['order_by'] = ( ! empty( $new_instance['order_by'] ) ) ? strip_tags( $new_instance['order_by'] ) : 'order';
		$instance['ordering'] = ( ! empty( $new_instance['ordering'] ) ) ? strip_tags( $new_instance['ordering'] ) : 'DESC';
		$instance['count']    = ( ! empty( $new_instance['count'] ) ) ? (int) strip_tags( $new_instance['count'] ) : 5;

		return $instance;
	}

	function form( $instance ) {
		global $lg_fs;
		require_once( GRS_PLG_DIR . '/admin/models/Model.php' );
		$model            = new GRSAdminModel( LIMB_Gallery::$version, $lg_fs );
		$title            = @ $instance['title'] ?: 'Gallery';
		$orderBy          = @ $instance['order_by'] ?: 'order';
		$ordering         = @ $instance['ordering'] ?: 'DESC';
		$count            = @ $instance['count'] ?: 5;
		$thumbnail_width  = @ $instance['width'] ?: 100;
		$thumbnail_height = @ $instance['height'] ?: 75;
		$gallery          = @ $instance['gallery'] ?: 0;
		$theme            = @ $instance['theme'] ?: 0;
		$themes           = $model->getGrsThemes();
		$galleries        = $model->getGrsGalleries();
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'limb-gallery' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'gallery' ); ?>"><?php _e( 'Select gallery:', 'limb-gallery' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'gallery' ); ?>"
                    name="<?php echo $this->get_field_name( 'gallery' ); ?>">
				<?php
				foreach ( $galleries as $key => $item ) {
					?>
                    <option <?php echo $item->id == $gallery ? 'selected' : ''; ?>
                            value="<?php echo $item->id; ?>"><?php echo $item->title; ?></option>
					<?php
				}
				?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'theme' ); ?>"><?php _e( 'Select theme:', 'limb-gallery' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'theme' ); ?>"
                    name="<?php echo $this->get_field_name( 'theme' ); ?>">
				<?php
				foreach ( $themes as $key => $item ) {
					?>
                    <option <?php echo $item->id == $theme ? 'selected' : ''; ?>
                            value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
					<?php
				}
				?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Count' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>"
                   name="<?php echo $this->get_field_name( 'count' ); ?>" type="number"
                   value="<?php echo esc_attr( $count ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Thumbnail width:', 'limb-gallery' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>"
                   name="<?php echo $this->get_field_name( 'width' ); ?>" type="number"
                   value="<?php echo esc_attr( $thumbnail_width ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e( 'Thumbnail height:', 'limb-gallery' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>"
                   name="<?php echo $this->get_field_name( 'height' ); ?>" type="number"
                   value="<?php echo esc_attr( $thumbnail_height ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php _e( 'Order by:', 'limb-gallery' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'order_by' ); ?>"
                    name="<?php echo $this->get_field_name( 'order_by' ); ?>">
                <option <?php echo $orderBy === 'order' ? 'selected' : ''; ?> value="order">Custom order</option>
                <option <?php echo $orderBy === 'id' ? 'selected' : ''; ?> value="id">Id</option>
                <option <?php echo $orderBy === 'title' ? 'selected' : ''; ?> value="title">Title</option>
                <option <?php echo $orderBy === 'description' ? 'selected' : ''; ?> value="description">
                    Description
                </option>
                <option <?php echo $orderBy === 'type' ? 'selected' : ''; ?> value="type">Type</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'ordering' ); ?>"><?php _e( 'Ordering:', 'limb-gallery' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'ordering' ); ?>"
                    name="<?php echo $this->get_field_name( 'ordering' ); ?>">
                <option <?php echo $ordering === 'ASC' ? 'selected' : ''; ?> value="ASC">ASC</option>
                <option <?php echo $ordering === 'DESC' ? 'selected' : ''; ?> value="DESC">DESC</option>
            </select>
        </p>
		<?php
	}
}