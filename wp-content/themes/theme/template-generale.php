<?php /*
Template Name: Page Génerale
*/
get_header();
$o_fields = get_fields('options');
$fields = get_fields();
?>
<div class="section-generale">
<!--    --><?php //get_template_part('parts/generale','heading'); ?>
<!--    <div class="blocks-wrapper">-->
<!--    --><?php //// go for content blocks
//        $contentBlocks = get_field('content_blocks');
//        foreach ($contentBlocks as $contentBlock) {
//            include( locate_template( 'parts/generale-'.$contentBlock['type'].'.php' , false, false));
//        } ?>
<!--    </div>-->

    <div class="block block--banner block--banner--section">
        <div class="block--banner__inner">
            <div class="block--banner__bg block--banner__bg"></div>
        </div>
        <div class="text">
            <img src="<?php the_field('logo-top','option'); ?>" alt="#GIVINGTUESDAY">
            <div class="date"><?php echo $fields['block_1_date']; ?></div>
            <h1><?php echo $fields['block_1_title']; ?></h1>
            <div class="btn--wrapper">
                <a href="#" class="btn form-scroll-btn">
                    <span><?php the_field('cta_bouton_text','option'); ?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="block--reasons">
        <div class="wrap">
            <?php echo $fields['block_2_content']; ?>
            <img class="block--reasons__logo" src="<?php echo get_field('logo', 'option'); ?>" alt="Giving Tuesday">
        </div>
    </div>
    <div class="block--ideas">
        <div class="wrap">
            <h2 class="block--ideas__title"><?php echo $fields['block_3_title']; ?></h2>
            <ul class="block--ideas__list" data-no-slick="1">
                <?php foreach ($fields['block_3_repeater'] as $field): ?>
                    <li class="block--ideas__item">
                        <div class="block--ideas__icon">
                            <img src="<?php echo $field['image']['url']; ?>" alt="<?php echo $field['image']['alt']; ?>">
                        </div>
                        <h3 class="block--ideas__item__title"><?php echo $field['text']; ?></h3>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a class="block--ideas__link" href="/comment-participer/actions-a-decouvrir/">Découvrir toutes les actions déjà mises en place</a>
        </div>
    </div>
        <div class="block--partners">
        <div class="wrap">
            <h2 class="block--partners__title"><?php echo $fields['block_6_title']; ?></h2>
            <ul class="block--partners__list">
                 <?php foreach ($fields['block_6_repeater'] as $field): ?>
                    <li class="block--partners__item">
                        <div class="block--partners__icon">
                            <img src="<?php echo $field['image']['url']; ?>" alt="<?php echo $field['image']['alt']; ?>">
                        </div>
                        <h3 class="block--partners__item__title"><?php echo $field['text']; ?></h3>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<!--     <div class="block--download-files">
        <h2 class="block--download-files__title"><?php echo $fields['block_4_title']; ?></h2>
        <div class="block--download-files__content">
            <ul class="block--download-files__list">

                <?php foreach ($fields['block_4_repeater'] as $field): ?>
                    <li class="block--download-files__item">
                        <div class="block--download-files__item__inner">
                            <img class="block--download-files__img" src="<?php the_field('logo-top','option'); ?>" alt="#GIVINGTUESDAY">
                            <div class="block--download-files__file"><?php echo $field['texte']; ?></div>
                            <a class="block--download-files__link download-link" href="<?php echo $field['file']; ?>"><span><?php echo $field['button_texte']; ?></span></a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <img class="block--download-files__bg" src="<?php echo $fields['block_4_bg']['url']; ?>" alt="">
        </div>
    </div> -->



    <?php if (is_page(126) || is_page(33) || is_page(35) || is_page(1619) ) : ?>
    <div class="block block__form block__form--2">
        <a id="block-form"></a>
        <div class="wrap-container">
            <div class="form-wrapper">
                <header>
                    <?php //echo get_field('form_title'); ?>
                    <h2>Rejoignez le mouvement <br> <span>#GivingTuesday</span> et participez <br>à l’élan mondial en faveur de la générosité&nbsp;!</h2>
                    <p>En nous laissant vos coordonnées, vous pourrez recevoir les dernières informations, <br>des idées et des outils pour vous engager à l’occasion de la journée mondiale de la générosité&nbsp;!</p>
                </header>
                <div class="merci-popup">
                    <span class="close-popup"><i class="fas fa-times"></i></span>
