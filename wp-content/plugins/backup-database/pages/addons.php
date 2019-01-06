<?php 
function backup_database_addons_ui(){
	backup_database_admin_styles();
	backup_database_top_ui_callout();
	?>

	<div class="wrap">

		<?php if(isset($_GET['settings-updated'])): ?>
				<div id="setting-error-settings_updated" class="updated settings-error"> 
					<p>
						<strong>General settings saved.</strong>
					</p>
				</div>
		<?php endif; ?>

		<div id="poststuff">
				<div id="post-body-content">

					<!-- Start of tabs -->	

					<div class="backup_database-tabs">
					  <?php backup_database_admin_page_tabs(); ?>
					  <div class="clearboth"></div>
					</div>		

					<div class="backup_database-cloud">

						<h1><?php _e("FTP BackUp","backup_database"); ?>
						  	
						<table>
						
							
							
								
								<tr>
						<?php 		
						include BACKUP_DATABASE_ROOT_PATH.'lib/FTP/ftp-form.php';?>
							
							    </tr>
								
						
							</table>
							<h1><?php _e("DropBox BackUp","backup_database"); ?>
							<table>
					       <?php include BACKUP_DATABASE_ROOT_PATH.'lib/Dropbox/dropboxform.php';?>
							</table>
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
