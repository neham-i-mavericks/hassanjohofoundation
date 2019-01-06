<?php
function backup_database_overview_ui(){ 

	

	if( isset( $_GET['backup_database-task'] ) && $_GET['backup_database-task'] == 'backup' ){

		if( ! empty($_GET['backup_type'] ) ){

			print '<h2>Database Backup</h2>';

			switch ( $_GET['backup_type'] ){
				
				

				case 'database_backup':
					print "<p>Starting Database Backup...</p>";
					flush(); sleep(1);
					backup_database_do_database_backup();
					exit;
					break;

					// do nothing if nothing is found
			}
		}


	}
	
	backup_database_admin_styles();
	backup_database_admin_scripts();
	backup_database_top_ui_callout();
	
	?>



	<div class="wrap">

		<div id="poststuff">

			<?php if(isset($_GET['settings-updated'])): ?>
					<div id="setting-error-settings_updated" class="updated settings-error"> 
						<p>
							<strong>Settings saved.</strong>
						</p>
					</div>
			<?php endif; ?>
				<div id="post-body-content">

					<!-- Start of tabs -->	

					<div class="backup_database-tabs">
					  <?php backup_database_admin_page_tabs(); ?>
					  <div class="clearboth"></div>
					</div>		

					<div class="backup_database-wrapper">

						<!--<div class="tab-description">
							<h3> Overview </h3>
						  	<p>
						  		Below are your current backups.
						  	</p>
						</div>-->
												  	
						<table class="widefat">
							<thead>
							    <tr>
							        <th>ID</th>
							        <th>Date</th> 
							        <th>Type</th>
								<th>Location</th>
							        <th>Status</th>       
							        <th>Size</th>
								<th>Action</th>
								
							    </tr>
							</thead>
							<tfoot>
							    <tr>
							    	<th>ID</th>
							    	<th>Date</th>
							    	<th>Type</th>
								<th>Location</th>
							    	<th>Status</th>
							    	<th>Size</th>
								<th>Action</th>
								
							    </tr>
							</tfoot>
							<tbody id="backup_database-backup-list">
								<?php

							$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			$per_page = 10;
$page = (!empty($_GET['paged'])) ? $_GET['paged'] : 1;
		$offset = ( ($page -1) * $per_page);

$args = array(
	'posts_per_page' => $per_page,
	'post_type' => 'backup-database',
	
	'offset'=> $offset,
	'current'      => $page,
					'show_all'     => false,
					'end_size'     => 1,
					'mid_size'     => 2,
					'prev_next'    => true,
					'prev_text'    => __('« Previous','userpro'),
					'next_text'    => __('Next »','userpro'),
					'type'         => 'plain',
					'add_args' => false ,	
	
);
									//$args = array( 'post_type' => 'backup_database', 'posts_per_page' => 10 );
									$loop = new WP_Query( $args );
								
									if($loop->have_posts()): while ( $loop->have_posts() ) : $loop->the_post();
									$backup_status =  get_post_meta( $loop->post->ID, 'backup_status', true);
								?>

								<tr id="backup_database-backup-<?= $loop->post->ID; ?>">
							     <td><?php print $loop->post->ID; ?></td>
							     <td><span class="icon dashicons dashicons-portfolio  "> </span> <?php the_time('F jS, Y  @ H: i: s'); ?>
							     	

							

							     </td>
							     <td><?php print get_post_meta($loop->post->ID, 'backup_type', true); ?></td>
							 <td><?php $sources= get_post_meta($loop->post->ID, 'backupsource', true); 
									if(!empty($sources))
									{
										foreach($sources as $k=>$v)
											{
												echo $v;
												echo "<br>";							
											}
									}
								
								?></td>
							     <td><?php print $backup_status; if($backup_status == 'In Progress') print ' <img class="ajax-loading-backup-browser" src="'.BACKUP_DATABASE_ROOT_DIR .'/assets/loading.gif" width="20" align="top"><br /> <!--<small> 19% Complete</small>-->'; ?></td>
							     <td><?php print get_post_meta($loop->post->ID, 'backup_size', true); ?></td>

								<td> 

<a class="download-backup  button" title="Download this backup to your local computer" href="<?= BACKUP_DATABASE_DOWNLOADER . '?download=' . $loop->post->ID; ?>"><span class="icon dashicons dashicons-download"></span>Download</a> 

<a class="backup_database-remove-backup button" href="javascript:void(0);" title="Delete the backup from the the server" data-id="<?= $loop->post->ID; ?>"><span class="icon dashicons dashicons-trash"></span>Remove</a> </span></td>
							    </tr>
								<?php endwhile; else: ?>
								<tr id="no-backups-found">
									<td id="no-backups-found"> There are no backups found. </td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									
								</tr>
								<?php endif; ?>
					
							</tbody>
							</table>

<?php
$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( $page, get_query_var('paged') ),
	'total' => $loop->max_num_pages
) );
?>


							<br><br>
							<div class="doing-backup" style="margin-bottom: 20px; line-height: 30px; height: 30px; position: relative;">
								<span class="spinner" style="width: 40px; height: 40px; display: inline; position: relative; top: 3px;"></span> <b>Creating Backup...</b>
							</div>
							
							<a class="backup_database_button" id="create-database-backup" href="<?= admin_url(); ?>?page=backup_database_overview&backup_database-task=backup&backup_type=database_backup"> Create DB Backup </a>
					</div>
					<!-- / End of tabs -->

				</div>


		<br class="clear">
		</div>

	</div>
	<!-- /wrap -->
<div>
<h1>
Get Flat 30% off on PRO 
<a href="http://www.wpallbackup.com/pricing/" target="_blank">Buy Now</a>
Use Coupon code 'UPDATEPRO'
</h1>
</div>

<?php }

function backup_pagination($pages = '', $range = 4)
{ 
     $showitems = ($range * 2)+1; 
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
         echo "<div class=\"backup_pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>"; 
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }


}
?>
