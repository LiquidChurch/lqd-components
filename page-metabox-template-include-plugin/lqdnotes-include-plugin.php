<?php
/**
 * Plugin Name: Include Plugin Templates Plugin
 * Version: 0.0.1
 * Author: Liquid Church, Dave Mackey
 * Author URI: https://liquidchurch.com/
 *
 * Creates an additional page template option in WP meta box, however we are looking to do this automatically.
 *
 * Unlike other portions of the components this code is written in an OOP manner. It is based on:
 * https://www.wpexplorer.com/wordpress-page-templates-plugin/
 */

/**
 * Class PageTemplater
 */
class PageTemplater {
    // Reference to an instance of this class.
    private static $instance;

    // The array of templates this plugin tracks.
    protected $templates;

    // Unique Identifier
    protected $plugin_slug;

    /**
     * Return Singleton Instance of Class
     *
     */
    public static function get_instance() {
        // If instance does not already exist
        if( null == self::$instance ) {
            //  Get a new instance of PageTemplater
            self::$instance = new PageTemplater();
        }

        return self::$instance;
    }


    /**
     * Initialize Plugin by Setting Filters and Admin Functions.
     *
     * References:
     * - What does the variable $this mean in PHP? : https://stackoverflow.com/questions/1523479/what-does-the-variable-this-mean-in-php
     */
    // By making __construct private we ensure that only our code can kick off an instance of the class.
    private function __construct() {
        // Use $this to refer to current instance of object.
        // We are setting the templates property of our PageTemplater object instance to an empty array.
        $this->templates = array();

        // This filter requires WP 4.7+
        add_filter(
            'theme_page_templates',
            array( $this, 'add_new_template' )
        );

        // By default WP includes templates in the active theme in its cache. Since our files actually exist
        // in the plugin we need to force WP to register our plugin templates.
        // The result of this is that the page template is added to the dropdown list in the page attributes meta box
        // in the page editor.
        // If selected this page template will be saved to the post data.
        add_filter(
            'wp_insert_post_data',
            array( $this, 'register_project_templates' )
        );

        // Provide the path to our templates.
        add_filter(
            'template_include',
            array( $this, 'view_project_template' )
        );

        // These are the specific page templates we want added, the path is relative to where the page template file is.
        $this->templates = array(
            'lqdnotes-template.php' => 'Liquid Notes',
        );
    }

    /**
     * Register Project Templates with WP
     */
    public function register_project_templates( $atts ) {

        // A unique identifier for this plugin's page template data.
        // md5 ensures we have a unique string to avoid collisions.
        $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

        // Retrieve the existing cache list if it exists.
        $templates = wp_get_theme()->get_page_templates();
        // If cache is empty, prepare a new one array to merge with cache
        if ( empty( $templates ) ) {
            $templates = array();
        }

        // Delete the existing cache, note that we have it saved in $templates.
        wp_cache_delete( $cache_key, 'themes' );

        // Merge the list of templates we are adding with what was the cache's list (now in $templates)
        $templates = array_merge( $templates, $this->templates );

        // Send back to WP the updated cache which includes all its previous contents plus our templates.
        wp_cache_add( $cache_key, $templates, 'themes', 1800 );

        return $atts;
    }

    /**
     * Check if Template is Assigned to Page
     */
    public function view_project_template( $template ) {
        // $post is a global variable containing the current post.
        global $post;

        // If $post is empty we return the template we were given.
        if ( ! $post ) {
            return $template;
        }

        // If we don't have a custom page defined, return template we were given.
        if ( ! isset( $this->templates[get_post_meta(
            $post->ID, '_wp_page_template', true
            )] ) ) {
            return $template;
        }

        // If there is a custom page defined, return out template.
         $file = plugin_dir_path( __FILE__ ) . get_post_meta(
             $post->ID, '_wp_page_template', true
            );

        // Check if the template file exists
        if ( file_exists( $file ) ) {
            return $file;
        } else {
            echo $file;
        }

        // Return template
        return $template;
    }
}

add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );