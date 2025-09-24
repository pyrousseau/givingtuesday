<?php /*
Template Name: Page Contacts
*/
get_header();
$o_fields = get_fields('options');
$fields = get_fields();
?>
<div class="block--contacts-privilegies">
    <div class="block--contacts-privilegies__container">
        <h2><?php echo $fields['title']; ?></h2>
        <div class="block--contacts-privilegies__top">
            <?php foreach ($fields['repeater'] as $field): ?>
            <div class="block--contacts-privilegies__col">
                <img src="<?php echo $field['image']['url']; ?>" alt="<?php echo $field['image']['alt']; ?>">
                <h3><?php echo $field['name']; ?></h3>
                <p><a href="mailto:<?php echo $field['email']; ?>" target="_blank"><?php echo $field['email']; ?></a>
                    <?php if($field['texte']):?><br> <?php echo $field['texte']; endif; ?></p>
            </div>
            <?php endforeach; ?>

        </div>
        <div class="block--contacts-privilegies__social">
            <div class="block--contacts-privilegies__social__title"><?php echo $fields['title_social']; ?></div>
            <ul class="block--contacts-privilegies__social__list">
            <li><a href="<?php the_field('linkedin_lien','option'); ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li>
            <li><a href="<?php the_field('instagramm_lien','option'); ?>" target="_blank"><i
                            class="fab fa-instagram"></i></a></li>
                <li><a href="<?php the_field('facebook_lien','option'); ?>" target="_blank"><i
                            class="fab fa-facebook-f"></i></a></li>
                            
                <li><a href="<?php the_field('tiktok_lien','option'); ?>" target="_blank"><i class="fab fa-tiktok"></i></a></li>
                <li><a href="<?php the_field('twitter_lien','option'); ?>" target="_blank"><i
                            class="fab fa-x-twitter"></i></a></li>
                
                <li><a href="<?php the_field('youtube_lien','option'); ?>" target="_blank"><i
                            class="fab fa-youtube"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<?php get_footer(); ?>