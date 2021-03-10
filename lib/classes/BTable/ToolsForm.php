<?php

trait ToolsForm{
	
	public function getParentsOptionsSelectForm($id){
		
		$array = $this->arraySections;
		
		$id = $this->idForEdit;
		
		$options = "";
		
		$arrayChildsId = array();
		
		/* if((int)$array[$id]['parent_id'] != (int)0):
			
			$options .= '<option value="0">Убрать родителя</option>';
			
		endif; */
		
		require __DIR__ . '/../Tools/Childs.php';
		
		$Childs = new Childs();
		
		$stringChildsId = $Childs->getChildsId($array,$id);
		
		$arrayChildsId = explode(',',$stringChildsId);
		
		foreach($array as $item){
			
			if((int)$item['id'] == (int)$id) continue;
			
			//if((int)$item['id'] == (int)$array[$id]['parent_id']) continue;
			
			if(in_array($item['id'],$arrayChildsId)) continue;
					
			$options .= '<option value="'.$item['id'].'">'.$item['title'].'</option>';
				
		}
		
		return $options;
		
	}
	
	public function getAllParentSelectForm(string $name){
		
		$DB = new Database();
		
		$array = $DB->selectAll("sections");
		
		$options = "";
		
		if(isset($this->FIELDS[$this->tableName][$name]['parent_show']) AND $this->FIELDS[$this->tableName][$name]['parent_show'] == true){
			
			$options .= '<option value="0">Без родителя</option>';
			
		}
		
		foreach($array as $item){
			
			$options .= '<option value="'.$item['id'].'">'.$item['title'].'</option>';
			
		}
		
		return $options;
		
	}
	
	public function getEnums(string $name){
		
		$options = ""; 
		
		$stringType = $this->structureFieldKey[$name]['Type'];
		
		preg_match('#enum\(\'(.*)\'\)$#u',$stringType,$matches);
		
		$array = explode("','" , $matches[1]);
		
		foreach($array as $item){
			
			$options .= '<option value="' . $item . '">' . $item . '</option>';
			
		}
		
		return $options;
		
	}
	
	public function getTypeProducts(string $name){
		
		$options = "";
		
		$stringType = $this->structureFieldKey[$name]['Type'];
		
		preg_match('#enum\(\'(.*)\'\)$#u',$stringType,$matches);
		
		$array = explode("','" , $matches[1]);
		
		foreach($array as $item){
			
			$title = ($item == '1') ? "Продовольственный" : "Не Продовольственный";
			
			$options .= '<option value="' . $item . '">' . $title . '</option>';
			
		}
		
		return $options;
		
	}
	
}