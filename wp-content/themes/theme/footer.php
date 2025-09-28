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
        <select id="footer__select" class="gt-select">
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

<script>
document.addEventListener('DOMContentLoaded', function () {
  if (!document.body.classList.contains('actualites')) return;

  function fixActuStatic() {
    document.querySelectorAll('.block__actualites--last-news .slick-slide img').forEach(function (img) {
      // Neutralise la "taille fantôme" et toute contrainte HTML
      img.removeAttribute('width');
      img.removeAttribute('height');
      img.style.contentVisibility   = 'visible';
      img.style.containIntrinsicSize = 'auto';

      // Affichage proportionnel, SANS absolute
      img.style.position   = 'static';
      img.style.inset      = 'auto';
      img.style.display    = 'block';
      img.style.width      = '100%';
      img.style.height     = 'auto';
      img.style.maxHeight  = 'none';
      img.style.objectFit  = 'cover'; // ne gêne pas avec height:auto, évite quelques cas
      img.style.visibility = 'visible';
      img.style.opacity    = '1';
      img.style.clip       = 'auto';
      img.style.clipPath   = 'none';
    });
  }

  // au chargement
  fixActuStatic();

  // si Slick réagit (init / resize / lazy), on réapplique
  if (window.jQuery) {
    var $ = window.jQuery;
    $('.block__actualites--last-news .slick-slider')
      .on('init reInit setPosition lazyLoaded', fixActuStatic);
  }
});
</script>

<script>
(function () {
  const TARGET_ID  = 'gt-formulaire';                   // l'ancre visée
  const BTN_SEL    = 'a.form-scroll-btn';               // ton CTA
  const HEADER_SEL = 'header.site-header, .site-header, .header';
  const MAX_WAIT   = 8000; // ms pour attendre l'injection lazy

  function headerOffset() {
    const h = document.querySelector(HEADER_SEL);
    return h ? h.getBoundingClientRect().height : 0;
  }

  // trouve le scroller (fenêtre OU conteneur overflow:auto)
  function getScroller() {
    const docScroller = document.scrollingElement || document.documentElement;
    const candidates = document.querySelectorAll('main, .site, .site-wrapper, .wrapper, .content, body, html');
    for (const el of candidates) {
      const cs = getComputedStyle(el);
      if (/(auto|scroll)/.test(cs.overflowY) && el.scrollHeight > el.clientHeight) return el;
    }
    return docScroller;
  }

  function getTarget() {
    return document.getElementById(TARGET_ID) || document.querySelector('[data-form-anchor]');
  }

  function doScroll() {
    const target = getTarget(); if (!target) return false;
    const scroller = getScroller();
    const off = headerOffset();

    if (scroller === document.documentElement || scroller === document.body) {
      const y = target.getBoundingClientRect().top + window.pageYOffset - off;
      window.scrollTo({ top: y, behavior: 'smooth' });
    } else {
      const y = target.getBoundingClientRect().top + scroller.scrollTop - off;
      scroller.scrollTo({ top: y, behavior: 'smooth' });
    }
    return true;
  }

  function waitThenScroll() {
    if (doScroll()) return;
    const deadline = Date.now() + MAX_WAIT;

    const mo = new MutationObserver(() => {
      if (Date.now() > deadline) { mo.disconnect(); return; }
      if (doScroll()) mo.disconnect();
    });
    mo.observe(document.documentElement, { childList: true, subtree: true });

    const tick = setInterval(() => {
      if (Date.now() > deadline || doScroll()) clearInterval(tick);
    }, 250);
  }

  // Intercepte le CTA (capture=true pour passer avant d'éventuels preventDefault)
  document.addEventListener('click', function (e) {
    const a = e.target.closest(BTN_SEL);
    if (!a) return;
    e.preventDefault(); e.stopPropagation();
    // 👉 si tu dois déclencher manuellement le lazy‑loader, fais-le ici :
    // window.loadLazyForm?.();
    waitThenScroll();
  }, true);

  // Si on arrive avec #gt-formulaire dans l’URL
  if (location.hash === '#'+TARGET_ID) {
    window.addEventListener('load', waitThenScroll, { once:true });
  }

  // met à jour une variable CSS pour scroll-margin-top éventuel
  function setHeaderVar(){
    document.documentElement.style.setProperty('--header-h', headerOffset() + 'px');
  }
  setHeaderVar();
  window.addEventListener('resize', setHeaderVar, { passive:true });
})();
</script>

<?php wp_footer(); ?>



<script>
/* Redirection select footer */
document.getElementById('footer__select')?.addEventListener('change', e=>{
  const v=e.target.value; if(v && v!=='select'){ if(/^https?:\/\//i.test(v)||v[0]==='/') location.href=v; }
});

</script>
<script>
jQuery(function ($) {
  var SELECTOR = '.block_actions_filter select, .block__frontpage select, select.gt-select';

  function initSelectric(ctx) {
    $(ctx || document).find(SELECTOR).each(function () {
      var $sel = $(this);
      // déjà initialisé ? on ne touche pas
      if ($sel.data('selectric')) return;
      // init 1 fois
      $sel.selectric({
        disableOnMobile: false,
        nativeOnMobile: false
      });
    });
  }

  // 1) init au chargement
  initSelectric(document);

  // 2) Observer SÉLECTIF (ne réagit qu’à des <select> nouveaux)
  try {
    var debounceT = null;
    var pending = [];

    var mo = new MutationObserver(function (muts) {
      for (var m of muts) {
        for (var n of m.addedNodes) {
          if (n.nodeType !== 1) continue;
          // si le nœud lui‑même est un <select>
          if (n.matches && n.matches('select')) pending.push(n);
          // ou s’il en contient
          $(n).find('select').each(function(){ pending.push(this); });
        }
      }
      if (!pending.length) return;

      clearTimeout(debounceT);
      debounceT = setTimeout(function () {
        // n’initialise QUE les nouveaux select, une seule fois
        $(pending).each(function () {
          var $sel = $(this);
          if (!$sel.data('selectric')) {
            $sel.selectric({
              disableOnMobile: false,
              nativeOnMobile: false
            });
          } else {
            // si déjà initialisé, un petit refresh suffit
            $sel.selectric('refresh');
          }
        });
        pending = [];
      }, 120);
    });

    mo.observe(document.documentElement, { childList: true, subtree: true });
  } catch (e) {
    // no-op
  }
});
</script>



</body>
</html>
