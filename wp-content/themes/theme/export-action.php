<?php include(dirname(__FILE__) . '/../../../wp-load.php');
$upload = wp_upload_dir();
$uploadDir = $upload['basedir'].'/exports/';
$uploadUrl = $upload['baseurl'].'/exports/';
$filename = 'export-actions-'.time();


$filename .= '.csv';
//$fName = $uploadDir.$filename;
//$fileOpen = fopen($fName,'w');
//fputcsv($fileOpen,array('ID','Intitulé de l’évènement','Type de l\'organisation','Nom de societe','Civilite','Nom','Prénom','Email', 'Type d’évènement', 'Catégorie d’évènement', 'Date de l’évènement', 'Ville', 'Reégion', 'Description', 'Site Web'));
$data = "ID,Intitule de l’evenement,Type de l'organisation,Nom de societe,Civilite,Nom,Prenom,Email,Type d’evenement,Categorie d’evenement,Date de l’evenemente, Ville, Region, Description, Site Web\n";
$getActions = new WP_Query(
    array(
        'post_type' => 'action-a-decouvrir',
        'posts_per_page' => '-1',
        'post_status' => 'publish',
        'orderby' => 'ID',
        'order' => 'DESC'
    )
);
while ($getActions->have_posts()) : $getActions->the_post();
    $fields = get_fields();
    $type = get_field_object('form_type'); $type = $type['choices'][$fields['form_type']];
    $type_event = get_field_object('type_event'); $type_event = $type_event['choices'][$fields['type_event']];
    $cat_event = get_field_object('categorie_event'); $cat_event = $cat_event['choices'][$fields['categorie_event']];
    if ($fields['region'] == '-') {
        $region = '-';
    } else {
        $region = get_field_object('region'); $region = $region['choices'][$fields['region']];
    }

    $data .= get_the_ID().",".get_the_title().",".$type.",".$fields["nom_societe"].",".$fields["civilite"].",".$fields["nom"].",".$fields["prenom"].",".$fields["email"].",".$type_event.",". $cat_event.",".$fields["event_date"].",".$fields["ville"].",".$region.','.$fields["event_description"].",".$fields["url"]."\n";


endwhile;
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'"');
echo $data;
exit();
?>