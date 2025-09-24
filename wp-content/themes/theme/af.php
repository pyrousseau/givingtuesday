<?php
include(dirname(__FILE__) . '/../../../wp-load.php');
extract($_POST);
//var_dump($_POST); 

$secteurMetaQuery = array();
$organisationMetaQuery = array();
$titleO = "";

if (isset($secteur) && count($secteur) > 0) {
    $secteurMetaQuery = array(
        'key' => 'secteur_activite',
        'value' => $secteur,
        'compare' => 'IN'
    );
}
if (isset($title) && !empty($title) ) {
    $titleO = $title;

}
if ($action == 'filter' && $filter != 'all') {
    $organisationMetaQuery = array(
        'key' => 'type_participant',
        'value' => $filter,
        'compare' => 'LIKE'
    );
}
$query = new WP_Query(
        array(
            'posts_per_page' => '-1',
            'post_type' => 'participant',
            's'=>$titleO,
            'orderby' => 'title',
            'order'=>'ASC',
            'meta_key'  => 'type_participant',
            'meta_value' => $filter,
            'meta_query' => array(
                    'relation' => 'OR',
                    $organisationMetaQuery,
                    $secteurMetaQuery,
            ),
        )
);

/*if ($action == 'filter') {
    if ($filter != 'all') {
        $query = new WP_Query(
            array(
                'posts_per_page' => '-1',
                'post_type' => 'participant',
                'orderby' => 'title',
                'order'=>'ASC',
                'meta_key'  => 'type_participant',
                'meta_value' => $filter
            )
        );
    } else {
        $query = new WP_Query(
            array(
                'posts_per_page' => '-1',
                'post_type' => 'participant',
                'orderby' => 'title',
                'order'=>'ASC',
            )
        );
    }*/

    $html = '';
    while($query->have_posts()) : $query->the_post();
     // Image
    $image = get_field('image_participant');
    $url   = '';
    if (is_array($image)) {
    // ⚠️ vérifie la clé de taille : 'paricipant' semble une coquille → 'participant' ?
    $sizeKey = isset($image['sizes']['participant']) ? 'participant' : 'paricipant';
    $url = esc_url($image['sizes'][$sizeKey] ?? ($image['url'] ?? ''));
    }

    // Type participant (classe CSS)
    $type = esc_attr( get_field('type_participant') );

    // Lien (Link ou URL)
    $l = get_field('lien_participant');
    $href   = '';
    $target = '_self';
    if ($l) {
    if (is_array($l)) {
        $href   = esc_url($l['url'] ?? '');
        $target = esc_attr($l['target'] ?? '_self');
        // $linkTitle = esc_html($l['title'] ?? ''); // si tu veux l’utiliser
    } else {
        $href = esc_url($l);
    }
    }

    // Titre
    $title = esc_html( get_the_title() );

    // HTML
    $html .= sprintf(
    '<li class="type-%s"><a href="%s" target="%s" rel="noopener" class="innter-wrapper-list"><div class="img-block"><img src="%s" alt="%s"></div><div class="text-block">%s</div></a></li>',
    $type,
    $href,
    $target,
    $url,
    $title,
    $title
    );

    endwhile;

    echo json_encode(array(
        'html' => $html,
        'post_count' => $query->post_count
    ));
//}
?>