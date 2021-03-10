<?php

if(!isset($_POST['table'])) die();

require_once("lib/classes/BTable/BuildForm.php");
require_once("lib/classes/DB/Database.php");

$Database = new Database();

$BuildForm = new BuildForm($_POST['table'],true,$_POST['id']);

$BuildForm->getAddForm('EditForm');

