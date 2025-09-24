/*! lazy-io.js — stable */
(function () {
  // ========= Config =========
  const DEBUG = document.documentElement.hasAttribute('data-lazy-debug');
  const ROOT_MARGIN_PAGE = '200px 0px';             // IO (page) précharge ~200px avant le viewport
  const SLIDER_SELECTOR  = '.block--banner__slider';// conteneur du hero Slick
  const log = (...a)=>DEBUG&&console.log('[lazy-io]', ...a);

  // ========= CSS (fade‑in) =========
  (function injectCSS(){
    if (document.getElementById('lazy-io-css')) return;
    const css = [
      '.js-lazy, picture.js-lazy img, .js-lazy-bg, [data-lazy]{opacity:0;transition:opacity .25s ease}',
      '.is-loaded, picture.js-lazy.is-loaded img, img.is-loaded{opacity:1}'
    ].join('\n');
    const s = document.createElement('style'); s.id='lazy-io-css'; s.textContent = css;
    document.head.appendChild(s);
  })();

  // ========= Sanitizer : retire src/srcset des <picture class="js-lazy"> non chargés =========
  function sanitizeLazyPictures(root = document) {
    root.querySelectorAll('picture.js-lazy:not(.is-loaded)').forEach(pic => {
      let changed = false;

      // <source srcset> -> data-srcset
      pic.querySelectorAll('source[srcset]').forEach(src => {
        src.setAttribute('data-srcset', src.getAttribute('srcset'));
        src.removeAttribute('srcset');
        changed = true;
      });

      // <img src/srcset> -> data-src / data-srcset (pas de loading/fetchpriority sur lazy)
      const img = pic.querySelector('img');
      if (img) {
        if (img.hasAttribute('srcset')) { img.setAttribute('data-srcset', img.getAttribute('srcset')); img.removeAttribute('srcset'); changed = true; }
        if (img.hasAttribute('src'))    { img.setAttribute('data-src',    img.getAttribute('src'));    img.removeAttribute('src');    changed = true; }
        img.removeAttribute('loading'); img.removeAttribute('fetchpriority');
      }

      if (changed) pic.classList.remove('is-loaded');
    });
  }
  window.__gtSanitize = sanitizeLazyPictures;

  // Plugins d’optimisation : ne re‑sanitize que si l’élément n’est pas encore chargé
  const antiReinject = new MutationObserver(muts => {
    let need = false;
    for (const m of muts) {
      if (m.type === 'attributes') {
        const el = m.target;
        if (el.closest && el.closest('picture.js-lazy:not(.is-loaded)')) {
          if (m.attributeName === 'src' || m.attributeName === 'srcset') { need = true; break; }
        }
      }
      if (m.addedNodes && m.addedNodes.length) {
        for (const node of m.addedNodes) {
          if (node.nodeType === 1 && node.closest && node.closest('picture.js-lazy:not(.is-loaded)')) { need = true; break; }
        }
      }
    }
    if (need) sanitizeLazyPictures();
  });

  // ========= Hydratation =========
  function hydrate(el){
    if (!el) return;

    // <picture>
    if (el.tagName === 'PICTURE'){
      el.querySelectorAll('source[data-srcset]').forEach(s=>{
        s.setAttribute('srcset', s.getAttribute('data-srcset'));
        s.removeAttribute('data-srcset');
      });
      const img = el.querySelector('img');
      if (img){
        if (img.dataset.srcset){ img.setAttribute('srcset', img.dataset.srcset); img.removeAttribute('data-srcset'); }
        if (img.dataset.src){ img.src = img.dataset.src; img.removeAttribute('data-src'); }
        img.classList.add('is-loaded'); // important pour annuler l’opacité 0
      }
      el.classList.add('is-loaded');
      log('hydrate <picture>', el);
      return;
    }

    // <img>
    if (el.tagName === 'IMG'){
      if (el.dataset.srcset){ el.setAttribute('srcset', el.dataset.srcset); el.removeAttribute('data-srcset'); }
      if (el.dataset.src){ el.src = el.dataset.src; el.removeAttribute('data-src'); }
      el.classList.add('is-loaded');
      log('hydrate <img>', el);
      return;
    }

    // <iframe>
    if (el.tagName === 'IFRAME' && el.dataset.src){
      el.src = el.dataset.src; el.removeAttribute('data-src');
      el.classList.add('is-loaded');
      log('hydrate <iframe>', el);
      return;
    }

    // background-image
    if (el.classList.contains('js-lazy-bg') && el.dataset.bg){
      el.style.backgroundImage = `url("${el.dataset.bg}")`;
      el.classList.add('is-loaded');
      log('hydrate bg', el);
      return;
    }

    // bloc HTML différé via <template>
    if (el.hasAttribute('data-lazy')){
      const tpl = el.querySelector('template');
      if (tpl){ el.appendChild(tpl.content.cloneNode(true)); initWhenVisible(el); }
      el.classList.add('is-loaded'); el.removeAttribute('data-lazy');
      log('hydrate <template>', el);
    }
  }
  window.__gtHydrate = hydrate;

  // ========= IO global (reste de la page) =========
  function bootPageIO(){
    const candidates = document.querySelectorAll('.js-lazy, picture.js-lazy, .js-lazy-bg, [data-lazy]');
    if (!('IntersectionObserver' in window)) {
      log('IO not supported → hydrate all');
      candidates.forEach(hydrate);
      return;
    }
    const io = new IntersectionObserver((entries)=>{
      entries.forEach(entry=>{
        if (!entry.isIntersecting) return;
        io.unobserve(entry.target);
        hydrate(entry.target);
      });
    }, { root:null, rootMargin: ROOT_MARGIN_PAGE, threshold: 0.01 });

    candidates.forEach(el=> io.observe(el));
    log('bootPageIO. Candidates:', candidates.length);
  }

  // ========= Hook slider (Slick) : hydrate slide courante + voisine =========
  function hookHeroSlider(){
    const $ = window.jQuery;
    const slider = document.querySelector(SLIDER_SELECTOR);
    if (!slider) return;

    // hydrate toutes les images lazy d’un slide donné
    function hydrateIn(node){
      node.querySelectorAll('picture.js-lazy, img.js-lazy').forEach(hydrate);
    }

    function hydrateCurrentAndNeighbors(slick){
      const cur = slick.currentSlide;
      const $slides = slick.$slides; // jQuery collection
      const len = $slides.length;

      // Courante
      const curEl = $slides.get(cur);
      if (curEl) hydrateIn(curEl);

      // Voisine suivante (pré‑charge)
      const nextEl = $slides.get((cur + 1) % len);
      if (nextEl) hydrateIn(nextEl);

      // (Optionnel) Voisine précédente
      const prevEl = $slides.get((cur - 1 + len) % len);
      if (prevEl) hydrateIn(prevEl);
    }

    // Cas 1 : Slick disponible (normal ici)
    if ($ && $.fn && $.fn.slick && $(slider).on){
      $(slider)
        .on('init', function(e, slick){
          sanitizeLazyPictures(slider);       // enlève tout src/srcset résiduel
          hydrateCurrentAndNeighbors(slick);  // hydrate visible + pré‑charge
        })
        .on('afterChange', function(e, slick){
          hydrateCurrentAndNeighbors(slick);
        });

      // Si le slider est déjà initialisé (classe slick-initialized déjà sur le DOM)
      if (slider.classList.contains('slick-initialized')) {
        const slick = $(slider).slick('getSlick');
        sanitizeLazyPictures(slider);
        hydrateCurrentAndNeighbors(slick);
      }
      log('hookHeroSlider: Slick events attached');
    } else {
      // Cas 2 : filet sans jQuery (au cas où)
      const hydrateActives = () => {
        slider.querySelectorAll('.slick-current, .slick-active').forEach(el => hydrateIn(el));
      };
      new MutationObserver(hydrateActives)
        .observe(slider, { attributes:true, subtree:true, attributeFilter:['class'] });
      sanitizeLazyPictures(slider);
      hydrateActives();
      log('hookHeroSlider: fallback MutationObserver');
    }
  }

  // ========= Init composants insérés dynamiquement (ex. sliders dans templates) =========
  function initWhenVisible(container){
    container.querySelectorAll('[data-init-on-visible]').forEach(node=>{
      if (node.dataset._inited === '1') return;
      const type = node.getAttribute('data-init-on-visible');
      if (type === 'slick' && window.jQuery && jQuery.fn && jQuery.fn.slick){
        jQuery(node).slick(/* options si besoin */);
        node.dataset._inited = '1';
      }
    });
  }

  // ========= Boot =========
  function init(){
    // Surveille ré‑injections (plugins images)
    antiReinject.observe(document.documentElement, { subtree:true, childList:true, attributes:true, attributeFilter:['src','srcset'] });

    // 1) Nettoyage immédiat des <picture.js-lazy> non chargés
    sanitizeLazyPictures();

    // 2) Hero slider (au‑dessus de la ligne) : init + hydratations courante/voisine
    hookHeroSlider();

    // 3) IO pour le reste de la page
    bootPageIO();
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init, {once:true});
  else init();
})();
