
<div class="block block--propos block--propos__intro block-size-a">
    <h1 class="block--propos__intro__title"><?php echo get_the_title(); ?></h1>
    <p><?php echo get_field('texte') ?></p>
    <div class="inner-wrapper">
    <div class="faq__btn btns-group2 otherPage">
    <?php
        $hero = get_field('les_collectes_en_cours');
        if( $hero ): 
    ?>
            <div class="les_collectes_en_cours">
                <div class="title_collect">
                    <h3> <?php echo esc_attr( $hero['titre_section_page'] ); ?></h3>
                </div>
                <?php
                    $categorie_event_value = 'voix'; // Récupère la valeur du champ ACF

                    // Assurez-vous que $categorie_event_value n'est pas vide
                    // if( $categorie_event_value ) {
                        $actionsQuery = new WP_Query(array(
                            'post_type' => 'action-a-decouvrir',
                            'posts_per_page' => '6',
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'meta_query' => array(
                                array(
                                    'key' => 'categorie_event', // Nom du champ ACF
                                    'value' => $categorie_event_value, // Valeur à rechercher
                                    'compare' => '=', // Comparaison (peut être ajusté selon le besoin, par ex. 'LIKE', 'IN', etc.)
                                )
                            )
                        ));
                    // } else {
                    //     // Si $categorie_event_value est vide, récupérer toutes les actions
                    //     $actionsQuery = new WP_Query(array(
                    //         'post_type' => 'action-a-decouvrir',
                    //         'posts_per_page' => '-1',
                    //         'orderby' => 'date',
                    //         'order' => 'DESC'
                    //     ));
                    // }
                    ?>
                <?php if ($actionsQuery->have_posts()) : ?>
                <div class="block__actions_list list2">
                    <?php
                        $actionsQueryChunked = array_chunk($actionsQuery->posts, 3);
                        $visuels = get_field('loop_visuels');
                        $newActionQuery = array();

                        foreach ($actionsQueryChunked as $actionArray) {
                            $newActionArray = array();

                            foreach ($actionArray as $key => $action) {
                                $newActionArray[] = $action;
                            }


                            $newActionQuery[] = $newActionArray;
                        }
                        ?>
                    <div class="slick-sliderx" id="slick-sliderx">
                        <?php 
                            foreach($newActionQuery as $key => $array) {
                                foreach ($array as $key => $post) {
                                    $region = get_field('region',$post->ID);
                                    $ville = get_field('ville', $post->ID);
                                    
                                    $image_url = '';
                                    $padding_head = 'padding-top:40px;';
                                    $image_infos = get_field('event_photo',$post->ID);
                                    if(isset($image_infos['url']) && ($image_infos['url'] != '')){
                                        $padding_head = '';
                                        $image_url = $image_infos['url'];
                                    }

                        ?>
                        <div class="li">
                            <div class="action-block-container categorie-<?php the_field('categorie_event'); ?>">
                                <!-- position:relative; -->
                                <div class="icon-block-container">
                                    <!-- position:absolute; top:-35px; width:100%; -->
                                    <div class="icon-block"></div> <!-- margin: 0 auto; -->
                                </div>
                                <div class="action-block categorie-<?php the_field('categorie_event'); ?>"
                                    id="<?php echo $post->ID; ?>" data-date="<?php echo get_field('event_date',$post->ID); ?>">
                                    <?php 
                                                    if($image_url != ''){
                                                ?>
                                    <img src="<?php echo $image_url; ?>" title="Présentation"
                                        style="margin-bottom:20px;min-height: 175px; width: 100%; max-height: 175px;object-fit: cover;object-position: top center;" />
                                    <?php
                                                    }
                                                ?>
                                    <div class="head-block" style="<?php echo $padding_head; ?>">
                                        <div class="title-block">
                                            <div class="info-block">

                                                <div class="date-block">
                                                    <?php echo strftime('%d %B %Y',strtotime(get_field('event_date',$post->ID))); ?>
                                                </div>
                                                <div class="loc-block">
                                                    <?php echo ($region && $region != '-') ? $regions[$region] : ''; ?>
                                                    <?php echo $ville ? '/ '.$ville : '' ; ?></div>
                                            </div>
                                            <div class="title">
                                                <?php echo $post->post_title; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-block">
                                        <?php the_field('event_description', $post->ID); ?>...
                                        <?php if (get_field('url', $post->ID)) { ?>
                                        <div class="link-wrap">
                                            <a href="<?php echo get_field('url', $post->ID); ?>" target="_blank" class="enSav">En savoir
                                                plus</a>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="social-block mediasocial">
                                        <span>Partager cette action :</span>
                                        <ul>
                                            <li>
                                                <a class="fab-click" href="#"><i class="fab fa-facebook-f"></i></a>
                                            </li>
                                            <li>
                                                <a class="twi-click" href="#"
                                                    data-text="<?php echo trim(preg_replace('/ss+/', ' ',$post->post_title)); ?>"
                                                    data-url="<?php echo $permalink; ?>"><i class="fab fa-x-twitter"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php } } wp_reset_query(); ?>
                    </div>
                    
                </div>
                <?php else : ?>
                <div class="block__actions_list otherList">
                    <ul>
                        <li class="no-posts-text">Désolé, aucune action ne correspond à vos critères.<br>
                            Vous organisez un événement ? Ajoutez-le via le formulaire ci-dessous !</li>
                    </ul>
                    <!-- <input type="hidden" name="post_count" value="<?php //echo $allActions->post_count; ?>"> -->
                    <!-- <div class="block__actions_list--more-block">
                        <a href="#" class="actions_list--more no-more">Voir plus d’actions</a>
                    </div> -->
                </div>
                <?php endif; ?>
            </div>
            <div class="centermyBtn">
                <a href="<?php echo get_field('bottom_btn')["url"]; ?>"
                    target="<?php echo get_field('bottom_btn')["target"]; ?>" id="load-more" data-page="1" data-event="<?php echo esc_attr($categorie_event_value); ?>"
                    class="bnt-action-page-footer bnt-action-page-footer-blue"><span><?php echo get_field('bottom_btn')["title"]; ?></span></a>
            </div>
        <?php endif; ?>      
        </div>
        <?php if( have_rows('Section_plateformes_de_don') ): ?>
            <?php while( have_rows('Section_plateformes_de_don') ): the_row(); 

                // Get sub field values.
                $title_section = get_sub_field('title_section');

                ?>
                <div class="plat_don">
                    <div class="title_plat_don">
                        <h3><?php echo $title_section; ?></h3>
                    </div>
                    <div class="list_plat_don">
                    <?php if( have_rows('les_dons') ): ?>
                        <?php 
                            while( have_rows('les_dons') ): the_row(); 
                            $image_plateforme = get_sub_field('image_plateforme');
                            $lien_plateforme = get_sub_field('lien_plateforme');
                        ?>
                            <div class="item_plat">
                                <div class="img_plat">
                                    <img src="<?php echo esc_url( $image_plateforme['url'] ); ?>" alt="<?php echo esc_attr( $image_plateforme['alt'] ); ?>" />
                                </div>
                                <div class="content_plat_don">
                                    <h4><?php echo get_sub_field('titre_plateforme') ?></h4>
                                    <?php echo get_sub_field('texte_plateforme') ?>
                                    <a href="<?php echo esc_url( $lien_plateforme['url'] ); ?>"><?php echo esc_attr( $lien_plateforme['title'] ); ?></a>

                                </div>
                            </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>

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

.page-id-4928 .block__actions--main {
    padding-bottom: 0 !important;
}

.page-id-4928 .pre-footer {
    display: none !important;
}

.page-id-4928 .pre-footer-2 {
    display: block !important;
}

.page-id-4928 h2.h2 {
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

    .page-id-4928 h2.h2 {
        margin-bottom: 0px;
        margin-top: 30px;
    }

    /* .page-id-4928 .block__actions_list .slick-track .action-block .social-block {
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