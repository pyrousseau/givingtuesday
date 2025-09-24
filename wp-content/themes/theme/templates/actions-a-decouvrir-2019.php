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
        display:none;
    }
</style>
<div class="block block__actions block__actions--main">
    <div class="inner-wrapper">
        <h1><?php the_field('page_title'); ?></h1>
        <?php $image = get_field('form_image'); $permalink = get_the_permalink(); ?>
        <div class="block__actions_filter">
            <form action="#" class="actions-filter-form-block">
                <div class="input-wrap">
                    <label for="actions-catégorie-filter">Trier par :</label>
                    <select id="actions-catégorie-filter" name="actions-catégorie-filter">
                        <option value="">Trier par catégorie</option>
                        <option value="all">Toutes</option>
                        <?php $cat_event = get_field_object('field_5bbb81367415e',$id);
                        $cat_event = $cat_event['choices'];
                        foreach($cat_event as $key => $categorie) { ?>
                            <option value="<?php echo $key; ?>"><?php echo $categorie; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-wrap">
                    <label for="actions-région-filter">Trier par :</label>
                    <select id="actions-région-filter" name="actions-région-filter">
                        <option value="">Trier par region</option>
                        <option value="current">Événement en ligne</option>
                        <?php
                        foreach($regions as $r => $region) { ?>
                            <option value="<?php echo $r; ?>"><?php echo $region; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </form>
        </div>
        <?php
        $allActions = new WP_Query(array(
            'post_type' => 'action-a-decouvrir',
            'posts_per_page' => '-1',
            'meta_query' => array(
                'relation' => 'OR',
                'isset' => array( //check to see if date has been filled out
                    'key' => 'pin_action',
                    'value' => [1,2],
                    'compare' => 'BETWEEN',
                ),
                'gone' => array( //if no date has been added show these posts too
                    'key' => 'pin_action',
                    'compare' => 'NOT EXISTS'
                )
            ),
            'orderby' => array(
                'isset' => 'ASC',
                'gone' => 'DESC',
            ),
        ));
        wp_reset_query();
        $actionsQuery = new WP_Query(array(
            'post_type' => 'action-a-decouvrir',
            'posts_per_page' => '6',//6
//            'meta_query' => array(
//                'relation' => 'OR',
//                'isset' => array( //check to see if date has been filled out
//                    'key' => 'pin_action',
//                    'value' => [1,2],
//                    'compare' => 'BETWEEN',
//                ),
//                'gone' => array( //if no date has been added show these posts too
//                    'key' => 'pin_action',
//                    'compare' => 'NOT EXISTS'
//                )
//            ),
//            'orderby' => array(
//                'isset' => 'ASC',
//                'gone' => 'DESC',
//            ),
            'meta_key'			=> 'event_date',
            'orderby'			=> 'meta_value',
//            'orderby'			=> 'meta_value_num',
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
                    $offset = rand(0, count($visuels) - 1);
                    $sliced = array_slice($visuels, $offset,1);

                    $slicePosition = rand(0,3);
                    if ($key == 0) {
                        $slicePosition = 3;
                    }
                    $newActionArray = array();

                    foreach ($actionArray as $key => $action) {
                        if ($key  == 2 && $slicePosition == 3) {
                            $newActionArray[] = $action;
                            $newActionArray[] = $sliced;
                        } else if ($key  == 2 && $slicePosition == 2) {
                            $newActionArray[] = $sliced;
                            $newActionArray[] = $action;
                        } else if ($slicePosition == $key) {
                            $newActionArray[] = $sliced;
                            $newActionArray[$key+1] = $action;
                        } else {
                            $newActionArray[] = $action;
                        }

                    }


                    $newActionQuery[] = $newActionArray;
                }
                ?>
                <ul>
                    <?php foreach($newActionQuery as $key => $array) {
                        foreach ($array as $key => $post) {
                            if (is_array($post)) {   ?>
                                <li class="visuel-block">
<!--                                    --><?php
//                                    var_dump ($post);
//                                    ?>
                                    <div class="thumbnail" style='background-image: url("<?php echo  $post[0]['image']['url']; ?>")'></div>
                                </li>
                            <?php } else {
                                $region = get_field('region',$post->ID);
                                $ville = get_field('ville', $post->ID);

                                ?>
                                <li>
                                    <?php //var_dump(get_post_meta($post->ID, 'event_date')); ?>
                                    <div class="action-block categorie-<?php the_field('categorie_event'); ?>" id="<?php echo $post->ID; ?>" data-date="<?php echo get_field('event_date',$post->ID); ?>">
                                        <div class="head-block">
                                            <div class="icon-block"></div>
                                            <div class="title-block">
                                                <div class="info-block">
                                                   
                                                    <div class="date-block"><?php echo strftime('%d %B %Y',strtotime(get_field('event_date',$post->ID))); ?></div>
                                                    <div class="loc-block"><?php echo ($region && $region != '-') ? $regions[$region] : ''; ?> <?php echo $ville ? '/ '.$ville : '' ; ?></div>
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
                                                    <a href="<?php echo get_field('url', $post->ID); ?>" target="_blank">En savoir plus</a>
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
                                                    <a class="twi-click" href="#" data-text="<?php echo trim(preg_replace('/ss+/', ' ',$post->post_title)); ?>" data-url="<?php echo $permalink; ?>"><i class="fab fa-twitter"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            <?php } } } wp_reset_query(); ?>
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
</style>
<div class="block block__actions block__actions--form block__form">
    <div class="inner-wrapper form-wrapper">
        <form action="#" class="add-event">
            <div class="form-title">
                <h2>Publiez votre évènement :</h2>
            </div>
            <div class="input-block-wrapper input-block-wrapper__i-am">
                <div class="input-title">Je suis :</div>
                <div class="input-wrapper">
                    <input type="radio" id="j-03" name="form_type" value="i" checked="checked">
                    <label for="j-03">un particulier</label>
                </div>
                <div class="input-wrapper">
                    <input type="radio" id="j-01" name="form_type" value="a">
                    <label for="j-01">une association / <br>une fondation</label>
                    <div class="inner-input-wrapper">

                        <input type="text" name="association" placeholder="Nom de l’association">
                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>

                        <input type="text" name="association2" placeholder="Intitulé de poste" />
                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                    </div>
                </div>
                <div class="input-wrapper">
                    <input type="radio" id="j-02" name="form_type" value="e">
                    <label for="j-02">une entreprise</label>
                    <div class="inner-input-wrapper">


                        <input type="text" name="entreprise" placeholder="Nom de l’entreprise">
                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>

                        <input type="text" name="entreprises2" placeholder="Intitulé de poste" />
                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                    </div>
                </div>
                <div class="input-wrapper">
                    <input type="radio" id="j-04" name="form_type" value="p">
                    <label for="j-04">un parent / enseignant</label>
                    <div class="inner-input-wrapper">
                        <input type="text" name="parent" placeholder="Nom de l'établissement">
                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                    </div>
                </div>
            </div>
            <div class="input-block-wrapper input-block-wrapper__gender">
                <?php $civilite = get_field_object('field_5bbb80b76cf78',$id);
                $civilite = $civilite['choices'];
                $i = 0; foreach ($civilite as $c => $civ) { $i++; ?>
                    <div class="input-wrapper">
                        <input type="radio" id="g-0<?php echo $i; ?>" name="gender" value="<?php echo $c; ?>" <?php if ($i == 1) { echo 'checked';} ?>>
                        <label for="g-0<?php echo $i; ?>"><?php echo $civ; ?></label>
                    </div>
                <?php } ?>
            </div>
            <div class="input-block-wrapper input-block-wrapper__personal-data">
                <div class="input-wrapper">
                    <input type="text" name="nom" placeholder="Nom">
                    <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                </div>
                <div class="input-wrapper">
                    <input type="text" name="prenom" placeholder="Prénom">
                    <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                </div>
                <div class="input-wrapper">
                    <input type="text" name="email" placeholder="Adresse email">
                    <div class="error_text">Veuillez inclure un nom de domaine dans l'adresse e-mail.</div>
                </div>
            </div>
            <div class="input-block-wrapper input-block-wrapper__events">
                <?php $type_event = get_field_object('field_5bbb81127415d',$id);
                $type_event = $type_event['choices'];  ?>
                <div class="input-title">Type d’évènement :</div>
                <?php $e = 0; foreach ($type_event as $te => $event) { $e++; ?>
                    <div class="input-wrapper">
                        <input type="radio" id="e-0<?php echo $e; ?>" name="event" value="<?php echo $te; ?>" <?php if ($e == 1) { echo 'checked';} ?>>
                        <label for="e-0<?php echo $e; ?>"><?php echo $event; ?></label>
                    </div>
                <?php } ?>

            </div>
            <div class="input-block-wrapper input-block-wrapper__category">
                <div class="input-title">Catégorie d’évènement :</div>
                <?php $cat_event = get_field_object('field_5bbb81367415e',$id);
                $cat_event = $cat_event['choices'];
                $c = 0; foreach ($cat_event as $ce => $cat) { $c++; ?>
                    <div class="input-wrapper">
                        <input type="radio" id="c-0<?php echo $c; ?>" name="category" value="<?php echo $ce; ?>" <?php if ($c == 1) { echo 'checked';} ?>>
                        <label for="c-0<?php echo $c; ?>"><?php echo $cat; ?></label>
                    </div>
                <?php } ?>
            </div>
            <div class="input-block-wrapper input-block-wrapper__info">
                <div class="input-column">
                    <div class="input-wrapper">
                        <input type="text" name="event_name" placeholder="Intitulé de l’évènement">
                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                    </div>
                    <div class="input-wrapper">
                        <input type="text" name="event_date" id="date1" placeholder="Date de l’évènement (ex: 01/01/2019)">
                        <div class="error_text">Date de l’évènement (ex: 01/01/2019)</div>
                    </div>
                    <!--                    <div class="input-wrapper input-wrapper__half">-->
                    <!--                        <input type="text" name="ville" placeholder="Ville">-->
                    <!--                    </div>-->
                    <!--                    <div class="input-wrapper input-wrapper__half">-->
                    <!--                        --><?php //$r = 0; ?>
                    <!---->
                    <!--                        <select name="region">-->
                    <!--                            <option value="" selected>Région</option>-->
                    <!--                            --><?php //foreach ($regions as $reg => $region) { ?>
                    <!--                                <option value="--><?php //echo $reg; ?><!--">--><?php //echo $region; ?><!--</option>-->
                    <!--                            --><?php //} ?>
                    <!--                        </select>-->
                    <!--                    </div>-->
                </div>
                <div class="input-column">
                    <div class="input-wrapper">
                        <textarea name="description" placeholder="Description de l’évènement (250 caractères maximum)"></textarea>
                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>
                    </div>
                </div>
                <div class="input-column">
                    <div class="input-wrapper">
                        <input type="text" name="url" placeholder="Site web ou page Facebook de l’évènement">
                        <div class="error_text">Site web ou page Facebook de l’évènement</div>
                    </div>
                </div>
            </div>
            <div class="action-block">
                <button type="submit">Je publie mon évènement</button>
            </div>
            <div class="text-block">En remplissant ce formulaire, vous acceptez les conditions d’utilisations de vos données dans les mentions légales et de recevoir des informations dans le cadre du mouvement GivingTuesday France. Don’t worry! Vos données ne seront ni vendues, ni échangées. Elles nous permettent uniquement de vous tenir au courant de GivingTuesday France.</div>
            <div class="merci-popup">
                <span class="close-popup"><i class="fas fa-times"></i></span>
                <div>Merci beaucoup pour votre participation  ! Votre événement a bien été pris en compte et ajouté dans la liste des événements pour le #GivingTuesdayFr </div>
            </div>
        </form>
    </div>
</div>