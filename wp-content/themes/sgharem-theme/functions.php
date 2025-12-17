<?php
function sgharem_assets() {
    wp_enqueue_style('sgharem-style', get_stylesheet_uri(), [], '1.0');
}
add_action('wp_enqueue_scripts', 'sgharem_assets');
