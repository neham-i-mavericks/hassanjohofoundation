<?php
/**
 * Give Section
 * 
 * @package Charity_Care
 */

$title          = get_theme_mod( 'charity_care_give_section_title' );
$content        = get_theme_mod( 'charity_care_give_section_content' );
$readmore       = get_theme_mod( 'benevolent_button_text', __( 'Donate Now', 'charity-care' ) );// From 
$excerpt_option = give_get_option( 'disable_forms_excerpt' );
$form_id = '';
 
$give_query = new WP_Query( array( 
    'post_type'           => 'give_forms',
    'post_status'         => 'publish',
    'posts_per_page'      => -1,
    'ignore_sticky_posts' => true,   
) );

if( $title || $content || $give_query->have_posts() ){ ?>
        <?php if( $title || $content ){ ?>
            <div class="container">
            <header class="header">
                <?php 
                    if( $title ) echo '<h2 class="main-title">' . esc_html( $title ) . '</h2>';
                    if( $content ) echo wpautop( esc_html( $content ) );
                ?>
            </header>
            <?php }
            
            $total_posts = $give_query->found_posts;
        
            if( $give_query->have_posts() ){
            ?>    
            <div class="give-holder">
            		<?php 
                        echo ( $total_posts > 3 ) ? '<div class="give-slider owl-carousel">' : '<div class="row">'; 
                        
                        while( $give_query->have_posts() ){
                            $give_query->the_post();
                            $form_id = get_the_ID();

                            echo ( $total_posts > 3 ) ? '<div>' : '<div class="columns-3">'; ?>
                        
            				<div class="post">
                                <?php if( has_post_thumbnail() ){ ?>
            					   <a href="<?php the_permalink(); ?>" class="post-thumbnail"><?php the_post_thumbnail( 'charity-care-give', array( 'itemprop' => 'image' ) ); ?></a>
                                <?php }else{
                                    echo '<img src="' . esc_url( get_stylesheet_directory_uri() . '/images/charity-care-give.jpg'  ) . '" alt="' . esc_attr( get_the_title() ) . '" itemprop="image" />';    
                                } ?>
            					<div class="text-holder">
            						<header class="entry-header">
            							<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            						</header>
            						<div class="entry-content">
            							<?php 
                                    
                                            the_excerpt();

                                            $goal_stats = give_goal_progress_stats( $form_id );
                                            //Output the goal
                            				$goal_option = get_post_meta( $id, '_give_goal_option', true );
                                            $goal_format = get_post_meta( $id, '_give_goal_format', true );

                            				if ( $goal_option == 'enabled' ) {

                                                if($goal_format == 'percentage'){
                                					$shortcode = '[give_goal id="' . $id . '" show_text="true" ]';
                                					echo do_shortcode( $shortcode );
                            				    }
                                                if($goal_stats['raw_actual'] || $goal_stats['raw_goal']){ ?>
                                                    <div class="cc-goal-raise">
                                                        <div class="cc-goal"><?php echo esc_html__('Goal: ','charity-care'); ?><span><?php echo esc_html('$ '.$goal_stats['raw_goal']); ?></span></div>
                                                        <div class="cc-raise"><?php echo esc_html__('Raised: ','charity-care'); ?><span><?php echo esc_html('$ '.$goal_stats['raw_actual']); ?></span></div>
                                                    </div>
                                                <?php } ?>
                                            
                                           <?php } ?>

            						</div>
            						<a href="<?php the_permalink(); ?>" class="btn-donate"><?php echo esc_html( $readmore ); ?></a>
            					</div>
            				</div>
                            <?php
                            echo ( $total_posts > 3 ) ? '</div>' : '</div>';
                        }
                        wp_reset_postdata();
                        
                    echo ( $total_posts > 3 ) ? '</div>' : '</div>'; 
                    ?>
            </div>
        </div> <!-- container -->
        <?php 
        }
    ?>
<?php    
}
