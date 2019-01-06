<?php
/**
 * Plugin Name: Backup Database
 * Plugin URI:http://www.wpallbackup.com 
 * Version: 4.9
 * Description: Backup Database One Click WordPress Database Backup Plugin, It then gives you the options to store locally, download, or push to any server using FTP,Dropbox.
 * Author: WpProKing
 * Author URI:http://www.wpallbackup.com 
 * Text Domain: backup_database
 */

class Backup_Database {

	// BACKUP_DB Version
	public $version = '4.0';
	var $core_table_names = array();
	public $pages = null;
	public $components = null;

	/**
	 * [__construct description]
	 * Loads the actions, filter and other needed companents
	 */
	public function __construct(){
		global $table_prefix, $wpdb;
		do_action('backup_database_pre');

		$possible_names = array(
			'categories',
			'commentmeta',
			'comments',
			'termmeta',
			'terms',
			'links',
			'options',
			'postmeta',
			'posts',
			'terms',
			'term_taxonomy',
			'term_relationships',
			'users',
			'usermeta'
		);

		foreach( $possible_names as $name ) {
			if ( isset( $wpdb->{$name} ) ) {
				$this->core_table_names[] = $wpdb->{$name};
			}
		}

		ignore_user_abort( true );


					//add_action( is_multisite() ? 'network_admin_notices' : 'admin_notices', array( $this, 'admin_notice' ) );

		add_action( 'plugins_loaded' , array( $this, 'init' ), 0 );
		add_filter( 'backup_database_components', array( $this,'register_backup_database_components'));
		add_filter( 'backup_database_pages', array( $this,'register_backup_database_pages'));
	}

	/*
	 |--------------------------------------------------------------------------
	 | BACKUP_DB Start Method
	 |--------------------------------------------------------------------------
	 |
	 | Setups up some basic infromation BACKUP_DB will use
	 |
	 */
	public function start(){
		define( 'BACKUP_DATABASE_VERSION', $this->version);
		define( 'BACKUP_DATABASE_ABSPATH' , dirname( __FILE__ ) );
		define( 'BACKUP_DATABASE_ROOT_DIR', plugins_url('/', __FILE__ ) );
		define( 'BACKUP_DATABASE_DOWNLOADER', BACKUP_DATABASE_ROOT_DIR . 'components/downloader.php' );

		define('BACKUP_DATABASE_ROOT_PATH',plugin_dir_path(__FILE__ ));
		define('BACKUP_DATABASE_ROOT_URL',plugin_dir_url(__FILE__ ));

		$wp_upload_basedir_backup_database = wp_upload_dir();
		define( 'BACKUP_DATABASE_BACKUP_DIR', $wp_upload_basedir_backup_database['basedir'] . '/backup-database' );
	}

function admin_notice() {

		echo '<div class="updated notice-info my-wp-backup-notice" id="mywpb-notice" style="position:relative;">';
				printf(__('<p>Liked Backup Database? You will definitely love the ​<strong>Pro</strong> version. <a target="_blank" href="http://wpallbackup.com/pricing" target="_blank" class="notice-button"><strong>Get it now</strong>!</a></p>' ), '?mwpb_notice_close=1');
				echo "</div>";

	}

	/*
	 |--------------------------------------------------------------------------
	 |  Init Method
	 |--------------------------------------------------------------------------
	 |
	 | Simply does required things when BACKUP_DB is called
	 |
	 */
	public function init(){
		do_action('backup_database_pre_int'); 
		
		$this->start();
		$this->includes();
		$this->load();

		do_action('backup_database_post_init');
	}

	/*
	 |--------------------------------------------------------------------------
	 | BACKUP_DB's defualt components
	 |--------------------------------------------------------------------------
	 |
	 | Register components as an addon would to keep things uniform
	 |
	 */
	public function register_backup_database_components( $components ){

		$components['components']['backup_database_error'] = array(
			'title' 	=> 'Error Handler (Analytics)',
			'path'		=> BACKUP_DATABASE_ABSPATH . '/components/error_handler.php',
			'version' 	=> '1.0.0',
			'auhtor'	=> 'WPAllbackup',
			'description'	=> 'Reports core errors to the developers analaytics server.'
			);
		$components['components']['core_backup'] = array(
			'title' 	=> 'BACKUP_DB Core Backup',
			'path'		=> BACKUP_DATABASE_ABSPATH . '/components/backup.php',
			'version' 	=> '2.1.1',
			'auhtor'	=> 'WPAllbackup',
			'description'	=> 'BACKUP_DB core backup component'
			);
		$components['components']['backup_database_cron'] = array(
			'title' 	=> 'WP Cron Helper',
			'path'		=> BACKUP_DATABASE_ABSPATH . '/components/cron.php',
			'version' 	=> '1.0.0',
			'auhtor'	=> 'WPAllbackup',
			'description'	=> 'Extends native WP cron options.'
			);
		
		return $components;
	}

