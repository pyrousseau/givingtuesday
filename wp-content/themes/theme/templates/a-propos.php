<div class="block block--propos block--propos__intro">
    <h1 class="block--propos__intro__title">Qu’est ce que Giving Tuesday ?</h1>
    <div class="block--propos__intro__wrap">
        <div class="block--propos__intro__img">
            <img src="/wp-content/themes/theme/images/about/a-propos-intro.jpg" alt="">
        </div>
        <div class="block--propos__intro__text">
            <div>
                <div>
                    <?php the_field('pb_texte'); ?>
                    <div class="block--propos__intro__read-more">
                        <a class="js-block--propos__read-more" href="#">Lire la suite</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block block--propos block--propos__france">
    <div class="container">
        <div class="block--propos__france__img">
            <img class="img-desktop" src="/wp-content/themes/theme/images/about/a-propos-img22.jpeg" alt="">
            <img class="img-mobile" src="/wp-content/themes/theme/images/about/a-propos-img22.jpeg" alt="">
        </div>
        <div class="block--propos__france__text">
            <?php
            $tb = get_field('tb_texte', false, false); // brut, sans formatage ACF
            if ($tb) {
            echo wp_kses_post($tb);                  // HTML sûr (équiv. contenu d’article)
            }
            ?>

        </div>
    </div>
</div>
<div class="block block--propos block--propos__citation">
    <div class="container">
        <div class="block--propos__citation__cols">
            <div class="block--propos__citation__col">
                <blockquote>
                    <p><span class="quote quote-left">“</span><strong><?php the_field('titre_citation_1'); ?></strong></p>
                    <p> <?php the_field('citation_1'); ?><span class="quote quote-right">”</span></p>
                    <footer><strong><?php the_field('nom_citation_1'); ?>,</strong> <br><?php the_field('position_citation_1'); ?> <br><?php the_field('societe_citation_1'); ?></footer>
                </blockquote>
            </div>
            <div class="block--propos__citation__col">
                <blockquote>
                    <p><span class="quote quote-left">“</span><strong><?php the_field('titre_citation_2'); ?></strong></p>
                    <p> <?php the_field('citation_2'); ?><span class="quote quote-right">”</span></p>
                    <footer><strong><?php the_field('nom_citation_2'); ?>,</strong> <br><?php the_field('position_citation_2'); ?> <br><?php the_field('societe_citation_2'); ?></footer>
                </blockquote>
            </div>
        </div>
    </div>
</div>
<div class="block block--propos block--propos__key-numbers">
    <div class="container">
        <h2><?php the_field('qd_titre'); ?></h2>

        <div class="block--propos__key-numbers__items">
            <?php $chiffres = get_field('chiffres');
            foreach($chiffres as $chiffre) { ?>
                <div class="block--propos__key-numbers__item">
                    <div class="block--propos__key-numbers__icon">
                        <img src="<?php echo $chiffre['image']['url']; ?>" alt="">
                    </div>
                    <div class="block--propos__key-numbers__text"><strong><?php echo $chiffre['chiffre']; ?></strong> <?php echo $chiffre['texte']; ?></div>
                </div>

            <?php } ?>
<!--            <div class="block--propos__key-numbers__item">-->
<!--                <div class="block--propos__key-numbers__icon">-->
<!--                    <img src="/wp-content/themes/theme/images/about/globe.png" alt="">-->
<!--                </div>-->
<!--                <div class="block--propos__key-numbers__text"><strong>49</strong> pays impliqués</div>-->
<!--            </div>-->
<!--            <div class="block--propos__key-numbers__item">-->
<!--                <div class="block--propos__key-numbers__icon">-->
<!--                    <img src="/wp-content/themes/theme/images/about/partners.png" alt="">-->
<!--                </div>-->
<!--                <div class="block--propos__key-numbers__text"><strong>180</strong> partenaires</div>-->
<!--            </div>-->
<!--            <div class="block--propos__key-numbers__item">-->
<!--                <div class="block--propos__key-numbers__icon">-->
<!--                    <img src="/wp-content/themes/theme/images/about/target.png" alt="">-->
<!--                </div>-->
<!--                <div class="block--propos__key-numbers__text"><strong>270</strong> actions enregistrées <br>sur le site internet</div>-->
<!--            </div>-->
<!--            <div class="block--propos__key-numbers__item">-->
<!--                <div class="block--propos__key-numbers__icon">-->
<!--                    <img src="/wp-content/themes/theme/images/about/donation.png" alt="">-->
<!--                </div>-->
<!--                <div class="block--propos__key-numbers__text"><strong>5</strong> formes de dons</div>-->
<!--            </div>-->
        </div>
<!--            
<div class="block--propos__key-numbers__footer">
            > <a class="block--propos__key-numbers__link" href="https://givingtuesday.fr/giving-tuesday-now/">DÉCOUVRIR LE BILAN DU #GIVINGTUESDAYNOW !</a> <
        </div>-->
    </div>
</div>
<div class="block--propos block--propos__bg">
    <img src="<?php the_field('image_4'); ?>" alt="">
