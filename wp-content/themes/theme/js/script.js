function participentHideElement() {
    if ($('.block__participent_list').length) {
        if ($(window).width() > 767) {
            $('.block__participent_list li').each(function () {
                var block = $(this);
                if (block.index() > 11) {
                    block.addClass('is-hide');
                }
            });
            soutiennentCount('.block__participent_list');
        } else {
            $('.block__participent_list li').removeClass('is-hide is-visible');
        }
    }
}
function soutiennentCount(block) {
    var allElement = $(block + ' li').length,
        visibleElement = allElement - $(block + ' li.is-hide').length;
    $(block + '--more-block .vu-info').text(visibleElement);
    $(block + '--more-block .sur-info').text(allElement);
}
function participentSliderMobileDestroy() {
    if ($('.block__participent_list').hasClass('slider-version')) {
        $('.participent_list-counter').remove();
        $('.block__participent_list').removeClass('slider-version').slick('unslick');
        $('.block__participent_list .list-wrapper-block li').unwrap();
    }
}

function participentSliderMobile(n) {
    if ($(window).width() < 768 && $('.block__participent_list').length) {
        var partBlock = '.block__participent_list';
        if (!$(partBlock).hasClass('slider-version')) {
            $(partBlock).addClass('slider-version');
            var countElements = $(partBlock + ' >li').length,
                wrapCount = 0;
            if (countElements > n) {
                if (countElements % n != 0) {
                    wrapCount = parseInt(countElements / n) + 1;
                } else {
                    wrapCount = parseInt(countElements / n);
                }
            } else {
                wrapCount = 1;
            }
            for (var i = 0; i < wrapCount; i++) {
                $(partBlock + ' >li:lt(' + n + ')').wrapAll('<div class="list-wrapper-block"></div>');
            }

            $(partBlock).after('<div class="participent_list-counter"></div>');
            $(partBlock).on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
                //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
                var i = (currentSlide ? currentSlide : 0) + 1;
                $('.participent_list-counter').text(i + '/' + slick.slideCount);
            });

            $(partBlock).slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: false,
                dots: false,
                speed: 500,
                infinite: false
            });

        }
    } else {
        if ($(window).width() > 767 && $('.block__participent_list').length) {
            participentSliderMobileDestroy();
        }
    }
}

function actuSlider() {
    var slide = $('.block__frontpage--actus .slide-block');
    var slide1 = $('.block__frontpage--actus .slide-block').eq(0);
    var slide2 = $('.block__frontpage--actus .slide-block').eq(1);
    var slide3 = $('.block__frontpage--actus .slide-block').eq(2);

    slide1.attr('tabindex', 1).addClass('slick-left');
    slide2.attr('tabindex', 2).addClass('slick-center');
    slide3.attr('tabindex', 3).addClass('slick-right');

    function removeClasses() {
        slide.removeClass('slick-left');
        slide.removeClass('slick-center');
        slide.removeClass('slick-right');
    }

    function goSlide1() {
        removeClasses();
        slide1.addClass('slick-center');
        slide2.addClass('slick-right');
        slide3.addClass('slick-left');
        $('.block__frontpage--actus__slider .slick-dots [tabindex="1"]').parent().addClass('slick-active').siblings().removeClass('slick-active');
    }

    function goSlide2() {
        removeClasses();
        slide1.addClass('slick-left');
        slide2.addClass('slick-center');
        slide3.addClass('slick-right');
        $('.block__frontpage--actus__slider .slick-dots [tabindex="2"]').parent().addClass('slick-active').siblings().removeClass('slick-active');
    }

    function goSlide3() {
        removeClasses();
        slide1.addClass('slick-right');
        slide2.addClass('slick-left');
        slide3.addClass('slick-center');
        $('.block__frontpage--actus__slider .slick-dots [tabindex="3"]').parent().addClass('slick-active').siblings().removeClass('slick-active');
    }

    $('.block__frontpage--actus__slider .slick-dots button').on('click', function () {

        var tabindex = $(this).attr('tabindex');
        if (tabindex == 1) {
            goSlide1();
        } else if (tabindex == 2) {
            goSlide2();
        } else {
            goSlide3();
        }
    })

    $('.block__frontpage--actus .slick-next').on('click', function () {
        if (slide1.hasClass('slick-center')) {
            goSlide2();
        } else if (slide2.hasClass('slick-center')) {
            goSlide3();
        } else if (slide3.hasClass('slick-center')) {
            goSlide1();
        }
    })

    $('.block__frontpage--actus .slick-prev').on('click', function () {
        if (slide1.hasClass('slick-center')) {
            goSlide3();
        } else if (slide2.hasClass('slick-center')) {
            goSlide1();
        } else if (slide3.hasClass('slick-center')) {
            goSlide2();
        }
    })

}

