<?php
$o_fields = get_fields('options');
?>
<div class="pre-footer">
    <a href="<?php echo get_site_url(); ?>/je-publie-mon-action" class="bnt-action-page-footer">JE PUBLIE MON ACTION</a>
</div>
<div id="footer" class="footer">
    <div class="wrap">
        <div class="footer__left">
            <div class="links">
                <?php
                wp_nav_menu( array(
                        'container'=> false,
                        'theme_location'=> 'header-menu',
                        'menu_id'=> 'menu-footer_navigation',
                        'menu_class'=> 'f_nav',
                        'walker'    => new WP_First_Level_Navwalker()

                    )
                );
                
                ?>
                <?php
                // wp_nav_menu( array(
                //         'container'=> false,
                //         'theme_location'=> 'footer-2',
                //         'menu_id'=> 'menu-footer_navigation2',
                //         'menu_class'=> 'f_nav'
                //     )
                // );
                ?>
            </div>
            <div class="select-block">
                <label for="footer__select">Pour un contenu personnalisé <br>indiquez-nous votre profil... <span>Vous êtes&nbsp;:</span></label>
                <select id="footer__select" name="Un particulier">
                    <option value="select"><?php echo $o_fields['header_select_subtitle']; ?></option>
                    <?php foreach ($o_fields['header_select'] as $field): ?>
                        <option value='<?php echo $field['lien'];?>'><?php echo $field['texte'];?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="footer__right">
            <p class="share-title">Suivez nous sur les réseaux sociaux&nbsp;:</p>
            <ul class="footer__share">
                <li><a href="<?php the_field('linkedin_lien','option'); ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                <li><a href="<?php the_field('instagramm_lien','option'); ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                <li><a href="<?php the_field('facebook_lien','option'); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="<?php the_field('tiktok_lien','option'); ?>" target="_blank"><i class="fab fa-tiktok"></i></a></li>
                <li><a href="<?php the_field('twitter_lien','option'); ?>" target="_blank"><i class="fab fa-x-twitter"></i></a></li>
                <li><a href="<?php the_field('youtube_lien','option'); ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
            </ul>
            <div class="text-block">
                <?php echo get_field('footer_texte','option'); ?>
            </div>
        </div>
    </div>
    <div class="footer__ml">
        <a href="<?php echo get_page_link(94); ?>" class="ml-link">Mentions légales</a>
    </div>
</div>

<div id="cookie-bar" class="fixed bottom" style="z-index:1000;">
    <div class="wrap">
        <div class="cookie-texte"><div><?php echo get_field('cookie_bar_texte', 'option'); ?></div>
        </div>
        <div class="cookie-cta"><button><?php echo get_field('cookie_bar_bouton_texte', 'option'); ?></button></div><!-- /.cookie-cta -->
    </div><!-- /.wrap -->
</div>
<div class="popup-block cookie-block">
    <div class="popup-content">
        <div class="close"></div>
        <?php // go for content blocks
        echo the_field('content',94);
         ?>
    </div>
</div>
<?php wp_footer(); ?>
<script>
window.addEventListener('load', function () {
  // Laisse le héros (LCP) se peindre, puis seulement après on init le slider
  setTimeout(function () {
    if (window.initHomeSlider) window.initHomeSlider();
    // charge d'autres scripts lourds à l'idle
    if ('requestIdleCallback' in window) {
      requestIdleCallback(function(){
        // ex: charger une carte, analytics custom, etc.
      }, {timeout: 2000});
    }
  }, 250);
});
</script>
<script>
(function(){
  function initSlider(){
    const root = document.querySelector('.block--banner__slider');
    if (!root) return;
    root.classList.add('is-ready'); // lève le display:none du fallback

    // 1) Si ton site a déjà une fonction d'init, on la lance
    if (typeof window.initHomeSlider === 'function') { window.initHomeSlider(); return; }

    // 2) Sinon, si Slick est là
    if (window.jQuery && jQuery.fn && jQuery.fn.slick && jQuery(root).length) {
      jQuery(root).slick({autoplay:true, dots:true, arrows:true, adaptiveHeight:true});
      return;
    }

    // 3) Sinon, si Swiper est là
    if (window.Swiper && typeof Swiper === 'function') {
      /* eslint-disable no-new */
      new Swiper('.block--banner__slider', {loop:true, slidesPerView:1, autoplay:{delay:4000}});
      return;
    }

    // 4) Plan C : mini-rotateur maison (au cas où aucune lib n'est chargée)
    const slides = root.querySelectorAll('.slide-block');
    if (slides.length <= 1) return;
    let i = 0;
    slides.forEach((s,idx)=>s.style.display = idx===0 ? 'block' : 'none');
    setInterval(() => {
      slides[i].style.display = 'none';
      i = (i+1) % slides.length;
      slides[i].style.display = 'block';
    }, 4000);
  }

  // Laisse le héros se peindre, puis initialise
  window.addEventListener('load', function(){ setTimeout(initSlider, 250); });
})();
</script>
<script>
(function(){
  // 1) Garde anti double-initialisation
  var GT_SLICK_ALREADY = false;

  function GT_initSliderOnce(){
    if (GT_SLICK_ALREADY) { console.warn('[GT] skip duplicate init'); return; }
    GT_SLICK_ALREADY = true;

    var root = document.querySelector('.block--banner__slider');
    if (!root) return;
    root.classList.add('is-ready');

    if (!window.jQuery || !jQuery.fn || !jQuery.fn.slick) {
      console.warn('[GT] Slick absent -> skip');
      return;
    }

    var $root = jQuery(root);
    if ($root.hasClass('slick-initialized')) {
      try { $root.slick('unslick'); } catch(e){}
    }

    // Conteneurs sûrs pour dots/arrows
    var dots  = root.querySelector('.gt-slick-dots')  || root.appendChild(Object.assign(document.createElement('div'),{className:'gt-slick-dots'}));
    var arrws = root.querySelector('.gt-slick-arrows')|| root.appendChild(Object.assign(document.createElement('div'),{className:'gt-slick-arrows'}));
    var prev = document.createElement('button'); prev.type='button'; prev.className='slick-prev'; prev.setAttribute('aria-label','Précédent'); prev.innerHTML='‹';
    var next = document.createElement('button'); next.type='button'; next.className='slick-next'; next.setAttribute('aria-label','Suivant');   next.innerHTML='›';
    arrws.appendChild(prev); arrws.appendChild(next);

    try {
      $root.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 4000,
        adaptiveHeight: true,
        dots: true,
        appendDots:   dots,
        appendArrows: arrws,
        prevArrow:    prev,
        nextArrow:    next
      });
      console.log('[GT] Slick ready (single)');
    } catch (e) {
      console.error('[GT] Slick init error:', e);
    }
  }

  // 2) Rediriger tout appel externe vers notre init unique
  var _origInitHome = window.initHomeSlider;
  window.initHomeSlider = function(){ GT_initSliderOnce(); };

  // 3) Bloquer toute tentative de ré-init via jQuery.fn.slick
  window.addEventListener('load', function(){
    if (window.jQuery && jQuery.fn && jQuery.fn.slick) {
      var _slick = jQuery.fn.slick;
      jQuery.fn.slick = function(){
        // si déjà initialisé, on ignore l'appel suivant
        if (this.hasClass && this.hasClass('slick-initialized')) {
          return this; 
          return this;
        }
        try { return _slick.apply(this, arguments); }
        catch(e){ console.warn('[GT] slick init prevented:', e); return this; }
      };
    }
    setTimeout(GT_initSliderOnce, 250); // notre init unique
  });
})();
</script>


</body>

</html>