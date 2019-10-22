<?php

add_action( 'single_template', 'lqdnotes_single_template' );

function lqdnotes_single_template($originalArchiveTemplate) {
    $archiveTemplate = plugin_dir_path(
        \dirname( __DIR__ )
    );
    $archiveTemplate .= '/archive-template.php';

    if ( 'lqdnotes' === get_post_type( get_the_ID() ) ) {
        if ( file_exists( $archiveTemplate ) ) {
            return $archiveTemplate;
        }
    }

    return $originalArchiveTemplate;
}