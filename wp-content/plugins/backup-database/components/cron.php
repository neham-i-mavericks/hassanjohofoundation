<?php

add_filter('cron_schedules', 'backup_database_addtional_schedule_options' ); 
function backup_database_addtional_schedule_options( $schedules ) {

	// Once Weekly
	$schedules['weekly'] = array(
		'interval' 	=> 604800,
		'display' 	=> __( 'Once a Week', 'backup_database' )
	);

	// Monthly
	$schedules['monthly'] = array(
		'interval' 	=> 2592000,
		'display' 	=> __( 'Once a Month', 'backup_database' )
	);

	return $schedules;
}?>
