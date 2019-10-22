<?php
/**
 * Plugin Name: Liquid Notes Create Custom Post Type
 * Version: 0.0.1
 * Author: Liquid Church, Dave Mackey
 * License: GPLv2 or later
 * Text Domain: lqdnotes
 * 
 * We define and register a Custom Post Type (CPT) of 'Liquid Notes'
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
    createNotesCPT();
}

/**
 * Register a Custom Post Type: Liquid Notes.
 * 
 * References:
 * - List of Available Labels for CPT: https://developer.wordpress.org/reference/functions/get_post_type_labels/
 * - List of Available Capabilities for CPT: https://developer.wordpress.org/reference/functions/get_post_type_capabilities/
 * - List of Available Arguments for Registering CPT: https://developer.wordpress.org/reference/functions/register_post_type/
 * - Registering a CPT: https://developer.wordpress.org/reference/functions/register_post_type/
 *
 *  @since: 0.0.1
 * 
 */
function createNotesCPT() {
    // Define the labels for CPT.
    $labels = array(
        'name'                  => _x( 'Liquid Notes', 'post type general name', 'lqdnotes' ),
        'singular_name'         => _x( 'Liquid Note', 'post type singular name', 'lqdnotes' ),
        'menu_name'             => _x( 'Liquid Notes', 'admin menu', 'lqdnotes' ),
        'name_admin_bar'        => _x( 'Liquid Notes', 'lqdnotes'),
        'add_new'               => _x( 'Add New', 'lqdnotes' ),
        'add_new_item'          => _x( 'Add New Note', 'lqdnotes' ),
        'new_item'              => _x( 'New Note', 'lqdnotes' ),
        'edit_item'             => _x( 'Edit Note', 'lqdnotes' ),
        'view_item'             => _x( 'View Note', 'lqdnotes' ),
        'all_items'             => _x( 'All Notes', 'lqdnotes' ),
        'search_items'          => _x( 'Search Notes', 'lqdnotes' ),
        'parent_item_colon'     => _x( 'Parent Notes', 'lqdnotes' ),
        'not_found'             => _x( 'No note found.', 'lqdnotes' ),
        'not_found_in_trash'    => _x( 'No note found in trash.', 'lqdnotes' ),
    );

    // Define the capabilities of the CPT.
    $capabilities = array(
        'edit_others_posts'         => 'edit_others_lqdnotes',
        'delete_others_posts'       => 'delete_others_lqdnotes',
        'delete_private_posts'      => 'delete_private_lqdnotes',
        'edit_private_posts'        => 'edit_private_lqdnotes',
        'read_private_posts'        => 'read_private_lqdnotes',
        'edit_published_posts'      => 'edit_published_lqdnotes',
        'publish_posts'             => 'publish_lqdnotes',
        'delete_published_posts'    => 'delete_published_lqdnotes',
        'edit_posts'                => 'edit_lqdnotes',
        'delete_posts'              => 'delete_lqdnotes',
        'edit_post'                 => 'edit_lqdnote',
        'read_post'                 => 'read_lqdnote',
        'delete_post'               => 'delete_lqdnote'
    );

    // Arguments array which we will pass to register_post_type function.
    // Array will include the labels and capabilities arrays we've defined above.
    $args = array(
        'description'       => 'Interactive fill-in-the-blank notes.',
        'has_archive'       => 'true',
        'hierarchical'      => 'true',
        'labels'            => $labels,
        'menu_icon'         => 'dashicons-admin-comments',
        'menu_position'     => 30,
        'public'            => true,
        'rewrite'           => 'notes', // TODO: Make customizable
        'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackback', 'custom-fields',
            'comments', 'revisions', 'page-attributes', 'post-formats' ),
        'capabilities'      => $capabilities,
        'map_meta_cap'      => true,
    );

    // Register Liquid Notes CPT.
    // register_post_type( string $post_type, array|string $args = array() )
    register_post_type( 'lqdnotes', $args );
}