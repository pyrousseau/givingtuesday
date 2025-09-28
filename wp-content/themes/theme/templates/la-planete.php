
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

                    <?php if ( have_rows('section_webinaires') ) : ?>
                      <?php while ( have_rows('section_webinaires') ) : the_row();

                        // Champs ACF
                        $titre = get_sub_field('titre');
                        $image = get_sub_field('image');
                        $desc  = (string) get_sub_field('description');
                        $lien  = get_sub_field('lien'); // Peut être array, string ou post ID

                        // Normalisation URL
                        $href = '';
                        $target = '_self';

                        if (is_array($lien)) {
                          $href   = $lien['url'] ?? '';
                          $target = $lien['target'] ?? '_self';
                        } elseif (is_string($lien)) {
                          $href = $lien;
                        } elseif (is_numeric($lien)) {
                          $href = get_permalink((int)$lien) ?: '';
                        }

                        $href = trim($href);

                        // Nettoyage : supprime doublons de https://
                        $href = preg_replace('#^(https?:\/\/)+#i', 'https://', $href);

                        // Si l’URL commence par "www." sans schéma, ajoute "https://"
                        if ($href && preg_match('#^www\.#i', $href)) {
                          $href = 'https://' . $href;
                        }

                        // Escaping final + rel
                        $href = esc_url($href);
                        $rel  = ($target === '_blank') ? 'noopener' : '';

                        // Génération image
                        $img_html = '';
                        if (is_array($image) && !empty($image['ID'])) {
                          $img_html = wp_get_attachment_image(
                            $image['ID'], 'large', false, [
                              'class'   => 'webinaire-img',
                              'alt'     => esc_attr($image['alt'] ?: ($titre ?: 'Webinaire')),
                              'loading' => 'lazy'
                            ]
                          );
                        } elseif (is_array($image) && !empty($image['url'])) {
                          $alt = esc_attr($image['alt'] ?? ($titre ?: 'Webinaire'));
                          $img_html = '<img class="webinaire-img" src="'.esc_url($image['url']).'" alt="'.$alt.'" loading="lazy">';
                        }

                      ?>

                        <?php if ($titre): ?>
                          <h2><?php echo esc_html($titre); ?></h2>
                        <?php endif; ?>

                        <div class="webinaire-wrap">
                          <a class="webinaire-link"
                            href="<?php echo $href ?: '#'; ?>"
                            target="_blank"
                            <?php echo $rel ? 'rel="'.$rel.'"' : ''; ?>>

                            <?php echo $img_html; ?>

                            <?php if ($desc): ?>
                              <p class="webinaire-desc"><?php echo wp_kses_post($desc); ?></p>
                            <?php endif; ?>
                          </a>
                        </div>

                      <?php endwhile; ?>
                    <?php endif; ?>


                    <?php if ( have_rows('section_conseils') ) : ?>
                      <?php while ( have_rows('section_conseils') ) : the_row();
                        $titre = get_sub_field('titre');
                        $desc  = get_sub_field('description');
                        $cta   = trim((string) get_sub_field('cta'));

                        // Nettoyage URL
                        if ($cta !== '') {
                          $cta = preg_replace('#^(https?:\/\/)+#i', 'https://', $cta);
                          if (preg_match('#^www\.#i', $cta)) $cta = 'https://' . $cta;
                          $cta = esc_url($cta);
                        }
                      ?>

                      <section class="gt-conseils" style="text-align:center; margin:2.5rem 0;">
                        <?php if ($titre): ?>
                          <h2><?php echo esc_html($titre); ?></h2>
                        <?php endif; ?>

                        <?php if ($desc): ?>
                          <div class="gt-conseils__desc" >
                            <?php echo apply_filters('the_content', $desc); ?>
                          </div>
                        <?php endif; ?>

                        <?php if (!empty($cta)): ?>
                          <p class="gt-conseils__cta">
                            <a class="btn btn--primary"
                              href="<?php echo $cta; ?>"
                              target="_blank" rel="noopener"
                              style="display:inline-block;padding:.75rem 1.25rem;border-radius:999px;background:#002a57;color:#fff;text-decoration:none;">
                              Vous êtes fundraiser, rejoignez l'opération !
                            </a>
                          </p>
                        <?php endif; ?>
                      </section>

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

