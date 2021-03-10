<?php

require_once('lib/classes/Add/AddForm.php');

require_once('lib/classes/DB/Database.php');

if(isset($_POST['table'])){
	
	$update = false;
	
	if(isset($_POST['id'])){$update = true;}
	
	$ADD = new AddForm($_POST,$update);
	
}