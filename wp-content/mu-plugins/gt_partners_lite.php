<?php
/**
 * Plugin Name: GT Partners Slick Cards (MU, site-wide)
 * Description: Détection runtime (UL/OL ≥ 3 <img>) + Slick (flèches) + style "cards" homogène. Ignore header/nav. Scrollbars masquées. Exception home (givingtuesday.fr) : cards en grille sans slider.
 * Version: 1.4.0
 * Author: PY + ChatGPT
 */

add_action('wp_head', function () {
  echo "\n<!-- GT Partners Slick Cards MU LOADED v1.4.0 -->\n";
}, 1);

/** CSS global (head) — valeurs demandées : logos 100px, padding 14, arrow left à 74% */
add_action('wp_head', function () {
  ?>
  <style id="gt-partners-slick-cards-css">
    :root{
      --gt-logo-max-h: 100px; /* ← ta valeur */
      --gt-card-pad:     14px; /* ← ta valeur */
      --gt-gap-x:        18px;
    }

    /* ===== Scope “cards” (lists taguées par le JS) ===== */
    .gtp-cards{ list-style:none; padding:0; margin:1.25rem 0; }
    .gtp-cards > li{
      list-style:none;
      background:#fff; border-radius:14px;
      box-shadow:0 1px 3px rgba(0,0,0,.06);
      display:flex; align-items:center; justify-content:center;
      padding:var(--gt-card-pad);
      transition:transform .18s ease, box-shadow .18s ease;
      margin:0 calc(var(--gt-gap-x) / 2);
    }
    .gtp-cards > li:hover{
      transform:translateY(-2px);
      box-shadow:0 6px 16px rgba(0,0,0,.08);
    }
    .gtp-cards img{
      display:block; height:auto; width:auto;
      max-height:var(--gt-logo-max-h);
      filter:none !important; opacity:1 !important;
      transition:transform .18s ease;
    }
    .gtp-cards a:hover img{ transform:scale(1.02); }

    /* Scrollbars masquées (liste brute et slick) */
    .gtp-cards{
      overflow:auto;
      scrollbar-width:none; -ms-overflow-style:none;
      overscroll-behavior-x:contain; touch-action:pan-x;
    }
    .gtp-cards::-webkit-scrollbar{ width:0; height:0; display:none; }

    /* Slick : sécurité z-index + flèches */
    .slick-slider{ position:relative; z-index:0; }
    .slick-prev, .slick-next{ z-index:1; }
    .slick-prev:before, .slick-next:before{
      color:#111; opacity:.85; font-size:28px;
    }
    .slick-prev:hover:before, .slick-next:hover:before{ opacity:1; }

    /* Taille logos unifiée partout (home + internes + slick déjà présent) */
    .gtp-cards img,
    .js-gt-partners img,
    .slick-slider[data-gt-cards="1"] img{
      max-height: var(--gt-logo-max-h) !important;
      height:auto; width:auto; display:block;
      filter:none !important; opacity:1 !important;
      transition: transform .18s ease;
    }

    /* Hauteur de piste cohérente = 100 + 2*14 = 128px */
    .gtp-cards.slick-slider,
    .gtp-cards.slick-slider .slick-list,
    .gtp-cards.slick-slider .slick-track,
    .slick-slider[data-gt-cards="1"],
    .slick-slider[data-gt-cards="1"] .slick-list,
    .slick-slider[data-gt-cards="1"] .slick-track{
      min-height: calc(var(--gt-logo-max-h) + 2 * var(--gt-card-pad)); /* 128px */
    }

    /* Position flèches (gauche 74%, droite 50%) */
    .gtp-cards.slick-slider .slick-prev,
    .slick-slider[data-gt-cards="1"] .slick-prev{
      top: 74% !important;
      transform: translateY(-50%);
    }
    .gtp-cards.slick-slider .slick-next,
    .slick-slider[data-gt-cards="1"] .slick-next{
      top: 50% !important;
      transform: translateY(-50%);
    }

    /* Effet "cards" même si le conteneur est déjà un slick (home, thèmes) */
    .slick-slider[data-gt-cards="1"] .slick-slide{ margin: 0 9px; }
    .slick-slider[data-gt-cards="1"] .slick-slide > *{
      background:#fff; border-radius:14px;
      box-shadow:0 1px 3px rgba(0,0,0,.06);
      display:flex; align-items:center; justify-content:center;
      padding:var(--gt-card-pad);
      transition:transform .18s ease, box-shadow .18s ease;
    }
    .slick-slider[data-gt-cards="1"] .slick-slide > *:hover{
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0,0,0,.08);
    }

    /* Scrollbars masquées côté slick */
    .slick-slider[data-gt-cards="1"] .slick-list{
      scrollbar-width:none; -ms-overflow-style:none; overscroll-behavior-x:contain;
    }
    .slick-slider[data-gt-cards="1"] .slick-list::-webkit-scrollbar{ width:0; height:0; display:none; }

    /* ===== Mode “grid statique” pour la home (sans slider) ===== */
    .gtp-cards.gtp-static{
      display:grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 18px;
      list-style:none;
      padding:0;
      margin:1.5rem 0;
      overflow:visible; /* pas de scroll, pas de scrollbar */
    }
    .gtp-cards.gtp-static > li{ /* cards identiques */
      background:#fff; border-radius:14px;
      box-shadow:0 1px 3px rgba(0,0,0,.06);
      display:flex; align-items:center; justify-content:center;
      padding: var(--gt-card-pad);
      transition:transform .18s ease, box-shadow .18s ease;
    }
    .gtp-cards.gtp-static > li:hover{
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0,0,0,.08);
    }
    .gtp-cards.gtp-static .slick-list,
    .gtp-cards.gtp-static .slick-track{ overflow:visible !important; height:auto !important; }
    .gtp-cards.gtp-static .slick-prev,
    .gtp-cards.gtp-static .slick-next,
    .gtp-cards.gtp-static .slick-dots{ display:none !important; }
 
 /* RESET ultra-ciblé pour la home : logos simples sans style de <ul>/<li> */
