<?php
/**
 * Plugin Name: Template Include Plugin
 * Author: Liquid Church, Dave Mackey
 *
 * This plugin checks when a post is loaded whether it is a lqdnotes CPT. If it is it returns the custom template
 * included with the plugin.
 *
 * If it isn't, it returns the original template.
 *
 * References:
 * - On single_template and archive_template hooks: https://developer.wordpress.org/reference/hooks/type_template/
 * - Based on Tom McFarlin's tutorial: https://tommcfarlin.com/custom-templates-in-our-wordpress-plugin/
 */

add_action( 'single_template', 'lqdNotesIncludeSingleTemplate' );

/**
 * Add Custom, Single Template from Plugin.
 *
 * If post is in CPT, then use plugin's custom single template.
 */
function lqdNotesIncludeSingleTemplate( $originalTemplate ) {

    $singleTemplate = plugin_dir_path(
        \dirname(
            __DIR__
        )
    );
    $singleTemplate .= '/templates/single-lqdnotes.php';

    if ( 'lqdnotes' === get_post_type(get_the_ID())) {
        if (file_exists( $singleTemplate ) ) {
            return $singleTemplate;
        }
    }

    return $originalTemplate;
}

add_action( 'archive_template', 'lqdNotesIncludeArchiveTemplate' );

/**
 * Add Custom, Archive Template from Plugin.
 *
 * If archive is of CPT, use plugin's custom archive template.
 */
function lqdNotesIncludeArchiveTemplate( $originalArchiveTemplate ) {
    $archiveTemplate = plugin_dir_path(
        \dirname(
            __DIR__
        )
    );
    $archiveTemplate .= '/templates/archive-lqdnotes.php';

    if ( 'lqdnotes' === get_post_type(get_the_ID() ) ) {
        if( file_exists( $archiveTemplate ) ) {
            return $archiveTemplate;
        }
    }

    return $originalArchiveTemplate;
}