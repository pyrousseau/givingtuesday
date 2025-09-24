<?php
$id = 767;
$regions = get_field_object('field_5bbb818374161',$id);
$regions = $regions['choices'];
setlocale(LC_ALL, 'fr_FR.UTF8');
?>

<style>
    .error {
        border-color: red !important;
        border-bottom-color: red !important;
        color: red !important;
    }
    .block__actions--form {
        background-image: url('<?php echo $image;  ?>');
    }
</style>
<script>
    var expanded = false;

    function showCheckboxes() {
        var checkboxes = document.getElementById("sa_checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }
</script>


<div class="block block__actions block__actions--form block__form">
    <img src="/wp-content/uploads/2018/10/bg-06.jpg" class="block__actions--form--pre-img"/>
    <div class="inner-wrapper form-wrapper">
        <form class="add-event" enctype="multipart/form-data"><!-- action="#" method="post" -->
            <div class="form-title">
                <h2>Publiez votre action</h2>
            </div>
            <div class="input-block-wrapper input-block-wrapper__i-am">
                <div class="input-title">Je suis :</div>
                <div class="input-wrapper">
                    <input type="radio" id="j-03" name="form_type" value="i" checked="checked">
                    <label for="j-03">un particulier</label>
                </div>
                <div class="input-wrapper">
                    <input type="radio" id="j-01" name="form_type" value="a">
                    <label for="j-01">une association / <br>une fondation / une OSBL</label>
                    <div class="inner-input-wrapper">

                        <input type="text" name="association" placeholder="Nom de l’association">
                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div>

                        <!-- <input type="text" name="association2" placeholder="Intitulé de poste" />
                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères.</div> -->
                        <!-- <input type="select" name="secteur" placeholder="Secteur d'activité" multiple="oui"/> -->
                        <div class="checkboxes_multiselect">
                            <div class="selectBox" onclick="showCheckboxes()">
                                <select>
                                    <option>Secteur d'activité</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div id="sa_checkboxes">
                                <label for="sa_1"><input type="checkbox" id="sa_1" name="sa_1" value="sa_1" />Caritatif / solidarité</label>
                                <label for="sa_2"><input type="checkbox" id="sa_2" name="sa_2" value="sa_2" />Sport</label>
                                <label for="sa_3"><input type="checkbox" id="sa_3" name="sa_3" value="sa_3" />Confessionnel</label>
                                <label for="sa_4"><input type="checkbox" id="sa_4" name="sa_4" value="sa_4" />Collectivités</label>
                                <label for="sa_5"><input type="checkbox" id="sa_5" name="sa_5" value="sa_5" />Culture</label>
                                <label for="sa_6"><input type="checkbox" id="sa_6" name="sa_6" value="sa_6" />Enseignement supérieur</label>
                                <label for="sa_7"><input type="checkbox" id="sa_7" name="sa_7" value="sa_7" />Environnement</label>
                                <label for="sa_8"><input type="checkbox" id="sa_8" name="sa_8" value="sa_8" />Hospitalier</label>
                                <label for="sa_9"><input type="checkbox" id="sa_9" name="sa_9" value="sa_9" />Recherche</label>
                                <label for="sa_10"><input type="checkbox" id="sa_10" name="sa_10" value="sa_10" />Santé</label>
                                <label for="sa_11"><input type="checkbox" id="sa_11" name="sa_11" value="sa_11" />Tous secteurs</label>
                            </div>
                            <div class="error_text">Vous devez sélectionner au moins un secteur.</div>
                        </div>
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
                        <?php if($te == 'physique'){ ?>
                            <div class="inner-input-wrapper">
                                <select name="region" style="display:none;">
                                    <option value="" selected>Région</option>
                                    <?php foreach ($regions as $reg => $region) { ?>
                                    <option value="<?php echo $reg; ?>"><?php echo $region; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
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
                        <div class="error_text">Date de l’évènement (ex: 01/01/2021)</div>
                    </div>
                    <div class="input-wrapper">
                        <input type="text" name="url" placeholder="Site web ou page Facebook de l’évènement">
                        <div class="error_text">Site web ou page Facebook de l’évènement</div>
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
                        <div class="error_text">Veuillez respecter le format requis. Le champ doit comporter au moins 2 caractères dans la limite de 250 caractères.</div>
                    </div>
                </div>
            </div>
            <div class="input-block-wrapper input-block-wrapper__image">
                <div class="input-column">
                    <div class="input-wrapper">
                        <div class="input-container-file">
                            <img src="/wp-content/uploads/2020/09/file_upload.png"/>
                            <input type="file" id="file-upload" name="file" multiple/>
                            <div class="error_text">Visuel de l'évènement au format .jpg, .jpeg ou .png.</div>
                            <p class="text-file-upload-desktop">Glissez / déposez ici le visuel de l'évènement, ou votre logo, au format 16/9<br/>
                            ou <u>choisissez un fichier sur votre ordinateur</u></p>
                            <p class="text-file-upload-mobile">Téléchargez ici le visuel<br/>de l’évènement, ou votre logo,<br/>au format 16/9</p>
                            <p id="file-name"></p>
                        </div>
                        <!--<div class="fallback" style="display:none;">
                            <input type="file" id="file" name="file" multiple/>--required--
                        </div>-->
                    </div>
                </div>
            </div>
            <div class="input-block-wrapper input-block-wrapper__autorise-communication">
                <div class="input-wrapper">
                    <input type="checkbox" name="autorise_communication" value="1">
                    <label for="autorise_communication" class="text-block">J'accepte de recevoir des informations dans le cadre du mouvement GivingTuesday France. Don’t worry! Vos données ne seront ni vendues, ni échangées. Elles nous permettent uniquement de vous tenir au courant de GivingTuesday France.</label>
                    <div class="error_text">Ce champ est obligatoire.</div>
                </div>
            </div>
            <div class="action-block">
                <button type="submit">Je publie mon évènement</button>
            </div>
            <div class="merci-popup">
                <span class="close-popup"><i class="fas fa-times"></i></span>
                <div>Merci beaucoup pour votre participation ! Votre événement a bien été pris en compte et ajouté dans la liste des événements pour le #GivingTuesdayFr </div>
            </div>
        </form>
    </div>
</div>