.block__frontpage--intro__logos ul.gtp-aff.gtp-static{
  list-style: none !important;
  margin: 0 !important;
  padding: 0 !important;
  display: grid !important;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)) !important;
  gap: 18px !important;
  overflow: visible !important;       /* pas de scrollbar */
}

.block__frontpage--intro__logos ul.gtp-aff.gtp-static > li{
  margin: 0 !important;
  padding: 0 !important;
  background: transparent !important;
  border: 0 !important;
  box-shadow: none !important;
  border-radius: 0 !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
}

/* liens & images : centrés, sans effets */
.block__frontpage--intro__logos ul.gtp-aff.gtp-static a{
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  text-decoration: none !important;
}

.block__frontpage--intro__logos ul.gtp-aff.gtp-static img{
  max-height: 100px !important; /* ta valeur */
  height: auto !important;
  width: auto !important;
  filter: none !important;
  opacity: 1 !important;
  box-shadow: none !important;
}
/* — Bloc logos simple (home) — */
.block__frontpage--intro__logos ul.gtp-aff.gtp-static{
  list-style:none !important;
  margin:0 !important;
  padding:0 !important;

  display:grid !important;
  grid-template-columns:repeat(auto-fit, minmax(160px,1fr)) !important;
  gap:18px !important;

  overflow:visible !important;
  background:transparent !important;
  border:0 !important;
}

/* neutralise tout styling hérité sur les <li> */
.block__frontpage--intro__logos ul.gtp-aff.gtp-static > li{
  margin:0 !important;
  padding:0 !important;
  background:transparent !important;
  border:0 !important;
  box-shadow:none !important;
  border-radius:0 !important;

  display:flex !important;
  align-items:center !important;
  justify-content:center !important;
}

/* liens propres */
.block__frontpage--intro__logos ul.gtp-aff.gtp-static a{
  display:flex !important;
  align-items:center !important;
  justify-content:center !important;
  text-decoration:none !important;
}

/* images : hauteur fixe, largeur auto (pas d’étirement) */
.block__frontpage--intro__logos ul.gtp-aff.gtp-static img{
  max-height:100px !important;   /* ta valeur */
  height:auto !important;
  width:auto !important;

  max-width:none !important;     /* casse les “img{max-width:100%}” qui rapetissent trop */
  object-fit:contain !important;

  filter:none !important;
  opacity:1 !important;
  box-shadow:none !important;
}

/* si un slick s’était glissé : on neutralise flèches/dots dans CE bloc uniquement */
.block__frontpage--intro__logos ul.gtp-aff.gtp-static .slick-list,
.block__frontpage--intro__logos ul.gtp-aff.gtp-static .slick-track{
  overflow:visible !important; height:auto !important;
}
.block__frontpage--intro__logos ul.gtp-aff.gtp-static .slick-prev,
.block__frontpage--intro__logos ul.gtp-aff.gtp-static .slick-next,
.block__frontpage--intro__logos ul.gtp-aff.gtp-static .slick-dots{
  display:none !important;
}

