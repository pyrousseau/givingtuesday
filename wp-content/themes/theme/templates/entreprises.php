
<div class="block block--propos block--propos__intro block-size-a">
    ﻿<iframe border="0" frameborder="0" style="display:block; width:100%; height:100vh;" loading="lazy" allowfullscreen
src=https://givingtuesday.charitips.com/></iframe>
<div style="padding:10px; display:flex;">
  <img src="https://apicivique.s3.eu-west-3.amazonaws.com/jvalogo.svg"/>
  <div style="color:#A5A5A5; font-style:normal; font-size:13px; padding:8px;">Proposé par la plateforme publique du bénévolat
    <a href="https://www.jeveuxaider.gouv.fr/" target="_blank">JeVeuxAider.gouv.fr</a>
  </div>
</div>
</div>

<style>
.block__actions--form {
    background-image: url('<?php echo $image;  ?>');
}
</style>


<?php $id = 767;
$regions = get_field_object('field_5bbb818374161',$id);
$regions = $regions['choices'];
setlocale(LC_ALL, 'fr_FR.UTF8');
?>
<?php
$o_fields = get_fields('options');

?>
<style>
.error {
    border-color: red !important;
    border-bottom-color: red !important;
    color: red !important;
}

.actions_list--more.no-more {
    display: none;
}
</style>
<script>
var expanded = false;

function showCheckboxes(t) {
    var elmnt = t.getAttribute("data-idselect"),
        checkboxes = document.getElementById(elmnt);
    expanded = t.getAttribute("data-expanded");
    t.classList.toggle("opened")
    if (expanded === "false") {
        checkboxes.style.display = "block";
        expanded = "true";

    } else {
        checkboxes.style.display = "none";
        expanded = "false";
    }
    t.setAttribute("data-expanded", expanded);
}

function hideCheckboxes(t) {
    var elmnt = t.childNodes[1].getAttribute("data-idselect");
    var tt = t.childNodes[1];
    checkboxes = document.getElementById(elmnt);
    tt.classList.remove("opened");
    checkboxes.style.display = "none";
    tt.setAttribute("data-expanded", "false");
}
</script>

<style>
.block__actions--form {
    background-image: url('<?php echo $image;  ?>');
}

.page-id-4897 .block__actions--main {
    padding-bottom: 0 !important;
}

.page-id-4897 .pre-footer {
    display: none !important;
}

.page-id-4897 .pre-footer-2 {
    display: block !important;
}

.page-id-4897 h2.h2 {
    margin-bottom: 40px;
    margin-top: 60px;
}
.slick-sliderx .slick-arrow {
    width: 40px;
    height: 74px;
    background-image: url('https://givingtuesday.fr/wp-content/themes/theme/images/icon-arrow-left.png');
    background-position: center;
    background-repeat: no-repeat;
    background-size: contain;
    top: 50%;
    border: none !important;
    left: -45px;
    z-index: 1;
    position: absolute;
}

.slick-sliderx .slick-arrow.slick-next {
    -webkit-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg);
    left: auto;
    right: -45px;
}

/* .block__actions_list .slick-track .action-block .head-block .title-block .title {
    width: calc(100% - 40px) !important;
    margin: 0 auto;
} */
.block__actions_list>ul .action-block .head-block,
.block__actions_list>ul .action-block .text-block {
    width: 100% !important;
}

@media screen and (min-width: 768px) and (max-width: 1240px) {
    .slick-sliderx {
        width: 88%;
        position: relative;
        margin: 0 auto;
    }
}

@media screen and (max-width: 768px) {
    .slick-sliderx {
        width: 88%;
        position: relative;
        margin: 0 auto;
    }

    slick-sliderx .slick-arrow {
        width: 25px;
    }

    .slick-sliderx .slick-arrow {
        width: 25px;
        left: -15px;
    }

    .slick-sliderx .slick-arrow.slick-next {
        left: auto;
        right: -15px;
    }

    .page-id-4897 h2.h2 {
        margin-bottom: 0px;
        margin-top: 30px;
    }

    /* .page-id-4897 .block__actions_list .slick-track .action-block .social-block {
        padding: 13px 0px;
    } */


}
</style>
<!-- <div class="block block__actions block__actions--form block__form">
    <img src="<?php //echo get_site_url(); ?>/wp-content/uploads/2018/10/bg-06.jpg" class="block__actions--form--pre-img"/>
    <div class="inner-wrapper form-wrapper">
    </div>
</div> -->
<div class="pre-footer pre-footer-2">
    <a href="https://givingtuesday.fr/comment-participer/actions-a-decouvrir/" class="bnt-action-page-footer">actions
        à découvrir</a>
</div>
<!-- <div class="block block__actions block__actions--form block__form">
    <img src="<?php //echo get_site_url(); ?>/wp-content/uploads/2018/10/bg-06.jpg" class="block__actions--form--pre-img"/>
    <div class="inner-wrapper form-wrapper">
    </div>
</div> -->
<script>
// $(document).ready(function() {
//     $('.slick-sliderx').slick({
//         autoplay: true, // Activer la lecture automatique
//         autoplaySpeed: 6000, // Durée d'affichage de chaque diapositive en millisecondes
//         cssEase: 'linear',
//         dots: false, // Afficher les indicateurs de diapositive (pagination)
//         arrows: true,
//         adaptiveHeight: true,
//         // centerMode: true,
//         // centerPadding: '60px',
//         slidesToShow: 3,
//         responsive: [{
//                 breakpoint: 1240,
//                 settings: {
//                     slidesToShow: 2,
//                 }
//             },
//             {
//                 breakpoint: 768,
//                 settings: {
//                     slidesToShow: 1,
//                 }
//             }
//             // You can unslick at a given breakpoint now by adding:
//             // settings: "unslick"
//             // instead of a settings object
//         ]
//     });
// });
</script>