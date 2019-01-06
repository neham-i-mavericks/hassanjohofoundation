<?php
require_once( dirname( __FILE__ ) . '/helper.php' );
/**
 * Return filesize in MB, GB and TB if needed
 * @param  Integer $size Raw system size
 * @param  String $type MB, GB, TB
 * 
 * @return {Formatted Size}
 * @since 2.1.0
 */
function backup_database_convert_size( $size, $type ){
    switch($type){
    	case "KB":
            $filesize = $size * .0009765625; // bytes to KB
          	break;
        case "MB":
            $filesize = ( $size * .0009765625) * .0009765625; // bytes to MB
          	break;
        case "GB":
            $filesize = (( $size * .0009765625) * .0009765625) * .0009765625; // bytes to GB
          	break;
       }
    return round($filesize, 2).' '.$type;
}

/**
 * Return the cuurent system memeory limit
 * @return Current system memeory in MB
 */
function backup_database_get_memory_limit(){
	return ini_get('memory_limit');
}

/**
 * Attempts to chnage the memory limit 
 * If attempt was succefull, then we know that we are able to adjust the memory limit.
 * If we can not adjust the memory limit we need to trigger a admin notice about the issue
 * @return Boolean
 */
function backup_database_init_memory_check(){
	$stable = ini_get('memory_limit');
	ini_set( "memory_limit", "64M" );
	return $stable == ini_get("memory_limit") ? false : true;
}

/*
|--------------------------------------------------------------------------
| BACKUP_DB Register PostType
|--------------------------------------------------------------------------
|
| Registers BACKUP_DB Post Type - DO NOT MODIFY THIS
|
*/
add_action('init', 'register_backup_database_posttype');
function register_backup_database_posttype(){
	$labels = array(
	    'name'               => 'Backup Database',
	    'singular_name'      => 'Backup',
	    'add_new'            => 'Backup',
	    'add_new_item'       => 'Add New Backup',
 		'edit_item'          => 'Edit Backup',
	   	'new_item'           => 'New Backup',
	   	'all_items'          => 'All Backup',
	   	'view_item'          => 'View Backup',
	   	'search_items'       => 'Search Backups',
	   	'not_found'          => 'No Backups found',
	   	'not_found_in_trash' => 'No Backups found in Trash',
	   	'parent_item_colon'  => BACKUP_DATABASE_ROOT_URL.'assets/img/backup.png',
	   	'menu_name'          => 'Backup Plus'
	);
	$args = array(
	   	'labels'             => $labels,
	   	'public'             => false,
	   	'publicly_queryable' => false,
	   	'show_ui'            => false,
	   	'show_in_menu'       => false,
	   	'query_var'          => false,
	   	'rewrite'            => array( 'slug' => 'backup_database' ),
	   	'capability_type'    => 'post',
	   	'has_archive'        => false,
	   	'hierarchical'       => false,
	   	'menu_position'      => null,
	   	'supports'           => array( 'title', 'editor', 'custom-fields' )
	);
  	register_post_type( 'backup_database', $args );
}

/*
|--------------------------------------------------------------------------
| BACKUP_DB add main menu
|--------------------------------------------------------------------------
|
| Hardcode mmain page and all other pages will hook under this one
|
*/
add_action('admin_menu', 'backup_database_add_main_page');
function backup_database_add_main_page(){
	
	$backup_database_main = add_menu_page( __('Backup Database ','db_backup'), __('Backup Database ','db_backup'), 'manage_options', 'backup_database_overview', '', BACKUP_DATABASE_ROOT_URL.'assets/img/backup.png ', '125'); 
	
}

/*
|--------------------------------------------------------------------------
| BACKUP_DB include pages
|--------------------------------------------------------------------------
|
| Uses backup_database_pages filter - DO NOT MODIFY THIS
|
*/
function backup_database_include_pages(){
	global $backup_database;
	$pages = apply_filters('backup_database_pages', $backup_database->pages);
	if(is_array($pages)){
		foreach($pages as $page_info){
			foreach($page_info as $page){
				$backup_database_sub = add_submenu_page( 'backup_database_overview', $page['title'], $page['title'], $page['permission'], $page['slug'], $page['call'] );
				
			}
		}
	}
}

