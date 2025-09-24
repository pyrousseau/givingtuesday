<?php the_post();
$queryAllActu = new WP_Query(array(
    'posts_per_page' => '-1',
    'post_type' => 'post',
    'orderby' => 'date',
    'order' => 'DESC'
));
$allPosts = $queryAllActu->post_count - 3;
?>
<div class="block block__actualites block__actualites--title">
    <div class="inner-wrapper">
        <div class="title-block">
            <div class="logo-block"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-3.png" alt=""></div>
            <div class="text-block"><h1><?php the_title(); ?></h1></div>
        </div>
    </div>
</div>
<div class="block__actualites block__actualites--last-news">
    <div class="inner-wrapper">
        <div class="block__actualites--last-news__title">
            <h2>À la une</h2>
        </div>
        <div class="block__actualites--last-news__list">
            <ul class="news-list">
                <?php $alaune = new WP_Query(array(
                    'posts_per_page' => 3,
                    'post_type' => 'post',
                    'orderby' => 'date',
                    'order' => 'DESC'
                )); ?>
                <?php while ($alaune->have_posts()) : $alaune->the_post(); ?>
                <li>
                    <div class="news-block">
                        <a href="<?php the_permalink(); ?>" class="img-block">
                            <?php the_post_thumbnail('actu-thumb'); ?>
                            <?php if (get_field('tag')) { ?>
                            <div class="status">#<?php the_field('tag'); ?></div>
                            <?php } ?>
                        </a>
                        <div class="text-block">
                            <div class="news-title"><?php the_title(); ?></div>
                            <div class="text"><?php the_field('exceprt'); ?></div>
                            <div class="link-block">
                                <a href="<?php the_permalink(); ?>">Lire la suite</a>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endwhile; wp_reset_query(); ?>
            </ul>
        </div>
    </div>
</div>
<div class="block__actualites block__actualites--news-all">
    <div class="inner-wrapper">
        <ul class="news-list-all"  data-count="3" data-all="<?php echo $allPosts; ?>">
            <?php $actu = new WP_Query(array(
                'posts_per_page' => 3,
                'post_type' => 'post',
                'orderby' => 'date',
                'order' => 'DESC',
                'offset' => 3
            ));  ?>
            <?php while ($actu->have_posts()) : $actu->the_post(); ?>
            <li>
                <div class="news-block">
                    <a href="<?php the_permalink(); ?>" class="img-block">
                        <?php the_post_thumbnail('actu-thumb'); ?>
                        <?php if (get_field('tag')) { ?>
                            <div class="status">#<?php the_field('tag'); ?></div>
                        <?php } ?>
                    </a>
                    <div class="text-block">
                        <div class="news-title"><?php the_title(); ?></div>
                        <div class="text"><?php the_field('exceprt'); ?></div>
                        <div class="link-block">
                            <a href="<?php the_permalink(); ?>">Lire la suite</a>
                        </div>
                    </div>
                </div>
            </li>
            <?php endwhile; wp_reset_query(); ?>
        </ul>
        <div class="news-list-all--more-block">
            <a href="#" class="news-list-all--more">Voir plus d’actualités</a>
        </div>
    </div>
</div>