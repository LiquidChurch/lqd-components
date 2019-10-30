<?php
/**
 * Plugin Name: Add Gutenberg Button
 */

function addgb_format_script_register() {
    wp_register_script(
        'addgb-format-js',
        plugins_url( 'addgb-format.js', __FILE__ ),
        array( 'wp-rich-text', 'wp-element', 'wp-editor' )
    );
}
add_action( 'init', 'addgb_format_script_register' );

function addgb_format_enqueue_assets_editor() {
    wp_enqueue_script( 'addgb-format-js' );
}
add_action( 'enqueue_block_editor_assets', 'addgb_format_enqueue_assets_editor' );