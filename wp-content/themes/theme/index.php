<?php get_header(); ?>
<?php setlocale(LC_ALL,'fr_FR.utf-8'); ?>
<?php $o_fields = get_fields('option'); ?>
<?php
function gt_src($field, $post_id='option') {
  $v = get_field($field, $post_id);
  if (empty($v)) return ['url'=>'', 'type'=>'', 'w'=>null, 'h'=>null];

  $url=''; $type=''; $w=null; $h=null;

  if (is_array($v)) {
    $url  = $v['url'] ?? '';
    $type = $v['mime_type'] ?? '';
    if (!empty($v['ID'])) {
      $meta = wp_get_attachment_metadata($v['ID']);
      if ($meta && !empty($meta['width']) && !empty($meta['height'])) {
        $w = (int)$meta['width']; $h = (int)$meta['height'];
      }
    }
  } elseif (is_numeric($v)) {
    $url  = wp_get_attachment_image_url($v, 'full') ?: '';
    $type = get_post_mime_type($v) ?: '';
    $meta = wp_get_attachment_metadata($v);
    if ($meta && !empty($meta['width']) && !empty($meta['height'])) {
      $w = (int)$meta['width']; $h = (int)$meta['height'];
    }
  } else { // URL directe
    $url  = $v;
    $path = parse_url($url, PHP_URL_PATH);
    $ext  = $path ? strtolower(pathinfo($path, PATHINFO_EXTENSION)) : '';
    $type = in_array($ext, ['webp','avif']) ? 'image/'.$ext : '';
    // pas de dimensions fiables si URL pure → on laisse null
  }

  if (!in_array($type, ['image/avif','image/webp'])) $type = '';
  return ['url'=>$url, 'type'=>$type, 'w'=>$w, 'h'=>$h];
}


