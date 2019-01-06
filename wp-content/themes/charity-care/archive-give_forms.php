<?php
/**
 *  Used to display an archive page of Give Donation forms.
 *
 * @package Charity_Care
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main give-archive" role="main">
			
            <?php
    		if ( have_posts() ) : 
            
    			/* Start the Loop */
    			while ( have_posts() ) : the_post();
    				
    				get_template_part( 'template-parts/content', 'give-form' );
    
    			endwhile;
    
    			the_posts_pagination( array(
                    'prev_text'          => '',
                    'next_text'          => '',
                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'charity-care' ) . ' </span>',
                 ) );
    
    		else :
    
    			get_template_part( 'template-parts/content', 'none' );
    
    		endif; ?>
            
		</main>

	</div>

<?php 
get_sidebar();
get_footer();