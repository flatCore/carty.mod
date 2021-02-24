<?php
//error_reporting(E_ALL ^E_NOTICE);

if(!defined('FC_INC_DIR')) {
	die("No access");
}

include '../modules/'.$mod_name.'.mod/install/installer.php';
include __DIR__.'/include.php';


echo '<h3>'.$mod_name.' '.$mod_version.' <small>| '.$mod['description'].'</small></h3>';

?>