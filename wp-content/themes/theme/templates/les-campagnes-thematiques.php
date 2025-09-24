
<div class="block_page thematiques">
    <h1><?php echo get_the_title(); ?></h1>
    <div class="inner-wrapper">
        <div class="cententPage">
           
            <?php if( have_rows('reglages_page_les_campagnes_thematiques') ): ?>
                <?php while( have_rows('reglages_page_les_campagnes_thematiques') ): the_row(); ?>
                    <?php 
                        $description = get_sub_field('description'); 
                        $liste_de_poste = get_sub_field('liste_de_poste'); 
                    ?>
                        <div class="descript_top">
                            <?php echo $description; ?>
                        </div>

                        <?php if( $liste_de_poste ): ?>
                            <div class="conteneur_actions_phares">
                            <?php 
                            foreach ($liste_de_poste as $list_post) {
                                $image = $list_post['image']; 
                                $titre_poste = $list_post['titre_poste']; 
                                $contenu_du_poste = $list_post['contenu_du_poste']; 
                                $lien = $list_post['lien'];
                                
                                ?>
                                <div class="item_actions_phares">
                                    <div class="pic_actions_phares">
                                        <img src="<?php echo esc_url($image['url']); ?>">
                                    </div>
                                    <h3><?php echo $titre_poste; ?></h3>
                                    <?php echo $contenu_du_poste; ?>
                                    <a href="<?php echo esc_url($lien['url']); ?>" class="url_to_post"><?php echo $lien['title']; ?></a>
                                </div>
                            <?php
                                } 
                            ?>
                            </div>
                        <?php endif; ?>
                    
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

<!-- <div class="pre-footer pre-footer-2">
    <a href="https://givingtuesday.fr/comment-participer/actions-a-decouvrir/" class="bnt-action-page-footer">actions
        à découvrir</a> -->
</div> 
<script>
    $('.banners-block').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            arrows: true,
            fade: false,
            dots: false,
            infinite: true,
            speed: 1000,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
</script>