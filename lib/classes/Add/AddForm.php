<?php

class AddForm{
	
	private $tableName;
	
	private $SETTINGS;
	
	private $errors;
	
	private $post;
	
	private $update;
	
	public function __construct(array $post, bool $update = false){
		
		require __DIR__ . '/../../settings/formfunctions.php';
		
		$this->SETTINGS = $FF;
		
		$this->tableName = $post['table'];
		
		unset($post['table']);
		
		$this->update = $update;
		
		$this->post = $post;
		
		$this->start();
		
	}
	
	private function start(){
		
		$this->isNull();
		
		$post = $this->post;
		
		$this->patternTest();
		
		$this->inArray();
		
		if(empty($this->errors)){
			
			$settings = $this->SETTINGS[$this->tableName];
			
			$DB = new Database();
			
			//$insert = "INSERT INTO `$this->tableName` SET ";
			
			$insert = $this->update == true ? "UPDATE `$this->tableName` SET " : "INSERT INTO `$this->tableName` SET ";
			
			$set = array();
			
			foreach($post as $key => $item){
				
				if($this->findExeption($key, $item, "not_print")) continue;
				
				$insert .= "`$key` = :$key,";
				
				$set[$key] = $item;
				
			}
			
			$insert = rtrim($insert , ',');
			
			$insert .= ($this->update == true) ? " WHERE `id` = :id" : "";
			
			$success = $DB->insert($insert, $set, $this->update);
			
			if($success){
				
				echo json_encode(array('result' => 'success'));
				
			}else{
				
				$this->errors['connect'] = "Ошибка добавления записи.";
				
				echo json_encode(array('result' => 'error', 'text_error' => $this->errors));
				
			}
			
		}else{
			
			echo json_encode(array('result' => 'error', 'text_error' => $this->errors));
			
		}
		
	}
	
	private function isNull(){
		
		$post = $this->post;
		
		$settings = $this->SETTINGS[$this->tableName];
		
		$nameSetting = "trim";
		
		foreach($post as $key => $item){
			
			if($this->findExeption($key, $item, $nameSetting)) continue;
			
			if(!$settings[$key][$nameSetting]) continue;
			
			$post[$key] = trim($item);
			
			if($settings[$key]['null']) continue;
			
			if($item == ''){
				
				$this->errors[$key] = "Поле осталось пустое.";
				
			}
			
		}
		
		$this->post = $post;
		
	}
	
	private function patternTest(){
		
		$post = $this->post;
		
		$settings = $this->SETTINGS[$this->tableName];
		
		$nameSetting = "pattern";
		
		foreach($post as $key => $item){
			
			if($this->findExeption($key, $item, $nameSetting)) continue;
			
			if(!$settings[$key][$nameSetting]) continue;
			
			preg_match_all($settings[$key]['pattern_string'], $item, $results);
			
			if($results[0][0] != (string)$item){
		
				$this->errors[$key] = "Ошибка в ожидании от поля.";
		
			}
			
		}
		
	}
	
	private function inArray(){
		
		$post = $this->post;
		
		$settings = $this->SETTINGS[$this->tableName];
		
		$nameSetting = "in_array";
		
		foreach($post as $key => $item){
			
			if($this->findExeption($key, $item, $nameSetting)) continue;
			
			if(!$settings[$key][$nameSetting]) continue;
			
			if(!in_array($item, $settings[$key]['test_array'])){
				
				$this->errors[$key] = "Подмена значений";
				
			}
			
		}
		
	}
	
	private function findExeption($key, $item, $nameSetting){
		
		$settings = $this->SETTINGS[$this->tableName];
		
		$exeption = $settings[$key]['exeption'];
		
		if(isset($exeption)){
			
			foreach($exeption as $value){
				
				$array = explode('/',$value);
				
				if($this->post[$array[0]] == $array[1] && $nameSetting == $array[2]){
				
					return true;
				
				}
				
				if($this->post[$array[0]] == $array[1] && $nameSetting == "not_print"){
				
					return true;
				
				}
				
			}
			
		}else{
			
			return false;
			
		}
		
	}
	
}