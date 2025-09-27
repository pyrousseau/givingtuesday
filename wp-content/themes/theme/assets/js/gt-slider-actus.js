(function($){
  function initActusSlider(){
    const $rail = $('.block__frontpage--actus__slider__inner');
    if (!$rail.length) return;

    try {
      if ($rail.hasClass('slick-initialized')) $rail.slick('unslick');
    } catch(e) {}

    $rail.slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      infinite: true,
      arrows: true,
      dots: true,
      adaptiveHeight: true,
      autoplay: true,
      autoplaySpeed: 4000,
      responsive: [
        { breakpoint: 1200, settings: { slidesToShow: 3 } },
        { breakpoint: 1024, settings: { slidesToShow: 2 } },
        { breakpoint: 640,  settings: { slidesToShow: 1 } }
      ]
    });

    // relance un refresh visuel
    setTimeout(function(){
      try {
        $rail.slick('setPosition');
        $rail.slick('refresh');
      } catch(e){}
    }, 300);
  }

  $(initActusSlider);
})(jQuery);
