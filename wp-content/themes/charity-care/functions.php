<?php
/**
 * Theme functions and definitions
 *
 * @package Charity_Care
 */

/**
 * After setup theme hook
 */
function charity_care_theme_setup(){
    /*
     * Make chile theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'charity-care', get_stylesheet_directory() . '/languages' );
    add_image_size( 'charity-care-donation-post', 780, 520, true );
    add_image_size( 'charity-care-give', 380, 270, true );

}
add_action( 'after_setup_theme', 'charity_care_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function charity_care_enqueue_styles() {

    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
    $parent_style = 'benevolent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'charity-care-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get( 'Version' )
    );
    wp_enqueue_script( 'equal-height', get_stylesheet_directory_uri() . '/js' . $build . '/equal-height' . $suffix . '.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );

    wp_enqueue_script( 'charity-care-custom-script', get_stylesheet_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );

    $array = array(
        'rtl'  => is_rtl(),
    );

    wp_localize_script( 'charity-care-custom-script', 'charity_care_data', $array );
}
add_action( 'wp_enqueue_scripts', 'charity_care_enqueue_styles' );

function charity_care_customizer_options( $wp_customize ){
    if( charity_care_is_give_activated() ){
        /** Give Section */
        $wp_customize->add_section(
            'charity_care_give_settings',
            array(
                'title' => __( 'Give Section', 'charity-care' ),
                'priority' => 55,
                'panel' => 'benevolent_home_page_settings',
            )
        );
        
        /** Enable/Disable Give Section */
        $wp_customize->add_setting(
            'charity_care_ed_give_section',
            array(
                'default' => false,
                'sanitize_callback' => 'benevolent_sanitize_checkbox',
            )
        );
        
        $wp_customize->add_control(
            'charity_care_ed_give_section',
            array(
                'label' => __( 'Enable Give Section', 'charity-care' ),
                'section' => 'charity_care_give_settings',
                'type' => 'checkbox',
            )
        );

        /** give Section Title */
        $wp_customize->add_setting(
            'charity_care_give_section_title',
            array(
                'default' => '',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        
        $wp_customize->add_control(
            'charity_care_give_section_title',
            array(
                'label' => __( 'Give Section Title', 'charity-care' ),
                'section' => 'charity_care_give_settings',
                'type' => 'text',
            )
        );
        
        /** Give Section Content */
        $wp_customize->add_setting(
            'charity_care_give_section_content',
            array(
                'default' => '',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        
        $wp_customize->add_control(
            'charity_care_give_section_content',
            array(
                'label' => __( 'Give Section Content', 'charity-care' ),
                'section' => 'charity_care_give_settings',
                'type' => 'textarea',
            )
        );
    }

}
add_action( 'customize_register', 'charity_care_customizer_options' );

function charity_care_remove_parent_action(){
    remove_action( 'customize_register', 'benevolent_customizer_theme_info' );
}
add_action( 'init', 'charity_care_remove_parent_action' );

function charity_care_customizer_theme_info( $wp_customize ) {
    
    $wp_customize->add_section( 'theme_info' , array(
        'title'       => __( 'Information Links' , 'charity-care' ),
        'priority'    => 6,
        ));

    $wp_customize->add_setting('theme_info_theme',array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
        ));
    
    $theme_info = '';
    $theme_info .= '<h3 class="sticky_title">' . __( 'Need help?', 'charity-care' ) . '</h3>';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View demo', 'charity-care' ) . ': </label><a href="' . esc_url( 'https://demo.raratheme.com/charity-care/' ) . '" target="_blank">' . __( 'here', 'charity-care' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'View documentation', 'charity-care' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/documentation/charity-care/' ) . '" target="_blank">' . __( 'here', 'charity-care' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Support ticket', 'charity-care' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/support-ticket/' ) . '" target="_blnak">' . __( 'here', 'charity-care' ) . '</a></span><br />';
    $theme_info .= '<span class="sticky_info_row"><label class="more-detail row-element">' . __( 'More Details', 'charity-care' ) . ': </label><a href="' . esc_url( 'https://raratheme.com/wordpress-themes/' ) . '" target="_blank">' . __( 'here', 'charity-care' ) . '</a></span><br />';
    

    $wp_customize->add_control( new Theme_Info_Custom_Control( $wp_customize ,'theme_info_theme',array(
        'label' => __( 'About Charity Care' , 'charity-care' ),
        'section' => 'theme_info',
        'description' => $theme_info
        )));

    $wp_customize->add_setting('theme_info_more_theme',array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
        ));
    
}
add_action( 'customize_register', 'charity_care_customizer_theme_info' );