	/*
	 |--------------------------------------------------------------------------
	 | BACKUP_DB's default pages
	 |--------------------------------------------------------------------------
	 |
	 | Register pages as an addon would to keep things uniform. Keep in mind
	 | that the first page is dedicated as the main page. 
	 |
	 */
	public function register_backup_database_pages( $pages ){

		$pages['page']['backup_database_overview'] = array(
			'title' 	=> 'Create Backup',
			'path'		=> BACKUP_DATABASE_ABSPATH . '/pages/overview.php',
			'class' 	=> 'fa fa-tachometer fa-1x',
			'slug'		=> 'backup_database_overview',
			'permission'=> 'administrator',
			'call'		=> 'backup_database_overview_ui'
			);
		

		$pages['page']['backup_database_scheduler'] = array(
			'title' 	=> 'Schedule Options',
			'path'		=> BACKUP_DATABASE_ABSPATH . '/pages/scheduler.php',
			'class' 	=> 'fa fa-calendar fa-1x',
			'slug'		=> 'backup_database_scheduler',
			'permission'=> 'administrator',
			'call'		=> 'backup_database_scheduler_ui'
			);

		$pages['page']['backup_database_general'] = array(
			'title' 	=> 'Email Notification',
			'path'		=> BACKUP_DATABASE_ABSPATH . '/pages/general.php',
			'class' 	=> 'fa fa-envelope fa-1x',
			'slug'		=> 'backup_database_general',
			'permission'=> 'administrator',
			'call'		=> 'backup_database_general_ui'
			);
		$pages['page']['backup_database_settings'] = array(
			'title' 	=> 'Settings',
			'path'		=> BACKUP_DATABASE_ABSPATH . '/pages/settings.php',
			'class' 	=> 'fa fa-cog fa-1x',
			'slug'		=> 'backup_database_settings',
			'permission'=> 'administrator',
			'call'		=> 'backup_database_settings_ui'
			);

		$pages['page']['backup_database_addons'] = array(
			'title' 	=> 'Store Backup',
			'path'		=> BACKUP_DATABASE_ABSPATH . '/pages/addons.php',
			'class' 	=> 'fa fa-cloud fa-1x',
			'slug'		=> 'backup_database_addons',
			'permission'=> 'administrator',
			'call'		=> 'backup_database_addons_ui'
			);
		$pages['page']['backup_database_pro'] = array(
			'title' 	=> 'Pro Features',
			'path'		=> BACKUP_DATABASE_ABSPATH . '/pages/pro.php',
			'class' 	=> '',
			'slug'		=> 'backup_database_pro',
			'permission'=> 'administrator',
			'call'		=> 'backup_database_pro'
			);

		return $pages;
	}

	/*
	 |--------------------------------------------------------------------------
	 | BACKUP_DB Includes Method
	 |--------------------------------------------------------------------------
	 |
	 | Grabs the basic files need right now
	 |
	 */
	public function includes(){

		// Require BACKUP_DB Functions
		require_once( BACKUP_DATABASE_ABSPATH . '/lib/Dropbox/Dropboxclass.php');
		$dropbox_restore = new Backupdb_Dropbox();
		require_once( BACKUP_DATABASE_ABSPATH . '/lib/backup_database-functions.php');
		include(BACKUP_DATABASE_ROOT_PATH .'components/hook.php');	
		// Apply BACKUP_DB components Filter
		@$this->components = apply_filters( 'backup_database_components', $this->components );
		if(is_array($this->components)){
			foreach($this->components as $component){
				foreach($component as $include){
					require_once($include['path']);
				}
			}
		}

		// Apply BACKUP_DB Pages Filter
		@$this->pages = apply_filters( 'backup_database_pages', $this->pages );
		if(is_array($this->pages)){
			foreach($this->pages as $page){
				foreach($page as $include){
					require_once($include['path']);
				}
			}
		}
		do_action('backup_database_includes');
	}


	/*
	 |--------------------------------------------------------------------------
	 | BACKUP_DB Load Method
	 |--------------------------------------------------------------------------
	 |
	 | Loads all the things needed for BACKUP_DB
	 |
	 */
	public function load(){
		add_action( 'admin_menu', 'backup_database_include_pages');
		add_action( 'admin_init', array( $this, 'backup_database_register_settings') ); 
		add_action( 'plugins_loaded', array( $this, 'backup_database_register_languages') );
		add_action( 'plugins_loaded', 'backup_database_schedule_ensure' );
		add_action( 'backup_database_backup_event', 'backup_database_backup_event' );
		do_action('backup_database_load');
	}

	/**
	 * backup_database_register_settings Registers Complete Central Backups core settings (containers)
	 * @return 
	 */
	public function backup_database_register_settings(){
		register_setting( 'backup_database-global-group', 'backup_database_global_settings' );
		register_setting( 'backup_database-general-group', 'backup_database_general_settings' );
		register_setting( 'backup_database-schedule-group', 'backup_database_schedule_settings' );
		register_setting( 'backup_database-setting-group', 'backup_database_default_settings' );
	}

	/**
	 * backup_database_register_languages Loads Complete Central Backup's Language files directory
	 * @return 
	 *
	 * @todo Language files are not setup to work. Add lanaguagse eventully!
	 */
	 public function backup_database_register_languages(){
	 	load_plugin_textdomain('backup_database', false, basename( dirname( __FILE__ ) ) . '/languages');
	 }

	/**
	 * activate Adds basic options for Complete Central Backup
	 * @return 
	 */
	public function activate(){
		add_option('backup_database_account_settings');
		add_option('backup_database_general_settings');
		add_option('backup_database_schedule_settings');
		add_option('backup_database_default_settings');
		do_action('backup_database_activate');
	}

	/**
	 * [deactivate description]
	 * @return [type] [description]
	 */
	public function deactivate(){
		do_action('backup_database_deactivate');
	}

}

// Start BACKUP_DB
$backup_database = new Backup_Database();
global $pagenow;?>
