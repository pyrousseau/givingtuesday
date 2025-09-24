
<div class="block_page">
    <h1><?php echo get_the_title(); ?></h1>
    <div class="inner-wrapper">
        <div class="cententPage">
           
            <?php if( have_rows('parametres_de_page') ): ?>
                <?php while( have_rows('parametres_de_page') ): the_row(); ?>
                    <?php if( have_rows('section_description') ): ?>
                        <?php while( have_rows('section_description') ): the_row(); ?>
                            <?php 
                                $titre_section = get_sub_field('titre_section');
                                $description = get_sub_field('description');
                                $lien = get_sub_field('lien');
                                $titre_du_lien = get_sub_field('titre_du_lien');
                                $lien_2 = get_sub_field('lien_2');
                                $titre_du_lien_2 = get_sub_field('titre_du_lien_2');

                            ?>
                            <div id="section_description">
                                <div class="content">
                                    <!-- <h2><?php //echo $titre_section; ?></h2> -->
                                    <?php echo $description; ?>
                                    <?php if($lien){ ?>
                                        <a href="<?php echo esc_url( $lien['url']); ?>" class="big_btn_page"><?php echo strip_tags( $titre_du_lien); ?></a>
                                    <?php } ?>
                                    <?php if($lien_2){ ?>
                                    <a href="<?php echo esc_url( $lien_2['url']); ?>" class="big_btn_page"><?php echo strip_tags( $titre_du_lien_2); ?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    
                    <?php if( have_rows('section_faites_le_plein_d’idees') ): ?>
                        <?php while( have_rows('section_faites_le_plein_d’idees') ): the_row(); ?>
                            <?php 
                                $titre_section = get_sub_field('titre_section_faites_le_plein_d’idees'); 
                                $liste_de_poste = get_sub_field('liste_de_poste'); 
                            ?>
                            <h2><?php echo $titre_section; ?></h2>

                            <?php if( $liste_de_poste ): ?>
                                <div class="conteneur_actions_phares">
                                <?php 
                                foreach ($liste_de_poste as $list_post) {
                                    $image = $list_post['image']; 
                                    $titre_poste = $list_post['titre_poste']; 
                                    $contenu_du_poste = $list_post['contenu_du_poste']; 
                                    $bold_texte = $list_post['bold_texte'];
                                    
                                    ?>
                                    <div class="item_actions_phares">
                                        <div class="pic_actions_phares">
                                            <img src="<?php echo esc_url($image['url']); ?>">
                                        </div>
                                        <h3><?php echo $titre_poste; ?></h3>
                                        <?php echo $contenu_du_poste; ?>
                                        <a href="<?php echo esc_url( $bold_texte['url']); ?>" ><?php echo esc_attr( $bold_texte['title']); ?></a>
                                    </div>
                                <?php
                                    } 
                                ?>
                                </div>
                            <?php endif; ?>

                        <?php endwhile; ?>
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