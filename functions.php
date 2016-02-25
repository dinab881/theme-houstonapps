<?php
/**
 * Created by PhpStorm.
 * User: Dina
 * Date: 24.02.2016
 * Time: 12:26
 */


/**
 * Plugin Name: Enqueue jQuery in Footer
 * Version:     0.0.1
 * Plugin URI:  http://wpgrafie.de/836/
 * Description: Prints jQuery in footer on front-end.
 * Author:      Dominik Schilling
 * Author URI:  http://wpgrafie.de/
 */
/*
function ds_enqueue_jquery_in_footer() {

    if ( ! is_admin() ){
        wp_deregister_script('jquery');

        // Load the copy of jQuery that comes with WordPress
        // The last parameter set to TRUE states that it should be loaded
        // in the footer.
        wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', FALSE, '', TRUE);

        wp_enqueue_script('jquery');
    }
}
add_action( 'init', 'ds_enqueue_jquery_in_footer' );

*/

/**
 * Customize the title for the home page, if one is not set.
 *
 * @param string $title The original title.
 * @return string The title to use.
 */
function wpdocs_hack_wp_title_for_home( $title ) {
    if ( empty( $title ) && ( is_home() || is_front_page() ) ) {
        $title = get_bloginfo( 'description' );
    }
    return $title;
}
add_filter( 'wp_title', 'wpdocs_hack_wp_title_for_home' );




if ( ! function_exists( 'houstonapps_setup' ) ):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * @since Shape 1.0
     */
    function houstonapps_setup() {

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         * If you're building a theme based on houstonapps, use a find and replace
         * to change 'houstonapps' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'houstonapps', get_template_directory() . '/languages' );

        /**
	     * Enable support for Post Formats.
	     * See http://codex.wordpress.org/Post_Formats
	     */
        add_theme_support( 'post-formats', array(
            'aside', 'image', 'video', 'quote', 'link'
        ) );

        /**
         * This theme uses wp_nav_menu() in one location.
         */
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'houstonapps' ),
        ) );
    }
endif; // houstonapps_setup
add_action( 'after_setup_theme', 'houstonapps_setup' );


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function houstonapps_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sliding sidebar', 'houstonapps' ),
        'id'            => 'sidebar-1',
        'description'   => '',
        'before_widget' => '<header id="%1$s" class="large-12 columns %2$s">',
        'after_widget'  => '</header>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    //Register the front page widgets
    /*if ( function_exists('siteorigin_panels_activate') ) {
        register_widget( 'Moesia_Services' );
        register_widget( 'Moesia_Employees' );
        register_widget( 'Moesia_Fp_Social_Profile' );
        register_widget( 'Moesia_Blockquote' );
        register_widget( 'Moesia_Skills' );
        register_widget( 'Moesia_Facts' );
        register_widget( 'Moesia_Testimonials' );
        register_widget( 'Moesia_Clients' );
        register_widget( 'Moesia_Projects' );
        register_widget( 'Moesia_Action' );
        register_widget( 'Moesia_Latest_News' );
    }*/

    //Register the sidebar widgets
   /* register_widget( 'Moesia_Recent_Comments' );
    register_widget( 'Moesia_Recent_Posts' );
    register_widget( 'Moesia_Social_Profile' );
    register_widget( 'Moesia_Video_Widget' );
    register_widget( 'Moesia_Contact_Info' );*/
}
add_action( 'widgets_init', 'houstonapps_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function houstonapps_scripts() {

    wp_enqueue_style( 'houstonapps-foundation-css', get_template_directory_uri() . '/css/foundation.css', array(), false );
    wp_enqueue_style( 'houstonapps-normalize', get_template_directory_uri(). '/css/normalize.css', array('houstonapps-foundation-css'), false );
    wp_enqueue_style( 'houstonapps-style', get_stylesheet_uri(), array('houstonapps-foundation-css','houstonapps-normalize') );

    wp_enqueue_style( 'houstonapps-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', false );
    wp_enqueue_style( 'houstonapps-google-fonts', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700', false );
    wp_enqueue_style( 'houstonapps-devicon', 'https://cdn.rawgit.com/konpa/devicon/master/devicon.min.css', false );

    wp_enqueue_script( 'houstonapps-foundation-js', get_template_directory_uri() .  '/js/foundation.min.js', array( 'jquery' ), true, true );
    wp_enqueue_script( 'houstonapps-main-js', get_template_directory_uri() .  '/js/main.js', array('houstonapps-foundation-js' ), true, true );

}
add_action( 'wp_enqueue_scripts', 'houstonapps_scripts' );



/**
 * Include the TGM_Plugin_Activation class 2.5.2.
 */
require_once dirname( __FILE__ ) .'/tgm-plugin/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'houstonapps_register_required_plugins' );
function houstonapps_register_required_plugins() {

    $plugins = array(
        array(
            'name'               => 'TGM Example Plugin', // The plugin name.
            'slug'               => 'houstonapps', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/lib/plugins/houstonapps-plugin.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        )
    );

    $config = array(
        'id'           => 'houstonapps',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

        /*
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'houstonapps' ),
            'menu_title'                      => __( 'Install Plugins', 'houstonapps' ),
            'installing'                      => __( 'Installing Plugin: %s', 'houstonapps' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'houstonapps' ),
            'notice_can_install_required'     => _n_noop(
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.',
                'houstonapps'
            ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop(
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.',
                'houstonapps'
            ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop(
                'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
                'houstonapps'
            ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop(
                'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                'houstonapps'
            ), // %1$s = plugin name(s).
            'notice_ask_to_update_maybe'      => _n_noop(
                'There is an update available for: %1$s.',
                'There are updates available for the following plugins: %1$s.',
                'houstonapps'
            ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop(
                'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
                'houstonapps'
            ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop(
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'houstonapps'
            ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop(
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.',
                'houstonapps'
            ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop(
                'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
                'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
                'houstonapps'
            ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'houstonapps'
            ),
            'update_link' 					  => _n_noop(
                'Begin updating plugin',
                'Begin updating plugins',
                'houstonapps'
            ),
            'activate_link'                   => _n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'houstonapps'
            ),
            'return'                          => __( 'Return to Required Plugins Installer', 'houstonapps' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'houstonapps' ),
            'activated_successfully'          => __( 'The following plugin was activated successfully:', 'houstonapps' ),
            'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'houstonapps' ),  // %1$s = plugin name(s).
            'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'houstonapps' ),  // %1$s = plugin name(s).
            'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'houstonapps' ), // %s = dashboard link.
            'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'houstonapps' ),

            'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        ),
        */
    );

    tgmpa( $plugins, $config );

}