/*** Sticky header ***/
function stickyHeader() {
    if ($(window).scrollTop() > 31) {
        $('body').addClass('hasSticky');
    } else {
        $('body').removeClass('hasSticky');
    }
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 31) {
            $('body').addClass('hasSticky');
        } else {
            $('body').removeClass('hasSticky');
        }
    });
}

jQuery(document).ready(function ($) {
    $("#menu-general_navigation li.menu-item.menu-item-has-children").click(function () {
        $(this).toggleClass("active");
        $("#menu-general_navigation li.menu-item.menu-item-has-children").not($(this)).removeClass("active");
    });
    /*function handleFileSelect(evt) {
        evt.stopPropagation();
        evt.preventDefault();

        var files = evt.dataTransfer.files; // FileList object.

        // files is a FileList of File objects. List some properties.
        var output = [];
        for (var i = 0, f; f = files[i]; i++) {
            output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
            f.size, ' bytes, last modified: ',
            f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
            '</li>');
        }
        document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';
    };

    function handleDragOver(evt) {
        evt.stopPropagation();
        evt.preventDefault();
        evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
    };

    // Setup the dnd listeners.
    var dropZone = document.getElementById('drop_zone');
    dropZone.addEventListener('dragover', handleDragOver, false);
    dropZone.addEventListener('drop', handleFileSelect, false);*/

    function soutiennentHideElement() {
        if ($('.soutiennent-list').length) {
            if ($(window).width() < 768 && !$('.soutiennent-list').hasClass('mobile-version')) {
                $('.soutiennent-list').addClass('mobile-version');
                $('.soutiennent-list li').each(function () {
                    var block = $(this);
                    if (block.index() > 4) {
                        block.addClass('is-hide');
                    }
                });
                soutiennentCount('.soutiennent-list');
            } else {
                if ($(window).width() > 767 && $('.soutiennent-list').hasClass('mobile-version')) {
                    $('.soutiennent-list').removeClass('mobile-version');
                    $('.soutiennent-list li').removeClass('is-hide');
                }
            }
        }
    }


    // function actualitesHideElement(){
    //     if( $('.news-list-all').length ){
    //         if ( $(window).width() < 768 ){
    //             $('.news-list-all li').each(function(){
    //                 var block = $(this);
    //                 if( block.index() > 2 ){
    //                     block.addClass('is-hide');
    //                 }
    //             });
    //         }else{
    //             if ( $(window).width() > 767){
    //                 $('.news-list-all li').each(function(){
    //                     var block = $(this);
    //                     if( block.index() > 5 ){
    //                         block.addClass('is-hide');
    //                     }
    //                 });
    //             }
    //         }
    //     }
    // }

    stickyHeader();

    function sticky(stickyBlock, parentBlock) {
        if ($(stickyBlock).length) {
            var sticky = $(stickyBlock),
                stickyHeight = sticky.outerHeight(),
                parentStickyBlock = $(parentBlock),
                stickyPos = sticky.offset().top,
                parentHeight = parentStickyBlock.outerHeight(),
                parentPos = parentStickyBlock.offset().top;
            $(window).on('scroll', function () {
                var scrollPos = $(window).scrollTop();
                if (scrollPos >= stickyPos) {
                    sticky.addClass('is-fixed');
                } else {
                    sticky.removeClass('is-fixed');
                }
                if (scrollPos >= parentPos + parentHeight - stickyHeight) {
                    sticky.addClass('fixed-bottom');
                } else {
                    sticky.removeClass('fixed-bottom');
                }
            });
        }
    }

    function actionsSlider() {
        if ($('.block__actions_list').length) {
            if ($(window).width() < 768 && !$('.block__actions_list .slick-initialized').length) {
                $('.block__actions_list >ul').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    asNavFor: '.block__actions_list-nav >ul',
                    centerMode: true,
                    infinite: false,
                    adaptiveHeight: true
                });


                $('.block__actions_list-nav >ul').slick({
                    slidesToShow: 6,
                    slidesToScroll: 3,
                    arrows: false,
                    asNavFor: '.block__actions_list >ul',
                    focusOnSelect: true,
                    centerMode: true,
                    infinite: false,
                    adaptiveHeight: true
                });

                $('.block__actions_list .visuel-block').each(function () {
                    blockIndex = $(this).attr('data-slick-index');
                    $('.block__actions_list-nav li[data-slick-index=' + blockIndex + ']').addClass('visuel-nav-block');


                });
                $('.block__actions_list > ul').slick('slickFilter', ':not([class=visuel-block])');

                $('.block__actions_list-nav > ul').slick('slickFilter', ':not([class=visuel-nav-block])');

            } else {
                if ($(window).width() >= 768 && $('.block__actions_list .slick-initialized').length) {
                    $('.block__actions_list >ul').slick('slickUnfilter');
                    $('.block__actions_list >ul').slick('unslick');

                }
            }
        }
    }




    $('.show-more').on('click', function () {
        $(this).closest('.block').addClass('show-more');
    });

    $(".question h3,.question .plusmoins").click(function () {
        $(this).parent(".question").toggleClass("is-closed");
    });

    $('.burger, .overlay').click(function () {
        // $('.burger').toggleClass('clicked');
        $('.header').toggleClass('header--closed');
        // $('.nav').toggleClass('show');
    });

    $(".select-content__select__title").click(function () {
        $(this).next().toggle();
        $(this).parent().toggleClass('isActive');
    });

    //cookies
    $(".cookie-cta button").click(function () {
        if ($.cookie('acceptcookie') === undefined) {
            $.cookie('acceptcookie', '1', { expires: 365, path: '/' });
        }
        $("#cookie-bar").hide();
        $(".s1").css('height', '100%');
        $('body').css({ 'padding-bottom': 0 });
    });

    if ($.cookie('acceptcookie') == 1 || /Mobi/.test(navigator.userAgent)) {
        $("#cookie-bar").hide();
        $(".s1").css('height', '100%');
        $('body').css({ 'padding-bottom': 0 });
    } else {
        var marginBody = $('#cookie-bar').outerHeight();
        $('body').css({ 'padding-bottom': marginBody + 'px' });
    }

    $('#click-mentions-legales2,.ml-link').on('click', function () {
        $('.cookie-block').addClass('is-visible');
        return false;
    });

    $('.popup-block .close').on('click', function () {
        var popup = $(this).closest('.popup-block');
        popup.toggleClass('is-visible is-hidden');
        setTimeout(function () {
            popup.removeClass('is-hidden');
        }, 500);

    });

    $('body').on('click', function () {
        $('.popup-block').removeClass('is-visible').addClass('is-hidden');;
    });

    $('.popup-content').on('click', function (e) {
        e.stopPropagation();
    });

    if ($('.slider--block-2,.actualites-slider').length) {
        $('.slider--block-2,.actualites-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: false,
            dots: true,
            speed: 1000
        });
    }
    if ($('.actualites-slider').length) {
        $('.actualites-slider').append('<div class="controls-wrapper"></div>');
        $('.actualites-slider .slick-arrow,.actualites-slider .slick-dots').prependTo('.controls-wrapper');
        if ($(window).width() > 767) {
            var imgHeight = $('.actualites-slider .slick-current .img-block').outerHeight();
            $('.actualites-slider .controls-wrapper').css({ 'top': imgHeight + 'px' });
            $('.actualites-slider').on('afterChange', function (event, slick, currentSlide, nextSlide) {
                imgHeight = $('.actualites-slider .slick-current .img-block').outerHeight();
                $('.actualites-slider .controls-wrapper').css({ 'top': imgHeight + 'px' });
            });
        } else {
            $('.actualites-slider .controls-wrapper').css({ 'top': 'auto' });
        }
    }
    if ($('.block--banner__slider').length) {
        $('.block--banner__slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            speed: 1000,
            autoplay: true,
            autoplaySpeed: 2000,
        });
    }

    if ($('.block__frontpage--actus__slider__inner').length && $(window).width() < 768) {
        $('.block__frontpage--actus__slider__inner').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            dots: true,
            centerMode: true,
            //variableWidth: true
        });
    }

    if ($('.block--ideas__list').length && $(window).width() < 768) {
        $('.block--ideas__list').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            centerMode: true,
            variableWidth: true
        });
    }

    actuSlider();

    sticky('.sticky-social-block', '.news-content');

    // $('.block__frontpage--block-news .news-list .news-block a').hover(function(){
    //     $(this).closest('.news-block').addClass('is-hover');
    // }, function(){
    //     $(this).closest('.news-block').removeClass('is-hover');
    // });


    $('.form-scroll-btn').on('click', function () {
        $('html,body').animate({
            scrollTop: $('#block-form').offset().top
        }, 500);
        return false;
    });

    if ($('.block__actualites--content iframe').length) {
        $('.block__actualites--content iframe').wrap('<div class="iframe-wrapper"></div>');
    }

    if ($('.news-list').length) {
        $('.news-list').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            fade: false,
            dots: false,
            infinite: false,
            speed: 1000,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        dots: true
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true
                    }
                }
            ]
        });
    }
    if ($('.block__icons__slider').length) {
        $('.block__icons__slider').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            arrows: true,
            fade: false,
            dots: false,
            infinite: true,
            speed: 1000,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }

    if ($('.block__frontpage--block-banners').length) {
        $('.block__frontpage--block-banners .banners-block').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
            fade: false,
            dots: false,
            infinite: true,
            speed: 1000,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }

    if ($('select').length) {
        $('select').selectric();
    }

    //homeVideoHeight();

    participentHideElement();
    soutiennentHideElement();

    participentSliderMobile(3);

    /* filter load more function */
    //Page Filter Action
    var regionF = [], secteurF = [], catF = [], title = "";

    $("#search-by-title").on("input", function (e) {
        title = $(this).val();
        filterActions('filter');
        console.log(title);
    });
    function arrayRemove(arr, value) {

        return arr.filter(function (ele) {
            return ele != value;
        });
    }
    $('.action-select-page input').on('click', function (e) {
        let fil = $(this).parents(".action-select-page").attr("data-filter");
        switch (fil) {
            case "secteur":
                if ($(this).prop("checked")) {
                    secteurF.push($(this).val());
                }
                else {
                    secteurF = arrayRemove(secteurF, $(this).val());
                }
                filterActions('filter');
                break;
            case "region":
                if ($(this).prop("checked")) {
                    regionF.push($(this).val());
                }
                else {
                    regionF = arrayRemove(regionF, $(this).val());
                }
                filterActions('filter');
                break;
            case "categorie":
                if ($(this).prop("checked")) {
                    catF.push($(this).val());
                }
                else {
                    catF = arrayRemove(catF, $(this).val());
                }
                filterActions('filter');
                console.log(catF);
                break;

        }
    });


    actionsSlider();
    $('.block__actions_list >ul').on('afterChange', function (event, slick, currentSlide) {
        if (currentSlide == $('.block__actions_list .slick-slide').length - 1) {
            filterActions('loadmore');
        }
    });

    // check if filters are enabled
    /*filterCat = $('#actions-catégorie-filter').val();
    filterRegion = $('#actions-région-filter').val();*/
    filterCat = catF;
    filterRegion = regionF;
    filterSecteur = secteurF;
    filterTitle = title;

    function filterActions(action) {
        filterCat = catF;
        filterRegion = regionF;
        filterSecteur = secteurF;
        filterTitle = title;

        if (action == 'loadmore') {
            offset = $('.block__actions--main .action-block').length;
        } else {
            if ($(window).width() < 768) {
                $('.block__actions_list > ul').slick('unslick').html('');
                $('.block__actions_list-nav > ul').slick('unslick').html('');

            }
            offset = 0;
        }

        $.post(templateUrl + '/52f3a95a-e1e1-4a33-9093-bf9673942651.php', {
            categorie: filterCat,
            region: filterRegion,
            secteur: filterSecteur,
            title: filterTitle,
            action: action,
            offset: offset
        }, function (complete) {
            complete = $.parseJSON(complete);
            $('[name=post_count]').val(complete.post_count);
            if (action == 'loadmore') {
                $('.block__actions_list > ul').append(complete.code);
                if ($(window).width() < 768) {
                    AddSlickForLoadedActions();
                    $('.block__actions_list > ul').slick('slickFilter', ':not([class=visuel-block])');
                }
            } else {
                $('.block__actions_list > ul').html(complete.code);
                if ($(window).width() < 768) {
                    actionsSlider();
                    $('.block__actions_list > ul').slick('slickFilter', ':not([class=visuel-block])');
                    $('.block__actions_list > ul .slick-slide').each(function () {
                        $('.block__actions_list-nav >ul').slick('slickAdd', '<li></li>');
                    });

                }


            }

            hideVoirButton();
        });
    }
    function AddSlickForLoadedActions() {
        $('.block__actions_list > ul > li.loaded-action-block').each(function () {
            html = $(this).clone();
            $(this).remove();
            $('.block__actions_list >ul').slick('slickAdd', html);
            $('.block__actions_list-nav >ul').slick('slickAdd', '<li></li>');
        })
    }



    // filter posts
    /*$('#actions-catégorie-filter').on('change',function() {
        filterActions('filter');
    });
    $('#actions-région-filter').on('change',function() {
        filterActions('filter');
    });*/

    // load more
    $('.actions_list--more').on('click', function (y) {
        y.preventDefault();
        filterActions('loadmore');
    });




    function hideVoirButton() {
        BlockLength = $('.block__actions--main .action-block').length;
        console.log(BlockLength + '  ' + parseInt($('[name=post_count]').val()));

        if (BlockLength <= parseInt($('[name=post_count]').val())) {
            $('.actions_list--more').addClass('no-more');
        } else if (BlockLength > 6) {
            $('.actions_list--more').removeClass('no-more');
        } else {
            $('.actions_list--more').removeClass('no-more');
        }
    }

    $('.participent_list--more').on('click', function () {
        if ($('.block__participent_list .is-hide').length) {
            if ($('.block__participent_list .is-hide').length < 12) {
                $(this).addClass('no-more');
            }
            $('.block__participent_list .is-hide:lt(12)').removeClass('is-hide').addClass('is-visible');
            soutiennentCount('.block__participent_list');
        } else {
            $(this).addClass('no-more');
        }
        return false;
    });

    $('.soutiennent-list--more').on('click', function () {
        if ($('.soutiennent-list .is-hide').length) {
            if ($('.soutiennent-list .is-hide').length < 5) {
                $(this).addClass('no-more');
            }
            $('.soutiennent-list .is-hide:lt(5)').removeClass('is-hide').addClass('is-visible');
            soutiennentCount('.soutiennent-list');
        } else {
            $(this).addClass('no-more');
        }
        return false;
    });

    $('.news-list-all--more').on('click', function () {
        all = parseInt($('.news-list-all').attr('data-all'));
        offset = parseInt($('.news-list-all').attr('data-count')) + 3;
        $('.news-list-all').attr('data-count', offset);
        $.post(templateUrl + '/3ebe26be-2895-474e-baf8-19af391446d8.php', { offset: offset }, function (callback) {
            $('.news-list-all').append(callback);
            $('.is-hide').removeClass('is-hide').addClass('is-visible');
            if (offset >= all) {
                $('.news-list-all--more').addClass('no-more');
            }
        });

        // if( $('.news-list-all .is-hide').length ){
        //     var i = 3;
        //     if ( $(window).width() < 992 && $(window).width() > 767){
        //         i = 2;
        //     }
        //     if($('.news-list-all .is-hide').length <= i ){
        //         $(this).addClass('no-more');
        //     }
        //     $('.news-list-all .is-hide:lt('+i+')').removeClass('is-hide').addClass('is-visible');
        // }else{
        //     $(this).addClass('no-more');
        // }
        return false;
    });

    function presseHideElement() {
        if ($('.presse-list,.presse-list-2').length) {
            $('.presse-list li,.presse-list-2 li').each(function () {
                var block = $(this);
                if (block.index() > 3) {
                    block.addClass('is-hide').removeClass('is-visible');
                }
            });
        }
    }

    $('#presse-read-more-01').on('click', function () {
        if ($('.presse-list .is-hide').length) {
            var i = 2;
            if ($('.presse-list .is-hide').length <= i) {
                $(this).addClass('no-more');
            }
            $('.presse-list .is-hide:lt(' + i + ')').removeClass('is-hide').addClass('is-visible');
        } else {
            $(this).addClass('no-more');
        }
        return false;
    });
    $('#presse-read-more-02').on('click', function () {
        if ($('.presse-list-2 .is-hide').length) {
            var i = 3;
            if ($('.presse-list-2 .is-hide').length <= i) {
                $(this).addClass('no-more');
            }
            $('.presse-list-2 .is-hide:lt(' + i + ')').removeClass('is-hide').addClass('is-visible');
        } else {
            $(this).addClass('no-more');
        }
        return false;
    });

    presseHideElement();


    $(window).on('resize', function () {
        //homeVideoHeight();
        participentHideElement();
        soutiennentHideElement();
        participentSliderMobile(3);
        if ($('.sticky-social-block').length) {
            sticky('.sticky-social-block', '.news-content');
        }
        actionsSlider();
    });

    $('#footer__select').on('change', function () {
        window.location = $(this).val();
    });

    $('.js-block--propos__read-more').on('click', function (e) {
        e.preventDefault();
        $(this).hide();
        $(this).parents('.block--propos__intro__text').find('p').show();
    });

    $('.form-item__radio-text input[type=radio]').on('change', function () {
        if ($(this).siblings('.form-item__text').length) {
            var margin = $(this).siblings('.form-item__text').innerHeight() + 25;
            setTimeout(function () {
                $('.form__right .form-item__title').css({ 'margin-bottom': margin });
            }, 10);
        } else {
            $('.form__right .form-item__title').removeAttr("style")
        }
    });

    $('.block__form .form-wrapper .btn').on('click', function () {
        console.log('click');
        var block = $(this).parents().find('input[type=radio]:checked').siblings('.form-item__text');
        if (block.length) {
            console.log(block);
            var margin = block.innerHeight() + 65;
            setTimeout(function () {
                $('.form__right .form-item__title').css({ 'margin-bottom': margin });
            }, 10);
        } else {
            $('.form__right .form-item__title').removeAttr("style")
        }
    });

    $('.block--banner__link').on('mouseenter', function () {
        $(this).addClass('isActive').siblings().removeClass('isActive');
    });

    $('.block--banner__links__wrap').on('mouseleave', function () {
        $(this).find('.block--banner__link').removeClass('isActive');
        $(this).find('.block--banner__link:first').addClass('isActive');
    });

    $('#date1').mask('AB/CD/FGH0', {
        translation: {
            A: { pattern: /[0-3]/ },
            B: { pattern: /[0-9]/ },
            C: { pattern: /[0-1]/ },
            D: { pattern: /[0-9]/ },
            F: { pattern: /[2-2]/ },
            G: { pattern: /[0-9]/ },
            H: { pattern: /[0-9]/ },

        },
        onKeyPress: function (a, b, c, d) {
            if (!a) return;
            var m = a.match(/(\d{1})/g);
            if (!m) return;
            if (parseInt(m[0]) === 3) {
                d.translation.B.pattern = /[0-1]/;
            } else if (parseInt(m[0]) === 0) {
                d.translation.B.pattern = /[1-9]/;
            } else {
                d.translation.B.pattern = /[0-9]/;
            }
            if (parseInt(m[2]) == 1) {
                d.translation.D.pattern = /[0-2]/;
            } else {
                d.translation.D.pattern = /[1-9]/;
            }

            if (parseInt(m[4]) === 2) {
                d.translation.G.pattern = /[0-0]/;
            } else {
                d.translation.G.pattern = /[9-9]/;
            }
            if (parseInt(m[5]) == 0) {
                // d.translation.H.pattern = /[0-1]/;
                d.translation.H.pattern = /[2-3]/;
                // d.translation.H.pattern = /[0-1]/;
            } else {
                d.translation.H.pattern = /[0-9]/;
            }

            var temp_value = c.val();
            console.log(temp_value);
            // var date = temp_value.split("/").reverse().join("-");
            // console.log(date);
            c.val('');
            c.unmask().mask('AB/CD/FGH0', d);
            c.val(temp_value);
            // c.val(date);
            console.log('value');
            console.log($('#date1').val());

        }
    }).keyup();

    /* load more */
    jQuery(document).ready(function ($) {
        $('#load-more').attr('href', 'javascript:void(0);');
        $('#load-more').on('click', function () {
            var button = $(this);
            var page = button.data('page');
            var categorie_event = button.data('event');

            $.ajax({
                url: ajaxurl.url,
                type: 'POST',
                data: {
                    action: 'load_more_cpts',
                    page: page,
                    categorie_event: categorie_event
                },
                beforeSend: function () {
                    button.html('<span>Chargement...</span>');
                },
                success: function (response) {
                    if (response.success) {
                        $('#slick-sliderx').append(response.data);
                        button.data('page', page + 1);
                        button.html('<span>Voir toutes les actions en cours</span>');
                    } else {
                        button.html('<span>Aucun post trouvé</span>');
                        button.prop('disabled', true);
                    }
                }
            });
        });
    });
    /* map */
    // 	$('.infoReg').parent().parent().css("border:2px solid #000;");

});