<?php

/**
 * carty Database-Scheme
 * install/update the table for entries
 */

$database = "carty";
$table_name = "messages";

$cols = array(
	"id"  => 'INTEGER NOT NULL PRIMARY KEY',
	"time_entry" => 'VARCHAR',
	"status" => 'VARCHAR',
	/* sender */
	"company" => 'VARCHAR',
	"first_name" => 'VARCHAR',
	"last_name" => 'VARCHAR',
	"salutation " => 'VARCHAR',
	"street " => 'VARCHAR',
	"zip " => 'VARCHAR',
	"city " => 'VARCHAR',
	/* cart */
	"cart_string" => 'VARCHAR'
  );
  


 
?>