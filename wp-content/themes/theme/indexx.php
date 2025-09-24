<?php get_header(); ?>
<?php setlocale(LC_ALL,'fr_FR.utf-8'); ?>
<?php 
function gt_src($field, $post_id='option') {
  $v = get_field($field, $post_id);
  if (empty($v)) return ['url'=>'', 'type'=>''];

  // ACF: Array / ID / URL
  if (is_array($v)) {
    $url  = $v['url'] ?? '';
    $type = $v['mime_type'] ?? (!empty($v['ID']) ? get_post_mime_type($v['ID']) : '');
  } elseif (is_numeric($v)) {
    $url  = wp_get_attachment_image_url($v, 'full') ?: '';
    $type = get_post_mime_type($v) ?: '';
  } else { // URL
    $url  = $v;
    $path = parse_url($url, PHP_URL_PATH);
    $ext  = $path ? strtolower(pathinfo($path, PATHINFO_EXTENSION)) : '';
    $type = in_array($ext, ['webp','avif']) ? 'image/'.$ext : '';
  }

  // On garde type seulement pour AVIF/WEBP (sinon on l'omet)
  if (!in_array($type, ['image/avif','image/webp'])) $type = '';
  return ['url'=>$url, 'type'=>$type];
}

$m = gt_src('version_mobile_slide1');
$t = gt_src('version_tablette_slide1');
$d = gt_src('version_desktop_slide1');
$f = gt_src('version_fallback_slide1');
?>
<div class="block block__frontpage block--banner">
    <div class="block--banner__slider--background">
        <div class="block--banner__slider--sunshine">
            <div class="block--banner__slider">
                <div class="slide-block slide-block associations">
                    <picture>
                    <?php if ($m['url']): ?>
                        <source media="(max-width: 767px)" srcset="<?= esc_url($m['url']) ?>"<?= $m['type'] ? ' type="'.$m['type'].'"' : '' ?>>
                    <?php endif; ?>
                    <?php if ($t['url']): ?>
                        <source media="(min-width: 768px) and (max-width: 1300px)" srcset="<?= esc_url($t['url']) ?>"<?= $t['type'] ? ' type="'.$t['type'].'"' : '' ?>>
                    <?php endif; ?>
                    <?php if ($d['url']): ?>
                        <source media="(min-width: 1301px)" srcset="<?= esc_url($d['url']) ?>"<?= $d['type'] ? ' type="'.$d['type'].'"' : '' ?>>
                    <?php endif; ?>
                    <img
                        src="<?= esc_url($f['url'] ?: $d['url'] ?: $t['url'] ?: $m['url']) ?>"
                        alt="Giving Tuesday"
                        decoding="async" fetchpriority="high"
                        style="width:100%;height:100%;object-fit:cover;object-position:center;display:block;">
                    </picture>
                    
                </div>
                <div class="slide-block slide-block entreprises">
                     <picture>
                        <!-- Version mobile -->
                        <source media="(max-width: 767px)" srcset="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-entreprises-sm.webp" type="image/webp">

                        <!-- Version tablette -->
                        <source media="(min-width: 768px) and (max-width: 1300px)" srcset="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-entreprises.webp" type="image/webp">

                        <!-- Version desktop -->
                        <source media="(min-width: 1301px)" srcset="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-entreprises.webp" type="image/webp">

                        <!-- Fallback (desktop ou si les media queries ne marchent pas) -->
                        <img src="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-entreprises.png" alt="Giving Tuesday" style="height: 100%; width:100%; object-fit:cover; object-position:center; display:block;">
                    </picture> 
                    
                </div>
                <div class="slide-block slide-block particuliers">
                    
                     <picture>
                        <!-- Version mobile -->
                        <source media="(max-width: 767px)" srcset="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-particuliers-sm.webp" type="image/webp">

                        <!-- Version tablette -->
                        <source media="(min-width: 768px) and (max-width: 1300px)" srcset="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-particuliers.webp" type="image/webp">

                        <!-- Version desktop -->
                        <source media="(min-width: 1301px)" srcset="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-particuliers.webp" type="image/webp">

                        <!-- Fallback (desktop ou si les media queries ne marchent pas) -->
                        <img src="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-particuliers.png" alt="Giving Tuesday" style="height: 100%; width:100%; object-fit:cover; object-position:center; display:block;">
                    </picture> 
                   
                </div>
                <div class="slide-block slide-block parents-enseignants">
                   
                     <picture>
                        <!-- Version mobile -->
                        <source media="(max-width: 767px)" srcset="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-parents-sm.webp" type="image/webp">

                        <!-- Version tablette -->
                        <source media="(min-width: 768px) and (max-width: 1300px)" srcset="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-parents.webp" type="image/webp">

                        <!-- Version desktop -->
                        <source media="(min-width: 1301px)" srcset="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-parents.webp" type="image/webp">

                        <!-- Fallback (desktop ou si les media queries ne marchent pas) -->
                        <img src="https://webdevserver.fr/givingtuesday/wp-content/themes/theme/images/hero/slide-parents.png" alt="Giving Tuesday" style="height: 100%; width:100%; object-fit:cover; object-position:center; display:block;">
                    </picture>                         
                    
                </div>
            </div>
        </div>
    </div>
    <div class="text">
        <img src="<?php the_field('logo-top','option'); ?>" alt="#GIVINGTUESDAY">
