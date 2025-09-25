(function ($) {
  function bootPartners() {
    var $list = $('.js-gt-partners');

    if (!$list.length) return;
    if (typeof $.fn.slick !== 'function') return;

    $list.each(function () {
      var $el = $(this);
      if ($el.data('slick-inited')) return;

      $el.slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [
          { breakpoint: 1200, settings: { slidesToShow: 4 } },
          { breakpoint: 992,  settings: { slidesToShow: 3 } },
          { breakpoint: 768,  settings: { slidesToShow: 2 } },
          { breakpoint: 480,  settings: { slidesToShow: 1 } }
        ]
      });

      $el.data('slick-inited', 1);
    });
  }

  // DOM ready + éventuellement ré-exécuter après Ajax/ACF
  $(bootPartners);
  document.addEventListener('gt:refresh', bootPartners); // hook maison si besoin
})(jQuery);