/**
 * Fuction to get Sections 
 */
function charity_care_get_sections(){
    
    $sections = array( 
        'intro-section' => array(
            'class' => 'intro',
            'id'    => 'intro'    
        ),
        'community-section' => array(
            'class' => 'our-community',
            'id'    => 'community'
        ),
        'stats-section' => array(
            'class' => 'stats',
            'id'    => 'stats'
        ),
        'give-section' => array(
            'class' => 'give-section',
            'id'    => 'give'
        ),
        'blog-section' => array(
            'class' => 'blog-section',
            'id'    => 'blog'
        ),
        'sponsor-section' => array(
            'class' => 'sponsors',
            'id'    => 'sponsor'
        )              
    );
        
    $enabled_section = array();
    foreach ( $sections as $section ) {
        if( $section['id'] == 'give' ){
            if(charity_care_is_give_activated()){
                if(get_theme_mod( 'charity_care_ed_give_section',false )){
                    $enabled_section[] = array(
                        'id' => $section['id'],
                        'class' => $section['class']
                    );
                }
            }
        }else{
            if(get_theme_mod( 'benevolent_ed_' . $section['id'] . '_section',false )){
                $enabled_section[] = array(
                    'id' => $section['id'],
                    'class' => $section['class']
                );
            }
        }
    }
    return $enabled_section;
}

/** Check Is Give Donation Plugin Activate **/
function charity_care_is_give_activated(){
    return class_exists( 'Give' ) ? true : false;
}

add_action( 'tgmpa_register', 'charity_care_register_required_plugins', 15 );

function charity_care_register_required_plugins() {

    $plugins = array(

        array(
            'name'      => __( 'Give Donation Plugin','charity-care' ),
            'slug'      => 'give',
            'required'  => false,
        ),
   
    );

    $config = array(
        'id'           => 'charity-care',    // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

    );

    tgmpa( $plugins, $config );
}

/**
 * Add custom classes to the array of post classes.
*/
function charity_care_post_classes( $classes ){

    if( charity_care_is_give_activated() ){
        if( is_post_type_archive( 'give_forms' ) || is_singular('give_forms') ){
            $classes[] = 'post';
        }
    }
    return $classes;
}
add_filter( 'post_class', 'charity_care_post_classes' );

if( charity_care_is_give_activated() ){
    remove_action( 'give_single_form_summary', 'give_template_single_title', 5 );
    add_action( 'give_before_single_form_summary', 'give_template_single_title', 4 );
}

/** 
* Footer Credit
**/

function benevolent_footer_credit(){
    $copyright_text = get_theme_mod( 'benevolent_footer_copyright_text' );
    $text  = '<div class="site-info"><div class="container">';
    $text .= '<span class="copyright">';
      if( $copyright_text ){
        $text .=  wp_kses_post( $copyright_text );
      }else{
        $text .=  esc_html__( '&copy; ', 'charity-care' ) . date_i18n( esc_html__( 'Y', 'charity-care' ) ); 
        $text .= ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
      }
    $text .= '.</span>';
    if ( function_exists( 'the_privacy_policy_link' ) ) {
       $text .= get_the_privacy_policy_link();
   }
    $text .= '<span class="by">';
    $text .= '<a href="' . esc_url( 'https://raratheme.com/wordpress-themes/charity-care/' ) .'" rel="author" target="_blank">' . esc_html__( 'Charity Care by Rara Theme', 'charity-care' ) . '</a>. ';
    $text .= sprintf( esc_html__( 'Powered by %s', 'charity-care' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'charity-care' ) ) .'" target="_blank">WordPress</a>.' );
    $text .= '</span></div></div>';
    echo apply_filters( 'benevolent_footer_text', $text );    
}