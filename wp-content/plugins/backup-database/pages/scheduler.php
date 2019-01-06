<?php
function backup_database_scheduler_ui(){
	backup_database_admin_styles();
	backup_database_top_ui_callout();
	?>

	<div class="wrap">

		<?php if(isset($_GET['settings-updated'])): ?>
			<div id="setting-error-settings_updated" class="updated settings-error"> 
				<p>
					<strong>Backup schedule saved</strong>
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
				<h3> Schedule Settings </h3>
			  	<p>
			  		Control how often your WordPress website is backed up.
			  	</p>
			</div>
			-->
			  	
			<form name="backup_database_general" method="post" action="options.php"/>
				<?php
					$backup_database_settings = get_option('backup_database_schedule_settings');
					settings_fields( 'backup_database-schedule-group' );
				?>
				<table class="form-table">

					<!-- Backup Frequency -->
					<tr>
						<th>
							<label for="backup-notifications">Backup Frequency</label><br>
							
						</th>
						<td>
							<select id="backup-notifications" name="backup_database_schedule_settings[backup_frequency]">
								<?php backup_database_get_admin_schedule_options(); ?>
							</select>
						</td>
					</tr>
					
					<tr>
						<th>
							<label for="backup-type">Backup Type</label><br>
							
						</th>
						<td>
							<select id="backup-type" name="backup_database_schedule_settings[backup_type]">
								<option value="database" <?php if($backup_database_settings['backup_type'] == 'database') print 'selected="selected";'?>> Database </option>
								
							</select>
						</td>
					</tr>
					

				</table>

				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  /></p>
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
