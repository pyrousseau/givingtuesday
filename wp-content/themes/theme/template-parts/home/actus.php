<?php
/**
 * Fragment: Home Actus (HTML pur, sans header/footer)
 * - Respecte le markup de la prod (classes & structure)
 * - Utilise ACF 'excerpt' si présent, sinon l’extrait WP
 * - Nombre de posts via $GLOBALS['gt_actus_count'] (fallback 3)
 */

$max = isset($GLOBALS['gt_actus_count']) ? max(1, (int)$GLOBALS['gt_actus_count']) : 3;

$q = new WP_Query([
  'post_type'           => 'post',
  'posts_per_page'      => $max,
  'orderby'             => 'date',
  'order'               => 'DESC',
  'ignore_sticky_posts' => true,
]);

$title_opt = get_field('actu_bloc_titre','option');
$bloc_title = $title_opt ? $title_opt : 'Actualités';

// Page "toutes les actus"
$all_posts_url = get_permalink( get_option('page_for_posts') ?: 23 );
?>
<div class="block block__frontpage block__frontpage--actus" id="home-actus">
  <h2 class="block__frontpage--actus__title"><?= esc_html($bloc_title) ?></h2>

  <div class="block__frontpage--actus__slider slick-slider">
    <div class="block__frontpage--actus__slider__inner">
      <?php if ($q->have_posts()): while ($q->have_posts()): $q->the_post(); ?>
        <div class="slide-block">
          <div class="slide-block__inner">
            <div class="slide-block__header">
              <div class="slide-block__img">
                <?php
                if (has_post_thumbnail()) {
                  the_post_thumbnail('actu-thumb', ['loading'=>'lazy']);
                } else {
                  the_post_thumbnail('medium_large', ['loading'=>'lazy']);
                }
                ?>
              </div>
              <h3 class="slide-block__title"><?php the_title(); ?></h3>
            </div>

            <p class="slide-block__text">
              <?php
              // ACF 'excerpt' (orthographe correcte) sinon extrait WP
              $acf_excerpt = function_exists('get_field') ? get_field('excerpt') : '';
              $text = $acf_excerpt ?: wp_strip_all_tags( get_the_excerpt(), true );
              echo esc_html( $text );
              ?>
            </p>

            <a class="slide-block__link" href="<?php the_permalink(); ?>">Lire la suite</a>
          </div>
        </div>
      <?php endwhile; wp_reset_postdata(); else: ?>
        <!-- GT: aucune actu disponible -->
      <?php endif; ?>
    </div>

    <!-- Contrôles custom (comme prod) -->
    <ul class="custom-slick-dots slick-dots"></ul>
    <button class="custom-slick-prev slick-prev slick-arrow" type="button">Previous</button>
    <button class="custom-slick-next slick-next slick-arrow" type="button">Next</button>
  </div>

  <div class="block__frontpage--actus__footer">
    <a class="block__frontpage--actus__footer__link" href="<?= esc_url($all_posts_url) ?>">
      Voir toutes les actualités
    </a>
  </div>
</div>