/*
|--------------------------------------------------------------------------
| BACKUP_DB Register and Load Admin Styles
|--------------------------------------------------------------------------
|
| This should not be modified
|
*/
function backup_database_admin_styles(){
	do_action('backup_database_admin_styles');
	wp_register_style( 'backup_database-admin-styles', BACKUP_DATABASE_ROOT_DIR . '/assets/css/backup_database-admin-styles.css'  );
	wp_register_style( 'backup_database-admin-fonts', BACKUP_DATABASE_ROOT_DIR . '/assets/css/font-awesome.min.css'  );
	wp_enqueue_style( 'backup_database-admin-styles' );
	wp_enqueue_style( 'backup_database-admin-fonts' );
	wp_enqueue_style( 'jquery-color' );
	wp_enqueue_script('jquery-ui-tabs');
}

/*
|--------------------------------------------------------------------------
| BACKUP_DB Register and Load Admin Scripts
|--------------------------------------------------------------------------
|
| This should not be modified
|
*/
function backup_database_admin_scripts(){
	do_action('backup_database_admin_scripts');
	wp_enqueue_script( 'backup_database-admin-js', BACKUP_DATABASE_ROOT_DIR . 'assets/js/admin.ajax.js?version=' . time() );
	wp_enqueue_script( 'backup_database-admin-functions-js', BACKUP_DATABASE_ROOT_DIR . 'assets/js/functions.js?version=' . time() );
	wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
}

/*
|--------------------------------------------------------------------------
| BACKUP_DB Documentation Script
|--------------------------------------------------------------------------
|
| This should not be modified
|
*/
function backup_database_documentation_scripts(){
	wp_enqueue_script( 'backup_database-admin-js', BACKUP_DATABASE_ROOT_DIR . '/assets/js/documentation.js?version=' . time() );
}
/*
|--------------------------------------------------------------------------
| BACKUP_DB admin page tabs
|--------------------------------------------------------------------------
|
| Displays formatted data based on the backup_database_pages filter
|
*/
function backup_database_admin_page_tabs(){
	global $backup_database;
	if(isset($wp_query->query_vars['page'])){ 
        $current_page = get_query_var('page');
    }
	$pages = $backup_database->pages['page'];
	print '<ul>';
	foreach($pages as $page){
		$walker_class = '';
		if($page['slug'] === $_GET['page']){
			$walker_class = 'class="active"';
		}

		print '<li><a '.$walker_class.' href="'.admin_url().'admin.php?page='.$page['slug'].'"><span class="'.$page['class'].'"></span> '.$page['title'].' </a></li>';
	}
	print '</ul>';
}

/*
|--------------------------------------------------------------------------
| BACKUP_DB admin top content
|--------------------------------------------------------------------------
|
| HTML content displayed at the top of each plugin page
|
*/
function backup_database_top_ui_callout(){ 

	// General Setting (notifications)
	$backup_database_general_settings 	= get_option('backup_database_general_settings');
	$backup_database_schedule_settings = get_option('backup_database_schedule_settings');
	$backup_database_account_settings 	= get_option('backup_database_account_settings');

	// Include the help tab for the plugin
	do_action('backup_database_load_help_tab');

	global $backup_database;
	?>
	<div class="wrap">
		<h2><span class="fa fa-cloud"></span> Backup Database

	</div>

	
<?php
}

/*
|--------------------------------------------------------------------------
| Filters WP schedules
|--------------------------------------------------------------------------
|
| Filters the installed schedules but does it in a way that won't
| interferre with other schedule hooks that might be being used elsewhere.
| Reomves hourly and twice daily only for BACKUP_DB
|
*/
function backup_database_filtered_schedules(){
	$installed_schedules = wp_get_schedules();

	// Remove Hourly and twice daily
	$installed_schedules['hourly'];
	unset($installed_schedules['twicedaily']);

	return $installed_schedules;
}

/*
|--------------------------------------------------------------------------
| Schedule Output / BACKUP_DB Admin
|--------------------------------------------------------------------------
|
| Gathhers the availiable options and present a form select based on 
| settings.
|
*/
function backup_database_get_admin_schedule_options(){
	$schedule_options = backup_database_filtered_schedules();
	$schedule_keys = array_keys($schedule_options);
	$schedule_options_selected = get_option('backup_database_schedule_settings');

	print '<option> OFF </option>';
	foreach($schedule_keys as $key){
		if($schedule_options_selected['backup_frequency'] == $key){
			print '<option value="'.$key.'" selected="selected"> '.$schedule_options[$key]['display'].' </option>';
		}else{
			print '<option value="'.$key.'"> '.$schedule_options[$key]['display'].' </option>';
		}
	}
}

