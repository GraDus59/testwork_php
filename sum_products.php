<?php

if(!isset($_GET['showSum'])){die();}

require_once("lib/classes/Tools/Childs.php");
require_once("lib/classes/DB/Database.php");

(int)$id = trim($_GET['showSum']);

$DB = new Database();
$Childs = new Childs();

$array = $DB->selectAll("sections");

$ids = $Childs->getChildsId($array, $id);

$ids = $ids == "" ? "" : $ids.',';

$arrayFetch = $DB->getSelectIn("products", "parent_category", $ids.$id);

(int) $result = 0;

(int) $count = 0;

foreach($arrayFetch as $item){
	
	$result += $item['price'];
	
	$count++;
	
}

echo json_encode(array('result' => $result, 'count' => $count));