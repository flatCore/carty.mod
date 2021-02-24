<?php
/**
 * carty.mod | flatCore Modul
 * Configuration File
 */

if(FC_SOURCE == 'backend') {
	$mod_root = '../modules/carty.mod/';
} else {
	$mod_root = 'modules/carty.mod/';
}

include $mod_root.'lang/en.php';

if(is_file($mod_root.'lang/'.$languagePack.'.php')) {
	include $mod_root.'lang/'.$languagePack.'.php';
}


$mod['name'] 					= "carty";
$mod['version'] 			= "0.2";
$mod['author']				= "flatCore DevTeam";
$mod['description']		= "With carty.mod your Customers can collect Products in a list and send this list via form to you";
$mod['database']			= "content/SQLite/carty.sqlite3";

$modnav[] = array('link' => $mod_lang['nav_dashboard'], 'title' => '', 'file' => "start");
$modnav[] = array('link' => $mod_lang['nav_preferences'], 'title' => '', 'file' => "prefs");


?>