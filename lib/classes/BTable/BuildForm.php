<?php

require('ToolsForm.php');

class BuildForm{
	
	use ToolsForm;
	
	private $FIELDS;
	
	private $structure;
	
	private $structureFieldKey;
	
	private $arrayFetch;
	
	private $arraySections;
	
	private $tableName;
	
	private $edit;
	
	private $idForEdit;
	
	public function __construct(string $tableName, bool $edit = false, $idForEdit = false){
		
		$this->edit = $edit;
		
		$this->idForEdit = $idForEdit;
		
		$this->tableName = $tableName;
		
		require __DIR__ . '/../../settings/fieldtoname.php';
		
		$this->FIELDS = $FIELDS;
		
		$DB = new Database();
		
		$this->structure = $DB->getTableStructure($tableName);
		
		$this->structureFieldKey = $DB->fieldToKey($this->structure);
		
		$this->arrayFetch = $DB->selectAll($tableName);
		
		$this->arraySections = $DB->selectAll("sections","",true);
		
	}
	
	public function getAddForm(string $idForm){
		
		echo $this->startForm($idForm);
		
		echo '<input type="hidden" name = "table" value="' . $this->tableName . '">';
		
		echo $this->getInputs();

		echo $this->endForm();
		
	}
	
	private function getInputs(){
		
		$inputs = "";
		
		foreach($this->FIELDS[$this->tableName] as $key => $item):
		
			if(!$item['form']) continue;
			
			$inputs .= '<div class="col-4">';
			
			if($item['name'] == false){$item['name'] = $item['label'];}
			
			$inputs .= '<label class="form-label">' . $item['name'] . '</label>';
			
			switch($item['type']):
			
				case "text":
				
					$inputs .= $this->getOneInput($key);
					
				break;
				
				case "select":
				case "enum":
				
					if(isset($item['function'])){
					
						$func = $item['function'];
					
					}else{
					
						$func = "";
					
					}
					
					if($this->edit && $this->tableName == "sections"){
						
						$func = "getParentsOptionsSelectForm";
						
					}
				
					$inputs .= $this->getOneSelect($key, $func);
					
				break;
			
			endswitch;
			
			$inputs .= '</div>';
			
		endforeach;
		
		$inputs .= $this->getButton();
		
		return $inputs;
		
	}
	
	private function getOneSelect(string $name, string $functionName = ""){
		
		$class = $this->edit == false ? "" : "modal_edit_space ";
		
		$select = "";
		
		$select .= '<select name="' . $name . '" class="' . $class . 'form-select">';
		
		//$select .= $this->edit == false ? '<option selected>Выберите</option>' : "<option selected>Без родителя</option>";
			
		$select .= '<option value="0" selected>Без родителя</option>';
		
		if($functionName != ""){
			
			$select .= $this->{$functionName}($name);
			
		}
			
		$select .= '</select>';
		
		return $select;
		
	}
	
	private function getOneInput(string $name){
		
		$class = $this->edit == false ? "" : "modal_edit_space ";
		
		return '<input type="text" class="' . $class . 'form-control" name="' . $name . '">';
		
	}
	
	private function startForm(string $idForm){
		
		$border = $this->edit == false ? "border" : "";
		
		return '<form method="POST" class="row g-3 $border" id="' . $idForm . '">';
		
	}
	
	private function getButton(){
		
		$textButton = "Изменить";
		
		$col_num = 12;
		
		if($this->edit == false){$textButton = "Добавить"; $col_num = 3;}
		
		return'
		<div class="col-12">
			<button type="submit" class="btn btn-primary col-' . $col_num . '">' . $textButton . '</button>
		</div>';
		
	}
	
	private function endForm(){
		
		return '</form>';
		
	}
	
}