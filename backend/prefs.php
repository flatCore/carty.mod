<?php
//error_reporting(E_ALL ^E_NOTICE);

if(!defined('FC_INC_DIR')) {
	die("No access");
}

include 'functions.php';
include '../modules/carty.mod/global/functions.php';

if(isset($_POST['save_carty_prefs'])) {
	
	$tpl = basename($_POST['carty_template']);
	
	$db_carty->update("prefs", [
		"template" => $tpl
	], [
		"status" => "active"
	]);
	
}


$carty_preferences = carty_get_preferences();


echo '<h3>'.$mod_name.' '.$mod_version.' <small>| Preferences</small></h3>';


echo '<form action="acp.php?tn=moduls&sub=carty.mod&a=prefs" method="POST">';

$tpl_folders = carty_list_template_folders();

echo '<div class="form-group">';
echo '<label>Template</label>';

echo '<select class="form-control custom-select" name="carty_template">';
				
foreach ($tpl_folders as $tpl) {
	unset($sel);
	if($cookie_styles == $tpl) {
		$sel = "selected";
	}					
	echo "<option $sel value='$tpl'>$tpl</option>";
}
echo '</select>';
echo '</div>';

echo '</fieldset>';

echo '<hr><div class="formfooter">';
echo '<input type="hidden" name="csrf_token" value="'.$_SESSION['token'].'">';
echo '<input class="btn btn-success" type="submit" name="save_carty_prefs" value="'.$lang['update'].'">';
echo '</div>';


echo '</form>';

print_r($carty_preferences);

echo '<div class="well">';
echo '<code>README.md</code>';
$rmf = file_get_contents(__DIR__ .'/../README.md');
echo '<pre>'.$rmf.'</pre>';
echo '</div>';

?>