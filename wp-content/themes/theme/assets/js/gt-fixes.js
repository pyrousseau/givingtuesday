/*! gt-fixes.js — idées slider manuel (hors home), aucun data-gt-cards */
(function (w) {
  function ideasManual($) {
    if (document.body.classList.contains('home')) return; // home intact
    var $s = $('.block--ideas__list.slick-initialized');
    if (!$s.length) return;
    try {
      $s.slick('slickSetOption','autoplay',false,true);
      $s.slick('slickPause');
      $s.slick('slickSetOption','arrows',true,true);
      $s.slick('slickSetOption','swipe',true,true);
      $s.slick('slickSetOption','draggable',true,true);
      $s.slick('slickSetOption','touchMove',true,true);
    } catch(e){}
  }

  function boot(){
    if (!w.jQuery || !jQuery.fn || !jQuery.fn.slick){
      var tries=0, t=setInterval(function(){
        if (w.jQuery && jQuery.fn && jQuery.fn.slick){ clearInterval(t); jQuery(function(){ ideasManual(jQuery); setTimeout(()=>ideasManual(jQuery),400); }); }
        else if (++tries>40){ clearInterval(t); }
      },150);
      return;
    }
    jQuery(function(){ ideasManual(jQuery); setTimeout(()=>ideasManual(jQuery),400); });
    jQuery(document).on('init reInit', function(e,slick){
      if (slick?.$slider?.is('.block--ideas__list')) ideasManual(jQuery);
    });
  }
  if (document.readyState==='loading') document.addEventListener('DOMContentLoaded', boot, {once:true}); else boot();
})(window);
