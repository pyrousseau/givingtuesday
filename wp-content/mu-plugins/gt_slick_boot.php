<?php
if (!defined('ABSPATH')) exit;

/* 1) Ne pas mettre defer sur jQuery/Slick si tu as un filtre global */
add_filter('script_loader_tag', function ($tag, $handle, $src) {
  if (is_admin()) return $tag;
  $exclude = ['jquery','jquery-core','jquery-migrate','slick'];
  if (in_array($handle, $exclude, true)) return $tag;
  return str_replace(' src=', ' defer src=', $tag);
}, 10, 3);

/* 2) Charger jQuery + Slick 1.8.1 proprement (si non présents) */
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_script('jquery');
  if (!wp_script_is('slick','enqueued')) {
    wp_enqueue_style('slick-css',   'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
    wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', ['slick-css'], '1.8.1');
    wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);
  }
}, 20);

/* 3) Init unique en footer (silencieuse) */
add_action('wp_footer', function(){ ?>
<script>
(function(){
  var GT_SLICK_ALREADY = false;

  function GT_initSliderOnce(){
    if (GT_SLICK_ALREADY) return; // silence les appels doublons
    GT_SLICK_ALREADY = true;

    var root = document.querySelector('.block--banner__slider');
    if (!root) return;
    root.classList.add('is-ready');

    if (!window.jQuery || !jQuery.fn || !jQuery.fn.slick) return;
    var $root = jQuery(root);
    if ($root.hasClass('slick-initialized')) {
      try { $root.slick('unslick'); } catch(e){}
    }

    // Conteneurs sûrs
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
    } catch (e) { /* silence */ }

    // Neutralise les relances éventuelles du thème
    window.initHomeSlider = function(){ GT_initSliderOnce(); };
  }

  // Empêche toute ré-init jQuery.slick sur un élément déjà initialisé
  window.addEventListener('load', function(){
    if (window.jQuery && jQuery.fn && jQuery.fn.slick) {
      var _slick = jQuery.fn.slick;
      jQuery.fn.slick = function(){
        if (this.hasClass && this.hasClass('slick-initialized')) return this; // silence
        try { return _slick.apply(this, arguments); } catch(e){ return this; }
      };
    }
    setTimeout(GT_initSliderOnce, 250);
  });
})();
</script>
<?php }, 99);

/* 4) Fallback CSS (si pas déjà dans ta feuille) */
add_action('wp_head', function(){ ?>
<style>
.block--banner__slider{position:relative;overflow:hidden;display:block;width:100%;max-width:100%}
.block--banner__slider .slide-block{display:none}
.block--banner__slider .slide-block:first-child{display:block}
.block--banner__slider.is-ready .slide-block{display:block}
.block--banner__slider picture>img{display:block;width:100%;height:auto;aspect-ratio:16/9}
.gt-slick-arrows{position:absolute;inset:0;pointer-events:none}
.gt-slick-arrows .slick-prev,.gt-slick-arrows .slick-next{
  pointer-events:auto;position:absolute;top:50%;transform:translateY(-50%);z-index:2
}
.gt-slick-arrows .slick-prev{left:8px}.gt-slick-arrows .slick-next{right:8px}
.gt-slick-dots{position:absolute;left:0;right:0;bottom:8px}
</style>
<?php });
