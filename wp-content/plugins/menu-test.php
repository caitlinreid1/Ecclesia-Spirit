<?php
/*
Plugin Name: Menu Test
Plugin URI: http://codex.wordpress.org/Adding_Administration_Menus
Description: Menu Test
Author: Codex authors
Author URI: http://example.com
*/

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {

    // Add a new submenu under existing Settings:
    add_options_page(__('Test Settings','menu-test'), __('Test Settings','menu-test'), 'manage_options', 'testsettings', 'mt_settings_page');

    // Add a new submenu under Tools:
    add_management_page( __('Test Tools','menu-test'), __('Test Tools','menu-test'), 'manage_options', 'testtools', 'mt_tools_page');

    // Add a new top-level menu (ill-advised):
    add_menu_page(__('Custom Forms','menu-test'), __('Custom Forms','menu-test'), 'manage_options', 'mt-top-level-handle', 'mt_toplevel_page' );

    // Add a submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', __('Administrators','menu-test'), __('Administrators','menu-test'), 'manage_options', 'administrators', 'mt_sublevel_page');

    // Add a second submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', __('Salesforce','menu-test'), __('Salesforce','menu-test'), 'manage_options', 'salesforce', 'mt_sublevel_page2');
}

/*
// mt_settings_page() displays the page content for the Test Settings submenu
function mt_settings_page() {
    echo "<h2>" . __( 'Test Settings', 'menu-test' ) . "</h2>";
}
*/

// mt_tools_page() displays the page content for the Test Tools submenu
function mt_tools_page() {
    echo "<h2>" . __( 'Test Tools', 'menu-test' ) . "</h2>";
}

// mt_toplevel_page() displays the page content for the custom Custom Forms menu
function mt_toplevel_page() {
    echo "<h2>" . __( 'Custom Forms', 'menu-test' ) . "</h2>";
    echo "<p>" . "This page will route to the sub-pages for Administrators, Salesforce, etc." . "</p>";
}

// mt_sublevel_page() displays the page content for the first submenu
// of the custom Custom Forms menu
function mt_sublevel_page() {
    echo "<h2>" . __( 'Administrators', 'menu-test' ) . "</h2>";
    echo "<p> Testing 123 </p>";
}

// mt_sublevel_page2() displays the page content for the second submenu
// of the custom Custom Forms menu
function mt_sublevel_page2() {
    echo "<h2>" . __( 'Salesforce', 'menu-test' ) . "</h2>";
}



// ------------------- //



// mt_settings_page() displays the page content for the Test Settings submenu
function mt_settings_page() {

    //must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    // variables for the field and option names 
    $opt_name = 'mt_favorite_color';
    $hidden_field_name = 'mt_submit_hidden';
    $data_field_name = 'mt_favorite_color';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );

        // Put a "settings saved" message on the screen

?>
<div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div>
<?php

    }

    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Menu Test Plugin Settings', 'menu-test' ) . "</h2>";

    // settings form
    
?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Favorite Color:", 'menu-test' ); ?> 
    <input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
</p>

<hr /> <!--horizontal rule-->

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
</div>

<?php
 
}
// closes mt_settings_page() function


// add shortcode
add_shortcode('add_new_form', 'mt_settings_page');