$m1 = gt_src('version_mobile_slide1');
$t1 = gt_src('version_tablette_slide1');
$d1 = gt_src('version_desktop_slide1');
$f1 = gt_src('version_fallback_slide1');
$m2 = gt_src('version_mobile_slide2');
$t2 = gt_src('version_tablette_slide2');
$d2 = gt_src('version_desktop_slide2');
$f2 = gt_src('version_fallback_slide2');
$m3 = gt_src('version_mobile_slide3');
$t3 = gt_src('version_tablette_slide3');
$d3 = gt_src('version_desktop_slide3');
$f3 = gt_src('version_fallback_slide3');
$m4 = gt_src('version_mobile_slide4');
$t4 = gt_src('version_tablette_slide4');
$d4 = gt_src('version_desktop_slide4');
$f4 = gt_src('version_fallback_slide4');
?>
<div class="block block__frontpage block--banner">
  <div class="block--banner__slider--background">
    <div class="block--banner__slider--sunshine">
      <div class="block--banner__slider--sunshine-content">
        <div class="block--banner__slider">

          <!-- SLIDE 1 = LCP (eager) -->
          <div class="slide-block">
            <picture>
              <?php if ($m1['url']): ?>
                <source media="(max-width: 767px)" srcset="<?= esc_url($m1['url']) ?>"<?= $m1['type'] ? ' type="'.$m1['type'].'"' : '' ?>>
              <?php endif; ?>
              <?php if ($t1['url']): ?>
                <source media="(min-width: 768px) and (max-width: 1300px)" srcset="<?= esc_url($t1['url']) ?>"<?= $t1['type'] ? ' type="'.$t1['type'].'"' : '' ?>>
              <?php endif; ?>
              <?php if ($d1['url']): ?>
                <source media="(min-width: 1301px)" srcset="<?= esc_url($d1['url']) ?>"<?= $d1['type'] ? ' type="'.$d1['type'].'"' : '' ?>>
              <?php endif; ?>
              <img
                class="hero-image is-lcp"
                src="<?= esc_url($f1['url'] ?: $d1['url'] ?: $t1['url'] ?: $m1['url']) ?>"
                alt="Giving Tuesday"
                <?php if ($d1['w'] && $d1['h']): ?>
                  width="<?= (int)$d1['w'] ?>" height="<?= (int)$d1['h'] ?>"
                <?php elseif ($t1['w'] && $t1['h']): ?>
                  width="<?= (int)$t1['w'] ?>" height="<?= (int)$t1['h'] ?>"
                <?php elseif ($m1['w'] && $m1['h']): ?>
                  width="<?= (int)$m1['w'] ?>" height="<?= (int)$m1['h'] ?>"
                <?php endif; ?>
                loading="eager" decoding="async" fetchpriority="high">
            </picture>
          </div>

          <!-- SLIDE 2 = lazy (data-*) -->
          <div class="slide-block">
            <picture class="js-lazy">
              <?php if ($m2['url']): ?>
                <source media="(max-width: 767px)" data-srcset="<?= esc_url($m2['url']) ?>"<?= $m2['type'] ? ' type="'.$m2['type'].'"' : '' ?>>
              <?php endif; ?>
              <?php if ($t2['url']): ?>
                <source media="(min-width: 768px) and (max-width: 1300px)" data-srcset="<?= esc_url($t2['url']) ?>"<?= $t2['type'] ? ' type="'.$t2['type'].'"' : '' ?>>
              <?php endif; ?>
              <?php if ($d2['url']): ?>
                <source media="(min-width: 1301px)" data-srcset="<?= esc_url($d2['url']) ?>"<?= $d2['type'] ? ' type="'.$d2['type'].'"' : '' ?>>
              <?php endif; ?>
              <img
                class="hero-image"
                data-src="<?= esc_url($f2['url'] ?: $d2['url'] ?: $t2['url'] ?: $m2['url']) ?>"
                alt="Giving Tuesday"
                <?php if ($d2['w'] && $d2['h']): ?>
                  width="<?= (int)$d2['w'] ?>" height="<?= (int)$d2['h'] ?>"
                <?php elseif ($t2['w'] && $t2['h']): ?>
                  width="<?= (int)$t2['w'] ?>" height="<?= (int)$t2['h'] ?>"
                <?php elseif ($m2['w'] && $m2['h']): ?>
                  width="<?= (int)$m2['w'] ?>" height="<?= (int)$m2['h'] ?>"
                <?php endif; ?>
                decoding="async">
            </picture>
                <noscript>
                    <img src="<?= esc_url($f2['url'] ?: $d2['url'] ?: $t2['url'] ?: $m2['url']) ?>" alt="Giving Tuesday">
                </noscript>
          </div>

          <!-- SLIDE 3 = lazy (data-*) -->
          <div class="slide-block">
            <picture class="js-lazy">
              <?php if ($m3['url']): ?>
                <source media="(max-width: 767px)" data-srcset="<?= esc_url($m3['url']) ?>"<?= $m3['type'] ? ' type="'.$m3['type'].'"' : '' ?>>
              <?php endif; ?>
              <?php if ($t3['url']): ?>
                <source media="(min-width: 768px) and (max-width: 1300px)" data-srcset="<?= esc_url($t3['url']) ?>"<?= $t3['type'] ? ' type="'.$t3['type'].'"' : '' ?>>
              <?php endif; ?>
              <?php if ($d3['url']): ?>
                <source media="(min-width: 1301px)" data-srcset="<?= esc_url($d3['url']) ?>"<?= $d3['type'] ? ' type="'.$d3['type'].'"' : '' ?>>
              <?php endif; ?>
              <img
                class="hero-image"
                data-src="<?= esc_url($f3['url'] ?: $d3['url'] ?: $t3['url'] ?: $m3['url']) ?>"
                alt="Giving Tuesday"
                <?php if ($d3['w'] && $d3['h']): ?>
                  width="<?= (int)$d3['w'] ?>" height="<?= (int)$d3['h'] ?>"
                <?php elseif ($t3['w'] && $t3['h']): ?>
                  width="<?= (int)$t3['w'] ?>" height="<?= (int)$t3['h'] ?>"
                <?php elseif ($m3['w'] && $m3['h']): ?>
                  width="<?= (int)$m3['w'] ?>" height="<?= (int)$m3['h'] ?>"
                <?php endif; ?>
                decoding="async">
            </picture>
                <noscript>
                    <img src="<?= esc_url($f3['url'] ?: $d3['url'] ?: $t3['url'] ?: $m3['url']) ?>" alt="Giving Tuesday">
                </noscript>
          </div>

          <!-- SLIDE 4 = lazy (data-*) -->
          <div class="slide-block">
            <picture class="js-lazy">
              <?php if ($m4['url']): ?>
                <source media="(max-width: 767px)" data-srcset="<?= esc_url($m4['url']) ?>"<?= $m4['type'] ? ' type="'.$m4['type'].'"' : '' ?>>
              <?php endif; ?>
              <?php if ($t4['url']): ?>
                <source media="(min-width: 768px) and (max-width: 1300px)" data-srcset="<?= esc_url($t4['url']) ?>"<?= $t4['type'] ? ' type="'.$t4['type'].'"' : '' ?>>
              <?php endif; ?>
              <?php if ($d4['url']): ?>
                <source media="(min-width: 1301px)" data-srcset="<?= esc_url($d4['url']) ?>"<?= $d4['type'] ? ' type="'.$d4['type'].'"' : '' ?>>
              <?php endif; ?>
              <img
                class="hero-image"
                data-src="<?= esc_url($f4['url'] ?: $d4['url'] ?: $t4['url'] ?: $m4['url']) ?>"
                alt="Giving Tuesday"
                <?php if ($d4['w'] && $d4['h']): ?>
                  width="<?= (int)$d4['w'] ?>" height="<?= (int)$d4['h'] ?>"
                <?php elseif ($t4['w'] && $t4['h']): ?>
                  width="<?= (int)$t4['w'] ?>" height="<?= (int)$t4['h'] ?>"
                <?php elseif ($m4['w'] && $m4['h']): ?>
                  width="<?= (int)$m4['w'] ?>" height="<?= (int)$m4['h'] ?>"
                <?php endif; ?>
                decoding="async">
            </picture>
                <noscript>
                    <img src="<?= esc_url($f4['url'] ?: $d4['url'] ?: $t4['url'] ?: $m4['url']) ?>" alt="Giving Tuesday">
                </noscript>
          </div>

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

        </div>
        <h1><?php echo $o_fields['text-top'];?></h1>

        <div class="btn--wrapper">
            <a href="#" class="btn form-scroll-btn">
                <span><?php the_field('cta_bouton_text','option'); ?></span>
            </a>
        </div>
        <?php
        $date = $o_fields['date_copie'];
        if ( wp_date('Y-m-d', current_time('timestamp')) === wp_date('Y-m-d', strtotime($date)) ) { ?>

    <?php } else { ?>

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

<section id="home-intro" class="ssr-fragment" data-lazy
  data-fragment="/wp-json/gt/v1/fragment/intro" aria-busy="true">
  <div class="skeleton" style="height:320px"></div>
</section>

<section
  id="home-actus"
  class="ssr-fragment"
  data-lazy
  data-fragment="/wp-json/gt/v1/fragment/actus?count=3"
  aria-busy="true">
  <div class="skeleton" style="height:400px"></div>
</section>




<section data-lazy>
     </template>
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
        </template>
</section>
<section data-lazy>
        </template>
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
<template>
</section>
<section data-lazy>
        </template>
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
</template>
</section>
<?php get_footer(); ?>
