<?php get_header();
the_post();
$currentID = get_the_ID();
$currentTime = get_post_time('Y-m-d H:i:s');
?>
<div class="block__back">
    <div class="inner-wrapper">
        &larr; <a href="<?php echo get_page_link(23); ?>">Retour aux actualités</a>
    </div>
</div>
<div class="block__actualites block__actualites--title">
    <div class="inner-wrapper">
        <div class="title-block">
            <div class="logo-block"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-3.png" alt=""></div>
            <div class="text-block"><h1><?php echo get_the_title(23); ?></h1></div>
        </div>
    </div>
</div>
<div class="block__actualites block__actualites--content">
    <div class="inner-wrapper">
        <div class="news-content">
            <div class="news-attribute">
                <span class="date"><?php echo get_the_date('d/m/Y'); ?></span>
                <?php if (get_field('auteur')) { ?> • <span class="author"><?php the_field('auteur'); ?></span><?php } ?>
            </div>
            <div class="title"><?php the_title(); ?></div>
            <?php if (get_field('tag')) { ?>
                <div class="status-block">
                    <div class="status">#<?php the_field('tag'); ?></div>
                </div>
            <?php } ?>
            <div class="text-block">
                <div class="title-text-block">
                    <?php the_post_thumbnail('actu-thumb'); ?>
                    <p>
                        <?php the_field('exceprt'); ?>
                    </p>
                </div>
                <?php if (strlen(get_the_content()) > 0) { ?>
                <div class="article">
                    <?php the_content(); ?>
                </div>
                <?php } ?>
            </div>
            <?php $slides = get_field('gallery'); ?>
            <?php if ($slides && !empty($slides)) { ?>
            <div class="slider-block">
                <ul class="actualites-slider">
                    <?php foreach ($slides as $slide) { ?>
                        <li>
                            <div class="img-block"><img src="<?php echo $slide['image']['sizes']['actu']; ?>" alt=""></div>
                            <div class="text-block">
                                <strong>Légende :</strong> <?php echo $slide['legende']; ?>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
            <div class="social-block sticky-social-block">
                <div class="title-block">Partager <br/>cet article :</div>
                <ul>
                    <li>
                        <a href="#" class="fb-share">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <script>
                            $('.fb-share').on('click', function (e) {
                                e.preventDefault();
                                FB.ui({
                                    method: 'share',
                                    href: '<?php the_permalink(); ?>',
                                }, function(response){

                                });
                            });
                        </script>

                    </li>
                    <li>
                        <a href="#" class="tw-share">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <script>
                            $('.tw-share').on('click', function (e) {
                                e.preventDefault();
                                url = encodeURI("http://twitter.com/share?hashtags=GivingTuesdayFR&url=<?php the_permalink(); ?>&text=<?php echo trim(preg_replace('/\s\s+/', ' ',strip_tags(get_field('exceprt')))); ?>");

                                window.open(url, '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');
                            });
                        </script>
                    </li>
                    <!--<li>
                        <a href="#" class="gg-share">
                            <i class="fab fa-google-plus-g"></i>
                        </a>
                        <script>
                            $('.gg-share').on('click', function(e) {
                                e.preventDefault();
                                window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>','', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
                            });
                        </script>
                    </li>-->
                    <li>
                        <a href="#" class="in-share">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <script>
                            $('.in-share').on('click', function(e) {
                                e.preventDefault();
                                url = encodeURI("https://www.linkedin.com/sharing/share-offsite/?url=<?php the_permalink(); ?>");
                                window.open(url,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
                            });
                        </script>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $related = new WP_Query(array(
    'posts_per_page' => 3,
    'post_type' => 'post',
    'orderby' => 'date',
    'order' => 'DESC',
    'date_query' => array(
        array(
            'before' => $currentTime
        )
    ),

));
if ($related->post_count  <= 3) {
    $related = new WP_Query(array(
        'posts_per_page' => 3,
        'post_type' => 'post',
        'orderby' => 'date',
        'order' => 'DESC',
        'post__not_in' => array($currentID)

    ));
}
if ($related->have_posts()) : ?>
<div class="block__actualites block__actualites--news-block">
    <div class="inner-wrapper">
        <div class="block__actualites--news-block__title">
            <span>Vous pourriez aussi être interessé par :</span>
        </div>
        <div class="block__actualites--news-block__list">
            <ul class="news-list">

                <?php while ($related->have_posts()) : $related->the_post(); ?>
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
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>
<?php get_footer(); ?>
