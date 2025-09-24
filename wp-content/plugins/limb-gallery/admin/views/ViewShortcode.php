<?php

/**
 * LIMB gallery
 * Shortcode view
 */
class GRSViewShortcode
{
    /**
     * @var GRSAdminModel
     */
    private  $model ;
    /**
     * @param   GRSAdminModel  $model
     */
    public function __construct( $model )
    {
        $this->model = $model;
    }
    
    // method declaration
    public function check_action()
    {
    }
    
    public function display()
    {
        $lg_fs = $this->model->lg_fs;
        $grsGalleries = $this->model->getGrsGalleries();
        $grsAlbums = $this->model->getGrsAlbums();
        $grsThemes = $this->model->getGrsThemes();
        $version = $this->model->version;
        $gutenberg = ( isset( $_GET['gutenberg'] ) ? (bool) $_GET['gutenberg'] : 0 );
        $grsBlockId = ( isset( $_GET['grs_block_id'] ) ? sanitize_text_field( $_GET['grs_block_id'] ) : '' );
        $grsAjaxNonce = ( isset( $_GET['grsAjaxNonce'] ) ? sanitize_text_field( $_GET['grsAjaxNonce'] ) : '' );
        $task = ( isset( $_GET['task'] ) ? sanitize_text_field( $_GET['task'] ) : '' );
        $data = ( isset( $_GET['data'] ) ? stripslashes( $_GET['data'] ) : '' );
        $effects = $this->model->getEffects();
        // Check if the request is from gutenberg
        if ( !$gutenberg ) {
            // Trying to make json string from shortcode data
            $data = str_replace( array(
                ' ',
                '[',
                ']',
                '=',
                'GRS,'
            ), array(
                ',"',
                '{',
                '}',
                '":',
                ''
            ), $data );
        }
        //TODO sanitize fields
        try {
            $data = json_decode( urldecode( $data ) );
            if ( !empty($data) ) {
                $id = (int) $data->id;
            }
        } catch ( \Exception $e ) {
            //TODO log
            $id = -1;
        }
        // Now retrieve the shortCode data if such id exists
        // Fetching final params
        
        if ( !empty($id) && $id !== -1 ) {
            $params = $this->model->getShortCode( $id );
        } else {
            $params = '{}';
            $id = -1;
        }
        
        $orderbies = $this->model->getOrderbies();
        $orderbiesForAlb = $this->model->getOrderbiesForAlb();
        $clickActions = $this->model->getClickActions();
        $openlinkTargets = $this->model->getOpenLinkTargets();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Limb Gallery Shortcode</title>
            <link rel="stylesheet" type="text/css"
                  href="<?php 
        echo  GRS_PLG_URL . '/css/grsShortcode.css?ver=' . $version ;
        ?>">
            <link rel="stylesheet" type="text/css"
                  href="<?php 
        echo  GRS_PLG_URL . '/css/select2/select2.min.css?ver=' . $version ;
        ?>">
			<?php 
        wp_print_scripts( 'jquery' );
        ?>
            <script>
                var task = '<?php 
        echo  esc_js( $task ) ;
        ?>',
                    data = jQuery.parseJSON('<?php 
        echo  $params ;
        ?>'),
                    gutenberg = <?php 
        echo  $gutenberg ;
        ?>,
                    grsPlanName = '<?php 
        echo  esc_js( $lg_fs->get_plan_name() ) ;
        ?>',
                    grsPremium = '<?php 
        echo  esc_js( $lg_fs->is__premium_only() ) ;
        ?>',
                    grsUpgradeUrl = '<?php 
        echo  esc_js( $lg_fs->get_upgrade_url() ) ;
        ?>',
                    grsBlockId = '<?php 
        echo  esc_js( $grsBlockId ) ;
        ?>',
                    grsAjaxNonce = '<?php 
        echo  esc_js( $grsAjaxNonce ) ;
        ?>',
                    ajaxUrl = '<?php 
        echo  admin_url( 'admin-ajax.php' ) ;
        ?>',
                    id = <?php 
        echo  $id ;
        ?>,
                    viewHelp = true;
            </script>
            <script src="<?php 
        echo  GRS_PLG_URL . '/js/grsShortcode.js?ver=' . $version ;
        ?>"></script>
            <script src="<?php 
        echo  GRS_PLG_URL . '/js/select2/select2.full.min.js?ver=' . $version ;
        ?>"></script>
        </head>
        <body>
        <div class="grsMainCont">
            <div class="grsGallsLightCont">
                <div class="grsGallsCont">
                    <div class="grsGallsButtons">
                        <div>
                            <div class="grsGallButton">
                                <a class="grsGall" href="#">
                                    <i class="fa fa-camera-retro fa-lg"></i>
                                    <span><?php 
        _e( 'Select Gallery', 'limb-gallery' );
        ?></span>
                                </a>
                                <!-- GRS titles -->
                                <div class="grsGallTitlesCont" style="display:none">
                                    <ul class="grsGallTitles">
										<?php 
        foreach ( $grsGalleries as $galKey => $grsGallerie ) {
            ?>
                                            <li class="grsGallTitle" grsGallId="<?php 
            echo  $grsGallerie->id ;
            ?>">
                                                <span class="grsCheck"></span>
                                                <a href="#" class="grs_galleries_title_ln">
                                                    <div class="grsTitleLabel"> <?php 
            echo  $this->model->addDotes( $grsGallerie->title ) ;
            ?> </div>
                                                </a>
                                            </li>
										<?php 
        }
        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="grsAlbButton">
                                <a class="grsAlb" href="#">
                                    <i class="fa fa-camera-retro fa-lg"></i>
                                    <span><?php 
        _e( 'Select Album', 'limb-gallery' );
        ?></span>
                                </a>
                                <!-- GRS titles -->
                                <div class="grsAlbTitlesCont" style="display:none">
                                    <ul class="grsAlbTitles">
										<?php 
        foreach ( $grsAlbums as $albKey => $grsAlbum ) {
            ?>
                                            <li class="grsAlbTitle" grsAlbId="<?php 
            echo  $grsAlbum->id ;
            ?>">
                                                <span class="grsCheck"></span>
                                                <a href="#" class="grsAlbumsTitleLn">
                                                    <div class="grsTitleLabel"> <?php 
            echo  $this->model->addDotes( $grsAlbum->title ) ;
            ?> </div>
                                                </a>
                                            </li>
										<?php 
        }
        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="grsTypeButton">
                                <a class="grsTypeDeactive" href="#">
                                    <i class="fa fa-camera-retro fa-lg"></i>
                                    <span><?php 
        _e( 'Select view', 'limb-gallery' );
        ?></span>
                                </a>
                                <!-- GRS view types -->
                                <div class="grsGallViewsCont" style="display:none">
                                    <div class="grsGallViews">
                                        <div class="grsGallThumbnailView grsView enabled" grsView="Thumbnail"
                                             title="Thumbnail"></div>
                                        <div class="grsGallMasonryView grsView enabled" grsView="Masonry"
                                             title="Masonry"></div>
                                        <div class="grsGallFilmView grsView enabled" grsView="Film"
                                             title="Carousel"></div>
                                        <div class="grsGallCarousel3dView grsView <?php 
        echo  ( $lg_fs->can_use_premium_code__premium_only() ? 'enabled' : 'disabled' ) ;
        ?>"
                                             grsView="Carousel3d" title="3D Carousel">
											<?php 
        ?>
                                                <a href="<?php 
        echo  $lg_fs->get_upgrade_url() ;
        ?>" target="_blank"><span><?php 
        _e( 'Upgrade', 'limb-gallery' );
        ?> &#8594;</span></a>
											<?php 
        ?>
                                        </div>
                                        <div class="grsGallMosaicView grsView <?php 
        echo  ( $lg_fs->can_use_premium_code__premium_only() ? 'enabled' : 'disabled' ) ;
        ?>"
                                             grsView="Mosaic" title="Mosaic">
											<?php 
        ?>
                                                <a href="<?php 
        echo  $lg_fs->get_upgrade_url() ;
        ?>" target="_blank"><span><?php 
        _e( 'Upgrade', 'limb-gallery' );
        ?> &#8594;</span></a>
											<?php 
        ?>
                                        </div>
                                        <div class="grsGallAlbumView grsView enabled" grsView="Album"
                                             title="Album"></div>
                                        <div class="grsClear"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="grsClear"></div>
                        </div>
                        <div class="grsThemeButton">
                            <a class="grsTheme" href="#">
                                <i class="fa fa-camera-retro fa-lg"></i>
                                <span><?php 
        _e( 'Select theme', 'limb-gallery' );
        ?></span>
                            </a>
                            <div class="grsThemeNamesCont" style="display:none">
                                <ul class="grsThemeNames">
									<?php 
        foreach ( $grsThemes as $themeKey => $grsTheme ) {
            $default = ( $grsTheme->default ? 'grsThemeSelected' : '' );
            ?>
                                        <li class="grsThemeName <?php 
            echo  $default ;
            ?>"
                                            grsthemeid="<?php 
            echo  $grsTheme->id ;
            ?>">
                                            <span class="grsCheck"></span>
                                            <a href="#" class="grsThemesNameLn">
                                                <div class="grsNameLabel"> <?php 
            echo  $this->model->addDotes( $grsTheme->name ) ;
            ?> </div>
                                            </a>
                                        </li>
									<?php 
        }
        ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Thumbnail View -->
                    <div class="grsThumbnailCont grsViewCont" style="display:none">
                        <div class="grsThumbnail">
                            <div class="grsThumbnailTitleCont">
                                <div class="grsThumbnailTitle">
									<?php 
        _e( 'Thumbnail view', 'limb-gallery' );
        ?>
                                </div>
                                <div class="grsClear"></div>
                            </div>
                            <div class="grsThumbnailParamsCont">
                                <div class="grsThumbnailParams">
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="thumbnailWidth"><?php 
        _e( 'Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="200" name="thumbnailWidth"
                                                   id="thumbnailWidth"><span class="iden">px</span>
                                        </div>
                                        <div class="grsCell">
                                            <label for="thumbnailHeight"><?php 
        _e( 'Height:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="160" name="thumbnailHeight"
                                                   id="thumbnailHeight"><span class="iden">px</span>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell grsMasonryContWidthLab" style="width:25%">
                                            <label for="thumbnailContWidth"><?php 
        _e( 'Container Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMasonryContWidthInp" style="width:25%">
                                            <input type="number" value="100" name="thumbnailContWidth" max="100" min="0"
                                                   id="thumbnailContWidth"><span class="iden">%</span>
                                        </div>
                                        <div class="grsCell">
                                            <label for="thumbnailTitle"><?php 
        _e( 'Show title:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="thumbnailTitle" id="thumbnailTitle">
                                                <option value="no"><?php 
        _e( 'No', 'limb-gallery' );
        ?></option>
                                                <option selected
                                                        value="onhover"><?php 
        _e( 'On hover', 'limb-gallery' );
        ?></option>
                                                <option value="always"><?php 
        _e( 'Always', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="thumbnailPolaroid_1"><?php 
        _e( 'Polaroid:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <label for="thumbnailPolaroid_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                            <input type="radio" value="1" name="thumbnailPolaroid"
                                                   id="thumbnailPolaroid_1">
                                            <label for="thumbnailPolaroid_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                            <input type="radio" checked value="0" name="thumbnailPolaroid"
                                                   id="thumbnailPolaroid_0">
                                        </div>
                                        <div class="grsCell">
                                        </div>
                                        <div class="grsCell">
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="thumbnailImagesPerpage"><?php 
        _e( 'Items Perpage:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="20" name="thumbnailImagesPerpage"
                                                   id="thumbnailImagesPerpage" style="width:38px">
                                        </div>
                                        <div class="grsCell">
                                            <label for="thumbnailPagination"><?php 
        _e( 'Pagination:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="thumbnailPagination" id="thumbnailPagination">
                                                <option value="numbers"><?php 
        _e( 'Numbers', 'limb-gallery' );
        ?></option>
                                                <option selected
                                                        value="loadMore"><?php 
        _e( 'Load more', 'limb-gallery' );
        ?></option>
                                                <option value="scrolling"><?php 
        _e( 'Scrolling', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="thumbnailOrderBy"><?php 
        _e( 'Order by:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="thumbnailOrderBy" id="thumbnailOrderBy">
												<?php 
        foreach ( $orderbies as $key => $orderBy ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $orderBy ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="thumbnailOrdering"><?php 
        _e( 'Ordering:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="thumbnailOrdering" id="thumbnailOrdering">
                                                <option selected
                                                        value="ASC"><?php 
        _e( 'ASC', 'limb-gallery' );
        ?></option>
                                                <option value="DESC"><?php 
        _e( 'DESC', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="thumbnailClickAction"><?php 
        _e( 'Click action:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="thumbnailClickAction" id="thumbnailClickAction">
												<?php 
        foreach ( $clickActions as $key => $action ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $action ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="thumbnailOpenLinkTarget" id="thumbnailOpenLinkTargetLabel"
                                                   style="display:none"><?php 
        _e( 'Link target:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="thumbnailOpenLinkTarget" id="thumbnailOpenLinkTarget"
                                                    style="display:none">
												<?php 
        foreach ( $openlinkTargets as $key => $target ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $target ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel View -->
                    <div class="grsFilmCont grsViewCont" style="display:none">
                        <div class="grsFilm">
                            <div class="grsFilmTitleCont">
                                <div class="grsFilmTitle">
									<?php 
        _e( 'Carousel view', 'limb-gallery' );
        ?>
                                </div>
                                <div class="grsClear">

                                </div>
                            </div>
                            <div class="grsFilmParamsCont">
                                <div class="grsFilmParams">
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="fmWidth"><?php 
        _e( 'Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="200" name="fmWidth" id="fmWidth"><span class="iden">px</span>
                                        </div>
                                        <div class="grsCell">
                                            <label for="fmHeight"><?php 
        _e( 'Height:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="160" name="fmHeight"
                                                   id="fmHeight"><span class="iden">px</span>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell grsMasonryContWidthLab" style="width:25%">
                                            <label for="fmContWidth"><?php 
        _e( 'Container Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMasonryContWidthInp" style="width:25%">
                                            <input type="number" value="100" name="fmContWidth" max="100" min="0"
                                                   id="fmContWidth"><span class="iden">%</span>
                                        </div>
                                        <div class="grsCell">
                                            <label for="fmTitle"><?php 
        _e( 'Show title:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="fmTitle" id="fmTitle">
                                                <option value="no"><?php 
        _e( 'No', 'limb-gallery' );
        ?></option>
                                                <option selected
                                                        value="onhover"><?php 
        _e( 'On hover', 'limb-gallery' );
        ?></option>
                                                <option value="always"><?php 
        _e( 'Always', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="fmImagesPerpage"><?php 
        _e( 'Items Perpage:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="20" name="fmImagesPerpage" id="fmImagesPerpage"
                                                   style="width:38px">
                                        </div>
                                        <div class="grsCell">
                                            <label for="fmNav"><?php 
        _e( 'Navigation:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="fmNav" id="fmNav">
                                                <option selected
                                                        value="buttons"><?php 
        _e( 'Buttons', 'limb-gallery' );
        ?></option>
                                                <option value="scroll"><?php 
        _e( 'Scrolling', 'limb-gallery' );
        ?></option>
                                                <option value="both"><?php 
        _e( 'Buttons and scrolling', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="fmOrderBy"><?php 
        _e( 'Order by:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="fmOrderBy" id="fmOrderBy">
												<?php 
        foreach ( $orderbies as $key => $orderBy ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $orderBy ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="fmOrdering"><?php 
        _e( 'Ordering:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="fmOrdering" id="fmOrdering">
                                                <option selected
                                                        value="ASC"><?php 
        _e( 'ASC', 'limb-gallery' );
        ?></option>
                                                <option value="DESC"><?php 
        _e( 'DESC', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="fmClickAction"><?php 
        _e( 'Click action:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="fmClickAction" id="fmClickAction">
												<?php 
        foreach ( $clickActions as $key => $action ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $action ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="fmOpenLinkTarget" id="fmOpenLinkTargetLabel"
                                                   style="display:none"><?php 
        _e( 'Link target:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="fmOpenLinkTarget" id="fmOpenLinkTarget" style="display:none">
												<?php 
        foreach ( $openlinkTargets as $key => $target ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $target ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 3D Carousel View -->
                    <div class="grsCarousel3dCont grsViewCont" style="display:none">
                        <div class="grsCarousel3d">
                            <div class="grsCarousel3dTitleCont">
                                <div class="grsCarousel3dTitle">
									<?php 
        _e( '3D Carousel view', 'limb-gallery' );
        ?>
                                </div>
                                <div class="grsClear">

                                </div>
                            </div>
                            <div class="grsCarousel3dParamsCont">
                                <div class="grsCarousel3dParams">
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="crs3dWidth"><?php 
        _e( 'Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="200" name="crs3dWidth"
                                                   id="crs3dWidth"><span class="iden">px</span>
                                        </div>
                                        <div class="grsCell">
                                            <label for="crs3dHeight"><?php 
        _e( 'Height:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="160" name="crs3dHeight" id="crs3dHeight"><span class="iden">px</span>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell grsMasonryContWidthLab" style="width:25%">
                                            <label for="crs3dContWidth"><?php 
        _e( 'Container Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMasonryContWidthInp" style="width:25%">
                                            <input type="number" value="100" name="crs3dContWidth" max="100" min="0"
                                                   id="crs3dContWidth"><span class="iden">%</span>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell grsMasonryContWidthLab" style="width:25%">
                                            <label for="crs3dLDepth"><?php 
        _e( 'Left Side Depth:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMasonryContWidthInp" style="width:25%">
                                            <input type="number" value="0.35" step="0.05" name="crs3dLDepth" max="2.0"
                                                   min="-2.0" id="crs3dLDepth">
                                        </div>
                                        <div class="grsCell grsMasonryContWidthLab" style="width:25%">
                                            <label for="crs3dRDepth"><?php 
        _e( 'Right Side Depth:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMasonryContWidthInp" style="width:25%">
                                            <input type="number" value="0.35" step="0.05" name="crs3dRDepth" max="2.0"
                                                   min="-2.0" id="crs3dRDepth">
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell grsMasonryContWidthLab" style="width:25%">
                                            <label for="crs3dMaxScale"><?php 
        _e( 'Image Maximum Scale:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMasonryContWidthInp" style="width:25%">
                                            <input type="number" value="1.0" step="0.05" name="crs3dMaxScale" max="2.0"
                                                   min="0.1" id="crs3dMaxScale">
                                        </div>
                                        <div class="grsCell grsMasonryContWidthLab" style="width:25%">
                                            <label for="crs3dMinScale"><?php 
        _e( 'Image Minimum Scale:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMasonryContWidthInp" style="width:25%">
                                            <input type="number" value="0.7" step="0.05" name="crs3dMinScale" max="2.0"
                                                   min="0.1" id="crs3dMinScale">
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="crs3dImagesPerpage"><?php 
        _e( 'Items Perpage:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="20" name="crs3dImagesPerpage"
                                                   id="crs3dImagesPerpage" style="width:38px">
                                        </div>
                                        <div class="grsCell">
                                            <label for="crs3dViewItemsCount"><?php 
        _e( 'View Images Count:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="9" name="crs3dViewItemsCount" min="1"
                                                   id="crs3dViewItemsCount" style="width:38px">
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="crs3dTitle"><?php 
        _e( 'Show title:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="crs3dTitle" id="crs3dTitle">
                                                <option value="no"><?php 
        _e( 'No', 'limb-gallery' );
        ?></option>
                                                <option selected
                                                        value="onhover"><?php 
        _e( 'On hover', 'limb-gallery' );
        ?></option>
                                                <option value="always"><?php 
        _e( 'Always', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="crs3dOrderBy"><?php 
        _e( 'Order by:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="crs3dOrderBy" id="crs3dOrderBy">
												<?php 
        foreach ( $orderbies as $key => $orderBy ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $orderBy ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="crs3dOrdering"><?php 
        _e( 'Ordering:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="crs3dOrdering" id="crs3dOrdering">
                                                <option selected
                                                        value="ASC"><?php 
        _e( 'ASC', 'limb-gallery' );
        ?></option>
                                                <option value="DESC"><?php 
        _e( 'DESC', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="crs3dClickAction"><?php 
        _e( 'Click action:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="crs3dClickAction" id="crs3dClickAction">
												<?php 
        foreach ( $clickActions as $key => $action ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $action ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="crs3dOpenLinkTarget" id="crs3dOpenLinkTargetLabel"
                                                   style="display:none"><?php 
        _e( 'Link target:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="crs3dOpenLinkTarget" id="crs3dOpenLinkTarget"
                                                    style="display:none">
												<?php 
        foreach ( $openlinkTargets as $key => $target ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $target ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Masonry View -->
                    <div class="grsMasonryCont grsViewCont" style="display:none">
                        <div class="grsMasonry">
                            <div class="grsMasonryTitleCont">
                                <div class="grsMasonryTitle">
									<?php 
        _e( 'Masonry view', 'limb-gallery' );
        ?>
                                </div>
                                <div class="grsClear">

                                </div>
                            </div>
                            <div class="grsMasonryParamsCont">
                                <div class="grsMasonryParams">
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="masonryType"><?php 
        _e( 'Type:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <label for="masonryType_ver"><?php 
        _e( 'Vertical:', 'limb-gallery' );
        ?></label>
                                            <input type="radio" checked value="ver" name="masonryType"
                                                   id="masonryType_ver">
                                            <label for="masonryType_hor"><?php 
        _e( 'Horizontal:', 'limb-gallery' );
        ?></label>
                                            <input type="radio" value="hor" name="masonryType" id="masonryType_hor">
                                        </div>
                                        <div class="grsCell">
                                        </div>
                                        <div class="grsCell">
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell grsMasonryVerLab">
                                            <label for="masonryWidth"><?php 
        _e( 'Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMasonryVerInp">
                                            <input type="number" value="200" name="masonryWidth"
                                                   id="masonryWidth"><span class="iden">px</span>
                                        </div>
                                        <div class="grsCell grsMasonryHorLab" style="display:none;width:25%">
                                            <label for="masonryHeight"><?php 
        _e( 'Height:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMasonryHorInp" style="display:none;width:25%">
                                            <input type="number" value="160" name="masonryHeight"
                                                   id="masonryHeight"><span class="iden">px</span>
                                        </div>
                                        <div class="grsCell grsMasonryContWidthLab" style="width:25%">
                                            <label for="masonryContWidth"><?php 
        _e( 'Container Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMasonryContWidthInp" style="width:25%">
                                            <input type="number" value="100" name="masonryContWidth" max="100" min="0"
                                                   id="masonryContWidth"><span class="iden">%</span>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="masonryTitle"><?php 
        _e( 'Show title:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="masonryTitle" id="masonryTitle">
                                                <option value="no"><?php 
        _e( 'No', 'limb-gallery' );
        ?></option>
                                                <option selected
                                                        value="onhover"><?php 
        _e( 'On hover', 'limb-gallery' );
        ?></option>
                                                <option value="always"><?php 
        _e( 'Always', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="masonryImagesPerpage"><?php 
        _e( 'Items Perpage:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="20" name="masonryImagesPerpage"
                                                   id="masonryImagesPerpage" style="width:38px">
                                        </div>
                                        <div class="grsCell">
                                            <label for="masonryPagination"><?php 
        _e( 'Pagination:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="masonryPagination" id="masonryPagination">
                                                <option value="numbers"><?php 
        _e( 'Numbers', 'limb-gallery' );
        ?></option>
                                                <option selected
                                                        value="loadMore"><?php 
        _e( 'Load more', 'limb-gallery' );
        ?></option>
                                                <option value="scrolling"><?php 
        _e( 'Scrolling', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="masonryOrderBy"><?php 
        _e( 'Order by:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="masonryOrderBy" id="masonryOrderBy">
												<?php 
        foreach ( $orderbies as $key => $orderBy ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $orderBy ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="masonryOrdering"><?php 
        _e( 'Ordering:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="masonryOrdering" id="masonryOrdering">
                                                <option selected
                                                        value="ASC"><?php 
        _e( 'ASC', 'limb-gallery' );
        ?></option>
                                                <option value="DESC"><?php 
        _e( 'DESC', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="masonryClickAction"><?php 
        _e( 'Click action:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="masonryClickAction" id="masonryClickAction">
												<?php 
        foreach ( $clickActions as $key => $action ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $action ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="masonryOpenLinkTarget" id="masonryOpenLinkTargetLabel"
                                                   style="display:none"><?php 
        _e( 'Link target:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="masonryOpenLinkTarget" id="masonryOpenLinkTarget"
                                                    style="display:none">
												<?php 
        foreach ( $openlinkTargets as $key => $target ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $target ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mosaic View -->
                    <div class="grsMosaicCont grsViewCont" style="display:none">
                        <div class="grsMosaic">
                            <div class="grsMosaicTitleCont">
                                <div class="grsMosaicTitle">
									<?php 
        _e( 'Mosaic view', 'limb-gallery' );
        ?>
                                </div>
                                <div class="grsClear">

                                </div>
                            </div>
                            <div class="grsMosaicParamsCont">
                                <div class="grsMosaicParams">
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="mosaicType"><?php 
        _e( 'Type:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <label for="mosaicType_ver"><?php 
        _e( 'Vertical:', 'limb-gallery' );
        ?></label>
                                            <input type="radio" checked value="ver" name="mosaicType"
                                                   id="mosaicType_ver">
                                            <label for="mosaicType_hor"><?php 
        _e( 'Horizontal:', 'limb-gallery' );
        ?></label>
                                            <input type="radio" value="hor" name="mosaicType" id="mosaicType_hor">
                                            <label for="mosaicType_rand">Random:</label>
                                            <input type="radio" value="rand" name="mosaicType" id="mosaicType_rand">
                                        </div>
                                        <div class="grsCell">
                                        </div>
                                        <div class="grsCell">
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell grsMosaicVerLab grsMosaicRandLab">
                                            <label for="mosaicWidth"><?php 
        _e( 'Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMosaicVerInp grsMosaicRandInp">
                                            <input type="number" value="200" name="mosaicWidth" id="mosaicWidth"><span class="iden">px</span>
                                        </div>
                                        <div class="grsCell grsMosaicHorLab" style="display:none;width:25%">
                                            <label for="mosaicHeight"><?php 
        _e( 'Height:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMosaicHorInp" style="display:none;width:25%">
                                            <input type="number" value="160" name="mosaicHeight" max="1000" min="0"
                                                   id="mosaicHeight"><span class="iden">px</span>
                                        </div>

                                        <div class="grsCell grsMosaicContWidthLab" style="width:25%">
                                            <label for="mosaicHeight"><?php 
        _e( 'Container Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsMosaicContWidthInp" style="width:25%">
                                            <input type="number" value="100" name="mosaicContWidth" max="100" min="0"
                                                   id="mosaicContWidth"><span class="iden">%</span>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="mosaicTitle"><?php 
        _e( 'Show title:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="mosaicTitle" id="mosaicTitle">
                                                <option value="no"><?php 
        _e( 'No', 'limb-gallery' );
        ?></option>
                                                <option selected
                                                        value="onhover"><?php 
        _e( 'On hover', 'limb-gallery' );
        ?></option>
                                                <option value="always"><?php 
        _e( 'Always', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="mosaicImagesPerpage"><?php 
        _e( 'Items Perpage:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="20" name="mosaicImagesPerpage"
                                                   id="mosaicImagesPerpage" style="width:38px">
                                        </div>
                                        <div class="grsCell">
                                            <label for="mosaicPagination"><?php 
        _e( 'Pagination:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="mosaicPagination" id="mosaicPagination">
                                                <option value="numbers"><?php 
        _e( 'Numbers', 'limb-gallery' );
        ?></option>
                                                <option selected
                                                        value="loadMore"><?php 
        _e( 'Load more', 'limb-gallery' );
        ?></option>
                                                <option value="scrolling"><?php 
        _e( 'Scrolling', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="mosaicOrderBy"><?php 
        _e( 'Order by:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="mosaicOrderBy" id="mosaicOrderBy">
												<?php 
        foreach ( $orderbies as $key => $orderBy ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $orderBy ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="mosaicOrdering"><?php 
        _e( 'Ordering:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="mosaicOrdering" id="mosaicOrdering">
                                                <option selected
                                                        value="ASC"><?php 
        _e( 'ASC', 'limb-gallery' );
        ?></option>
                                                <option value="DESC"><?php 
        _e( 'DESC', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="mosaicClickAction"><?php 
        _e( 'Click action:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="mosaicClickAction" id="mosaicClickAction">
												<?php 
        foreach ( $clickActions as $key => $action ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $action ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="mosaicOpenLinkTarget" id="mosaicOpenLinkTargetLabel"
                                                   style="display:none"><?php 
        _e( 'Link target:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="mosaicOpenLinkTarget" id="mosaicOpenLinkTarget"
                                                    style="display:none">
												<?php 
        foreach ( $openlinkTargets as $key => $target ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $target ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Album View -->
                    <div class="grsAlbumCont grsViewCont" style="display:none">
                        <div class="grsAlbum">
                            <div class="grsAlbumTitleCont">
                                <div class="grsAlbumTitle">
									<?php 
        _e( 'Album view', 'limb-gallery' );
        ?>
                                </div>
                                <div class="grsClear"></div>
                            </div>
                            <div class="grsAlbumParamsCont">
                                <div class="grsAlbumParams">
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="albMainView"><?php 
        _e( 'Main view type:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="albMainView" id="albMainView">
                                                <option value="Thumbnail"><?php 
        _e( 'Thumbnail', 'limb-gallery' );
        ?></option>
                                                <option value="Masonry"><?php 
        _e( 'Masonry', 'limb-gallery' );
        ?></option>
                                                <option <?php 
        echo  ( $lg_fs->can_use_premium_code__premium_only() ? '' : 'disabled' ) ;
        ?>
                                                        value="Mosaic"><?php 
        _e( 'Mosaic', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                        <div class="grsCell grsAlbMasMosTypeLab">
                                            <label for="albMasMosType_ver"><?php 
        _e( 'Type:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsAlbMasMosTypeInp">
                                            <label for="albMasMosType_ver"><?php 
        _e( 'Vertical:', 'limb-gallery' );
        ?></label>
                                            <input type="radio" checked value="ver" name="albMasMosType"
                                                   id="albMasMosType_ver">
                                            <label for="albMasMosType_hor"><?php 
        _e( 'Horizontal:', 'limb-gallery' );
        ?></label>
                                            <input type="radio" value="hor" name="albMasMosType" id="albMasMosType_hor">
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell grsAlbVerLab">
                                            <label for="albWidth"><?php 
        _e( 'Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsAlbVerInp">
                                            <input type="number" value="200" name="albWidth"
                                                   id="albWidth"><span class="iden">px</span>
                                        </div>
                                        <div class="grsCell grsAlbHorLab">
                                            <label for="albHeight"><?php 
        _e( 'Height:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsAlbHorInp">
                                            <input type="number" value="160" name="albHeight"
                                                   id="albHeight"><span class="iden">px</span>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell grsMosaicContWidthLab">
                                            <label for="albContWidthLab"><?php 
        _e( 'Main container Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell albContWidthInp">
                                            <input type="number" value="60" name="albContWidth" max="100" min="0"
                                                   id="albContWidth"><span class="iden">%</span>
                                        </div>
                                        <div class="grsCell">
                                            <label for="albTitle"><?php 
        _e( 'Show title:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="albTitle" id="albTitle">
                                                <option value="no"><?php 
        _e( 'No', 'limb-gallery' );
        ?></option>
                                                <option value="onhover"><?php 
        _e( 'On hover', 'limb-gallery' );
        ?></option>
                                                <option selected
                                                        value="always"><?php 
        _e( 'Always', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="albOrderBy"><?php 
        _e( 'Order by:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="albOrderBy" id="albOrderBy">
												<?php 
        foreach ( $orderbiesForAlb as $key => $orderBy ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $orderBy ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="albOrdering"><?php 
        _e( 'Ordering:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="albOrdering" id="albOrdering">
                                                <option selected
                                                        value="ASC"><?php 
        _e( 'ASC', 'limb-gallery' );
        ?></option>
                                                <option value="DESC"><?php 
        _e( 'DESC', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="albGalView"><?php 
        _e( 'Gallery view type:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="albGalView" id="albGalView">
                                                <option value="Thumbnail"><?php 
        _e( 'Thumbnail', 'limb-gallery' );
        ?></option>
                                                <option value="Masonry"><?php 
        _e( 'Masonry', 'limb-gallery' );
        ?></option>
                                                <option <?php 
        echo  ( $lg_fs->can_use_premium_code__premium_only() ? '' : 'disabled' ) ;
        ?>
                                                        value="Mosaic"><?php 
        _e( 'Mosaic', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                        <div class="grsCell grsAlbGalMasMosTypeLab">
                                            <label for="albGalMasMosType_ver"><?php 
        _e( 'Type:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsAlbGalMasMosTypeInp">
                                            <label for="albGalMasMosType_ver"><?php 
        _e( 'Vertical:', 'limb-gallery' );
        ?></label>
                                            <input type="radio" checked value="ver" name="albGalMasMosType"
                                                   id="albGalMasMosType_ver">
                                            <label for="albGalMasMosType_hor"><?php 
        _e( 'Horizontal:', 'limb-gallery' );
        ?></label>
                                            <input type="radio" value="hor" name="albGalMasMosType"
                                                   id="albGalMasMosType_hor">
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell grsAlbGalVerLab">
                                            <label for="albGalWidth"><?php 
        _e( 'Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsAlbGalVerLab">
                                            <input type="number" value="200" name="albGalWidth" id="albGalWidth"><span class="iden">px</span>
                                        </div>
                                        <div class="grsCell grsAlbGalHorLab">
                                            <label for="albGalHeight"><?php 
        _e( 'Height:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell grsAlbGalHorInp">
                                            <input type="number" value="160" name="albGalHeight"
                                                   id="albGalHeight"><span class="iden">px</span>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell grsMosaicContWidthLab">
                                            <label for="galContWidthLab"><?php 
        _e( 'Gallery container Width:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell albContWidthInp">
                                            <input type="number" value="100" name="galContWidth" max="100" min="0"
                                                   id="galContWidth"><span class="iden">%</span>
                                        </div>
                                        <div class="grsCell">
                                            <label for="galTitle"><?php 
        _e( 'Show title:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="galTitle" id="galTitle">
                                                <option value="no"><?php 
        _e( 'No', 'limb-gallery' );
        ?></option>
                                                <option selected
                                                        value="onhover"><?php 
        _e( 'On hover', 'limb-gallery' );
        ?></option>
                                                <option value="always"><?php 
        _e( 'Always', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="galOrderBy"><?php 
        _e( 'Order by:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="galOrderBy" id="galOrderBy">
												<?php 
        foreach ( $orderbies as $key => $orderBy ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $orderBy ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="galOrdering"><?php 
        _e( 'Ordering:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="galOrdering" id="galOrdering">
                                                <option selected
                                                        value="ASC"><?php 
        _e( 'ASC', 'limb-gallery' );
        ?></option>
                                                <option value="DESC"><?php 
        _e( 'DESC', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="albPagination"><?php 
        _e( 'Pagination:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="albPagination" id="albPagination">
                                                <option value="numbers"><?php 
        _e( 'Numbers', 'limb-gallery' );
        ?></option>
                                                <option value="loadMore"><?php 
        _e( 'Load more', 'limb-gallery' );
        ?></option>
                                                <option value="scrolling"><?php 
        _e( 'Scrolling', 'limb-gallery' );
        ?></option>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="albPerpage"><?php 
        _e( 'Items Perpage:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <input type="number" value="20" name="albPerpage" id="albPerpage"
                                                   style="width:38px">
                                        </div>
                                    </div>
                                    <div class="grsRow">
                                        <div class="grsCell">
                                            <label for="galClickAction"><?php 
        _e( 'Click action:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="galClickAction" id="galClickAction">
												<?php 
        foreach ( $clickActions as $key => $action ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $action ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                        <div class="grsCell">
                                            <label for="galOpenLinkTarget" id="galOpenLinkTargetLabel"
                                                   style="display:none"><?php 
        _e( 'Link target:', 'limb-gallery' );
        ?></label>
                                        </div>
                                        <div class="grsCell">
                                            <select name="galOpenLinkTarget" id="galOpenLinkTarget"
                                                    style="display:none">
												<?php 
        foreach ( $openlinkTargets as $key => $target ) {
            ?>
                                                    <option value="<?php 
            echo  $key ;
            ?>"><?php 
            echo  $target ;
            ?></option>
												<?php 
        }
        ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Lightbox View -->
                <div class="grsLightCont">
                    <div class="grsLightButtons">
                        <div class="grsLightboxButton">
                            <a class="grsLightboxDeactive" href="#">
                                <i class="fa fa-camera-retro fa-lg"></i>
                                <span><?php 
        _e( 'Lightbox', 'limb-gallery' );
        ?></span>
                            </a>
                        </div>
                        <div class="grsClear"></div>
                    </div>
                    <div class="grsLightboxParamsCont" style="display:none">
                        <div class="grsLightboxParams">
                            <div class="grsRow">
                                <div class="grsCell">
                                    <label for="lightboxFullW"><?php 
        _e( 'Full width:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell">
                                    <div class="grsForSizeing">
                                        <label for="lightboxFullW_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                        <input type="radio" checked value="1" name="lightboxFullW" id="lightboxFullW_1">
                                        <label for="lightboxFullW_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                        <input type="radio" value="0" name="lightboxFullW" id="lightboxFullW_0">
                                    </div>
                                </div>
                                <div class="grsCell">
                                </div>
                                <div class="grsCell">
                                </div>
                            </div>
                            <div class="grsRow">
                                <div class="grsCell grsLightboxWidthLab" style="display: none">
                                    <label for="lightboxWidth"><?php 
        _e( 'Width:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxWidthInp" style="display: none">
                                    <input type="number" value="800" name="lightboxWidth"
                                           id="lightboxWidth"><span class="iden">px</span>
                                </div>
                                <div class="grsCell grsLightboxHeightLab" style="display: none">
                                    <label for="lightboxHeight"><?php 
        _e( 'Height:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxHeightInp" style="display: none">
                                    <input type="number" value="600" name="lightboxHeight"
                                           id="lightboxHeight"><span class="iden">px</span>
                                </div>
                            </div>
                            <div class="grsRow">
                                <div class="grsCell <?php 
        echo  ( $lg_fs->can_use_premium_code__premium_only() ? '' : 'disabled' ) ;
        ?>">
                                    <label for="lightboxFilmstrip"><?php 
        _e( 'Filmstrip:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell <?php 
        echo  ( $lg_fs->can_use_premium_code__premium_only() ? '' : 'disabled' ) ;
        ?>">
									<?php 
        ?>
                                        <a href="<?php 
        echo  $lg_fs->get_upgrade_url() ;
        ?>" target="_blank"><?php 
        _e( 'Upgrade', 'limb-gallery' );
        ?> &#8594;</a>
									<?php 
        ?>
                                </div>
                                <div class="grsCell <?php 
        echo  ( $lg_fs->is_plan__premium_only( 'pro', true ) || $lg_fs->is_plan__premium_only( 'elite', true ) ? '' : 'disabled' ) ;
        ?>">
                                    <label for="lightboxComment"><?php 
        _e( 'Comments:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell <?php 
        echo  ( $lg_fs->is_plan__premium_only( 'pro', true ) || $lg_fs->is_plan__premium_only( 'elite', true ) ? '' : 'disabled' ) ;
        ?>">
									<?php 
        
        if ( !$lg_fs->is_plan__premium_only( 'pro', true ) && !$lg_fs->is_plan__premium_only( 'elite', true ) ) {
            ?>
                                        <a href="<?php 
            echo  $lg_fs->get_upgrade_url() ;
            ?>" target="_blank"><?php 
            _e( 'Upgrade', 'limb-gallery' );
            ?> &#8594;</a>
									<?php 
        } else {
            ?>
                                        <label for="lightboxComment_1"><?php 
            _e( 'Yes:', 'limb-gallery' );
            ?></label>
                                        <input type="radio" checked value="1" name="lightboxComment" id="lightboxComment_1">
                                        <label for="lightboxComment_0"><?php 
            _e( 'No:', 'limb-gallery' );
            ?></label>
                                        <input type="radio" value="0" name="lightboxComment" id="lightboxComment_0">
									<?php 
        }
        
        ?>
                                </div>
                            </div>
                            <div class="grsRow">
                                <div class="grsCell">
                                    <label for="lightboxContButts_1"><?php 
        _e( 'Control buttons:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell">
                                    <label for="lightboxContButts_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxContButts"
                                           id="lightboxContButts_1">
                                    <label for="lightboxContButts_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxContButts" id="lightboxContButts_0">
                                </div>
                                <div class="grsCell">
                                    <label for="lightboxEffect"><?php 
        _e( 'Effect:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell">
                                    <select name="lightboxEffect" id="lightboxEffect">
										<?php 
        if ( !empty($effects) ) {
            foreach ( $effects as $key => $effectGroup ) {
                ?>
                                                <optgroup label="<?php 
                _e( $effectGroup['label'] );
                ?>">
													<?php 
                foreach ( $effectGroup['effects'] as $key_c => $single_effect ) {
                    $planName = ( !empty($this->model->lg_fs->get_plan()->name) && $this->model->lg_fs->is_plan__premium_only( $this->model->lg_fs->get_plan()->name, true ) ? $this->model->lg_fs->get_plan()->name : null );
                    ?>
                                                        <option
															<?php 
                    echo  ( in_array( $planName, $single_effect['plan'] ) ? '' : 'disabled' ) ;
                    ?>
															<?php 
                    echo  ( isset( $single_effect['selected'] ) && $single_effect['selected'] ? 'selected' : '' ) ;
                    ?>
                                                                value="<?php 
                    esc_attr_e( $key_c );
                    ?>">
															<?php 
                    esc_html_e( $single_effect['title'], 'limb-gallery' );
                    ?></option>
														<?php 
                }
                ?>
                                                </optgroup>
												<?php 
            }
        }
        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grsRow">
                                <div class="grsCell grsLightboxFButtLab">
                                    <label for="lightboxFButt_1"><?php 
        _e( 'Facebook:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxFButtInp">
                                    <label for="lightboxFButt_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxFButt" id="lightboxFButt_1">
                                    <label for="lightboxFButt_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxFButt" id="lightboxFButt_0">
                                </div>
                                <div class="grsCell grsLightboxGButtLab">
                                </div>
                                <div class="grsCell grsLightboxGButtInp">
                                </div>
                            </div>
                            <div class="grsRow">
                                <div class="grsCell grsLightboxTButtLab">
                                    <label for="lightboxTButt_1"><?php 
        _e( 'Twitter:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxTButtInp">
                                    <label for="lightboxTButt_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxTButt" id="lightboxTButt_1">
                                    <label for="lightboxTButt_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxTButt" id="lightboxTButt_0">
                                </div>
                                <div class="grsCell grsLightboxPButtLab">
                                    <label for="lightboxPButt_1"><?php 
        _e( 'Pinterest:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxPButtInp">
                                    <label for="lightboxPButt_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxPButt" id="lightboxPButt_1">
                                    <label for="lightboxPButt_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxPButt" id="lightboxPButt_0">
                                </div>
                            </div>
                            <div class="grsRow">
                                <div class="grsCell grsLightboxTbButtLab">
                                    <label for="lightboxTbButt_1"><?php 
        _e( 'Tumblr:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxTbButtInp">
                                    <label for="lightboxTbButt_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxTbButt" id="lightboxTbButt_1">
                                    <label for="lightboxTbButt_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxTbButt" id="lightboxTbButt_0">
                                </div>
                                <div class="grsCell grsLightboxLiButtLab">
                                    <label for="lightboxLiButt_1"><?php 
        _e( 'LinkedIn:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxLiButtInp">
                                    <label for="lightboxLiButt_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxLiButt" id="lightboxLiButt_1">
                                    <label for="lightboxLiButt_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxLiButt" id="lightboxLiButt_0">
                                </div>
                            </div>
                            <div class="grsRow">
                                <div class="grsCell grsLightboxReddButtLab">
                                    <label for="lightboxReddButt_1"><?php 
        _e( 'Reddit:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxReddButtInp">
                                    <label for="lightboxReddButt_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxReddButt"
                                           id="lightboxReddButt_1">
                                    <label for="lightboxReddButt_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxReddButt" id="lightboxReddButt_0">
                                </div>
                                <div class="grsCell grsLightboxFsButtLab">
                                    <label for="lightboxFsButt_1"><?php 
        _e( 'Fullscreen:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxFsButtInp">
                                    <label for="lightboxFsButt_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxFsButt" id="lightboxFsButt_1">
                                    <label for="lightboxFsButt_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxFsButt" id="lightboxFsButt_0">
                                </div>
                            </div>
                            <div class="grsRow">
                                <div class="grsCell grsLightboxAPLab">
                                    <label for="lightboxAP_1"><?php 
        _e( 'Autoplay:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxAPInp">
                                    <label for="lightboxAP_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxAP" id="lightboxAP_1">
                                    <label for="lightboxAP_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxAP" id="lightboxAP_0">
                                </div>
                                <div class="grsCell grsLightboxImInfLab">
                                    <label for="lightboxImInf_1"><?php 
        _e( 'Image Info:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxImInfInp">
                                    <label for="lightboxImInf_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxImInf" id="lightboxFsButt_1">
                                    <label for="lightboxImInf_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxImInf" id="lightboxImInf_0">
                                </div>
                            </div>
                            <div class="grsRow">
                                <div class="grsCell grsLightboxAPinLab">
                                    <label for="lightboxAPin"><?php 
        _e( 'Autoplay interval:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell grsLightboxAPinInp">
                                    <input type="number" min="1" value="3" name="lightboxAPin"
                                           id="lightboxAPin"><span class="iden"><?php 
        _e( 'sec', 'limb-gallery' );
        ?></span>
                                </div>
                                <div class="grsCell grsLightboxAPinLab">
                                </div>
                                <div class="grsCell grsLightboxAPinInp">
                                </div>
                            </div>
                            <div class="grsRow">
                                <div class="grsCell">
                                    <label for="lightboxImCn_1"><?php 
        _e( 'Image counting', 'limb-gallery' );
        ?>
                                        :</label>
                                </div>
                                <div class="grsCell">
                                    <label for="lightboxImCn_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxImCn" id="lightboxImCn_1">
                                    <label for="lightboxImCn_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxImCn" id="lightboxImCn_0">
                                </div>
                                <div class="grsCell">
                                    <label for="lightboxSwipe"><?php 
        _e( 'Swipe:', 'limb-gallery' );
        ?></label>
                                </div>
                                <div class="grsCell">
                                    <label for="lightboxSwipe_1"><?php 
        _e( 'Yes:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" checked value="1" name="lightboxSwipe" id="lightboxSwipe_1">
                                    <label for="lightboxSwipe_0"><?php 
        _e( 'No:', 'limb-gallery' );
        ?></label>
                                    <input type="radio" value="0" name="lightboxSwipe" id="lightboxSwipe_0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grsClear"></div>

                <div class="grsOkCont">
                    <div class="grsOk">
						<?php 
        echo  ( $task == 'update' ? __( 'Update', 'limb-gallery' ) : __( 'Insert', 'limb-gallery' ) ) ;
        ?>
                    </div>
                    <div class="grsClear"></div>
                </div>
            </div>
        </div>
        </body>
        </html>
		<?php 
    }

}