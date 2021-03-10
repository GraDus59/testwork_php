<?php
if(isset($_GET['table']) AND isset($_GET['id'])){
	
	$tableName = $_GET['table'];
	
	$id = $_GET['id'];
	
	require_once('lib/classes/DB/Database.php');
	
	$DB = new Database();
	
	$DB->deliteUniversal($tableName, $id);
	
}
