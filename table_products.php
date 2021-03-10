<?php

if(!isset($_GET['category'])){die();}

(int)$id = trim($_GET['category']);

require_once('lib/classes/BTable/BuildTable.php');

require_once("lib/classes/Tools/Childs.php");

$BT = new BuildTable("products", $id);

$BT->getTable();