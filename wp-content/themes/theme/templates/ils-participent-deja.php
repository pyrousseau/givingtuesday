<?php $participants = new WP_Query(array(
    'posts_per_page' => '-1',
    'post_type' => 'participant',
    'orderby' => 'title',
    'order' => 'ASC'
));
$participantsCount = $participants->post_count;
$filters = get_field_object('field_5b87fb6ea2f19');
?>
<style>
    .error {
        border-color: red !important;
        border-bottom-color: red !important;
        color: red !important;
    }
    .actions_list--more.no-more {
        display:none;
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
        t.setAttribute("data-expanded" , expanded);
    }
    function hideCheckboxes(t){
        var elmnt = t.childNodes[1].getAttribute("data-idselect");
        var tt = t.childNodes[1];
        checkboxes = document.getElementById(elmnt);
        tt.classList.remove("opened");
        checkboxes.style.display = "none";
        tt.setAttribute("data-expanded" , "false");
    }

</script>
<div class="block block__participent">
    <h1><?php the_field('top_title'); ?></h1>
    <div class="block__participent_filter">
        <form action="#" class="participent-filter-form-block">
            <div class="input-wrap">
                    <div class="search-section" >
                        <label>Rechercher par mot-clé: </label>
                        <input type="text" placeholder="" id="search-by-titleO">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="input-wrap">
                    <div class="checkboxes_multiselect" onmouseleave="hideCheckboxes(this)">
                         <?php $sec_event = get_field_object('field_60d0a48856de0',210);
                                $sec_event = $sec_event['choices'];?>
                        <div class="selectBox" onclick="showCheckboxes(this)" data-idselect="sa_checkboxes"  data-expanded="false">
                                <select class="select-of-page-action">
                                    <option>Trier par secteur</option>
                                </select>
                                <div class="overSelect"></div>
                        </div>
                        <div id="sa_checkboxes" class="action-select-pageO" data-filter="secteur">
                            <?php foreach($sec_event as $key => $secteur) { ?>
                                <label for="<?php echo $key ?>"><input type="checkbox" id="<?php echo $key ?>" name="<?php echo $key ?>" value="<?php echo $key; ?>" /><?php echo $secteur; ?></label>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <div class="input-wrap">
               <!--  <label for="participent-filter"></label> -->
                <select id="participent-filter" name="participent-filter">
                    <option value="placeholder">Trier par :type d’organisation</option>
                    <option value="all">Tous</option>
                    <?php foreach ($filters['choices'] as $key => $filter) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $filter; ?></option>
                    <?php } ?>
                </select>
            </div>
        </form>
    </div>
    <ul class="block__participent_list">
        <?php while ($participants->have_posts()) : $participants->the_post(); ?>
        <li class="type-<?php the_field('type_participant'); ?>">

        <?php
        $l = get_field('lien_participant'); // peut être array (Link) ou string (URL)
        if ($l) {
        if (is_array($l)) {
            $href   = esc_url($l['url'] ?? '');
            $target = esc_attr($l['target'] ?? '_self');
        } else {
            $href   = esc_url($l);
            $target = '_self';
        }
        ?>
        <a href="<?php echo $href; ?>" target="<?php echo $target; ?>" rel="noopener" class="innter-wrapper-list">
        <?php
        }
        ?>


                <div class="img-block"><img src="<?php $image = get_field('image_participant'); $url = $image['sizes']['paricipant']; echo $url; ?>" alt=""></div>
                <div class="text-block"><?php the_title(); ?></div>
            </a>
        </li>
        <?php endwhile; wp_reset_query(); ?>
    </ul>
    <div class="block__participent_list--more-block">
<!--        <div class="participent_list--info">Vous avez vu <span class="vu-info">12</span> participants sur <span class="sur-info">--><?php //echo $participants->post_count; ?><!--</span></div>-->
        <a href="#" class="participent_list--more" <?php if ($participantsCount <= 12) { echo 'style="display:none;"'; } ?>>Afficher plus de participants</a>
        <div style="margin-top:30px;">
        <?php
            global $post;
            the_field('content', $post->ID);
        ?>
        </div>
    </div>
</div>
<script>

    jQuery(document).ready(function($){
        var organisationP ="", secteurP=[] , titleP="";
        function arrayRemove(arr, value) { 
    
            return arr.filter(function(ele){ 
                return ele != value; 
            });
        }
        function filterParticipants(){
            var sendObj = {
                    action : 'filter',
                    filter : organisationP,
                    secteur : secteurP,
                    title : titleP
                }
                participentSliderMobileDestroy();
                $.post('<?php echo home_url(); ?>/wp-content/themes/theme/af.php', sendObj, function(complete) {
                    complete = JSON.parse(complete);
                    console.log(complete);
                    $('.block__participent_list').html(complete.html);
                    $('.sur-info').text(complete.post_count);
                    if (parseInt(complete.post_count) <= 12) {
                        $('.vu-info').text(complete.post_count);
                        $('.participent_list--more').hide();
                    } else {
                        $('.vu-info').text('12');
                        $('.participent_list--more').show();
                    }
                    participentHideElement();
                    participentSliderMobile(3);
            })
        }
        $('#participent-filter').on('change', function() {
            organisationP = $(this).val();
            filterParticipants();
        });
        $("#search-by-titleO").on("input", function(e){
            titleP = $(this).val();
            filterParticipants();
        });
        $('.action-select-pageO input').on('click' , function(e){
            console.log("reeee");
            let fil = $(this).parents(".action-select-pageO").attr("data-filter");
            if($(this).prop("checked")){
                secteurP.push($(this).val());
            }
            else{
                secteurP = arrayRemove(secteurP, $(this).val());
            }
            filterParticipants();
        });
    })
    
</script>
<div class="block block__soutiennent">
    <div class="soutiennent_bg-block"></div>
<!--    <div class="inner-wrapper">-->
<!--        <h2>--><?php //the_field('second_title'); ?><!--</h2>-->
<!--        <ul class="soutiennent-list">-->
<!--            --><?php //foreach (get_field('supporters') as $supporter) { ?>
<!--            <li>-->
<!--                <div class="title-block">--><?php //echo $supporter['titre']; ?><!--</div>-->
<!--                <div class="text-block">--><?php //echo $supporter['texte']; ?><!--</div>-->
<!--            </li>-->
<!--            --><?php //} ?>
<!--        </ul>-->
<!--        <div class="soutiennent-list--more-block">-->
<!--            <div class="soutiennent_list--info">Vous avez vu <span class="vu-info">XX</span> soutiens sur <span class="sur-info">XXX</span></div>-->
<!--            <a href="#" class="soutiennent-list--more">Afficher plus de participants</a>-->
<!--        </div>-->
<!--        <div class="btn-wrapper">-->
<!--            <a href="--><?php //echo get_field('bouton_lien','option'); ?><!--" class="btn"><span>--><?php //echo get_field('bouton_text','option'); ?><!--</span></a>-->
<!--        </div>-->
<!--    </div>-->
</div>