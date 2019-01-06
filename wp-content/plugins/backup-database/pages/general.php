<?php 
function backup_database_general_ui(){
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
								$backup_database_settings = get_option('backup_database_general_settings');
								settings_fields( 'backup_database-general-group' );
							?>
							<table class="form-table">
								<tr>
									<th><label for="backup-notifications">Backup Notifications</label></th>
									<td>
										<select id="backup-notifications" name="backup_database_general_settings[send_email_notification]">
											<option <?= $backup_database_settings['send_email_notification']=='OFF' ? 'selected="selected"' : ''; ?>>OFF</option>
											<option <?= $backup_database_settings['send_email_notification']=='ON' ? 'selected="selected"' : ''; ?>>ON</option>		
										</select>
									</td>
								</tr>

								<tr>
									<th>
										<label for="backup-notifications-contact">Notification Recipient</label><br>
										<!--<small class="description">
										 	This email will recieve backup notices when automatic backups run. Leave this field blank and the site admin will
										 	recieve the notifications.
										</small>-->
									</th>
									<td>
										<input class="regular-text" id="backup-notifications-contact" type="text" name="backup_database_general_settings[email_notification_contact]" size="32" placeholder="<?= get_bloginfo('admin_email'); ?>" value="<?= $backup_database_settings['email_notification_contact'] ?>" />
									</td>
								</tr>

								<!--<tr>
									<th>
										<label for="backup_database-error-tracking">Error Analytics</label><br>
										<small class="description">
											Allow the plugin to push errors to Blackbird Interactive. 
											No sensitive information is sent, just the stuff we need to know.
										</small>
									</th>
									<td>
										<select hidden id="backup_database-error-analytics" name="backup_database_general_settings[error_analytics]">
											<option value="OFF" <?= @$backup_database_settings['error_analytics']== 'OFF' ? 'selected="selected"' : ''; ?>>Deny</option>
											<option value="ON" <?= @$backup_database_settings['error_analytics']=='ON' ? 'selected="selected"' : ''; ?> >Allow</option>
										</select>	
									</td>
								</tr>-->
							</table>
							<select hidden id="backup_database-error-analytics" name="backup_database_general_settings[error_analytics]">
								<option value="OFF" <?= @$backup_database_settings['error_analytics']== 'OFF' ? 'selected="selected"' : ''; ?>>Deny</option>
								<option value="ON" <?= @$backup_database_settings['error_analytics']=='ON' ? 'selected="selected"' : ''; ?> >Allow</option>
							</select>	

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
<?php }?>
