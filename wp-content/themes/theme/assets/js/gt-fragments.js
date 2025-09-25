/*!
 * [GT] Fragments — Safe runner (countdown + actus) avec observer débouncé
 * Dépendances pour Actus : jQuery + slick.min.js (le compteur n'en dépend pas)
 */
(function () {
  "use strict";

  /* ------------ COUNTDOWN ------------- */
  var MS_DAY = 86400000, MS_H = 3600000, MS_M = 60000;
  var counterStarted = false;     // évite multi-intervals
  var counterInt = null;

  function pad(n){ return (n < 10 ? '0' : '') + n; }

  function computeEndTs(el){
    var ts = parseInt(el.getAttribute('data-deadline-ts') || '', 10);
    if (Number.isFinite(ts)) return ts;

    var dstr = el.getAttribute('data-deadline-date');
    if (dstr && /^\d{4}-\d{2}-\d{2}$/.test(dstr)) {
      var p = dstr.split('-'); // cible 05:00 locale pour rester cohérent
      return new Date(+p[0], +p[1]-1, +p[2], 5, 0, 0).getTime();
    }

    var iso = el.getAttribute('data-deadline');
    var t = iso ? Date.parse(iso) : NaN;
    return Number.isFinite(t) ? t : NaN;
  }

  function renderCountdown(el, end){
    var diff = end - Date.now();
    if (diff < 0) diff = 0;

    var dBase = Math.floor(diff / MS_DAY);
    var rem   = diff % MS_DAY;

    var inclusive = el.getAttribute('data-count-inclusive') === '1';
    var dShow = inclusive && rem > 0 ? dBase + 1 : dBase;

    var h = Math.floor(rem / MS_H);
    var m = Math.floor((rem % MS_H) / MS_M);
    var s = Math.floor((rem % MS_M) / 1000);

    var items = el.querySelectorAll('.item');
    if (items.length >= 4) {
      items[0].innerHTML = '<span class="time">'+ dShow +'</span><span class="time-text">jours</span>';
      items[1].innerHTML = '<span class="time">'+ h +'</span><span class="time-text">heures</span>';
      items[2].innerHTML = '<span class="time">'+ pad(m) +'</span><span class="time-text">min.</span>';
      items[3].innerHTML = '<span class="time">'+ pad(s) +'</span><span class="time-text">sec.</span>';
    }
  }

  function startCounterIfReady(){
    if (counterStarted) return;

    var el = document.getElementById('gt-timer');
    if (!el) return;

    // tue un vieux timer hérité s'il existe
    if (window.timer) { try { clearInterval(window.timer); } catch(e){} window.timer = null; }
    if (typeof window.dateHtml === 'function') { window.dateHtml = function(){}; }

    var end = computeEndTs(el);
    if (!Number.isFinite(end)) return;

    // 1er rendu + interval
    renderCountdown(el, end);
    counterStarted = true;
    if (counterInt) clearInterval(counterInt);
    counterInt = setInterval(function(){ renderCountdown(el, end); }, 1000);
  }

(function(){
  "use strict";
  var MS_DAY=86400000, MS_H=3600000, MS_M=60000;
  var finder = setInterval(boot, 300), ticking = false, tickInt = null;

  function pad(n){ return (n<10?'0':'')+n; }
  function getEnd(el){
    var ts = parseInt(el.getAttribute('data-deadline-ts')||'',10);
    if (Number.isFinite(ts)) return ts;
    var d = el.getAttribute('data-deadline-date');
    if (d && /^\d{4}-\d{2}-\d{2}$/.test(d)){ var p=d.split('-'); return new Date(+p[0],+p[1]-1,+p[2],5,0,0).getTime(); }
    var iso = el.getAttribute('data-deadline'); var t = iso?Date.parse(iso):NaN; return Number.isFinite(t)?t:NaN;
  }
  function render(el,end){
    var diff = end - Date.now(); if (diff<0) diff=0;
    var dBase=Math.floor(diff/MS_DAY), rem=diff%MS_DAY;
    var dShow=(el.getAttribute('data-count-inclusive')==='1' && rem>0)? dBase+1 : dBase;
    var h=Math.floor(rem/MS_H), m=Math.floor((rem%MS_H)/MS_M), s=Math.floor((rem%MS_M)/1000);
    var items=el.querySelectorAll('.item'); if(items.length<4) return;
    items[0].innerHTML='<span class="time">'+dShow+'</span><span class="time-text">jours</span>';
    items[1].innerHTML='<span class="time">'+h+'</span><span class="time-text">heures</span>';
    items[2].innerHTML='<span class="time">'+pad(m)+'</span><span class="time-text">min.</span>';
    items[3].innerHTML='<span class="time">'+pad(s)+'</span><span class="time-text">sec.</span>';
  }
  function boot(){
    var el = document.getElementById('gt-timer');
    if (!el || ticking) return;
    var end = getEnd(el);
    if (!Number.isFinite(end)) return;

    // stoppe le finder, démarre 1 seul interval
    clearInterval(finder); finder=null; ticking=true;
    // coupe tout vieux interval global
    if (window.timer){ try{ clearInterval(window.timer);}catch(e){} window.timer=null; }
    // premier rendu + interval
    render(el,end);
    tickInt && clearInterval(tickInt);
    tickInt = setInterval(function(){ render(el,end); }, 1000);
  }

  // si DOM déjà prêt, tente tout de suite
  if (document.readyState!=='loading') boot();
  else document.addEventListener('DOMContentLoaded', boot, {once:true});
})();


  /* ------------ ACTUS (Slick) ------------- */
  var actusStarted = false;

  function slickReady(){
    return (typeof jQuery !== 'undefined' && jQuery.fn && typeof jQuery.fn.slick === 'function');
  }

  function startActusIfReady(){
    if (actusStarted) return;
    if (!slickReady()) return;

    var $ = jQuery;
    var $inner = $('#home-actus .block__frontpage--actus__slider__inner');
    if (!$inner.length || $inner.hasClass('slick-initialized')) return;

    var $wrap = $('#home-actus .block__frontpage--actus__slider');
    $inner.css('visibility', 'hidden');

    $inner.on('init', function(){
      setTimeout(function(){
        $inner.slick('setPosition');
        $inner.css('visibility', 'visible');
      }, 0);
    });

    $inner.slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      adaptiveHeight: true,
      infinite: false,
      appendDots: $wrap.find('.custom-slick-dots'),
      prevArrow:  $wrap.find('.custom-slick-prev'),
      nextArrow:  $wrap.find('.custom-slick-next'),
      fade: false,
      cssEase: 'ease',
      speed: 300,
      swipe: true,
      draggable: true
    });

    // filet reflow
    setTimeout(function(){
      if ($inner.hasClass('slick-initialized')) $inner.slick('setPosition');
    }, 300);

    actusStarted = true;
  }

  /* ------------ BOOT + OBSERVER SAFE ------------- */

  // boot initial
  function boot(){
    startCounterIfReady();
    startActusIfReady();
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot, { once:true });
  } else {
    boot();
  }

  // observer débouncé (pas de boucle infinie)
  var scheduleId = null;
  function scheduleBoot(){
    if (scheduleId) return;
    scheduleId = setTimeout(function(){
      scheduleId = null;
      boot();
    }, 150);
  }

  try {
    var mo = new MutationObserver(function(muts){
      // On ne redéclenche que si des nœuds ont été AJOUTÉS (injection de fragment)
      for (var i=0; i<muts.length; i++){
        if (muts[i].addedNodes && muts[i].addedNodes.length) { scheduleBoot(); break; }
      }
    });
    // Observer seulement le <body> pour limiter le bruit
    mo.observe(document.body, { childList:true, subtree:true });
  } catch(e){}

  // sécurité : repositionne Slick au resize/orientation (léger)
  function setPos(){
    if (!slickReady()) return;
    jQuery('#home-actus .block__frontpage--actus__slider__inner.slick-initialized').slick('setPosition');
  }
  window.addEventListener('resize', setPos);
  window.addEventListener('orientationchange', setPos);
})();
