<div class="block__presse block__presse--content">
    <div class="inner-wrapper">
        <div class="block-title-page"><?php the_title(); ?></div>

        <div class="block__presse--content-block">
            <div class="block__presse--content-block__top">
                <div class="block__presse--content-block__title">
                    <h2>Communiqués de presse</h2>
                </div>
                <div class="block__presse--content-block__list">
                    <ul class="presse-list">
                        <?php
                        $actualites = get_field('actualites');
                        $actuCount = count($actualites);
                        foreach ($actualites as $key => $actu) {
                            if ($key > 3) {
                                $class = 'isHidden';
                            } else {
                                if ($actuCount < 4) {
                                    if ($key < 2) {
                                        $class = '';
                                    } else {
                                        $class = 'isHidden';
                                    }

                                } else {
                                    if ($key >= 4) {
                                        $class = 'isHidden';
                                    } else {
                                        $class = '';
                                    }
                                }


                            }

                            ?>
                        <li class="<?php echo $class; ?>">
                            <a class="news-block" href="<?php echo get_the_permalink($actu->ID); ?>">
                                <div class="img-block">
                                    <?php echo get_the_post_thumbnail($actu->ID, 'actu-thumb'); ?>
                                    <?php if (get_field('tag', $actu->ID)) { ?>
                                    <div class="status">#<?php the_field('tag', $actu->ID); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="text-block">
                                    <div class="news-title"><?php echo get_the_title($actu->ID); ?></div>
                                    <div class="text"><?php the_field('exceprt', $actu->ID); ?></div>
                                    <div class="link-block">
                                        <span>Lire la suite</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php
                    $moreClass = '';
                    if ($actuCount == 2 || $actuCount == 4) {
                        $moreClass = 'isHidden';
                    } ?>
                    <div class="presse-read-more <?php echo $moreClass; ?>" id="presse-read-more-01"><a href="#">Voir
                            plus de communiqués</a></div>
                </div>
            </div>
            <div class="block__presse--content-block__bottom">
                <div class="block__presse--content-block__title">
                    <h2>Revue de presse</h2>
                </div>
                <div class="block__presse--content-block__list-2">
                    <ul class="presse-list-2">
                        <?php $presse = get_field('communique_de_presse'); $presseCount = count($presse); ?>
                        <?php foreach ($presse as $key => $press) {  ?>
                        <li <?php if ($key >= 5) { echo 'class="isHidden"'; }  ?>>
                            <div class="press-block">
                                <div class="discription-block">
                                    <a target="_blank"
                                        href="<?php echo $press['lien']; ?>"><?php echo $press['titre']; ?></a>
                                </div>
                                <div class="author-block">
                                    <span class="author"><?php echo $press['nom_media'] ?></span><span
                                        class="date"><?php echo date('d.m.Y', strtotime($press['date'])); ?></span>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php
                    $class = '';
                    if ($presseCount < 5) {
                        $class = 'isHidden';
                    } ?>
                    <div class="presse-read-more <?php echo $class; ?>" id="presse-read-more-02"><a href="#">Afficher
                            plus d’articles</a></div>
                </div>
            </div>
        </div>


        <div class="block__presse--contact-block">
            <div class="block__presse--contact-block__title">
                <h2>Vos contacts privilégiés&nbsp;:</h2>
            </div>
            <div class="block__presse--contact-block__list">
                <?php $contacts = get_field('contacts_privilegies'); ?>
                <ul>
                    <li>
                        <div class="img-block"><img src="<?php echo $contacts['bloc_1_image']['sizes']['medium']; ?>"
                                alt=""></div>
                        <div class="text-block">
                            <div class="name-block"><?php echo $contacts['bloc_1_nom']; ?></div>
                            <div class="mail-block"><a
                                    href="mailto:<?php echo $contacts['bloc_1_email']; ?>"><?php echo $contacts['bloc_1_email']; ?></a>
                            </div>
                            <?php if ($contacts['bloc_1_telephone']) { ?>
                            <div class="aff-block">AFF : <a
                                    href="tel:+33<?php echo str_replace('.','',$contacts['bloc_1_telephone']); ?>"><?php echo $contacts['bloc_1_telephone']; ?></a>
                            </div>
                            <?php } ?>
                        </div>
                    </li>
                    <li>
                        <div class="img-block"><img src="<?php echo $contacts['bloc_2_image']['sizes']['medium']; ?>"
                                alt=""></div>
                        <div class="text-block">
                            <div class="name-block"><?php echo $contacts['bloc_2_nom']; ?></div>
                            <div class="mail-block"><a
                                    href="mailto:<?php echo $contacts['bloc_2_email']; ?>"><?php echo $contacts['bloc_2_email']; ?></a>
                            </div>
                            <?php if ($contacts['bloc_2_telephone']) { ?>
                            <div class="aff-block">AFF : <a title=""
                                    href="tel:+33<?php echo str_replace('.','',$contacts['bloc_2_telephone']); ?>"><?php echo $contacts['bloc_2_telephone']; ?></a>
                            </div>
                            <?php } ?>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="social-block">
                <div class="title-block">Pour ne rien manquer de notre actualité, retrouvez-nous sur les réseaux
                    sociaux&nbsp;:</div>
                <ul>
                    <?php $social = get_field('social_links');  ?>
                    <li>
                        <a href="<?php echo $social['facebook']; ?>" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $social['twitter']; ?>" target="_blank">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $social['instagram']; ?>" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $social['youtube']; ?>" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
<div class="block block__frontpage block__frontpage--block-files">
    <?php $tel = get_field('telecharger'); ?>
    <a id="files"></a>
    <div class="inner-wrapper">
        <h2><?php echo trim($tel['titre_du_bloc']);  ?></h2>
        <ul class="download-block">
            <?php foreach ($tel['fichier_blocs'] as $fichier) { ?>
            <li>
                <div class="block-wrapper">
                    <div class="icon-block"><img src="/wp-content/themes/theme/images/logo-2.png" alt=""></div>
                    <div class="title-block"><?php echo trim($fichier['nom']); ?></div>
                    <a href="/download.php?file=<?php echo $fichier['fichier']; ?>"
                        class="download-link"><span><?php echo $fichier['bouton_texte']; ?></span></a>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>