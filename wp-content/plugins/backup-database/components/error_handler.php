<?php
// Simple error analytic class for reporting to our analytics API
class backup_database_ErrorHandler{
	function reportError( $error ){
		$this->sendError( $error );
		return;
	}
	function sendError( $error ){
		if(empty($error))
			return; // silent return

    $fields = '';
    foreach($error as $key => $value) { 
        $fields .= $key . '=' . $value . '&'; 
    }
    rtrim($fields, '&');
		
    $errors = $fields .'&php_version='.phpversion();
		$post = curl_init();
		curl_setopt($post, CURLOPT_URL, "http://productanalytics.bbidev.com");
	   	curl_setopt($post, CURLOPT_POST, count($errors));
	   	curl_setopt($post, CURLOPT_POSTFIELDS, $errors);
	   	curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
	   	$result = curl_exec($post);
	   	curl_close($post);
	}
}

// ONLY set this trigger if the user allows it
$backup_database_settings = get_option('backup_database_general_settings');
if( $backup_database_settings['error_analytics'] == 'ON')
  register_shutdown_function( "backup_database_fatal_handler" );

function backup_database_fatal_handler() {
  $errfile = "unknown file";
  $errstr  = "shutdown";
  $errno   = E_CORE_ERROR;
  $errline = 0;
  $error = error_get_last();
  if( $error !== NULL) {
    $errno   = $error["type"];
    $errfile = $error["file"];
    $errline = $error["line"];
    $errstr  = $error["message"];
  }
  if( !strpos( $errfile, '/plugins/backup-database/') )
       return;
  $backup_databaseError = new backup_database_ErrorHandler;
  $backup_databaseError->reportError( $error );
}?>
