# Bricks Pre-Built Layouts tutorials

## Structurial changes

After making the video I had a number of requests to share the code. To better support this I have made some structural changes.

In the video all the code was placed in the functions.php file.

I have now seperated this out into several other files which are included with the functions.php file using the "require_once" command.

Below is an example of what that might look like:

```php
// The theme directory example:
// public_html/wp-content/themes/bricks-child
$theme_dir = get_stylesheet_directory();

// The includes directory example:
// public_html/wp-content/themes/bricks-child/includes
$includes_dir = $theme_dir . '/includes';

// This will pull in the file that contains the function to hide the admin bar to ensure it is included when the functions.php file is loaded
// public_html/wp-content/themes/bricks-child/includes/hide-admin-bar.php
require_once($includes_dir . '/hide-admin-bar.php');

```

What you will need to do is import the required files to your project and reference them the same way. Of course you can also just copy the code and paste it directly into you functions.php file.
