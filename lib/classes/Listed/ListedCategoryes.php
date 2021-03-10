<?php

class ListedCategoryes{
	
	private $tableName;
	
	private $categoryes;
	
	public function __construct(string $tableName){
		
		$this->tableName = $tableName;
		
		$DB = new Database();
		
		$this->categoryes = $DB->selectAll($tableName,"",true);
		
		$tree = $DB->getTree($this->categoryes);
		
		echo "<ul id='ListedCategory'>";
		
		$this->printCategoryes($tree);
		
		echo "</ul>";
		
	}
	
	private function printCategoryes($tree){
		
		foreach($tree as $item):
			
			$this->printList($item);
			
		endforeach;
		
	}
	
	private function printList($category){
		
		$url = $category['id'];
		
		$title = $category['title'];
		
		echo "
		<li><a class=category' href='?category=$url'>$title</a>" . PHP_EOL . "<button id='modal_sum' class='btn btn-secondary btn-sm' href='?showSum=$url'>sum</button></li>
		";
		
		if(isset($category['childs'])):
		
			echo "<ul>";
			
			$this->printCategoryes($category['childs']);
			
			echo "</ul>";
			
		endif;
		
	}
	
}