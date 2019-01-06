<?php

/*
 * @since 1.0
 * FTP FORM SETTINGS
 */
 
 // Direct calls to this file are Forbidden when core files are not present
// Thanks to Ed from ait-pro.com for this  code 
// @since 2.1

if ( !function_exists('add_action') ){
header('Status: 403 Forbidden');
header('HTTP/1.1 403 Forbidden');
exit();
}

if ( !current_user_can('manage_options') ){
header('Status: 403 Forbidden');
header('HTTP/1.1 403 Forbidden');
exit();
}

if(isset($_POST['Submit'])){
 if (!isset($_POST['wpallbackup_update_setting']))
die("<br><span class='label label-danger'>Invalid form data. form request came from the somewhere else not current site! </span>");
if (!wp_verify_nonce($_POST['wpallbackup_update_setting'],'wpallbackup-update-setting'))
die("<br><span class='label label-danger'>Invalid form data. form request came from the somewhere else not current site! </span>");
}
// 
//
    // variables for the field and option names 
	$ftp='wp_all_backup_ftp_enable';
    $opt_name = 'wp_all_backup_ftp_host';
    $opt_name2 = 'wp_all_backup_ftp_user';
    $opt_name3 = 'wp_all_backup_ftp_pass';
    $opt_name4 = 'wp_all_backup_ftp_subdir';
	$opt_name5 = 'wp_all_backup_ftp_prefix';
	$opt_name6 = 'wp_all_backup_add_dir1';
	$opt_name7 = 'wp_all_backup_auto_interval';
	$opt_name8 = 'wp_all_backup_auto_email';
	$opt_name9 = 'wp_all_backup_ftp_port';
	
    $hidden_field_name = 'wp_all_backup_ftp_hidden';
    $hidden_field_name2 = 'wp_all_backup_backup_hidden';
    $hidden_field_name3 = 'wp_all_backup_check_repo';
    $data_field_name = 'wp_all_backup_ftp_host';
    $data_field_name2 = 'wp_all_backup_ftp_user';
    $data_field_name3 = 'wp_all_backup_ftp_pass';
    $data_field_name4 = 'wp_all_backup_ftp_subdir';
	$data_field_name5 = 'wp_all_backup_ftp_prefix';
	$data_field_name6 = 'wp_all_backup_add_dir1';
	$data_field_name7 = 'wp_all_backup_auto_interval';
	$data_field_name8 = 'wp_all_backup_auto_email';
	$data_field_name9 = 'wp_all_backup_ftp_port';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
    $opt_val2 = get_option ($opt_name2 );
    $opt_val3 = get_option ($opt_name3 );
	$ftpval=get_option ($ftp );
    $opt_val4 = get_option ($opt_name4 );
	$opt_val5 = get_option ($opt_name5 );
	$opt_val6 = get_option ($opt_name6 );
	$opt_val7 = get_option ($opt_name7 );
	$opt_val8 = get_option ($opt_name8 );
	$opt_val9 = get_option ($opt_name9 );
	
    // BUTTON 3: 
	// UPDATE DIRECTORY
    // If user pressed this button, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name3 ]) && $_POST[ $hidden_field_name3 ] == 'Y' ) {
    // Read their posted value
    $opt_val6 = sanitize_text_field($_POST[ $data_field_name6 ]);
	// Save the posted value in the database
    update_option( $opt_name6, $opt_val6 );
	// Put a "settings updated" message on the screen
?>
<div class="updated"><p><strong><?php _e('Your additional directory has been saved.', 'wpallbkp' ); ?></strong></p></div>
<?php
    }
 
	// BUTTON 1: 
	// SAVE SETTINGS
    // If user pressed this button, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
    $opt_val = sanitize_text_field($_POST[ $data_field_name ]);
    $opt_val2 = sanitize_text_field($_POST[ $data_field_name2 ]);
	$opt_val3 = sanitize_text_field($_POST[ $data_field_name3 ]);
    $opt_val4 = sanitize_text_field($_POST[ $data_field_name4 ]);
    $ftpval=sanitize_text_field($_POST[ 'ftp-enabled' ]);

		
    if(isset($_POST[ $data_field_name5 ]))
	$opt_val5 = sanitize_text_field($_POST[ $data_field_name5 ]);
    else
        $opt_val5="";
	$opt_val9 = sanitize_text_field($_POST[ $data_field_name9 ]);
       
        
	// Save the posted value in the database
    update_option( $opt_name, $opt_val );
    update_option( $opt_name2, $opt_val2 );
	update_option( $opt_name3, $opt_val3 );
	update_option( $ftp,  $ftpval );
	update_option( $opt_name4, $opt_val4 );
	update_option( $opt_name5, $opt_val5 );
	update_option( $opt_name9, $opt_val9 );

     // Put a "settings updated" message on the screen
