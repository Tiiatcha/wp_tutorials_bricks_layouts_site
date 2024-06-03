<?php 
/**
 * Register/enqueue custom scripts and styles
 */
add_action( 'wp_enqueue_scripts', function() {
	// Enqueue your files on the canvas & frontend, not the builder panel. Otherwise custom CSS might affect builder)
	if ( ! bricks_is_builder_main() ) {
		wp_enqueue_style( 'bricks-child', get_stylesheet_uri(), ['bricks-frontend'], filemtime( get_stylesheet_directory() . '/style.css' ) );
	}
} );

/**
 * Register custom elements
 */
add_action( 'init', function() {
  $element_files = [
    __DIR__ . '/elements/title.php',
  ];

  foreach ( $element_files as $file ) {
    \Bricks\Elements::register_element( $file );
  }
}, 11 );

/**
 * Add text strings to builder
 */
add_filter( 'bricks/builder/i18n', function( $i18n ) {
  // For element category 'custom'
  $i18n['custom'] = esc_html__( 'Custom', 'bricks' );

  return $i18n;
} );

// custom functions....


// The theme directory example: 
// public_html/wp-content/themes/bricks-child
$theme_dir = get_stylesheet_directory();

// The includes directory example: 
// public_html/wp-content/themes/bricks-child/includes
$includes_dir = $theme_dir . '/includes';

// Only include what you need! Comment out or remove any lines that are not needed.
// Each file is idepentant of the others and can be used on its own.

// Each file contains all the code needed to run the function it is named after.

// This will pull in the file that contains the function to hide the admin bar to ensure it is included when the functions.php file is loaded
// public_html/wp-content/themes/bricks-child/includes/hide-admin-bar.php
require_once($includes_dir . '/hide-admin-bar.php');

// This will pull in the file that contains the function to copy to clipboard to ensure it is included when the functions.php file is loaded
// public_html/wp-content/themes/bricks-child/includes/copy-to-clipboard-endpoint.php
require_once($includes_dir . '/copy-to-clipboard-endpoint.php');

// This will pull in the file that contains the function to change the iframe size to ensure it is included when the functions.php file is loaded
// public_html/wp-content/themes/bricks-child/includes/change-ifram-size.php
require_once($includes_dir . '/change-ifram-size.php');



// anything below here is not yet available as it may still be under development!!!
// the code below will require all php files in the development directory and subdirectories
// if the in_development directory does not exist, the code will not run!

  // the full path to the development directory.
  $dev_path = $theme_dir . '/in_development/';

  // Check if the directory exists
  if (is_dir($dev_path)) {
    // require all php files in the directory and subdirectories

    // recursively search the directory for php files and require each one
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($full_path)) as $filename) {
      if ($filename->isDir()) {
        continue;
      }
      // for each file found, check if the extension is php and require it if true
      if ($filename->getExtension() === 'php') {
        require_once $filename->getPathname();
      }
      
    }
  }
