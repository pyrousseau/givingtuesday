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
<section data-lazy>
     </template>
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
           
            <div class="block__frontpage--intro__logos">
<?php
// 1) On lit d'abord dans la page d'options ("Paramètres d’accueil")
$g = get_field('mention-label-soutenants', 'option');

// 2) Fallback éventuel sur la page d'accueil (si le groupe est attaché à la page)
if (!$g) {
  $front_id = (int) get_option('page_on_front');
  if ($front_id) { $g = get_field('mention-label-soutenants', $front_id); }
}

// Helper: URL d'image quel que soit le type de retour ACF (Array/ID/URL)
function gt_img_url($img){
  if (!$img) return '';
  if (is_array($img) && !empty($img['url'])) return $img['url'];
  if (is_numeric($img)) { $src = wp_get_attachment_image_src($img, 'full'); return $src ? $src[0] : ''; }
  if (is_string($img)) return $img;
  return '';
}

if ($g):
  // On récupère jusqu'à 3 images/lien (gère image2 / image_2, etc.)
  $items = [];
  for ($i=1; $i<=3; $i++) {
    $s  = ($i===1) ? '' : (string)$i;   // image, image2, image3
    $su = ($i===1) ? '' : '_'.$i;       // image, image_2, image_3

    $img = $g['image'.$s] ?? ($g['image'.$su] ?? null);
    $lnk = $g['lien' .$s] ?? ($g['lien' .$su] ?? '');

    $src = gt_img_url($img);
    if (!$src) continue;
    $alt = is_array($img) && !empty($img['alt']) ? $img['alt'] : '';

    $items[] = ['src'=>$src, 'alt'=>$alt, 'href'=>$lnk];
  }
  if (!empty($items)):
?>
  <div class="gt-supporters">
    <?php if (!empty($g['texte'])): ?>
      <div class="gt-supporters__label"><?php echo esc_html($g['texte']); ?></div>
    <?php else: ?>
      <div class="gt-supporters__label">Mouvement soutenu par</div>
    <?php endif; ?>

    <div class="gt-supporters__row">
      <?php foreach ($items as $it): ?>
        <div class="gt-supporters__logo">
          <?php if (!empty($it['href'])): ?>
            <a href="<?php echo esc_url($it['href']); ?>" target="_blank" rel="noopener">
              <img src="<?php echo esc_url($it['src']); ?>" alt="<?php echo esc_attr($it['alt']); ?>">
            </a>
          <?php else: ?>
            <img src="<?php echo esc_url($it['src']); ?>" alt="<?php echo esc_attr($it['alt']); ?>">
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php
  endif;
endif;
?>


<!--                <li><a href="https://www.fondationcarasso.org/" target="_blank"><img src="/wp-content/themes/theme/images/front/logo-carasso.png" alt="Carasso"></a></li>-->
<!--                <li><a href="https://www.fondationdefrance.org/fr" target="_blank"><img src="/wp-content/themes/theme/images/front/logo-fondation-france.png" alt="Fondation de France"></a></li>-->
<!--                <li><a href="https://www.salesforce.com/fr/" target="_blank"><img src="/wp-content/themes/theme/images/front/logo-salesforce.png" alt="salesforce"></a></li>-->
            </div>
            <div class="block__frontpage--intro__logos">
            <?php
            // Lire le groupe en page d’options (Paramètres d’accueil), fallback page d’accueil
            $g = get_field('mention-label-porteurs', 'option');
            if (!$g) { $front_id = (int) get_option('page_on_front'); if ($front_id) $g = get_field('mention-label-porteurs', $front_id); }

            // Helper URL image (ACF array/ID/URL)
            if (!function_exists('gt_img_url')) {
            function gt_img_url($img){
                if (!$img) return '';
                if (is_array($img) && !empty($img['url'])) return $img['url'];
                if (is_numeric($img)) { $src = wp_get_attachment_image_src($img, 'full'); return $src ? $src[0] : ''; }
                if (is_string($img)) return $img;
                return '';
            }
            }

            if ($g) :
            // On ne prend QUE la première paire image/lien (gère image / image_1)
            $img = $g['image'] ?? ($g['image_1'] ?? null);
            $src = gt_img_url($img);
            $alt = is_array($img) && !empty($img['alt']) ? $img['alt'] : '';
            $lnk = !empty($g['lien']) ? $g['lien'] : ($g['lien_1'] ?? '');

            if ($src): ?>
                <div class="gt-porteur">
                <div class="gt-porteur__label"><?php echo esc_html($g['texte'] ?: 'Porté par'); ?></div>
                <div class="gt-porteur__logo">
                    <?php if ($lnk): ?>
                    <a href="<?php echo esc_url($lnk); ?>" target="_blank" rel="noopener">
                        <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($alt); ?>">
                    </a>
                    <?php else: ?>
                    <img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($alt); ?>">
                    <?php endif; ?>
                </div>
                </div>
            <?php endif;
            endif;
            ?>
   
            </div>
        </div>
    </div>

        <div class="block__frontpage--intro__mention">
       <!--  <img class="block__frontpage--intro__logo" src="<?php echo get_field('logo', 'option'); ?>" alt="Giving Tuesday"> -->

        <div class="block__frontpage--intro__rightinverted" >

<?php
            echo $o_fields['mention_texte'];
            ?>

            <ul class="block__frontpage--intro__logos">




            </ul>

        </div>
        <div class="block__frontpage--intro__leftinverted" style="background-image: url('<?php echo $o_fields['mention_background']; ?>')">
            
        </div>
    </div>

</div>
                </template>
</section>
<section data-lazy>
     </template>
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
                </template>
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