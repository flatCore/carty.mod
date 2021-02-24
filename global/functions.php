<?php
	
use Medoo\Medoo;

if(FC_SOURCE == 'frontend') {
	$db_carty = new Medoo([
		'database_type' => 'sqlite',
		'database_file' => 'content/SQLite/carty.sqlite3'
	]);

} else {

	$db_carty = new Medoo([
		'database_type' => 'sqlite',
		'database_file' => '../content/SQLite/carty.sqlite3'
	]);
		
}



/**
 * get carty preferences
 *
 */

function carty_get_preferences() {
	
	global $db_carty;
	

	$prefs = $db_carty->get("prefs", "*");
	
	return $prefs;
	
}


function carty_send_form($data) {
	
	global $fc_prefs;

	if($data['carty_sender_mail'] == '') {
		return 'fail';
	}
	
	if($fc_prefs['prefs_mailer_type'] == 'smtp') {
		require 'content/config_smtp.php';
	}
	
	
	return 'send';
	
}


function carty_check_inputs($user_submit) {
	$user_submit = strip_tags($user_submit);
	$user_submit = preg_replace( "/(content-type:|bcc:|cc:|to:|from:)/im", "",$user_submit);
	$user_submit = preg_replace('/\r\n|\r|\n/', '<br>', $user_submit);
	return $user_submit;
}


?>