/* conteneur du bloc */
.block__frontpage--intro__logos .intro-logos__label{
  margin: 0 0 12px;
  font-weight: 600;
}

/* grille sans UL/LI */
.block__frontpage--intro__logos .logos-grid{
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 18px;
  margin: 0;
  padding: 0;
}

/* “cartes” très light : si tu veux vraiment *aucun* style, supprime background/box-shadow/border-radius/padding */
.block__frontpage--intro__logos .logo-card{
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;      /* ou #fff si tu veux un fond */
  border-radius: 0;             /* ou 14px si “cards” */
  box-shadow: none;             /* ou 0 1px 3px rgba(0,0,0,.06) */
  padding: 0;                   /* ou 14px si “cards” */
}

/* liens propres */
.block__frontpage--intro__logos .logo-card a{
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
}

/* images en “logos simples” */
.block__frontpage--intro__logos .logo-card img{
  max-height: 100px;  /* ta valeur */
  height: auto;
  width: auto;
  max-width: none;    /* évite les contraintes globales type img{max-width:100%} */
  object-fit: contain;
  filter: none;
  opacity: 1;
  box-shadow: none;
}

/* bloc global */
.gt-supporters{
  --logo-max-h: 100px;    /* hauteur cible identique pour les 3 logos */
  --gap: 28px;            /* espace horizontal entre logos */
  text-align:left
  margin: 0 0 24px;
}

/* ligne 1 : libellé */
.gt-supporters__label{
  font-weight: 700;
  font-size: clamp(18px, 2vw, 22px);
  line-height: 1.2;
  margin-bottom: 14px;
  white-space: nowrap;          /* reste sur une seule ligne */
}

/* ligne 2 : 3 logos sur une seule ligne, centrés, sans wrap */
.gt-supporters__row{
  display: flex;
  justify-content: center;
  align-items: center;
  gap: var(--gap);
  flex-wrap: nowrap;            /* pas de retour à la ligne */
  overflow: hidden;             /* évite les scrollbars si très étroit */
}

/* chaque case logo : même “boîte” pour homogénéiser l’encombrement */
.gt-supporters__logo{
  flex: 0 0 auto;
  width: clamp(140px, 22vw, 220px);   /* largeur adaptable mais comparable */
  height: var(--logo-max-h);          /* hauteur identique pour les 3 */
  display: flex; align-items: center; justify-content: center;
}

/* liens propres */
.gt-supporters__logo a{
  display:flex; align-items:center; justify-content:center;
  text-decoration:none;
}

/* images : même hauteur, largeur auto, pas d’étirement */
.gt-supporters__logo img{
  max-height: var(--logo-max-h);
  height: auto;
  width: auto;
  max-width: 100%;
  object-fit: contain;
  filter: none; opacity: 1;
  display:block;
}

/* Option: si l'écran est vraiment trop étroit, on réduit la hauteur pour tenir sur une ligne */
@media (max-width: 420px){
  .gt-supporters{ --logo-max-h: 72px; --gap: 16px; }
}
/* par défaut : 3 logos sur une seule ligne (déjà en place) */
/* ... */

/* <= 600px : autoriser le wrap et centrer le 3e sur sa ligne */
@media (max-width: 600px){
  .gt-supporters{ --logo-max-h: 84px; --gap: 16px; } /* un peu plus compact */

  .gt-supporters__row{
    flex-wrap: wrap;                /* permet le retour à la ligne */
    justify-content: center;        /* centre chaque ligne */
  }

  /* 2 logos sur la première ligne */
  .gt-supporters__logo{
    flex: 1 1 calc(50% - var(--gap));
    width: auto;                    /* on laisse Flex gérer */
    max-width: 260px;               /* optionnel: évite des logos trop larges */
  }

  /* 3e logo : prend toute la ligne et se centre */
  .gt-supporters__logo:last-child{
    flex-basis: 100%;
    max-width: none;
    display: flex;
    justify-content: center;
  }
}

/* <= 360px (ultra petit) : on peut réduire un peu plus la hauteur */
@media (max-width: 360px){
  .gt-supporters{ --logo-max-h: 72px; --gap: 14px; }
}

