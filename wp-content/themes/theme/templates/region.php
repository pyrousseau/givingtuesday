
<div class="block_page">
    <h1><?php echo get_the_title(); ?></h1>
    <div class="inner-wrapper">
        <div class="cententPage">
            <div id="section_description">
                <div class="content">
                    <div class="text_center"><?php echo get_field('description');?></div>
                    <?php  
                        if( get_field('affichage_du_map') == 'oui' ) {
                            echo do_shortcode('[display-map id="5044"]');
                        }
                    ?>
                    <h2><?php echo get_field('titre_section_3');?></h2>
                    <div class="text_center"><?php echo get_field('description_section_3');?></div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="pre-footer pre-footer-2">
    <a href="https://givingtuesday.fr/comment-participer/actions-a-decouvrir/" class="bnt-action-page-footer">actions
        à découvrir</a> -->
</div>