<?php global $wpdb;
$table_prefix = 'gt_';
$table = $table_prefix.'formulaire';
$emails = $wpdb->get_results("SELECT * FROM $table WHERE 1 LIMIT 0,500000");
if (empty($_POST)) { ?>
    <form method="post">
        <button class="button button-primary button-large" name="csv" value="1">exporter comme *.csv</button>
    </form>
<?php } else {

    // here goes download link
    $upload = wp_upload_dir();
    $uploadDir = $upload['basedir'].'/exports/';
    $uploadUrl = $upload['baseurl'].'/exports/';
    $filename = 'export-'.time();


    $filename .= '.csv';
    $fName = $uploadDir.$filename;
    $fileOpen = fopen($fName,'w');
    fputcsv($fileOpen,array('ID','Email','Type','Societe','Civilite','Nom','Prenom','Date'));
    foreach ($emails as $email) {
        $stringArray = array(
            $email->id,
            $email->email,
            $email->type,
            $email->intitule,
            $email->societe,
            $email->civilite,
            $email->nom,
            $email->prenom,
            date('d/m/Y', strtotime($email->date))
        );
        fputcsv($fileOpen,$stringArray);
    }
    fclose($fileOpen);
    $downloadLink = $uploadUrl.$filename;
     ?>
    <a href="<?php echo $downloadLink; ?>" target="_blank" class="button button-primary button-large">Télécharger</a>
<?php } ?>
<br><br>
<table cellspacing="0" border="1" cellpadding="5">
    <thead>
    <tr>
        <td>ID</td>
        <td>Email</td>
        <td>Type</td>
        <td>Intitulé</td>
<!--        <td>Société</td>-->
        <td>Nom de la structure</td>
        <td>Civilité</td>
        <td>Nom</td>
        <td>Prénom</td>
        <td>date</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($emails as $email) { ?>
        <tr>
            <td><?php echo $email->id; ?></td>
            <td><?php echo $email->email; ?></td>
            <td><?php echo $email->type; ?></td>
            <td><?php echo $email->intitule; ?></td>
            <td><?php echo $email->societe; ?></td>
            <td><?php echo $email->civilite; ?></td>
            <td><?php echo $email->nom; ?></td>
            <td><?php echo $email->prenom; ?></td>
            <td><?php echo date('d/m/Y', strtotime($email->date)); ?></td>


        </tr>
    <?php } ?>
    </tbody>
</table>
</div>