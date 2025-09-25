
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

                            ?>
                            <div id="section_description">
                                <div class="content">
                                    <!-- <h2><?php //echo $titre_section; ?></h2> -->
                                    <?php echo $description; ?>
                                   <!-- <a href="<?php echo esc_url( $lien['url']); ?>" class="big_btn_page"><?php echo strip_tags( $titre_du_lien); ?></a>-->
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php if( have_rows('section_actions_phares') ): ?>
                        <?php while( have_rows('section_actions_phares') ): the_row(); ?>
                            <?php
                                $titre_section = get_sub_field('titre_section_actions_phares');
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
                                        <span><?php echo $bold_texte; ?></span>
                                    </div>
                                <?php
                                    }
                                ?>
                                </div>
                            <?php endif; ?>

                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php if( have_rows('section_partenaire') ): ?>
                        <?php while( have_rows('section_partenaire') ): the_row(); ?>
                            <?php
                                $titre = get_sub_field('titre_section');
                                $liste_de_logo = get_sub_field('liste_de_logo');
                                $description = get_sub_field('description');

                            ?>
                            <h2><?php echo $titre; ?></h2>

                            <?php if( $liste_de_logo ): ?>

                                <?php
                                foreach ($liste_de_logo as $list_logo) {
                                    $image_url = $list_logo['image'];
                                    $lien = $list_logo['lien'];
                                    ?>
                                        <p style="text-align: center;">
                                        <a href="<?php  if($lien['url'] !=''){ echo esc_url( $lien['url']);}else{ echo '#';} ?>" target="_blank" style="width: 200px;">
                                            <img src="<?php echo esc_url($image_url['url']); ?>">
                                        </a></p>
                                        <?php if( $description ): ?>

                                        <h3 style="text-align: center; max-width:500px; margin:0 auto;"> <?php echo $description; ?> </h3>
                                        <?php endif; ?>
                                <?php
                                    }
                                ?>


                            <?php endif; ?>

                        <?php endwhile; ?>

                    <?php if( have_rows('section_acteurs') ): ?>
                        <?php while( have_rows('section_acteurs') ): the_row(); ?>
                            <?php
                                $titre = get_sub_field('titre_section');
                                $liste_de_logo = get_sub_field('liste_de_logo');

                            ?>
                            <h2><?php echo $titre; ?></h2>

                            <?php if( $liste_de_logo ): ?>
                                <ul class="banners-block">
                                <?php
                                foreach ($liste_de_logo as $list_logo) {
                                    $image_url = $list_logo['image'];
                                    $lien = $list_logo['lien'];
                                    ?>
                                    <li>
                                        <a href="<?php  if($lien['url'] !=''){ echo esc_url( $lien['url']);}else{ echo '#';} ?>" class="block-wrapper">
                                            <img src="<?php echo esc_url($image_url['url']); ?>">
                                        </a>
                                    </li>
                                <?php
                                    }
                                ?>

                                </ul>
                            <?php endif; ?>

                        <?php endwhile; ?>
                    <?php endif; ?>

                    <?php if( have_rows('section_ambassadeur') ): ?>
                        <?php while( have_rows('section_ambassadeur') ): the_row(); ?>
                            <?php
                                $titre_section = get_sub_field('titre');
                                $image_user = get_sub_field('image');
                                $texte_user = get_sub_field('bio');
                            ?>
                            <?php if( $titre_section !='' ): ?>
                                <h2><?php echo $titre_section; ?></h2>

                                <div class="conteneur_user">
                                    <div class="pic_users">
                                        <img src="<?php echo esc_url($image_user['url']); ?>">
                                    </div>
                                    <div class="text_users">
                                        <?php echo $texte_user;?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
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