<!--        <p><span>--><?php //the_field('text-top','option'); ?><!--</span>-->
<!--            --><?php //$date = get_field('date', 'option');  ?>
<!--            --><?php //echo 'Continuez à être généreux auprès de vos associations et... RDV le 03 décembre 2019';//strftime('%d %B %G', strtotime($date)); ?>
<!---->
<!--        </p>-->
        <div class="date">
            <?php echo $o_fields['date'];?>
        </div>
        <h1><?php echo $o_fields['text-top'];?></h1>
        
        <div class="btn--wrapper">
            <a href="#" class="btn form-scroll-btn">
                <span><?php the_field('cta_bouton_text','option'); ?></span>
            </a>
        </div>
        <?php 
        $date = $o_fields['date_copie'];
        if (strftime('%G-%m-%d', current_time('timestamp',0)) == date('Y-m-d',strtotime($date)) ) { ?>
<!--        <div class="counter" id="timer">-->
<!--            <div class="item">-->
<!--                <span class="time">0</span>-->
<!--                <span class="time-text">jours</span>-->
<!--            </div>-->
<!--            <div class="item">-->
<!--                <span class="time">0</span>-->
<!--                <span class="time-text">heures</span>-->
<!--            </div>-->
<!--            <div class="item">-->
<!--                <span class="time">0</span>-->
<!--                <span class="time-text">Minutes</span>-->
<!--            </div>-->
<!--            <div class="item">-->
<!--                <span class="time">0</span>-->
<!--                <span class="time-text">secondes</span>-->
<!--            </div>-->
<!--        </div>-->
    </div>
    <?php } else { ?>
<!--    <div class="counter" id="timer">-->
<!--        <div class="item">-->
<!--            <span class="time"></span>-->
<!--            <span class="time-text"></span>-->
<!--        </div>-->
<!--        <div class="item">-->
<!--            <span class="time"></span>-->
<!--            <span class="time-text"></span>-->
<!--        </div>-->
<!--        <div class="item">-->
<!--            <span class="time"></span>-->
<!--            <span class="time-text"></span>-->
<!--        </div>-->
<!--        <div class="item">-->
<!--            <span class="time"></span>-->
<!--            <span class="time-text"></span>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="btn--wrapper">-->
<!--        <a href="--><?php //the_field('cta_bouton_lien','option'); ?><!--" class="btn form-scroll-link">-->
<!--            <span>--><?php //the_field('cta_bouton_text','option'); ?><!--</span>-->
<!--        </a>-->
<!--    </div>-->
    </div>
<?php } ?>
    <div class="block--banner__links">
        <ul class="block--banner__links__wrap">

            <?php
            $tempCounter = 0;
            foreach ($o_fields['header_select'] as $field): ?>
                <li class="block--banner__link <?php if($tempCounter<1){echo 'isActive';} ++$tempCounter; ?>">
                    <a href="<?php echo $field['lien'];?>">
                        Je suis <br> <?php echo $field['texte'];?>
                    </a>
                </li>
            <?php endforeach; ?>


