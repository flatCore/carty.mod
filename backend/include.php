<?php

use Medoo\Medoo;

$db_carty = new Medoo([
	'database_type' => 'sqlite',
	'database_file' => '../content/SQLite/carty.sqlite3'
]);

?>