<?php

require_once __DIR__ . '/../DB/Database.php';

class BuildTable{
	
	private $FIELDS;
	
	private $structure;
	
	private $arrayFetch;
	
	private $tableName;
	
	public function __construct(string $tableName, int $getID = -1){
		
		$this->tableName = $tableName;
		
		require __DIR__ . '/../../settings/fieldtoname.php';
		
		$this->FIELDS = $FIELDS;
		
		$DB = new Database();
		
		$this->structure = $DB->getTableStructure($tableName);
		
		$this->arrayFetch = $DB->selectAll($tableName,"",true);
		
		if($getID != -1){
			
			$Childs = new Childs();
			
			$this->arrayFetch = $DB->selectAll("sections","",true);
			
			$products = $Childs->getChildsId($this->arrayFetch, $getID);
			
			$products = $products == "" ? "" : $products.',';
			
			$this->arrayFetch = $DB->getSelectIn("products", "parent_category", $products.$getID);
			
		}
		
	}
	
	public function getTable(){
		
		echo '<table table-sm class="table table-striped table-hover table-bordered">';
		
		echo $this->getHeadTable();
		
		echo $this->getBodyTable();
		
		echo '</table>';
		
	}
	
	private function getHeadTable(){

		$th = "<thead><tr>";
		
		foreach($this->structure as $item):
		
			$name = $this->fieldToName($item['Field']);
			
			if(!$name) continue;
		
			$th .= '<th scope="col">' . $name . '</th>';
		
		endforeach;
		
		$th .= '<th scope="col">Изменить/Удалить</th>';
		
		$th .= "</tr></thead>";
		
		return $th;
		
	}
	
	private function fieldToName(string $field){
		
		return $this->FIELDS[$this->tableName][$field]['name'];
		
	}
	
	private function getBodyTable(){
		
		$body = "<tbody id='" . $this->tableName . "'>";
		
		foreach($this->arrayFetch as $item):
		
			$body .= $this->getTrBody($item);
		
		endforeach;
		
		$body .= "</tbody>";
		
		return $body;
		
	}
	
	private function getTrBody(array $item){
		
		$tr = "<tr id='" . $item['id'] . "'>";
		
		foreach($item as $k=>$value):
			
			if($this->FIELDS[$this->tableName][$k]['name'] === false) continue;
			
			$tr .= "<td id='" . $k . "' >" . $value . "</td>";
		
		endforeach;
		
		$tr .= $this->getButtonsTd();
			
		$tr .= "</tr>";
		
		return $tr;
		
	}
	
	private function getButtonsTd(){
		
		return '
		<td>
		<a class="popup-open btn btn-success btn-sm" id="edit_element" href="#">Изменить</a>
		<button type="button" class="btn btn-danger btn-sm" id="delite_this_element">Удалить</button>
		</td>
		';
		
	}
	
}