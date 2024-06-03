<?php

/**
 * Register the 'get-bricks-layout' REST API endpoint to fetch the layout details from a specific post.
 *
 * This function uses the 'rest_api_init' action to register a custom REST API endpoint that fetches the layout details
 * from a specific post. The endpoint is registered under the 'bricks-layouts/v1' namespace and the '/get-layout' route.
 * The endpoint requires a valid nonce to access the data. The callback function 'get_bricks_layout_callback' fetches the
 * layout details from the post meta and returns the JSON data. The 'bricks_layout_permission_callback' function is used to
 * check the nonce and validate the request. 
 * 
 * @author Craig Davison
 * @created 2024-05-31
 * @updated 2024-05-31
 * @since 1.0.0
 */
// End of comments describing this functioniality


// NOTE: be sure to check how this is imported into the functions.php file using require_once or include_once commands.


/** Get Bricks layout endpoint */

//add_action( $hook_name:string, $callback:callable, $priority:integer, $accepted_args:integer )
add_action('rest_api_init', 'register_get_bricks_layout_endpoint');

// Register Custom REST API Endpoint
function register_get_bricks_layout_endpoint() {
    // https://mywebsite.com/bricks-layouts/v1/get-layout

   
    $namespace = 'bricks-layouts/v1';
    $route = '/get-layout';

    register_rest_route($namespace, $route, array(
        'methods' => 'POST',
        'permission_callback' => 'bricks_layout_permission_callback', // Adjust permissions as needed
        'callback' => 'get_bricks_layout_callback'
    ));
}

// Permission Callback
function bricks_layout_permission_callback(WP_REST_Request $request){
  // Get the nonce from the request
  $nonce = $request->get_header('X_WP_Nonce');
  // Check if the nonce is valid
  if(!wp_verify_nonce( $nonce, 'wp-rest-bricks-layout' )){ 
    return new WP_Error('rest_forbidden', esc_html__('Invalid Nonce', 'rest_forbidden'), array('status' => 403));
  }

  return true; // Allow access to all users
}

// Callback function to get meta value
function get_bricks_layout_callback(WP_REST_Request $request) {
    $post_id = $request->get_param('post_id');
    // if no post found return a status of 400 and a message stating Invalid post ID
    if (!$post_id) {
        return new WP_Error('no_post_id', 'No post ID requested!', array('status' => 400));
    }

    $meta_key = 'layout-details_layout-json'; // Replace with your actual meta key
    $json_value = get_post_meta($post_id, $meta_key, true);

    // if no JSON string found, return a status of 400 with a message of "No JSON value found"
    if (empty($json_value)) {
        return new WP_Error('no_meta_value', 'No JSON value found', array('status' => 404));
    }

    // return rest_ensure_response(json_decode($json_value));
    return rest_ensure_response(json_decode($json_value));
}

// Enqueue the script to fetch the layout JSON data
function enqueue_all_js_scripts() {
  // wp_enqueue_script( $handle:string, $src:string, $deps:array, $ver:string|boolean|null, $in_footer:boolean )
  // Script 1
  $handle = 'fetch-bricks-layout-json-script';
  $src = get_template_directory_uri() . '-child/assets/js/fetch-layout-json.js';
  wp_enqueue_script($handle, $src, array(), 'v0.1', true);
  $object_name = 'bricksLayoutData';
  wp_localize_script($handle, $object_name, array(
      'endpointUrl' => rest_url('bricks-layouts/v1/get-layout'),
      'nonce' => wp_create_nonce('wp-rest-bricks-layout')
  ));
}
add_action('wp_enqueue_scripts', 'enqueue_all_js_scripts');



// Disable nonce check for the custom endpoint
function disable_rest_nonce_check_for_bricks_layout_endpoint($result) {
    if (!empty($result)) {
        return $result;
    }
    // https://mywebsite.com/wp-json/bricks-layouts/v1/get-layout
    // Check if the request is for your custom endpoint
    if (strpos($_SERVER['REQUEST_URI'], '/wp-json/bricks-layouts/v1/get-layout') !== false) {
        return true; // Disable default nonce check
    }

    return $result;
}
add_filter('rest_authentication_errors', 'disable_rest_nonce_check_for_bricks_layout_endpoint');