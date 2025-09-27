(function($){
  function initActusSlider(){
    // cible l’inner (si présent) OU, sinon, le premier conteneur qui contient les slides
    var $inner = $('.block__frontpage--actus__slider__inner');
    var $wrap  = $('.block__frontpage--actus');

    // fallback : certains templates n’ont pas __inner → on prend le 1er enfant “liste” qui contient ≥ 3 items
    if (!$inner.length) {
      $inner = $wrap.find('.block__frontpage--actus__slider, .block__frontpage--actus .slides, .block__frontpage--actus .items, .block__frontpage--actus .list')
                    .filter(function(){ return $(this).children().length >= 3; })
                    .first();
    }

    if (!$inner.length || $inner.hasClass('slick-initialized')) return;

    // nombre d’items → auto-adaptatif (si 3 items, on en montre 2 pour que ça “tourne”)
    var count = $inner.children().length;
    var showDesktop = Math.min(3, Math.max(1, count - 1));
    var infinite = count > showDesktop;

    $inner.slick({
      slidesToShow: showDesktop,
      slidesToScroll: 1,
      infinite: infinite,
      adaptiveHeight: true,
      arrows: true,
      prevArrow: $wrap.find('.custom-slick-prev').first(),
      nextArrow: $wrap.find('.custom-slick-next').first(),
      dots: true,
      appendDots: $wrap.find('.custom-slick-dots').first(),
      responsive: [
        { breakpoint: 1024, settings: { slidesToShow: Math.min(showDesktop, 2) } },
        { breakpoint: 640,  settings: { slidesToShow: 1 } }
      ]
    });
  }

  // lance au chargement + retries + écoute l’injection <template> (section data-lazy)
  $(function(){
    var tries = 0;
    (function again(){ tries++; initActusSlider(); if (tries < 25) setTimeout(again, 250); })();

    try{
      var mo = new MutationObserver(initActusSlider);
      mo.observe(document.body, { childList: true, subtree: true });
    }catch(e){}
  });
})(jQuery);
