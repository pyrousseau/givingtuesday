/*! gt-partners-init.js — autoplay OFF si data-no-slick (ou alias), sinon ON */
(function () {
  // ===== Config =====
  var DEBUG = document.documentElement.hasAttribute('data-partners-debug');
  var log = function(){ if (DEBUG) console.log.apply(console, ['[gt-partners]'].concat([].slice.call(arguments))); };

  // Cible tes répéteurs/carrousels (ajoute/retire si besoin)
  var CAROUSEL_SELECTOR = '.gtp-cards, .gt-cards, .partners-carousel, .block--ideas__list';

  // ===== Helpers =====
  function slickReady(){ return !!(window.jQuery && jQuery.fn && jQuery.fn.slick); }

  function hasNoAutoFlag(node){
    if (!node || node.nodeType !== 1) return false;
    if (node.hasAttribute('data-no-slick') || node.hasAttribute('data-noslick') || node.hasAttribute('datanoslick')) return true;
    return !!(node.closest && node.closest('[data-no-slick],[data-noslick],[datanoslick]'));
  }

  function baseOptions(){
    return {
      slidesToShow: 4,
      slidesToScroll: 1,
      arrows: true,
      dots: false,
      infinite: false,
      speed: 300,
      adaptiveHeight: false,
      autoplay: true,
      autoplaySpeed: 4000,
      // gestes actifs par défaut
      responsive: [
        { breakpoint: 1280, settings: { slidesToShow: 3 } },
        { breakpoint: 992,  settings: { slidesToShow: 2 } },
        { breakpoint: 576,  settings: { slidesToShow: 1 } }
      ]
    };
  }

  function optionsFor(el){
    var o = baseOptions();
    if (hasNoAutoFlag(el)) {
      o.autoplay = false;  // slider manuel (flèches + drag conservés)
    }
    return o;
  }

  function enforceNoAutoplay($el, el){
    if (!hasNoAutoFlag(el)) return;
    try{
      $el.slick('slickSetOption','autoplay',false,true);
      $el.slick('slickPause');
      // s’assurer que l’UI/gestes sont bien actifs
      $el.slick('slickSetOption','arrows',true,true);
      $el.slick('slickSetOption','swipe',true,true);
      $el.slick('slickSetOption','draggable',true,true);
      $el.slick('slickSetOption','touchMove',true,true);
      log('autoplay->OFF (flag present)', el);
    }catch(e){}
  }

  function initOne(el){
    if (!slickReady() || !el || el.nodeType !== 1) return;
    var $el = jQuery(el);
    if ($el.hasClass('slick-initialized')) { enforceNoAutoplay($el, el); return; }
    try {
      $el.slick( optionsFor(el) );
      enforceNoAutoplay($el, el);
      log('init', el);
    } catch(e){ console.error('[gt-partners] slick init error:', e); }
  }

  function initAll(scope){
    (scope||document).querySelectorAll(CAROUSEL_SELECTOR).forEach(initOne);
  }

  // ===== Boot =====
  function boot(){
    if (!slickReady()){
      // Attente douce si Slick/jQuery chargés tard
      var tries=0, t=setInterval(function(){
        if (slickReady() || ++tries > 40){ clearInterval(t); if (slickReady()) boot(); }
      }, 150);
      return;
    }

    initAll();

    // Harmonise à chaque (re)init
    jQuery(document).on('init reInit', function(e, slick){
      var $s = slick && slick.$slider;
      if (!$s || !$s.length) return;
      var el = $s[0];
      enforceNoAutoplay($s, el);
    });

    // Si un data-no-slick (ou alias) est ajouté/retiré après coup, on réapplique
    try{
      var mo = new MutationObserver(function(muts){
        for (const m of muts){
          // changement du flag sur un carousel existant
          if (m.type === 'attributes' &&
              (m.attributeName === 'data-no-slick' || m.attributeName === 'data-noslick' || m.attributeName === 'datanoslick') &&
              m.target && m.target.matches && m.target.matches(CAROUSEL_SELECTOR)) {
            initOne(m.target);
          }
          // nouveaux nœuds insérés
          for (const n of (m.addedNodes||[])){
            if (n.nodeType !== 1) continue;
            if (n.matches?.(CAROUSEL_SELECTOR)) initOne(n);
            else if (n.querySelector) {
              var list = n.querySelectorAll(CAROUSEL_SELECTOR);
              if (list.length) initAll(n);
            }
          }
        }
      });
      mo.observe(document.documentElement, {
        subtree:true, childList:true, attributes:true,
        attributeFilter:['data-no-slick','data-noslick','datanoslick']
      });
    }catch(e){}
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot, {once:true});
  else boot();

  // Mini‑API debug
  window.GTPartners = {
    refresh: function(scope){ initAll(scope); }
  };
})();
