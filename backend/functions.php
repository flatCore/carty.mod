<?php

function carty_list_template_folders() {
	$tpl_folders = array();
	
	$directory = "../modules/carty.mod/styles";
	
	if(is_dir($directory)) {
	
		$all_folders = glob("$directory/*");
		
		foreach($all_folders as $v) {
			if(is_dir("$v")) {
				$tpl_folders[] = basename($v);
			}
		}
	
	 }
	 
	 return $tpl_folders;
}


?>