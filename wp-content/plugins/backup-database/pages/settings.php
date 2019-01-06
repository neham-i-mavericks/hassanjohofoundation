<?php 
function backup_database_settings_ui(){
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

					<div class="backup_database-wrapper">

						<!--
						<div class="tab-description">
							<h3> General Settings </h3>
						  	<p>
						  		Here you will be able to control backup notifications, and the recipient of the notification.<br><br>
						  		Notifications only trigger when automated backups are ran.
						  	</p>
						</div>
						-->
						  	
						<form name="backup_database_general" method="post" action="options.php"/>
							<?php
								$backup_database_default_settings = get_option('backup_database_default_settings');
error_log("hello");
								
								settings_fields( 'backup_database-setting-group' );
							?>
							<table class="form-table">

								<tr>

			<th><label for="backup-notifications"><?php _e('Enable Number of Backup Store','db_backup');?></label></th><td>
								<input <?php checked( $backup_database_default_settings['limit-enabled'], 'yes' ) ?> type="radio" name="backup_database_default_settings[limit-enabled]" value="yes" /> Yes 
            	<input <?php checked( $backup_database_default_settings['limit-enabled'], 'no' ) ?> type="radio" name="backup_database_default_settings[limit-enabled]" value="no" /> No  </td>
								</tr>
								<tr>
									<th><label for="backup-notifications"><?php _e('Number Of Backup','db_backup');?></label></th>
									<td>
										<input type="text" name="backup_database_default_settings[backup_limit]" id="backup_limit"  value="<?php echo $backup_database_default_settings['backup_limit'];?>"  />
									</td>
								</tr>

								<tr>
									<th><label for="backup-notifications"><?php _e(' Remove local backup.','db_backup');?></label></th>
									<td>
										<input <?php checked( $backup_database_default_settings['bd_remove_local_backup'], 'yes' ) ?> type="radio" name="backup_database_default_settings[bd_remove_local_backup]" value="yes" /> Yes 
            	<input <?php checked( $backup_database_default_settings['bd_remove_local_backup'], 'no' ) ?> type="radio" name="backup_database_default_settings[bd_remove_local_backup]" value="no" /> No 
										 <br>If Checked then it will remove local backup. 
											Use this option only when you have set any destination. 
											If somesites you need only external backup.
									</td>
								</tr>


								
							</table>
							
							<?php submit_button('Update General Settings'); ?>
						</form>
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
