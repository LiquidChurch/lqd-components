<?php
/**
 * Plugin Name: Liquid Notes Settings Page
 * Version: 0.0.1
 * Author: Liquid Church, Dave Mackey
 * License: GPLv2 or later
 * Text Domain: lqdnotes
 *
 * Settings Pages are built using the Settings API, which behind the scenes uses the Options API.
 *
 * We will perform three functions:
 * 1. Create a navigation link on the WP Admin menu to our settings page.
 * 2. Create the necessary setting, section, and field.
 * 3. Render the settings page in the browser.
 *
 * Terminology:
 * - Page - A collection of sections.
 * - Section - A collection of individual fields.
 * - Field - Displays (and may allow editing of) individual settings.
 * - Setting - A setting is a row in the wp_options table.
 * - Group - A collection of fields that are grouped logically (though not necessarily visually) together.
 * Note that the last three items are "behind-the-scenes" whereas the first three are visually on the settings page.
 *
 * Notes:
 * - We have chosen to create variables with intuitive naming that are then passed in as arguments to WP functions,
 * one could provide the values directly as parameters but using variables reduces the necessity of referring to
 * other resources to learn parameters of a given function as it is not always intuitive from the value itself
 * what is being specified.
 *
 * References:
 * - Setting Pages Generally: https://wpshout.com/wordpress-options-page/
 * - Setting Pages Using Settings API: https://wpshout.com/making-an-admin-options-page-with-the-wordpress-settings-api/
 * - Options API: https://wpshout.com/mastering-wordpress-options-api/
 *
 */

/**
 * Custom Action: Add Submenu Item to Settings Menu
 *
 * References:
 * - https://developer.wordpress.org/reference/functions/add_options_page
 *
 * @since: 0.0.1
 */
function lqdnotes_settings_add_menu_item() {
    $page_title = 'Liquid Notes Settings'; // Title of the Settings Page
    $menu_title = 'Liquid Notes'; // Text for the Menu Item
    $capability = 'manage_options'; // Capabilities Required of User to Access
    $menu_slug = 'lqdnotes'; // Slug of Settings Page
    $settings_render_page = 'lqdnotes_settings_render_page'; // Function to Render Settings Page

    add_options_page(
        $page_title,
        $menu_title,
        $capability,
        $menu_slug,
        $settings_render_page
    );
}

// Register our custom action to the admin_menu hook.
add_action( 'admin_menu', 'lqdnotes_settings_add_menu_item' );

/**
 * Custom Action: Initialize Settings and Settings Page
 *
 * Initialize the setting, section, and field we'll use on our Settings page.
 *
 * References:
 * - Register Setting: https://developer.wordpress.org/reference/functions/register_setting/
 * - Adding Section: https://developer.wordpress.org/reference/functions/add_settings_section/
 * - Adding Field: https://developer.wordpress.org/reference/functions/add_settings_field/
 *
 * @since: 0.0.1
 */
function lqdnotes_settings_init() {
    // Register Setting
    $settings_option_group = 'lqdnotes_settings_taxonomies'; // Used in the ID of HTML attribute tags.
    $settings_option_name = 'lqdnotes_settings_taxonomies';
    // $args = array( 'type', 'description', 'sanitize_callback', 'show_in_rest', 'default' )

    register_setting(
        $settings_option_group,
        $settings_option_name
    );

    // Add Section
    $settings_slug_name = 'lqdnotes_main'; // Logical not necessarily visual organization
    $settings_title = 'Liquid Notes Settings';
    $settings_callback = 'lqdnotes_settings_render_section'; // Function we'll render.
    $settings_page = 'lqdnotes'; // Slug of settings page where section will be rendered.

    add_settings_section(
        $settings_slug_name,
        $settings_title,
        $settings_callback,
        $settings_page
    );

    // Add Field
    $settings_field_slug_name = 'lqdnotes_settings_taxonomies';
    $settings_title = __( 'Available Taxonomies', 'lqdnotes' );
    $settings_field_callback = 'lqdnotes_settings_render_field';
    // $settings_page - Already set when registering section above.
    $section = 'lqdnotes_main';
    // $args = array( 'label_for', 'class' ) - Parameter we aren't using.

    add_settings_field(
        $settings_field_slug_name,
        $settings_title,
        $settings_field_callback,
        $settings_page,
        $section
    );
}

// Register our custom action with the admin_init hook.
add_action( 'admin_init', 'lqdnotes_settings_init' );

/**
 * Render Section
 *
 * The section is a container for fields. There could be multiple sections on a single settings page,
 * but we are only using one currently.
 *
 * @since: 0.0.1
 */
function lqdnotes_settings_render_section() {
    echo 'Select taxonomies that should be associated with Liquid Notes.';
}

/**
 * Render Checkbox List of Custom Public Taxonomies Field
 *
 * We get the list of taxonomies we've saved in the option lqdnotes_settings_taxonomies,
 * check that it has values and if it does output checkboxes in checked or unchecked state
 * depending on whether they are in lqdnotes_settings_taxonomies.
 *
 * If there are no options in lqdnotes_settings_taxonomies then we output all taxonomies.
 *
 * Note in either case that we exclude any private taxonomies and any that are part of WP core.
 *
 * Reference:
 * - https://developer.wordpress.org/reference/functions/get_taxonomies/
 *
 * @since:  0.0.1
 */
function lqdnotes_settings_render_field() {
    // Get currently selected taxonomies
    $selected_taxonomies = get_option( 'lqdnotes_settings_taxonomies' );

    // We only want taxonomies that are public and aren't built into WP core.
    $taxonomy_args = array(
            'public'        => true,
            '_builtin'      => false
    );
    $all_taxonomies = get_taxonomies( $taxonomy_args );

    // TODO: Check that we are getting an array back from the option, it will be boolean if no option has been set.
    // TODO: Get friendly names of taxonomies instead of slug names.
    // Iterate through each taxonomy
    $is_selected_an_array = is_array( $selected_taxonomies ); // See NOTE1.
    foreach ( $all_taxonomies as $taxonomy ) {
        // If taxonomy doesn't exist in $selected_taxonomies then output checkbox as unchecked.
        if ( ! is_array( $selected_taxonomies ) || ! in_array( $taxonomy, $selected_taxonomies ) ) {
            echo '<input type="checkbox" name="lqdnotes_settings_taxonomies[]" value="'. $taxonomy . '">' . $taxonomy . '<br>';
        } else { // If term exists in $selected_taxonomies then output the checkbox as checked.
            echo '<input type="checkbox" name="lqdnotes_settings_taxonomies[]" value="' . $taxonomy . '" checked>' . $taxonomy . '<br>';
        }
    }
}

/**
 * Render Settings Page
 *
 * @since: 0.0.1
 */
function lqdnotes_settings_render_page() {
    ?>
<div class="wrap">
    <form action="options.php" method="post">
        <?php settings_fields( 'lqdnotes_settings_taxonomies' ); ?>
        <?php do_settings_sections( 'lqdnotes' ); ?>

        <input name="Submit" type="submit"
               value="<?php esc_attr_e( 'Save Changes', 'lqdnotes' ); ?>"
               class="button button-primary" />
    </form>
</div>
<?php
}