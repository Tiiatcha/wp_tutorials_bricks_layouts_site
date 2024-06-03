<?php

/**
 * Enqueue the change iframe size script
 *
 * This function uses the 'wp_enqueue_scripts' action to enqueue the 'change-iframe-size.js' script.
 *
 * 
 * @author Craig Davison
 * @created 2024-06-03
 * @updated 2024-06-03
 * @since 1.0.0
 */
// End of comments describing this functioniality


// NOTE: be sure to check how this is imported into the functions.php file

function enqueue_change_iframe_size_script() {
  // wp_enqueue_script( $handle:string, $src:string, $deps:array, $ver:string|boolean|null, $in_footer:boolean )
  
  $handle = 'change-iframe-size';
  $src = get_template_directory_uri() . '-child/assets/js/change-iframe-size.js';
  wp_enqueue_script($handle, $src, array(), 'v0.1', true);

}

add_action('wp_enqueue_scripts', 'enqueue_change_iframe_size_script');