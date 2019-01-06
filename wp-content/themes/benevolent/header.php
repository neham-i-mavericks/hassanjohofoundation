<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Benevolent
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head itemtype="http://schema.org/WebSite">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<div id="page" class="site">
	
	<header id="masthead" class="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
        
        <div class="header-top">
            <div class="container">
                
                <?php if( has_nav_menu( 'secondary' ) ) { ?>
                <div id="secondary-mobile-header">
    			    <a id="responsive-secondary-menu-button" href="#sidr-main2"><?php esc_html_e( 'Menu', 'benevolent' ); ?></a>
    			</div>
                
                <nav id="top-navigation" class="secondary-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
        			<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'secondary-menu', 'fallback_cb' => false ) ); ?>
        		</nav><!-- #site-navigation -->
                <?php } ?>
                <?php if( get_theme_mod( 'benevolent_ed_social_header' ) ) do_action( 'benevolent_social_links' ); ?>
            </div>
        </div>
        
        <div class="header-bottom">
            
            <div class="container">
        	
                <?php 
                $site_title = get_bloginfo( 'name' );
                $description = get_bloginfo( 'description', 'display' );
                
                if( has_custom_logo() && ( $site_title || $description ) ) {
                    $add_class = 'logo-text';
                }else{
                    $add_class = '';
                }?>
                <div class="site-branding <?php echo esc_attr( $add_class ); ?>" itemscope itemtype="http://schema.org/Organization">
                
                    <?php if( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
                        echo '<div class="site-logo">';
                        the_custom_logo();
                        echo '</div>';
                    }?>
                    <div class="site-title-wrap">
                        <?php if ( is_front_page() ) : ?>
                            <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php else : ?>
                            <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                        <?php endif;  
                    
                        $description = get_bloginfo( 'description', 'display' );
                        if ( $description || is_customize_preview() ) : ?>
                            <p class="site-description" itemprop="description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                        <?php endif; ?>
                    </div>
        		</div><!-- .site-branding -->
                
                <?php 
                    $button_text = get_theme_mod( 'benevolent_button_text', __( 'Donate Now', 'benevolent' ) );
                    $button_url = get_theme_mod( 'benevolent_button_url' );
                    if( $button_text && $button_url ) echo '<a href="' . esc_url( $button_url ). '" class="btn-donate">' . esc_html( $button_text ) . '</a>';
                ?>
                
        		<nav id="site-navigation" class="main-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
        			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
        		</nav><!-- #site-navigation -->
                
                <div id="mobile-header">
    			    <a id="responsive-menu-button" href="#sidr-main"><?php esc_html_e( 'Menu', 'benevolent' ); ?></a>
    			</div>
                
            </div>
            
        </div>
    </header><!-- #masthead -->
    
    <?php 
    $ed_breadcrumb    = get_theme_mod( 'benevolent_ed_breadcrumb' );
    $enabled_sections = benevolent_get_sections();
    
    if( ( is_front_page() || is_page_template( 'template-home.php' ) ) && get_theme_mod( 'benevolent_ed_slider' ) ) do_action( 'benevolent_slider' );
    
    if( is_home() || ! $enabled_sections || !( is_front_page() || is_page_template( 'template-home.php' ) ) ) echo '<div class="container">';
    
    //BreadCrumbs
    if( !( is_front_page() || is_page_template( 'template-home.php' ) ) && !is_404() && $ed_breadcrumb ) do_action( 'benevolent_breadcrumbs' ); 
        
   	if( is_home() || ! $enabled_sections || !( is_front_page() || is_page_template( 'template-home.php' ) ) ) echo '<div id="content" class="site-content"><div class="row">';