<?php

/**
 * carty Database-Scheme
 * install/update the table for preferences
 * 
 */

$database = "carty";
$table_name = "prefs";

$cols = array(
	"id"  => 'INTEGER NOT NULL PRIMARY KEY',
	"status"  => 'VARCHAR',
	"version" => 'VARCHAR',
	"template"  => 'VARCHAR'
  );
  
  
 
?>