/* --- Ferrer entièrement à gauche --- */
.gt-supporters{
  text-align: left;
}

.gt-supporters__label{
  text-align: left;
  margin-left: 0;
}

/* ligne logos : plus de centrage */
.gt-supporters__row{
  justify-content: flex-start;   /* au lieu de center */
}

/* nos “cards” logos : laissez Flex gérer la largeur */
.gt-supporters__logo{
  width: auto !important;        /* override l'ancien clamp(...) */
  flex: 0 0 auto;
}

/* --- Mobile : 2 logos sur la 1ʳᵉ ligne, le 3ᵉ passe à la ligne... à gauche --- */
@media (max-width: 600px){
  .gt-supporters{ --logo-max-h: 84px; --gap: 16px; }

  .gt-supporters__row{
    flex-wrap: wrap;
    justify-content: flex-start; /* aligne chaque ligne à gauche */
    gap: var(--gap);
  }

  /* 2 colonnes */
  .gt-supporters__logo{
    flex: 0 1 calc(50% - var(--gap));
    max-width: none;
  }

  /* important : le 3e n’est PLUS recentré ─ il reste à gauche
     (on retire tout override :last-child précédent) */
}
/* taille de base (déjà chez toi) */
.gt-supporters{
  --logo-max-h: 100px; /* hauteur standard des 1er et 2e logos */
}

/* ➜ 3ᵉ logo plus petit */
.gt-supporters__logo:nth-child(3) img{
  /* 75% de la hauteur standard (change 0.75 si tu veux +/–) */
  max-height: calc(var(--logo-max-h) * 0.65);
}

/* Si tu veux que la "boîte" du 3ᵉ prenne un peu moins de place visuelle : */
.gt-supporters__logo:nth-child(3){
  /* réduit légèrement sa largeur visuelle sans casser l’alignement */
  transform: scale(0.9);          /* ajuste 0.85–0.95 au besoin */
  transform-origin: left center;  /* ferré à gauche */
}

@media (max-width: 600px){
  /* on peut encore le réduire un chouïa sur mobile */
  .gt-supporters__logo:nth-child(3) img{
    max-height: calc(var(--logo-max-h) * 0.60);
  }
  .gt-supporters__logo:nth-child(3){
    transform: scale(0.88);
  }
}
.gt-porteur{ text-align:left; margin:0 0 20px; }
.gt-porteur__label{ font-weight:700; font-size:clamp(18px,2vw,22px); margin-bottom:10px; white-space:nowrap; }
.gt-porteur__logo{ display:flex; align-items:center; justify-content:flex-start; }
.gt-porteur__logo img{ max-height:100px; height:auto; width:auto; object-fit:contain; }
@media (max-width:480px){ .gt-porteur__logo img{ max-height:84px; } }

.gt-supporters, .gt-porteur{
  margin-top:20px;
}
.gt-supporters__logo:nth-child(1) img {
    max-height: calc(var(--logo-max-h) * 1.6);
}
.gt-porteur__logo img {
   max-height: calc(var(--logo-max-h) * 1.1);
}

/* 1) Ne coupe plus les logos */
.gt-supporters__row,
.gt-supporters__logo{
  overflow: visible !important;          /* au cas où */
}

/* 2) Laisse la boîte s'adapter à l'image (au lieu d'une hauteur fixe) */
.gt-supporters__logo{
  height: auto;                           /* ← avant: height: var(--logo-max-h) */
  min-height: var(--logo-max-h);          /* garde une hauteur de base pour l’alignement */
  display: flex;
  align-items: center;
  justify-content: flex-start;            /* ou center si tu préfères */
}

/* 3) Image bien contenue sans coupe */
.gt-supporters__logo img{
  display: block;
  height: auto;
  max-height: var(--logo-max-h);          /* limite la hauteur */
  width: auto;
  max-width: 100%;                        /* ne déborde pas horizontalement */
  object-fit: contain;                    /* pas d’écrasement ni de rognage */
}

/* 4) Si tu avais mis un overflow:hidden quelque part avant, on neutralise */
.gt-supporters__row{ overflow: visible !important; }

/* Option : pour “Label porteurs” uniquement, on peut autoriser un poil plus de hauteur */
.gt-porteurs{ --logo-max-h: 110px; }      /* augmente juste pour ce bloc si besoin */

/* === HOME — Actus : flèche gauche trop basse + “fantômes” de Slick === */

