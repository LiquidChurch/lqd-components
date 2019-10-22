<?php
/**
 * Plugin Name: Liquid Notes Create Custom Role
 * Version: 0.0.1
 * Author: Liquid Church, Dave Mackey
 * License: GPLv2 or later
 * Text Domain: lqdnotes
 * 
 * We define and create a custom role to be used with the 'Liquid Notes' CPT.
 * 
 */


/**
 * Activate our Plugin.
 * 
 * Runs once when plugin is activated.
 * 
 * @since: 0.0.1
 */
function activate_plugin()
{
    createNotesRole();
}

/**
 * Create a Custom Role: Liquid Notes Editor
 * 
 * References:
 * - List of Available Capabilities: https://wordpress.org/support/article/roles-and-capabilities/
 * - Adding a Custom Role: https://developer.wordpress.org/reference/functions/add_role/
 * - Get Existing Roles: https://developer.wordpress.org/reference/functions/get_role/
 * - Adding Capabilities to a Role: https://developer.wordpress.org/reference/classes/wp_role/add_cap/
 * 
 * @since: 0.0.1
 */
function createNotesRole()
{
// Set capabilities for role
    $customCaps = array(
        // Permissions for LqdNotes CPT
        'edit_other_lqdnotes' => true,
        'delete_other_lqdnotes' => true,
        'delete_private_lqdnotes' => true,
        'edit_private_lqdnotes' => true,
        'read_private_lqdnotes' => true,
        'edit_published_lqdnotes' => true,
        'publish_lqdnotes' => true,
        'delete_published_lqdnotes' => true,
        'edit_lqdnotes' => true,
        'delete_lqdnotes' => true,
        'edit_lqdnote' => true,
        'read_lqdnote' => true,
        'delete_lqdnote' => true,
        'read' => true,
        // Permissions for Message Series Taxonomy
        // TODO: Do we need to provide permissions for each taxonomy?
        'manage_lqdnote_types' => true,
        'edit_lqdnote_types' => true,
        'delete_lqdnote_types' => true,
        'assign_lqdnote_types' => true
        // Add Speaker
        // Add Scriptures
        // Add Series
    );

    // Create Our Liquid Notes role and assign the custom capabilities to it.
    // add_role( string $role, string $display_name, array $capabilities = array() );
    add_role('lqdnotes_editor', __('Liquid Notes Editor', 'lqdnotes'), $customCaps);
    
    // Add Custom Capabilities to Admin and Editor Roles
    $roles = array('administrator', 'editor');
    foreach ($roles as $roleName) {
        // Get role
        // $role = get_role ( string $role );
        $role = get_role($roleName);

        // Check role exists
        if (is_null($role)) {
            continue;
        }

        // Iterate through our custom capabilities, adding them
        // to this role if they are enabled
        foreach ($customCaps as $capability => $enabled) {
            if ($enabled) {
                // Add capability to role
                // WP_Role::add_cap( string $cap, bool $grant = true )
                $role->add_cap($capability);
            }
        }
    }
}