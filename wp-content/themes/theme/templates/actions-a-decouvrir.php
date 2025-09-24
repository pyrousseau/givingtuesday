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
<div class="block block__actions block__actions--main">
    <div class="inner-wrapper">
        <h1><?php the_field('page_title'); ?></h1>
        <?php $image = get_field('form_image'); $permalink = get_the_permalink(); ?>
        <div class="block__actions_filter">
            <form action="#" class="actions-filter-form-block">
                <div class="input-wrap">
                    <div class="search-section">
                        <label>Rechercher par mot-clé: </label>
                        <input type="text" placeholder="" id="search-by-title">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="input-wrap">
                    <div class="checkboxes_multiselect" onmouseleave="hideCheckboxes(this)">
                        <?php $sec_event = get_field_object('field_60a67dd1850b3',$id);
                                $sec_event = $sec_event['choices'];?>
                        <div class="selectBox" onclick="showCheckboxes(this)" data-idselect="sa_checkboxes"
                            data-expanded="false">
                            <select class="select-of-page-action">
                                <option>Trier par secteur</option>
                            </select>
                            <div class="overSelect"></div>
                        </div>
                        <div id="sa_checkboxes" class="action-select-page" data-filter="secteur">
                            <?php foreach($sec_event as $key => $secteur) { ?>
                            <label for="<?php echo $key ?>"><input type="checkbox" id="<?php echo $key ?>"
                                    name="<?php echo $key ?>"
                                    value="<?php echo $key; ?>" /><?php echo $secteur; ?></label>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="input-wrap">
                    <!-- <select id="actions-catégorie-filter" name="actions-catégorie-filter">
                        <option value="">Trier par type de don</option>
                        <option value="all">Toutes</option>
                        <?php //$cat_event = get_field_object('field_5bbb81367415e',$id);
                        //$cat_event = $cat_event['choices'];
                        //foreach($cat_event as $key => $categorie) { ?>
                            <option value="<?php //echo $key; ?>"><?php //echo $categorie; ?></option>
                        <?php //} ?>
                    </select> -->
                    <div class="checkboxes_multiselect" onmouseleave="hideCheckboxes(this)">
                        <?php $cat_event = get_field_object('field_5bbb81367415e',$id);
                                $cat_event = $cat_event['choices']; ?>
                        <div class="selectBox" onclick="showCheckboxes(this)" data-idselect="sa_checkboxes_don"
                            data-expanded="false">
                            <select class="select-of-page-action">
                                <option>Trier par type de don</option>
                            </select>
                            <div class="overSelect"></div>
                        </div>
                        <div id="sa_checkboxes_don" class="action-select-page" data-filter="categorie">
                            <?php foreach($cat_event as $key => $categorie) { ?>
                            <label for="<?php echo $key ?>"><input type="checkbox" id="<?php echo $key ?>"
                                    name="<?php echo $key ?>"
                                    value="<?php echo $key; ?>" /><?php echo $categorie; ?></label>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="input-wrap">
                    <!-- <select id="actions-région-filter" name="actions-région-filter">
                        <option value="">Trier par region</option>
                        <option value="current">Événement en ligne</option>
                        <?php
                        //foreach($regions as $r => $region) { ?>
                            <option value="<?php //echo $r; ?>"><?php //echo $region; ?></option>
                        <?php //} ?>
                    </select> -->
                    <div class="checkboxes_multiselect" onmouseleave="hideCheckboxes(this)">
                        <div class="selectBox" onclick="showCheckboxes(this)" data-idselect="sa_checkboxes_region"
                            data-expanded="false">
                            <select class="select-of-page-action">
                                <option>Trier par region</option>
                            </select>
                            <div class="overSelect"></div>
                        </div>
                        <div id="sa_checkboxes_region" class="action-select-page" data-filter="region">
                            <?php $last =0 ; ?>
                            <?php foreach($regions as $r => $region) { ?>
                            <label for="<?php echo $r ?>"><input type="checkbox" id="<?php echo $r ?>"
                                    name="<?php echo $r ?>"
                                    value="<?php echo $region; ?>" /><?php echo $region; ?></label>
                            <?php $last = $r +1 ; ?>
                            <?php } ?>
                            <!-- 
                            <label for="<?php //echo $last ?>"><input type="checkbox" id="<?php// echo $last ?>" name="<?php //echo $last ?>" value="Événement en ligne" />Événement en ligne</label> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php
        $allActions = new WP_Query(array(
            'post_type' => 'action-a-decouvrir',
            'posts_per_page' => '-1',
            'orderby'           => 'date',
            'order'             => 'DESC'
        ));
        wp_reset_query();
        $actionsQuery = new WP_Query(array(
            'post_type' => 'action-a-decouvrir',
            'posts_per_page' => '6',
            'orderby'			=> 'date',
            'order'				=> 'DESC'

        ));
        ?>
        <?php if ($actionsQuery->have_posts()) : ?>
        <div class="block__actions_list">
            <input type="hidden" name="post_count" value="<?php echo $allActions->post_count; ?>">
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
            <ul>
                <?php foreach($newActionQuery as $key => $array) {
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
                <li>
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
                            <img src="<?php echo $image_url; ?>" title="Présentation" style="margin-bottom:20px;" />
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
                                    <a href="<?php echo get_field('url', $post->ID); ?>" target="_blank">En savoir
                                        plus</a>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="social-block">
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
                </li>
                <?php } } wp_reset_query(); ?>
            </ul>
        </div>
        <div class="block__actions_list-nav">
            <ul>
                <?php foreach($newActionQuery as $key => $array) {
                        foreach ($array as $key => $post) { ?>
                <li></li>
                <?php } } ?>
            </ul>
        </div>
        <div class="block__actions_list--more-block">
            <a href="#" class="actions_list--more">Voir plus d’actions</a>
        </div>
        <?php else : ?>
        <div class="block__actions_list">
            <ul>
                <li class="no-posts-text">Désolé, aucune action ne correspond à vos critères.<br>
                    Vous organisez un événement ? Ajoutez-le via le formulaire ci-dessous !</li>
            </ul>
            <input type="hidden" name="post_count" value="<?php echo $allActions->post_count; ?>">
            <div class="block__actions_list--more-block">
                <a href="#" class="actions_list--more no-more">Voir plus d’actions</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.block__actions--form {
    background-image: url('<?php echo $image;  ?>');
}

/* .block__actions_list .slick-track .action-block .head-block .title-block .title {
    width: calc(100% - 40px) !important;
    margin: 0 auto;
} */
.block__actions_list>ul .action-block .head-block,
.block__actions_list>ul .action-block .text-block {
    width: 100% !important;
}
</style>
<!-- <div class="block block__actions block__actions--form block__form">
    <img src="<?php //echo get_site_url(); ?>/wp-content/uploads/2018/10/bg-06.jpg" class="block__actions--form--pre-img"/>
    <div class="inner-wrapper form-wrapper">
    </div>
</div> -->