</div>
<div class="block block--propos__block__icons block__icons">
    <h2>Giving Tuesday dans le monde</h2>
    <ul class="content block__icons__slider">
    <?php $icons = get_field('pays_rep', 25);
            $iconsSorted = array();
            foreach($icons as $icon) {
                $iconsSorted[$icon['titre']] = $icon;
            }
            ksort($iconsSorted);
            foreach ($iconsSorted as $iconSorted) {
                if ($iconSorted['image']['sizes']['monde']) {
                    $thumb = $iconSorted['image']['sizes']['monde'];
                } else {
                    $thumb = get_template_directory_uri().'/images/icon.jpg';
                }

                ?>
                <?php if ($iconSorted['lien'] && $iconSorted['lien'] != '') { ?>
                    <li><a href="<?php echo $iconSorted['lien']; ?>" target="_blank" class="item">
                <?php } else { ?>
                    <li><div target="_blank" class="item">
                    <?php } ?>
                    <div class="img">
                        <img src="<?php echo $thumb; ?>" />
                    </div>
                    <h4><?php echo $iconSorted['titre']; ?></h4>
                <?php if ($iconSorted['lien'] && $iconSorted['lien'] != '') { ?>
                </a></li>
                <?php } else { ?>
                </div></li>
                <?php } ?>
            <?php } ?>
        <!-- <li>  
            <a class="item" href="http://givingtuesdaysa.org/" target="_blank">
                <div class="img">
                    <img src="https://givingtuesday.fr/wp-content/uploads/2018/09/Afrique-du-sud-125x99.png" />
                </div>
                <h4>Afrique du sud</h4>
            </a>
        </li>
                <li>
        <div>
            <div class="item">
                <div class="img">
                    <img src="https://givingtuesday.fr/wp-content/uploads/2018/09/Allemagne-125x100.png" />
                </div>
                <h4>Allemagne</h4>
            </div>
        </li>
        <li>
            <a class="item"  href="https://undiaparadar.org.ar/" target="_blank">
                <div class="img">
                    <img src="https://givingtuesday.fr/wp-content/uploads/2018/09/Argentine-125x100.png" />
                </div>
                <h4>Argentine</h4>
            </a>
        </li>
        <li>
            <a class="item"  href="http://givingtuesdayarmenia.org/" target="_blank">
                <div class="img">
                    <img src="https://givingtuesday.fr/wp-content/uploads/2018/09/Armenie-125x100.png" />
                </div>
                <h4>Arménie</h4>
            </a>
        </li>
        <li>
            <a class="item"  href="https://twitter.com/GivingTuesAUS " target="_blank">
                <div class="img">
                    <img src="https://givingtuesday.fr/wp-content/uploads/2018/09/Australie-125x98.png" />
                </div>
                <h4>Australie</h4>
            </a>
        </li>
        <li>
            <a class="item"  href="https://www.facebook.com/GivingTuesdayBarbados/" target="_blank">
                <div class="img">
                    <img src="https://givingtuesday.fr/wp-content/uploads/2018/09/Barbade-125x99.png" />
                </div>
                <h4>Barbade</h4>
            </a>
        </li>
        <li>
            <a class="item"  href="http://www.diadedoar.org.br/" target="_blank">
                <div class="img">
                    <img src="https://givingtuesday.fr/wp-content/uploads/2018/09/Bresil-125x102.png" />
                </div>
                <h4>Brésil</h4>
            </a>
        </li>
        <li>
            <a class="item"  href="http://givingtuesday.ca/" target="_blank">
                <div class="img">
                    <img src="https://givingtuesday.fr/wp-content/uploads/2018/09/Canada-125x100.png" />
                </div>
                <h4>Canada</h4>
            </a>
        </li>
        <li>
            <a class="item"  href="https://www.givingtuesday.cl/" target="_blank">
                <div class="img">
                    <img src="https://givingtuesday.fr/wp-content/uploads/2018/09/Chilie-125x100.png" />
                </div>
                <h4>Chili</h4>
            </a>
        </li>
        <li>
            <a class="item"  href="https://www.givingtuesdaycroatia.eu/" target="_blank">
                <div class="img">
                    <img src="https://givingtuesday.fr/wp-content/uploads/2018/09/Croatie-125x108.png" />
                </div>
                <h4>Croatie</h4>
            </a>
        </li>
        <li>
            <a class="item" href="http://givingtuesday.es/" target="_blank">
                <div class="img">
                    <img src="https://givingtuesday.fr/wp-content/uploads/2018/09/Espagne-125x97.png" />
                </div>
                <h4>Espagne</h4>
            </a>
        </li> 
        -->
    </ul>
    <div class="faq__btn">
<!--        <a href="--><?php //echo get_field('bouton_lien','option'); ?><!--" class="btn"><span>--><?php //echo get_field('bouton_text','option'); ?><!--</span></a>-->
        <a href="<?php echo get_field('bouton_lien','option'); ?>" class="btn"><span>JE REJOINS <br>LE MOUVEMENT MONDIAL</span></a>
        <a href="https://givingtuesday.fr/je-publie-mon-action" class="bnt-action-page-footer">JE PUBLIE MON ACTION</a>
    </div>
</div>