<!--            <li><a class="block--banner__link isActive" href="/comment-participer/particulier/">Je suis <br>un particulier</a></li>-->
<!--            <li><a class="block--banner__link" href="/comment-participer/association-fondation-osbl/">Je suis une association <br>/ une fondation / une OSBL</a></li>-->
<!--            <li><a class="block--banner__link" href="/comment-participer/entreprise/">Je suis <br>une entreprise</a></li>-->
<!--            <li><a class="block--banner__link" href="/comment-participer/parent-enseignant/">Je suis <br>un parent / un enseignant</a></li>-->
        </ul>
    </div>
</div>
<div class="block block__frontpage block__frontpage--intro">
<!--    <p><a href="--><?php //the_field('pdf-top','option'); ?><!--" title="le bilan de la 1ère édition ici" target="_blank">Découvrez le bilan de la 1ère édition ici !</a></p>-->
    <div class="block__frontpage--intro__top">
        <h2>Rendez-vous le <?php echo $o_fields['date'];?> pour la huitième édition&nbsp;!</h2>
        <div class="counter" id="timer">
            <div class="item">
                <span class="time">0</span>
                <span class="time-text">jours</span>
            </div>
            <div class="item">
                <span class="time">0</span>
                <span class="time-text">heures</span>
            </div>
            <div class="item">
                <span class="time">0</span>
                <span class="time-text">min.</span>
            </div>
            <div class="item">
                <span class="time">0</span>
                <span class="time-text">sec.</span>
            </div>
        </div>

        <script>
            //const endDate = new Date(<?php echo date('Y', strtotime($date)); ?>, <?php echo date('m', strtotime($date))-1; ?>, <?php echo date('d', strtotime($date)); ?>).getTime();
            const endDate = new Date(2025, 11, 03).getTime();
            //console.log(endDate);


            function dateHtml(endDate) {
                const today = new Date().getTime();

                // get the difference
                const diff = endDate - today;

                // math
                let days = Math.floor(diff / (1000 * 60 * 60 * 24));
                let hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                if (minutes < 10) {
                    minutes = '0'+minutes;
                }
                let seconds = Math.floor((diff % (1000 * 60)) / 1000);
                if (seconds < 10) {
                    seconds = '0'+seconds;
                }
                // display
                document.getElementById("timer").innerHTML =
                    "<div class=\"item\">" +
                    "<span class=\"time\">" + days + "</span>" +
                    "<span class=\"time-text\">jours</span></div>" +
                    "<div class=\"item\">" +
                    "<span class=\"time\">" + hours + "</span>" +
                    "<span class=\"time-text\">heures</span></div>" +
                    "<div class=\"item\">" +
                    "<span class=\"time\">" + minutes + "</span>" +
                    "<span class=\"time-text\">min.</span></div>" +
                    "<div class=\"item\">" +
                    "<span class=\"time\">" + seconds + "</span>" +
                    "<span class=\"time-text\">sec.</span></div>";
            }
            dateHtml(endDate);
            // countdown
            let timer = setInterval(function() {
                dateHtml(endDate);
            }, 1000);
        </script>
    </div>
    <div class="block__frontpage--intro__bottom">
        <img class="block__frontpage--intro__logo" src="<?php echo get_field('logo', 'option'); ?>" alt="Giving Tuesday">
<!--        <div class="block__frontpage--intro__left" style="background-image: url('wp-content/themes/theme/images/front/bg-intro.jpg')"></div>-->
        <div class="block__frontpage--intro__left" style="background-image: url('<?php echo $o_fields['sb_deux_bg']; ?>')"></div>
        <div class="block__frontpage--intro__right">
            <?php
            echo $o_fields['sb_gros_texte'];
            ?>
<!--            <p><strong><span class="hashtag">#GivingTuesday</span><br> est un mouvement mondial qui célèbre et encourage la générosité, l'engagement et la solidarité.</strong></p>-->
<!--            <p>Que vous soyez un particulier, une organisation à but non lucratif, une école, une institution ou une entreprise <strong>rejoignez le mouvement&nbsp;!</strong></p>-->
<!--            <p><strong>Vous aussi donnez</strong> du temps, de l'argent, des objets, de la nourriture, du sang, des compétences ou tout simplement de la voix <strong>pour rendre le monde meilleur&nbsp;!</strong></p>-->
<!--            <p>Soutenu en France pour sa 2<sup>ème</sup> édition par&nbsp;:</p>-->
            <ul class="block__frontpage--intro__logos">

                <?php foreach ($o_fields['slider'] as $slide): ?>
                    <li><a href="<?php echo $slide['Lien']; ?>" target="_blank"><img src="<?php echo $slide['image']['url']; ?>" alt="<?php echo $slide['image']['alt']; ?>"></a></li>
                <?php endforeach; ?>