?>
<div class="updated"><p><strong><?php _e('Your FTP details have been saved.', 'wpallbkp' ); ?></strong></p></div>
<?php
    } // end if
	
	
	//
	// BUTTON 2: 
	// TEST SETTINGS
	// If user pressed this button, this hidden field will be set to 'Y'
	
	if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Test Connection' ) {
	include plugin_dir_path( __FILE__ ) . 'test-ftp.php';
	//
	// update all options while we're at it
	// @since 2.1
    $opt_val = sanitize_text_field($_POST[ $data_field_name ]);
    $opt_val2 = sanitize_text_field($_POST[ $data_field_name2 ]);
	$opt_val3 = sanitize_text_field($_POST[ $data_field_name3 ]);
    $opt_val4 = sanitize_text_field($_POST[ $data_field_name4 ]);
	 $ftpval=sanitize_text_field($_POST[ 'ftp-enabled' ]);


    if(isset($_POST[ $data_field_name5 ]))
	$opt_val5 = sanitize_text_field($_POST[ $data_field_name5 ]);
        else
            $opt_val5="";
	$opt_val9 = sanitize_text_field($_POST[ $data_field_name9 ]);
        
	// Save the posted value in the database
    update_option( $opt_name, $opt_val );
    update_option( $opt_name2, $opt_val2 );
	update_option( $opt_name3, $opt_val3 );
	update_option( $opt_name4, $opt_val4 );
	update_option( $opt_name5, $opt_val5 );
	update_option( $opt_name9, $opt_val9 );
	$result = wp_all_backup_test_ftp();
	// echo "<h2>$result</h2>";
	
	if ($result != 'OK') {	?>
    <div class="error"><p><strong><?php _e( 'connection has failed!', 'wpallbkp' ); ?><br /></strong></p>
    <?php _e( $result, 'wpallbkp' );echo '<br /><br />'; ?>
    </div>
    <?php } else { ?>
    
<div class="updated"><p><strong><?php _e( 'Subdirectory:', 'wpallbkp' ); ?><?php _e( 'Connected to :', 'wpallbkp' ); ?><?php echo $opt_val; ?>, <?php _e( 'for user:', 'wpallbkp' ); ?> <?php echo $opt_val2; ?></strong></p></div>
<?php	
	} // end if 
	} // end if

        ?>
<style>td, th {
    padding: 5px;
}</style>
<p><?php _e( 'Enter your FTP details for your offsite backup repository. Leave these blank for local backups.', 'wpallbkp' ); ?></p>		
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<table width="700" border="0" cellspacing="10">
<tr>
 <td><?php _e( 'Enable ', 'wpallbkp' ); ?></td>
<td>
            	<input <?php checked( $ftpval, 'yes' ) ?> type="radio" name="ftp-enabled" value="yes" /> Yes 
            	<input <?php checked( $ftpval, 'no' ) ?> type="radio" name="ftp-enabled" value="no" /> No
            </td>
</tr>
  <tr>
    <td><?php _e( 'FTP Host:', 'wpallbkp' ); ?></td>
    <td><input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="25" placeholder="<?php _e( 'e.g. ftp.yoursite.com', 'wpallbkp' ); ?>"></td>
   
  </tr>
  <tr>
    <td><?php _e( 'FTP Port:', 'wpallbkp' ); ?></td>
    <td><input type="text" name="<?php echo $data_field_name9; ?>" value="<?php echo $opt_val9; ?>" size="4"></td>
    <td><em><?php _e( 'defaults to 21 if left blank ', 'wpallbkp' ); ?></em></td>
  </tr>
  <tr>
    <td><?php _e( 'FTP User:', 'wpallbkp' ); ?></td>
    <td><input type="text" name="<?php echo $data_field_name2; ?>" value="<?php echo $opt_val2; ?>" size="25"></td>
    <td>&nbsp;      </td>
  </tr>
  <tr>
    <td><?php _e( 'FTP Password:', 'wpallbkp' ); ?></td>
    <td><input type="password" name="<?php echo $data_field_name3; ?>" value="<?php echo $opt_val3; ?>" size="25"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php _e( 'Subdirectory:', 'wpallbkp' ); ?></td>
    <td><input type="text" name="<?php echo $data_field_name4; ?>" value="<?php echo $opt_val4; ?>" size="25"></td>
    <td><em><?php _e( 'e.g. /httpdocs/backups or leave blank', 'wpallbkp' ); ?></em> </td>
  </tr>

 
</table>

<input name="wpallbackup_update_setting" type="hidden" value="<?php echo wp_create_nonce('wpallbackup-update-setting')?>" />
<p><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save FTP Details', 'wpallbkp' ); ?>" />&nbsp;
<input type="submit" name="<?php echo $hidden_field_name; ?>" class="button-secondary" value="<?php _e( 'Test Connection', 'wpallbkp' ); ?>" />

  <br />
</p>
</form>
<hr />
<br />