/*
|--------------------------------------------------------------------------
| BACKUP_DB Schedule Event Updater 
|--------------------------------------------------------------------------
|
| Checks the current state for  "OFF" and clear scheduled event else 
| it updates the scheduled event to what ever BACKUP_DB is set to.
|
*/
function backup_database_schedule_ensure(){
	$schedule_options = get_option('backup_database_schedule_settings');
	$schedule_setting = $schedule_options['backup_frequency'];
	if($schedule_setting == 'OFF'){
		if(wp_next_scheduled( 'backup_database_backup_event' )){
			wp_clear_scheduled_hook('backup_database_backup_event');
		}
	}else{
		if($schedule_setting != wp_get_schedule('backup_database_backup_event')){
			wp_clear_scheduled_hook('backup_database_backup_event');
			wp_schedule_event( current_time( 'timestamp' ), $schedule_setting, 'backup_database_backup_event');
		}

	}
}

/*
|--------------------------------------------------------------------------
| BACKUP_DB backup schedule
|--------------------------------------------------------------------------
|
| Trigger backup
|
*/
function backup_database_backup_event(){
	if(class_exists('BACKUP_DB_Backup')){
		$schedule_options = get_option('backup_database_schedule_settings');
		$general_settings = get_option('backup_database_general_settings');

		$backup_database_backup = new BACKUP_DB_Backup();
		if( $schedule_options['backup_type'] == 'database' ){
			$backup_database_backup->Create_Database_Backup();
		}elseif( $schedule_options['backup_type'] == 'full' ){
			$backup_database_backup->full_backup();
		}

		if( $general_settings['send_email_notification'] == 'ON' ){
			if($general_settings['email_notification_contact'] == ''){
				$email = get_bloginfo('admin_email');
			}else{
				$email = $general_settings['email_notification_contact'];
			}
			$subject = "Backup Notification (".get_bloginfo('name').")";
			wp_mail( $email, $subject, 'A '. $schedule_options['backup_type'] . ' backup task has run for '. site_url() );
		}
	}
}




/*
|--------------------------------------------------------------------------
| BACKUP_DB Browser Notice
|--------------------------------------------------------------------------
|
| Displays a notification notice to people not using modern browsers.
| This is called on pages only
|
| @changelog 2.0.24 Added isset to $_GET var page
|
*/
function backup_database_admin_notice() {
	$show = array('backup_database_overview', 'backup_database_scheduler', 'backup_database_general', 'backup_database_addons');
	if( isset($_GET['page']) && ! in_array(@$_GET['page'], $show) )
		return;
	
	if( preg_match('/(?i)msie [2-9]/', $_SERVER['HTTP_USER_AGENT'] ) ) {
    	print '	<div class="update-nag">
       				<p class="fa fa-warning"> It looks like you are using a browser that is known to have issues with Backup Database Plus. Please download a reliable modern browser such as Chrome or Firefox.</p>
    			</div>';
	}
}
add_action( 'admin_notices', 'backup_database_admin_notice' );

/*
|--------------------------------------------------------------------------
| BACKUP_DB ZipArchive class check
|--------------------------------------------------------------------------
|
| Check for ZipArchive class and returns an error if it is not found
|
*/
function backup_database_zipArchive_notice() {
	$show = array('backup_database_overview','backup_database_scheduler','backup_database_manage', 'backup_database_scheduler', 'backup_database_general', 'backup_database_addons');
	if( isset($_GET['page']) && ! in_array(@$_GET['page'], $show) )
		return;
	
	if( !class_exists('ZipArchive') ) {
    	print '	<div class="update-nag error">
       				<p class="fa fa-warning"> Backup Database  depends on the PHP <b>ZipArchive</b> class. 
       				Your hosting does not have ZipArchive installed or enabled. If you would like to use
       				 Backup Database please enable <b>ZipArchive</ class. </p>
    			</div>';
	}
}
add_action( 'admin_notices', 'backup_database_zipArchive_notice' );






/*
|--------------------------------------------------------------------------
| Extend BACKUP_DB with ajax functionality
|--------------------------------------------------------------------------
|
| Other inludes
|
*/
require_once( dirname(__FILE__) . '/helper.php');
require_once( dirname(__FILE__) . '/admin-ajax.php');
?>