<!--                <li><a href="https://www.fondationcarasso.org/" target="_blank"><img src="/wp-content/themes/theme/images/front/logo-carasso.png" alt="Carasso"></a></li>-->
<!--                <li><a href="https://www.fondationdefrance.org/fr" target="_blank"><img src="/wp-content/themes/theme/images/front/logo-fondation-france.png" alt="Fondation de France"></a></li>-->
<!--                <li><a href="https://www.salesforce.com/fr/" target="_blank"><img src="/wp-content/themes/theme/images/front/logo-salesforce.png" alt="salesforce"></a></li>-->
            </ul>
        </div>
    </div>

        <div class="block__frontpage--intro__mention">
       <!--  <img class="block__frontpage--intro__logo" src="<?php echo get_field('logo', 'option'); ?>" alt="Giving Tuesday"> -->

        <div class="block__frontpage--intro__rightinverted" >

<?php
            echo $o_fields['mention_texte'];
            ?>

            <ul class="block__frontpage--intro__logos">

                <?php foreach ($o_fields['mention-label'] as $slide): ?>
                    <li><a href="<?php echo $slide['lien']; ?>" target="_blank"><img src="<?php echo $slide['image']['url']; ?>" alt="<?php echo $slide['image']['alt']; ?>"></a></li>
                <?php endforeach; ?>


            </ul>

        </div>
        <div class="block__frontpage--intro__leftinverted" style="background-image: url('<?php echo $o_fields['mention_background']; ?>')">
            
        </div>
    </div>

</div>
<div class="block block__frontpage block__frontpage--actus">
    <h2 class="block__frontpage--actus__title"><?php the_field('actu_bloc_titre','option'); ?></h2>
    <div class="block__frontpage--actus__slider slick-slider">
        <div class="block__frontpage--actus__slider__inner">
            <?php $alaune = new WP_Query(array(
                'posts_per_page' => 3,
                'post_type' => 'post',
                'orderby' => 'date',
                'order' => 'DESC'
            )); ?>
            <?php while ($alaune->have_posts()) : $alaune->the_post(); ?>
                <div class="slide-block">
                    <div class="slide-block__inner">
                        <div class="slide-block__header">
                            <div class="slide-block__img"><?php the_post_thumbnail('actu-thumb'); ?></div>
                            <h3 class="slide-block__title"><?php the_title(); ?></h3>
                        </div>
                        <p class="slide-block__text"><?php the_field('exceprt'); ?></p>
                        <a class="slide-block__link" href="<?php the_permalink(); ?>">Lire la suite</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <ul class="custom-slick-dots slick-dots">
            <li>
                <button type="button" tabindex="1">1</button>
            </li>
            <li class="slick-active">
                <button type="button" tabindex="2">2</button>
            </li>
            <li>
                <button type="button" tabindex="3">3</button>
            </li>
        </ul>
        <button class="custom-slick-prev slick-prev slick-arrow" type="button">Previous</button>
        <button class="custom-slick-next slick-next slick-arrow" type="button">Next</button>
    </div>
    <div class="block__frontpage--actus__footer">
        <a class="block__frontpage--actus__footer__link" href="<?php echo get_page_link(23); ?>">Voir toutes les actualités</a>
    </div>
</div>
<!--<div class="block block__form" --><?php //echo 'style="background-image:url('.get_field('form_fond','33').')"'; ?><!-->
<div class="block block__form" style="background-image:url('<?php echo $o_fields['universal_form_image']['url']; ?>')";>
<!--<div class="block block__form" style="background-image:url('wp-content/themes/theme/images/front/bg-form.jpg')";>-->
    <a id="block-form"></a>
    <div class="wrap-container">
        <div class="form-wrapper">
