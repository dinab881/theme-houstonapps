<?php
/**
 * Shape functions and definitions
 *
 * @package Houstonapps
 * @since Houstonapps 1.0
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
            'aside', 'image', 'video'
        ) );

        add_theme_support( 'post-thumbnails' );

    }
endif; // houstonapps_setup
add_action( 'after_setup_theme', 'houstonapps_setup' );


/**
 * Remove all unneeded styles and scripts
 * */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function houstonapps_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Home top', 'houstonapps' ),
        'id'            => 'sidebar-1',
        'description'   => '',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );

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


	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', get_template_directory_uri() .'/js/jquery.js',array(),'', true);
		wp_enqueue_script('jquery');
	}
    wp_enqueue_script( 'houstonapps-foundation-js', get_template_directory_uri() .  '/js/foundation.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'houstonapps-main-js', get_template_directory_uri() .  '/js/main.js', array('houstonapps-foundation-js' ), '', true );

}
add_action( 'wp_enqueue_scripts', 'houstonapps_scripts' );



/**
 * Loop for custom post type Team.
 */
function display_team_members(){
    global $post;

    add_image_size( 'team_widget_size', 630, 630, false );
    $members = new WP_Query();

    $arr = array(
        'post_type' => 'team',
        'posts_per_page' => 7,
        'order' => 'ASC'
    );
    $members->query($arr);


    if($members->have_posts()) {?>
        <div class="large-12 columns members">
            <h2>Dream Team</h2>

            <ul class="large-12 columns members_list">
                <?php
                while ( $members->have_posts() ) : $members->the_post(); ?>

                    <li class="team_member">
                        <?php
                        (has_post_thumbnail($post->ID)) ? the_post_thumbnail($post->ID, 'team_widget_size') : '<div class="noThumb"></div>';?>
                        <div class="member_info">
                            <div>
                                <p class="member_name"><?php the_title(); ?></p>
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <div class="mobile_member_info">
                            <p class="member_name"><?php the_title(); ?></p>
                            <?php esc_html(the_content()); ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php
        wp_reset_postdata();
    }else{
        echo '<p>No members found</p>';
    }
    ?>

<?php
}


/**
 * Loop for custom post type Working Process.
 */
function display_working_process(){
    global $post;

    $members = new WP_Query();

    $arr = array(
        'post_type' => 'process',
        'posts_per_page' => 7,
        'order' => 'ASC'
    );
    $members->query($arr);


    if($members->have_posts()) {?>
        <div class="large-12 columns working_process">
            <h2>How we work</h2>


            <ul class="tabs process_items large-12 columns" data-tab="" role="tablist">
                 <li class="large-1 columns"></li>
                 <?php
                 $i=1;
                 while ( $members->have_posts() ) {
                            $members->the_post();
                            $active = '';
                            $aria_selected = 'false';


                            if($i==1){
                             $active = 'active';
                             $aria_selected = 'true';
                            }

                             $class_icon = get_post_meta($post->ID, "houstonapps_process_icon", true);
                     ?>
                              <li class="tab-title large-2 columns <?php echo $active;?>" role="presentation">
                                <a href="#panel2-<?php echo $i;?>" role="tab" tabindex="0" aria-selected="<?php echo $aria_selected;?>" aria-controls="panel2-<?php echo $i;?>">
                                    <i class="<?php echo $class_icon;?>"></i>
                                    <h3><?php the_title(); ?></h3>
                                </a>
                            </li>
                     <?php $i++; ?>
                 <?php
                 }
                 ?>
                <li class="large-1 columns"></li>
            </ul>



            <div class="tabs-content large-12 columns">
                <?php
                 $i=1;
                 while ( $members->have_posts() ) {
                     $members->the_post();
                     $active = '';
                     $aria_hidden = 'true';
                     if($i==1){
                        $active = 'active';
                        $aria_hidden = 'false';
                    } ?>
                     <section role="tabpanel" aria-hidden="<?php echo $aria_hidden;?>" class="content large-2 columns <?php echo $active;?>" id="panel2-<?php echo $i;?>">
                         <?php the_content(); ?>
                    </section>
                     <?php $i++; ?>
                 <?php
                 }
                ?>
            </div>
        </div>

        <?php
        wp_reset_postdata();
    }else{
        echo '<p>No processes found</p>';
    }

}

/**
 * Loop for custom post type Technologies.
 */
function display_technologies(){
    global $post;


    $ts = new WP_Query();

    $arr = array(
        'post_type' => 'technologies',
        'posts_per_page' => -1,
        'order_by'=> 'meta_value_num',
        'meta_key' => 'houstonapps_is_main',
        'order' => 'ASC'
    );

    $ts->query($arr);


    if($ts->have_posts()) {?>
        <div class="large-12 columns tech">
            <h2>We love</h2>

            <ul class="large-12 columns tech_items">
                <?php
                while ( $ts->have_posts() ){
                    $ts->the_post();

                    $cls = 'large-1 columns';
                    $values = get_post_custom( $post->ID );
                    $technologies_icon_class = isset( $values['houstonapps_technologies_icon'] ) ? $values['houstonapps_technologies_icon'][0]: '';
                    $is_main = isset( $values['houstonapps_is_main'] ) ? $values['houstonapps_is_main'][0] : '';

                    if(!empty($is_main) && $is_main=='on') {
                        $cls = 'large-2 columns main_item';
                    }

                ?>

                    <li class="<?php echo $cls;?>">
                        <i class="<?php echo $technologies_icon_class; ?>"></i>
                        <span><?php the_title(); ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php
        wp_reset_postdata();
    }else{
        echo '<p>No technologies found</p>';
    }
    ?>

    <?php
}



/**
 * Loop for custom post type Contacts.
 */
function display_contacts(){
    global $post;


    $contacts = new WP_Query();

    $arr = array(
        'post_type' => 'contacts',
        'posts_per_page' => -1,
        'order' => 'ASC'
    );
    $contacts->query($arr);


    if( $contacts->have_posts()) {?>
        <div class="large-12 columns contact_us">
            <h2>Contact us</h2>

            <?php
                while ( $contacts->have_posts() ) {
                    $contacts->the_post();
                ?>
                    <div class="contact_item">
                        <?php the_content(); ?>
                    </div>


                <?php } ?>

        </div>
        <?php
        wp_reset_postdata();
    }else{
        echo '<p>No contacts found</p>';
    }
    ?>

    <?php
}





/**
 * Include the TGM_Plugin_Activation class 2.5.2.
 */

require_once dirname( __FILE__ ) .'/tgm-plugin/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'houstonapps_register_required_plugins' );
function houstonapps_register_required_plugins() {

    $plugins = array(
        array(
            'name'               => 'Houstonapps Plugin', // The plugin name.
            'slug'               => 'houstonapps', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/lib/plugins/houstonapps-plugin.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        )
    );

    $config = array(
        'id'           => 'houstonapps',           // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.


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
            'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'houstonapps' ),
            // %1$s = plugin name(s).
            'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'houstonapps' ), // %s = dashboard link.
            'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'houstonapps' ),

            'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        ),

    );

    tgmpa( $plugins, $config );

}