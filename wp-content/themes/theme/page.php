<?php
get_header();

if (locate_template( array( 'templates/'.$post->post_name . '.php' ) ) != '') {
    get_template_part('templates/'.$post->post_name);
} else {
    the_content();
}

get_footer();

?>
