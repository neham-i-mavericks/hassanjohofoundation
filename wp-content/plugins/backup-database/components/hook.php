<?php

add_action("backup_database_after_backup_create","backup_database_upload_backup");
function backup_database_upload_backup($backupid)
{

		 $pageid = $backupid;
	$ftpval=get_option('wp_all_backup_ftp_enable');
	if($ftpval=='yes')
	{
        	include BACKUP_DATABASE_ROOT_PATH . 'lib/FTP/preflight.php';
        
        	include BACKUP_DATABASE_ROOT_PATH . 'lib/FTP/sendaway.php';
	}

}?>
