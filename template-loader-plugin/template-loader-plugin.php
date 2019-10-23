<?php
/**
 * Template Loader for Liquid Notes.
 *
 * Extends generic Gamajo's Template Loader for use with Liquid Notes specifically.
 *
 * TODO: Would it make sense to replace Gamajo with McFarlin's? See: https://github.com/tommcfarlin/simple-autoloader-for-wordpress/
 */

if ( ! class_exists( 'LqdNotes_Template_Loader' ) ) {
    /**
     * Template Loader
     *
     * @since: 0.0.1
     */
    class LqdNotes_Template_Loader extends Gamajo_Template_Loader {
        // Prefix for filter names
        protected $filter_prefix = 'lqdnotes';

        // Directory name where custom templates do/could exist in theme.
        protected $theme_template_directory = 'lqdnotes';

        // Root directory path of lqdnotes plugin.
        protected $plugin_directory = 'lqdnotes';

        // Directory where templates are found inside lqdnotes plugin.
        protected $plugin_template_directory = 'templates';

        // Store located template paths.
        private $template_path_cache = array();

        // Store variable names used for template data.
        private $template_data_var_names = array( 'data' );

        // Clean Up Template Data: Use inherited __destruct()
        // Retrieve a Template Part: Use inherited get_template_part()
        // Make Custom Data Available to Template: Use inherited et_template_data()
        // Remove Access to Custom Data in Template: Use inherited unset_template_data()
        // Given a Slug and Optional Name, Create the File Names of Templates: Use inherited get_template_file_names()
        // Retrieve the Name of the Highest Priority Template File That Exists: Use inherited locate_template()
        // Return a List of Paths to Check for Template Locations: Use inherited get_template_paths()
        // Allow Ordered list of Template Paths to be Amended: Use inherited apply_filters()
        // Return the Path to the Templates Directory in this Plugin: Use inherited get_templates_dir()

    }
}