/* 1) Version ciblée si ton bloc a cette classe */
.home .block__frontpage--news .slick-prev,
.home .block__frontpage--news .slick-next{
  top: 50% !important;
  transform: translateY(-50%) !important;
  z-index: 5 !important;
}
.home .block__frontpage--news .slick-prev:before,
.home .block__frontpage--news .slick-next:before,
.home .block__frontpage--news .slick-dots{
  display: none !important;
  content: "" !important;
  opacity: 0 !important;
  visibility: hidden !important;
}
.home .block__frontpage--news .slick-list{ overflow: visible !important; }

/* 2) Si (1) ne prend pas parce que la classe est différente,
   applique au slider d’actus ou, à défaut, à TOUS les sliders de la home
   sauf nos carrousels partenaires taggés data-gt-cards (pour ne rien casser). */
.home .slick-slider:not([data-gt-cards="1"]) .slick-prev,
.home .slick-slider:not([data-gt-cards="1"]) .slick-next{
  top: 50% !important;
  transform: translateY(-50%) !important;
  z-index: 5 !important;
}
.home .slick-slider:not([data-gt-cards="1"]) .slick-prev:before,
.home .slick-slider:not([data-gt-cards="1"]) .slick-next:before,
.home .slick-slider:not([data-gt-cards="1"]) .slick-dots{
  display: none !important;
  content: "" !important;
  opacity: 0 !important;
  visibility: hidden !important;
}
.home .slick-slider:not([data-gt-cards="1"]) .slick-list{ overflow: visible !important; }

/* === ACTUS (gt-news) : flèches centrées + masquer flèches/dots Slick fantômes === */
.gt-news .slick-prev,
.gt-news .slick-next{
  top:50% !important;
  transform:translateY(-50%) !important;
  z-index:10 !important;
}
.gt-news .slick-prev:before,
.gt-news .slick-next:before,
.gt-news .slick-dots{
  display:none !important;
  content:"" !important;
  opacity:0 !important;
  visibility:hidden !important;
}
/* éviter qu'un overflow coupe les flèches */
.gt-news .slick-list{ overflow:visible !important; }

/* Desktop only : remonter la flèche gauche dans "Les Actus" */
@media (min-width: 1024px){
  .gt-news .slick-prev{
    top: 42% !important;          /* ← ajuste 40–48% selon ton œil */
    transform: translateY(-50%) !important;
  }
  .gt-news .slick-next{
    top: 50% !important;          /* on garde la droite centrée */
    transform: translateY(-50%) !important;
  }
}


 </style>
  <?php
}, 5);

/** Slick depuis CDN (remplace par tes assets locaux si besoin) */
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_script('jquery');
  wp_enqueue_style('slick',       'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', [], '1.8.1');
  wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', ['slick'], '1.8.1');
  wp_enqueue_script('slick',      'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], '1.8.1', true);
}, 5);

/** JS (head) — détection runtime + init Slick + exception home (givingtuesday.fr) */
add_action('wp_head', function () {
  ?>
  <script id="gt-partners-slick-cards-js">
  (function(){
    var RETRIES = 14; // 14*400ms ≈ 5.6s
    var MIN_IMG = 3;

    // Active l'exception seulement en home du domaine prod
function isHomeException(){
  return false; // ← on enlève l'exception : la home slidera, flèches incluses
}


    function inHeader(el){
      try{
        return !!(el.closest && el.closest('header, nav, .site-header, #site-header, .header, #header, .navbar, .menu, .main-navigation, .primary-menu'));
      }catch(e){ return false; }
    }

    function looksLikeLogoList(el){
      if (!el || !/^(UL|OL)$/i.test(el.tagName)) return false;
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
      if (!el.classList.contains('js-gt-partners')) el.classList.add('js-gt-partners');
      if (!el.classList.contains('gtp-cards'))      el.classList.add('gtp-cards');
      return el;
    }

    function findCandidates(root){
      var out = [];
      (root || document).querySelectorAll('ul,ol').forEach(function(n){
        if (looksLikeLogoList(n)) out.push(n);
      });
      return out;
    }

    function initSlickOn(list){
      if (typeof jQuery !== 'function' || !jQuery.fn || !jQuery.fn.slick) return false;
      var $ = jQuery, $el = $(list);
      if ($el.hasClass('slick-initialized')) return true;

      $el.slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay: true,
        autoplaySpeed: 3000,
        infinite: true,
        adaptiveHeight: false,
        speed: 350,
        cssEase: 'ease',
        responsive: [
          { breakpoint: 1280, settings: { slidesToShow: 4 } },
          { breakpoint: 1024, settings: { slidesToShow: 3 } },
          { breakpoint: 768,  settings: { slidesToShow: 2 } },
          { breakpoint: 480,  settings: { slidesToShow: 1 } }
        ]
      });

      // Marque le conteneur slick pour activer le style "cards"
      $el.closest('.slick-slider').attr('data-gt-cards', '1');
      return true;
    }

    function boot(ctx){
      var any = false;
      findCandidates(ctx).forEach(function(el){
        tag(el);

        // Exception home prod : cards statiques sans slider
        if (isHomeException()) {
          el.classList.add('gtp-static');
          el.setAttribute('data-gt-cards', '1');
          // Si un slick a déjà été initialisé par le thème : on le retire
          if (typeof jQuery === 'function' && jQuery(el).hasClass('slick-initialized')) {
            try { jQuery(el).slick('unslick'); } catch(e){}
          }
          return; // pas d'init slick
        }

        // Comportement normal ailleurs : Slick + flèches
        any = initSlickOn(el) || any;
      });
      return any;
    }

    // DOM ready + retries (contenus injectés)
    function ready(fn){ if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fn, {once:true}); else fn(); }
    ready(function(){
      var tries = 0;
      (function tick(){
        if (boot(document) || ++tries >= RETRIES) return;
        setTimeout(tick, 400);
      })();

      // Marquer aussi les slick déjà présents (ex: home pilotée par le thème)
      if (window.jQuery){
        jQuery('.slick-slider').each(function(){
          var $s = jQuery(this);
          if ($s.attr('data-gt-cards') === '1') return;
          if ($s.find('img').length >= 3) $s.attr('data-gt-cards','1');
        });
      }
    });

    // Observe ajouts DOM (hors header/nav)
    try{
      var mo = new MutationObserver(function(muts){
        for (var i=0;i<muts.length;i++){
          var m = muts[i];
          if (!m.addedNodes || !m.addedNodes.length) continue;
          for (var j=0;j<m.addedNodes.length;j++){
            var n = m.addedNodes[j];
            if (n.nodeType === 1 && !inHeader(n)) boot(n);
          }
        }
      });
      mo.observe(document.documentElement, { childList:true, subtree:true });
    }catch(e){}
  })();

  // === Tag "Les Actus" pour CSS ciblé (sans toucher aux templates) ===
(function(){
  function tagNewsSlider(ctx){
    var root = ctx || document;
    var heads = root.querySelectorAll('h1,h2,h3,h4');
    heads.forEach(function(h){
      var t = (h.textContent || '').toLowerCase();
      if (!t.includes('les actus')) return; // "Les Actus du #GivingTuesday"
      // on remonte/descend pour trouver le slick le plus proche
      var sec = h.closest('section, .section, .block, .bloc, .wp-block-group, .elementor-widget, .wp-block') || h.parentElement;
      if (!sec) sec = h.parentElement;
      var slider = sec.querySelector('.slick-slider, .slick-initialized') 
                || sec.querySelector('.slick-list') 
                || sec.nextElementSibling;
      if (!slider) return;
      // place un marqueur sur le conteneur logique
      (slider.closest('.slick-slider') || slider).classList.add('gt-news');
      sec.classList.add('gt-news-wrap');
    });
  }

  // premier passage + retries + mutation observer
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function(){ tagNewsSlider(); }, {once:true});
  } else { tagNewsSlider(); }
  var tries = 0; (function again(){
    if (++tries > 10) return;
    tagNewsSlider(); setTimeout(again, 300);
  })();
  try{
    var mo = new MutationObserver(function(m){
      for (var i=0;i<m.length;i++){
        var n = m[i].target || null;
        if (n && n.nodeType === 1) tagNewsSlider(n);
      }
    });
    mo.observe(document.documentElement, {subtree:true, childList:true});
  }catch(e){}
})();

  </script>
    <style id="gt-news-arrow-fix">
    @media (min-width: 1024px){
      .gt-news.gtp-cards.slick-slider .slick-prev,
      .gt-news .gtp-cards.slick-slider .slick-prev,
      .gt-news.slick-slider[data-gt-cards="1"] .slick-prev,
      .gt-news .slick-slider[data-gt-cards="1"] .slick-prev {
        top: 50% !important;
        transform: translateY(-50%) !important;
      }
    }
  </style>
  <?php
}, 99);
