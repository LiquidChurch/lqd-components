<?php

add_action( 'archive_template', 'lqdnotes_archive_template' );

function lqdnotes_archive_template( $originalTemplate ) {
    $singleTemplate = plugin_dir_path(
        \dirname( __DIR__ )
    );

    $singleTemplate .= '/single-template.php';

    if ('lqdnotes' === get_post_type(get_the_ID() ) ) {
        if ( file_exists( $singleTemplate ) ) {
            return $singleTemplate;
        }
    }

    return $originalTemplate;
}