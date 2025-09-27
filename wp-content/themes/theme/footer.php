<?php
$o_fields = get_fields('option') ?: get_fields('options');
?>

<div id="footer" class="footer">
  <div class="wrap">
    <div class="footer__left">
      <div class="links">
        <?php
        wp_nav_menu(array(
          'container'      => false,
          'theme_location' => 'header-menu',
          'menu_id'        => 'menu-footer_navigation',
          'menu_class'     => 'f_nav',
          'walker'         => class_exists('WP_First_Level_Navwalker') ? new WP_First_Level_Navwalker() : null
        ));
        ?>
      </div>

      <div class="select-block">
        <label for="footer__select">
          Pour un contenu personnalisé <br>indiquez-nous votre profil...
          <span>Vous êtes&nbsp;:</span>
        </label>
        <select id="footer__select">
          <option value="select"><?php echo esc_html($o_fields['header_select_subtitle'] ?? ''); ?></option>
          <?php foreach ($o_fields['header_select'] ?? [] as $field): ?>
            <option value="<?php echo esc_url($field['lien'] ?? '#'); ?>">
              <?php echo esc_html($field['texte'] ?? ''); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="footer__right">
      <p class="share-title">Suivez nous sur les réseaux sociaux&nbsp;:</p>
      <ul class="footer__share">
        <li><a href="<?php the_field('linkedin_lien','option'); ?>" target="_blank" rel="noopener"><i class="fab fa-linkedin"></i></a></li>
        <li><a href="<?php the_field('instagramm_lien','option'); ?>" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a></li>
        <li><a href="<?php the_field('facebook_lien','option'); ?>" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a></li>
        <li><a href="<?php the_field('tiktok_lien','option'); ?>" target="_blank" rel="noopener"><i class="fab fa-tiktok"></i></a></li>
        <li><a href="<?php the_field('twitter_lien','option'); ?>" target="_blank" rel="noopener"><i class="fab fa-x-twitter"></i></a></li>
        <li><a href="<?php the_field('youtube_lien','option'); ?>" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a></li>
      </ul>
      <div class="text-block">
        <?php echo get_field('footer_texte','option'); ?>
      </div>
    </div>
  </div>

  <div class="footer__ml">
    <a href="<?php echo esc_url(get_page_link(94)); ?>" class="ml-link">Mentions légales</a>
  </div>
</div>

<div id="cookie-bar" class="fixed bottom" style="z-index:1000;">
  <div class="wrap">
    <div class="cookie-texte">
      <div><?php echo get_field('cookie_bar_texte', 'option'); ?></div>
    </div>
    <div class="cookie-cta">
      <button><?php echo esc_html(get_field('cookie_bar_bouton_texte', 'option')); ?></button>
    </div>
  </div>
</div>

<div class="popup-block cookie-block">
  <div class="popup-content">
    <div class="close"></div>
    <?php echo the_field('content', 94); ?>
  </div>
</div>

<?php wp_footer(); ?>

<style>
/* Flèches visibles pour .block--ideas__list (hors home) */
body:not(.home) .block--ideas__list .slick-arrow{display:block!important;opacity:1!important;visibility:visible!important}
body:not(.home) .block--ideas__list .slick-prev,
body:not(.home) .block--ideas__list .slick-next{
  position:absolute;top:50%;transform:translateY(-50%);
  width:42px;height:42px;border:0;border-radius:9999px;background:#fff;
  box-shadow:0 2px 10px rgba(0,0,0,.15);cursor:pointer
}
body:not(.home) .block--ideas__list .slick-prev{left:8px}
body:not(.home) .block--ideas__list .slick-next{right:8px}
</style>

<script>
/* Redirection select footer */
document.getElementById('footer__select')?.addEventListener('change', e=>{
  const v=e.target.value; if(v && v!=='select'){ if(/^https?:\/\//i.test(v)||v[0]==='/') location.href=v; }
});

</script>


</body>
</html>
