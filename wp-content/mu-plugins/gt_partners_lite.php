<?php
/**
 * Plugin Name: GT Partners Slick Cards (MU)
 * Description: Détection runtime (UL/OL ≥ 3 <img>) + Slick (flèches) + style "cards" homogène. Sans data-gt-cards.
 * Version: 2.0.0
 * Author: PY
 */

add_action('wp_head', function(){
  echo "\n<!-- GT Partners Slick Cards MU LOADED v2.0.0 (no data-gt-cards) -->\n";
}, 1);

/** CSS global (head) — UNIQUEMENT via classes (.gtp-cards, .gtp-static, .gt-news) */
add_action('wp_head', function () { ?>
<style id="gt-partners-slick-cards-css">
  :root{
    --gt-logo-max-h: 100px;
    --gt-card-pad:   14px;
    --gt-gap-x:      18px;
  }

  /* ===== Cartes partenaires (liste taguée .gtp-cards) ===== */
  .gtp-cards{ list-style:none; padding:0; margin:1.25rem 0; }
  .gtp-cards > li{
    list-style:none; background:#fff; border-radius:14px;
    box-shadow:0 1px 3px rgba(0,0,0,.06);
    display:flex; align-items:center; justify-content:center;
    padding:var(--gt-card-pad);
    transition:transform .18s ease, box-shadow .18s ease;
    margin:0 calc(var(--gt-gap-x)/2);
  }
  .gtp-cards > li:hover{ transform:translateY(-2px); box-shadow:0 6px 16px rgba(0,0,0,.08); }
  .gtp-cards img{
    display:block; height:auto; width:auto;
    max-height:var(--gt-logo-max-h);
    filter:none !important; opacity:1 !important; transition:transform .18s ease;
  }
  .gtp-cards a:hover img{ transform:scale(1.02); }

  /* Masque scrollbars si liste brute scrollable */
  .gtp-cards{ overflow:auto; scrollbar-width:none; -ms-overflow-style:none; overscroll-behavior-x:contain; touch-action:pan-x; }
  .gtp-cards::-webkit-scrollbar{ width:0; height:0; display:none; }

  /* Slick: flèches au-dessus et centrées verticalement */
  .gtp-cards.slick-slider{ position:relative; z-index:0; }
  .gtp-cards.slick-slider .slick-prev, .gtp-cards.slick-slider .slick-next{ z-index:1; top:50%; transform:translateY(-50%); }
  .gtp-cards.slick-slider .slick-prev:before, .gtp-cards.slick-slider .slick-next:before{ color:#111; opacity:.85; font-size:28px; }
  .gtp-cards.slick-slider .slick-prev:hover:before, .gtp-cards.slick-slider .slick-next:hover:before{ opacity:1; }
  .gtp-cards.slick-slider .slick-list,
  .gtp-cards.slick-slider .slick-track{ min-height:calc(var(--gt-logo-max-h) + 2*var(--gt-card-pad)); }

  /* ===== Grille statique (si on décide de ne PAS slider) ===== */
  .gtp-static{
    display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:18px;
    list-style:none; margin:1.5rem 0; padding:0; overflow:visible;
  }
  .gtp-static > li{
    background:#fff; border-radius:14px; box-shadow:0 1px 3px rgba(0,0,0,.06);
    display:flex; align-items:center; justify-content:center; padding:var(--gt-card-pad);
    transition:transform .18s ease, box-shadow .18s ease;
  }
  .gtp-static > li:hover{ transform:translateY(-2px); box-shadow:0 6px 16px rgba(0,0,0,.08); }
  .gtp-static .slick-list, .gtp-static .slick-track{ overflow:visible !important; height:auto !important; }
  .gtp-static .slick-prev, .gtp-static .slick-next, .gtp-static .slick-dots{ display:none !important; }

  /* ===== "Les Actus" (tagué .gt-news par le JS) ===== */
  .gt-news .slick-prev, .gt-news .slick-next{ top:50% !important; transform:translateY(-50%) !important; z-index:5 !important; }
  .gt-news .slick-prev:before, .gt-news .slick-next:before, .gt-news .slick-dots{ display:none !important; content:"" !important; opacity:0 !important; visibility:hidden !important; }
  .gt-news .slick-list{ overflow:visible !important; }
  @media (min-width:1024px){
    .gt-news .slick-prev{ top:42% !important; transform:translateY(-50%) !important; }
    .gt-news .slick-next{ top:50% !important; transform:translateY(-50%) !important; }
  }
</style>
<?php }, 5);

/** Slick (CDN ou remplace par tes assets locaux) */
add_action('wp_enqueue_scripts', function(){
  wp_enqueue_script('jquery');
  wp_enqueue_style('slick',       'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
  wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', ['slick'], '1.8.1');
  wp_enqueue_script('slick',      'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);
}, 5);

/** JS (head) — détection UL/OL logos → Slick (.gtp-cards) ; option grille (.gtp-static) ; tag .gt-news */
add_action('wp_head', function(){ ?>
<script id="gt-partners-slick-cards-js">
(function(){
  var RETRIES = 14;   // 14*400ms ≈ 5.6s
  var MIN_IMG = 3;

  // ⇩ Mets true si tu veux la grille statique sur la home (sinon false = slider)
  function homeAsStaticGrid(){ return false; }

  function inHeader(el){
    try{ return !!(el.closest && el.closest('header, nav, .site-header, #site-header, .header, #header, .navbar, .menu, .main-navigation, .primary-menu')); }
    catch(e){ return false; }
  }

  function looksLikeLogoList(el){
    if (!el || !/^(UL|OL)$/.test(el.tagName)) return false;
    if (inHeader(el)) return false;
    if (el.classList.contains('no-partner-slider')) return false;
    if (el.classList.contains('slick-initialized')) return false;
    var imgs = el.querySelectorAll('img');
    if (imgs.length < MIN_IMG) return false;
    var countLI = 0;
    el.querySelectorAll(':scope > li').forEach(function(li){ if (li.querySelector('img')) countLI++; });
    return countLI >= Math.min(MIN_IMG, el.children.length);
  }

  function tag(el){
    el.classList.add('js-gt-partners');
    el.classList.add('gtp-cards');
    return el;
  }

  function findCandidates(root){
    var out = [];
    (root || document).querySelectorAll('ul,ol').forEach(function(n){ if (looksLikeLogoList(n)) out.push(n); });
    return out;
  }

  function initSlick(list){
    if (typeof jQuery !== 'function' || !jQuery.fn || !jQuery.fn.slick) return false;
    var $ = jQuery, $el = $(list);
    if ($el.hasClass('slick-initialized')) return true;
    $el.slick({
      slidesToShow: 5, slidesToScroll: 1,
      arrows: true, dots: false,
      autoplay: true, autoplaySpeed: 3000,
      infinite: true, adaptiveHeight: false,
      speed: 350, cssEase: 'ease',
      responsive: [
        { breakpoint: 1280, settings: { slidesToShow: 4 } },
        { breakpoint: 1024, settings: { slidesToShow: 3 } },
        { breakpoint: 768,  settings: { slidesToShow: 2 } },
        { breakpoint: 480,  settings: { slidesToShow: 1 } }
      ]
    });
    return true;
  }

  function boot(ctx){
    var any = false;
    findCandidates(ctx).forEach(function(el){
      tag(el);

      if (homeAsStaticGrid() && document.body.classList.contains('home')) {
        el.classList.add('gtp-static');
        if (typeof jQuery === 'function' && jQuery(el).hasClass('slick-initialized')) {
          try { jQuery(el).slick('unslick'); } catch(e){}
        }
        return;
      }

      any = initSlick(el) || any;
    });
    return any;
  }

  // DOM ready + retries (contenus injectés)
  function ready(fn){ if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fn, {once:true}); else fn(); }
  ready(function(){
    var tries = 0;
    (function tick(){ if (boot(document) || ++tries >= RETRIES) return; setTimeout(tick, 400); })();
  });

  // Observe ajouts DOM (hors header/nav)
  try{
    var mo = new MutationObserver(function(muts){
      for (var i=0;i<muts.length;i++){
        var m = muts[i]; if (!m.addedNodes || !m.addedNodes.length) continue;
        for (var j=0;j<m.addedNodes.length;j++){
          var n = m.addedNodes[j];
          if (n.nodeType === 1 && !inHeader(n)) boot(n);
        }
      }
    });
    mo.observe(document.documentElement, { childList:true, subtree:true });
  }catch(e){}

  // === Tag "Les Actus" pour CSS ciblé (sans toucher aux templates) ===
  (function(){
    function tagNewsSlider(ctx){
      var root = ctx || document;
      var heads = root.querySelectorAll('h1,h2,h3,h4');
      heads.forEach(function(h){
        var t = (h.textContent || '').toLowerCase();
        if (!t.includes('les actus')) return;
        var sec = h.closest('section, .section, .block, .bloc, .wp-block-group, .elementor-widget, .wp-block') || h.parentElement;
        if (!sec) sec = h.parentElement;
        var slider = sec.querySelector('.slick-slider, .slick-initialized') || sec.querySelector('.slick-list') || sec.nextElementSibling;
        if (!slider) return;
        (slider.closest('.slick-slider') || slider).classList.add('gt-news');
        sec.classList.add('gt-news-wrap');
      });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function(){ tagNewsSlider(); }, {once:true}); else { tagNewsSlider(); }
    var tries = 0; (function again(){ if (++tries > 10) return; tagNewsSlider(); setTimeout(again, 300); })();
    try{
      new MutationObserver(function(m){ for (var i=0;i<m.length;i++){ var n = m[i].target; if (n && n.nodeType === 1) tagNewsSlider(n); } })
      .observe(document.documentElement, {subtree:true, childList:true});
    }catch(e){}
  })();
})();
</script>
<?php }, 99);