<!--                    <div>--><?php //echo get_field('merci_texte'); ?><!--</div>-->
                    <div><?php echo get_field('merci_texte',33); ?></div>
                </div>
                <div class="block-form">
                    <?php if (is_page(126)) : ?>
                        <div class="sponsor">
                            Avec le soutien de<br/>
                            <a href="https://www.salesforce.org/fr/home/" target="_blank"><img src="/wp-content/uploads/2020/10/Salesforce_2020_petit.png" alt=""></a>
                        </div>
                    <?php endif; ?>
                    <form action="" class="form" method="post">
                        <?php if(is_page(33)) :?>
                            <input name="radio-text" value="entreprises" id="radio-entreprises" <?php  echo 'checked="checked"'; ?> type="radio" style="display:none;"/>
                        <?php endif; ?>
                        <?php if(is_page(35)) :?>
                            <input name="radio-text" value="individus" id="radio-individus" <?php  echo 'checked="checked"'; ?> type="radio" style="display:none;"/>
                        <?php endif; ?>
                        <?php if(is_page(126)) :?>
                            <input name="radio-text" value="associations" id="radio-associations" <?php  echo 'checked="checked"'; ?> type="radio" style="display:none;"/>
                        <?php endif; ?>
                        <?php if(is_page(1619)) :?>
                            <input name="radio-text" value="parent" id="radio-parent" <?php  echo 'checked="checked"'; ?> type="radio" style="display:none;"/>
                        <?php endif; ?>


<!--                        add type of form here-->
                        <div class="form__right">
                            <div class="form-item__title">Mes coordonnées :</div>


                            <?php if(is_page(33)) :?>
                                <div class="form-item">
                                    <div class="form-item form-item__text">

                                        <input type="text" name="entreprises" placeholder="Nom de l’entreprise">
                                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>

                                        <input type="text" name="entreprises2" placeholder="Intitulé de poste" />
                                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                                    </div>

                                </div>
                            <?php endif; ?>
                            <?php if(is_page(126)) ://ok?>
                                <div class="form-item">
                                    <div class="form-item form-item__text">

                                        <input type="text" name="associations" placeholder="Nom de la structure" />
                                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>

                                        <input type="text" name="entreprises2" placeholder="Intitulé de poste" />
                                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if(is_page(1619)) :?>
                                <div class="form-item">
                                    <div class="form-item form-item__text">
                                        <input type="text" name="parent" placeholder="Nom de l'établissement">
                                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                                    </div>
                                </div>
                            <?php endif; ?>


                            <div class="form-item form-item__radio">
                                <div class="item">
                                    <input name="radio" id="radio-madame" value="Madame" type="radio"/>
                                    <label for="radio-madame">Madame</label>
                                </div>
                                <div class="item">
                                    <input name="radio" id="radio-monsieur" value="Monsieur" type="radio"/>
                                    <label for="radio-monsieur">Monsieur</label>
                                </div>
                            </div>
                            <div class="block-text-items">
                                <div class="form-item form-item__text form-item__text--prenom">
                                    <input type="text" name="prenom" placeholder="Prénom" />
                                    <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                                </div>
                                <div class="form-item form-item__text form-item__text--nom">
                                    <input type="text" name="nom" placeholder="Nom" />
                                    <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                                </div>
                            </div>
                            <div class="form-item form-item__text">
                                <input type="text" name="email" placeholder="Adresse e-mail" />
                                <div class="error_text">Veuillez inclure un nom de domaine dans l'adresse e-mail.</div>
                            </div>
                            <div class="btn">
                                <button type="submit"><span>Je rejoins<br> le mouvement mondial</span></button>
                            </div>
                            <p><?php echo get_field('form_mentions_legal_text'); ?></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (is_page(126) || is_page(33) || is_page(35) || is_page(1619) ) {} else { ?>
    <div class="faq__btn">
        <a href="<?php echo get_field('bouton_lien','option'); ?>" class="btn"><span><?php echo get_field('bouton_text','option'); ?></span></a>
    </div>
    <?php } ?>
    <div class="block block__frontpage block__frontpage--block-banners">
        <h2><?php the_field('saadl_titre','option'); ?></h2>
        <ul class="banners-block">
            <?php foreach (get_field('logos','option') as $logo) { ?>
                <li>
                    <?php if ($logo['lien']) { ?>
                        <a href="<?php echo $logo['lien']; ?>" target="_blank" class="block-wrapper">
                            <img src="<?php echo $logo['logo']; ?>" alt="">
                        </a>
                    <?php } else { ?>
                        <div class="block-wrapper">
                            <img src="<?php echo $logo['logo']; ?>" alt="">
                        </div>
                    <?php } ?>

                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<?php get_footer(); ?>


