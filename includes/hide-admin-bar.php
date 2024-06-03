<?php

/**
 * Hides the admin bar for the 'bricks_layout' custom post type.
 *
 * This function uses the 'show_admin_bar' filter to conditionally hide the WordPress
 * admin bar when viewing a single post of the 'bricks_layout' custom post type.
 *
 * @param bool $show : Whether to display the admin bar. Default true.
 * @return bool : Modified value of $show.
 * 
 * @author Craig Davison
 * @created 2024-06-01
 * @updated 2024-06-01
 * @since 1.0.0
 */
// End of comments describing this functioniality


// NOTE: be sure to check how this is imported into the functions.php file


// Hide the admin bar when displaying single posts from the custom post type of 'Bricks Layouts'
function hide_admin_bar_for_bricks_layouts($show_admin_bar) {
    // Check if we are viewing a single post of the 'bricks_layout' custom post type
    if (is_singular('bricks-layouts')) {
        return false; // Hide the admin bar
    }
    return $show_admin_bar; // Default behavior for other pages
  }
  add_filter('show_admin_bar', 'hide_admin_bar_for_bricks_layouts');

  