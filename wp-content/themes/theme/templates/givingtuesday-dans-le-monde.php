<div class="block block__icons">
    <div class="wrap-container">
        <h1 class="title__h1"><?php the_title(); ?></h1>
        <div class="content">
            <?php $icons = get_field('pays_rep');
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
                <a href="<?php echo $iconSorted['lien']; ?>" target="_blank" class="item">
                <?php } else { ?>
                <div target="_blank" class="item">
                    <?php } ?>
                    <div class="img">
                        <img src="<?php echo $thumb; ?>" />
                    </div>
                    <h4><?php echo $iconSorted['titre']; ?></h4>
                <?php if ($iconSorted['lien'] && $iconSorted['lien'] != '') { ?>
                </a>
                <?php } else { ?>
                </div>
                <?php } ?>
            <?php } ?>
        </div>
        <footer>
            <span class="show-more">En voir plus</span>
        </footer>
        <div class="faq__btn">
            <a href="<?php echo get_field('bouton_lien','option'); ?>" class="btn"><span><?php echo get_field('bouton_text','option'); ?></span></a>
        </div>
    </div>
</div>

