<?php
// Admin ajax functions



// Do database backup
function backup_database_do_database_backup($other_table) {
	if(class_exists('backup_database_Backup')){
		$backup = new backup_database_Backup();
			
		$backup = $backup->Create_Database_Backup($other_table);
		
	}
	exit;
}

/**
 * Remove a backup from WordPress
 *
 * @updated @ 2.0.27 to remove backup post type. 
 * This will prevent the backup from stalling and never being removed.
 * Also make the action return true all the time since there is no handler for it.
 *
 * @todo  Add some feddback to tell what is going on.
 */
add_action('wp_ajax_backup_database_remove_backup', 'backup_database_remove_backup');
function backup_database_remove_backup(){
	$params = $_POST;
	if(empty($params['backupID']))
		return;

	$backup_location = get_post_meta($params['backupID'], 'backup_location', true);	
	@unlink( $backup_location ); 
	wp_delete_post( $params['backupID'] );

	print '1';
	exit;
}

/*
|--------------------------------------------------------------------------
| Unpack a backup
|--------------------------------------------------------------------------
|
| Returns a JSON object contain a tree structure of a given backup
|
*/
add_action('wp_ajax_backup_database_backup_browser', 'backup_database_backup_browser');
function backup_database_backup_browser(){

	$errors = array();
	$params = $_POST;

	// Make sure the backuID was given
	if(empty($params['backupID'])){
		array_push($errors, array( 'Missing backup parameter' ));
	}

	// Get the backup location for the backup CPT
	$backup_location = get_post_meta( $params['backupID'], 'backup_location', true );

	// make sure the backup exists
	if( ! file_exists( $backup_location ) ){
		array_push($errors, array( 'Backup does not exist' ));
	}

	// Report is there is any errors
	if( count( $errors ) > 0 ){
		print json_encode( array( 'errors' => $errors ) );
		exit;
	}

	$backup_clone_location = BACKUP_DATABASE_ABSPATH . '/options/tmp';
	if( ! file_exists( $backup_clone_location )){
		mkdir( $backup_clone_location, 0755);
	}
	$backup_clone_name = 'tmp-browser-data.zip';

	// Try to copy the backup to a temp location
	if( ! @copy( $backup_location, $backup_clone_location. '/' . $backup_clone_name ) ){
		array_push($errors, array( 'Failed to make a copy of the backup' ));
		print json_encode( array( 'errors' => $errors ) );
		exit;
	}

	$zip = new ZipArchive;
	$zip->open( $backup_clone_location. '/' . $backup_clone_name );
	
	$zip->extractTo( BACKUP_DATABASE_ABSPATH . '/options/tmp/' );
	$zip->close();

	// Everything should be unpacked and now we only want the level 1 files and directories
	$files = backup_db_listDirectoryByFolder( BACKUP_DATABASE_ABSPATH . '/options/tmp' );

	// print_r($files);
	
	$dir_content = array();

	array_push($dir_content, array(
								'directory' => '/'
								));

	// Loop through the files in the root directory
	foreach($files as $file){
		$file_data['filename'] 	= basename($file);
		$file_data['is_dir'] 	= is_dir( BACKUP_DATABASE_ABSPATH . '/options/tmp/' . basename($file) ) ? '1':'0';
		$file_data['file_size']	= backup_db_filesize_formatted( filesize( BACKUP_DATABASE_ABSPATH . '/options/tmp/' . basename($file) ));
		$file_data['file_type']	= pathinfo( BACKUP_DATABASE_ABSPATH . '/options/tmp/' . basename($file), PATHINFO_EXTENSION );
		array_push($dir_content, $file_data);
		
	}

	print json_encode( $dir_content );
	exit;
}

/*
|--------------------------------------------------------------------------
| Options Close - Function 
|--------------------------------------------------------------------------
|
| Cleans the the temp directory used for backup browser
*/
add_action('wp_ajax_backup_database_options_window_close', 'backup_database_options_window_close');
function backup_database_options_window_close(){
	backup_db_delTree( BACKUP_DATABASE_ABSPATH . '/options/tmp' );
}?>