<!--            <header style="background-image:url('wp-content/themes/theme/images/front/bg-form-sm.jpg')">-->
            <header style="background-image:url('<?php echo $o_fields['universal_form_image']['url']; ?>')">
                <?php echo $o_fields['universal_texte'];//echo get_field('form_title','33'); ?>
<!--                <h2>Rejoignez le mouvement <br> <span>#GivingTuesday</span> et participez <br>à l’élan mondial en faveur de la générosité&nbsp;!</h2>-->
<!--                <p>En nous laissant vos coordonnées, vous pourrez recevoir les dernières informations, <br>des idées et des outils pour vous engager à l’occasion de la journée mondiale de la générosité&nbsp;!</p>-->
            </header>
            <div class="merci-popup">
                <span class="close-popup"><i class="fas fa-times"></i></span>
                <div><?php echo get_field('merci_texte',33); ?></div>
            </div>
            <div class="block-form">
                <form action="" class="form" method="post">
                    <div class="form__left">
                        <div class="form-item__title">Je suis :</div>
                        <div class="form-item form-item__radio-text">
                            <div class="item">
                                <input name="radio-text" value="individus" id="radio-individus" <?php  echo 'checked="checked"'; ?> type="radio"/>
                                <label for="radio-individus">un particulier</label>
                            </div>
                            <div class="item">
                                <input name="radio-text" value="associations" id="radio-associations" type="radio"/>
                                <label class="two-line" for="radio-associations">une association <br>/ une fondation</label>
                                <div class="form-item form-item__text">
                                    <input type="text" name="associations2" placeholder="Intitulé de poste" />
                                    <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                                    <input type="text" name="associations" placeholder="Nom de la structure" />
                                    <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                                </div>
                            </div>
                            <div class="item">
                                <input name="radio-text" value="entreprises" id="radio-entreprises"  type="radio"/>
                                <label for="radio-entreprises">une entreprise</label>
                                <div class="form-item form-item__text">
                                    <input type="text" name="entreprises2" placeholder="Intitulé de poste" />
                                    <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                                    <input type="text" name="entreprises" placeholder="Nom de l’entreprise" />
                                    <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                                </div>
                            </div>
                            <div class="item">
                                <input name="radio-text" value="parent" id="radio-parent"  type="radio"/>
                                <label for="radio-parent">un parent / un enseignant</label>
                                <div class="form-item form-item__text">
                                    <input type="text" name="parent" placeholder="Nom de l'établissement" />
                                    <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form__right">
                        <div class="form-item__title">Mes coordonnées :</div>
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
                        <p><?php echo get_field('form_mentions_legal_text',33); ?></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="block block__frontpage block__frontpage--block-social">
    <div class="inner-wrapper">
        <h2><?php the_field('rsb_titre','option'); ?></h2>
        <ul class="social-manual">
            <li>
                <div class="text-block"><?php the_field('rsb_bloc1','option'); ?></div>
            </li>
            <li>
                <div class="text-block"><?php the_field('rsb_bloc2','option'); ?></div>
            </li>
            <li>
                <div class="text-block"><?php the_field('rsb_bloc3','option'); ?></div>
            </li>
        </ul>
        <div class="social-links-block">
            <ul>
                <li>
                    <a target="_blank" href="<?php the_field('facebook_lien_image','option'); ?>"><i class="fab fa-facebook-f"></i></a>
                </li>
                <li>
                    <a target="_blank" href="<?php the_field('twitter_lien_image','option'); ?>"><i class="fab fa-x-twitter"></i></a>
                </li>
            </ul>
        </div>
        <div class="social-frame-wrapper">
            <div id="flockler_container"></div>
            <script type="text/javascript">
                var postCount = 6;
                if (jQuery(window).width() < 992) {
                    postCount = 3;
                }

                var _flockler = _flockler || [];
                _flockler.push({
                    count: postCount,
                    refresh: 0,
                    site: 5710,
                    loadMoreText: 'En voir plus',
                    style: 'wall'
                });
                (function(d){var f = d.createElement('script');f.async=1;f.src='https://embed-cdn.flockler.com/embed-v2.js';s=d.getElementsByTagName('script')[0];s.parentNode.insertBefore(f,s);})(document);
            </script>
        </div>
    </div>
</div>
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
<?php get_footer(); ?>
