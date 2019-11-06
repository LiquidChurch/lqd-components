<?php
/**
 * Plugin Name: Filter the Content
 * Description: Replaces text in the_content that has xxx into a form.
 *
 * Note: We are using PHP's DOM extension which in turn requires the libxml extension. Both of these are
 * installed/enabled by default for PHP installs, but if you are running into errors, take a look at your PHP config.
 *
 * @param $content
 *
 * Resources:
 * - @link https://developer.wordpress.org/reference/hooks/the_content/
 * - @link https://www.thewebtaylor.com/articles/wordpress-replace-string-in-content-of-all-pages
 * - @link https://www.php.net/manual/en/class.domdocument.php
 * - @link https://wordpress.stackexchange.com/questions/216879/how-to-enqueue-javascripts-in-a-plugin
 */

/**
 * Enqueues Our JavaScript
 *
 * This JavaScript is what actually replaces blanked text with the input boxes and that converts
 * input boxes back to regular text.
 */
function lqdnotes_enqueue() {
    wp_enqueue_script( 'lqdnotes-filter-content', plugin_dir_url( __FILE__ ) . '/filter-content.js', array(), '0.0.1' );
    wp_enqueue_script( 'lqdnotes-return-filled', plugin_dir_url( __FILE__ ) . '/prepare-note-for-email.js', array( 'jquery' ),
        '0.0.2' );
}
add_action( 'wp_enqueue_scripts', 'lqdnotes_enqueue' );

/**
 * Enclose our post content in a form.
 *
 * We need to be able to submit the fields so we need a form around our inptus.
 */
function lqdnotes_add_form( $content ) {
    // $content = '<form id="lqd-notes-form">' . $content . '<input type="email"><input type="submit" value="Send
    // Notes" onclick="prepareNotes()"></form>';
    $content .= '<input type="submit" value="Send Notes" onclick="prepareNotes()">';
    return $content;
}
add_filter( 'the_content', 'lqdnotes_add_form' );

/**
 * Send our Notes Email
 */
function send_notes() {
    // nonce check
    if( !wp_verify_nonce( $_REQUEST['nonce'], 'send_notes_nonce')) {
        exit;
    }
}