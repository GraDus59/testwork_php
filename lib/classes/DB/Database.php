<?php

class Database{
	
	private $HOST = 'localhost';
	private $DBNAME = 'test';
	private $LOGIN = 'root';
	private $PASSWORD = 'root';
	
	private function connect(){
			
			return new PDO("mysql:host=$this->HOST;dbname=$this->DBNAME", $this->LOGIN, $this->PASSWORD);
			
	}
	
	public function getTableStructure(string $tableName){
		
		$connect = $this->connect();
		
		$sth = $connect->prepare("SHOW COLUMNS FROM `$tableName`");
		$sth->execute();
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
		
	}
	
	public function deliteRowId(string $tableName, $id){
		
		$connect = $this->connect();
		
		$connect->exec("DELETE FROM `$tableName` WHERE `id` = $id");
		
		return true;
		
	}
	
	public function deliteUniversal(string $tableName, $id){
		
		$connect = $this->connect();
		
		$this->deliteRowId($tableName, $id);
		
		if($tableName == "sections"){
			
			$IDs = $this->selectAll($tableName,"WHERE parent_id = '$id'");
			
			$products = $this->selectAll("products","WHERE parent_category = '$id'");
			
			if(count($products) > 0){
				
				foreach($products as $prod){
					
					$sth = $connect->prepare("UPDATE `products` SET `parent_category` = :parent_category WHERE `id` = :id");
					$sth->execute(
						array(
							'parent_category' => 999999,
							'id' => $prod['id']
						)
					);
					
				}
				
			}
			
			if(count($IDs) > 0){
				
				foreach($IDs as $item){
					
					$sth = $connect->prepare("UPDATE `$tableName` SET `parent_id` = :parent_id WHERE `id` = :id");
					$sth->execute(
						array(
							'parent_id' => 0,
							'id' => $item['id']
						)
					);
					
				}
				
			}
			
		}
		
	}
	
	public function selectAll(string $table, string $sqlPlus = "", bool $idToKey = false){
			
		$connect = $this->connect();
			
		$sql = "SELECT * FROM `$table` $sqlPlus";
			
		$sth = $connect->prepare($sql);
		$sth->execute();
		$array = $sth->fetchAll(PDO::FETCH_ASSOC);
			
		if($idToKey === false){return $array;}
			
		$item = $this->idToKey($array);
				
		return $item ;
			
	}
	
	public function getSelectIn(string $table, string $key, string $IN, bool $idToKey = false){
			
			$connect = $this->connect();
			
			$sql = "SELECT * FROM $table WHERE $key IN($IN)";
			
			$sth = $connect->prepare($sql);
			$sth->execute();
			$array = $sth->fetchAll(PDO::FETCH_ASSOC);
			
			if($idToKey === false){return $array;}
			
			$item = $this->idToKey($array);
			
			return $item;
			
		}
	
	public function insert(string $sql, array $set, bool $update = false){
		
		$connect = $this->connect();
		
		$sth = $connect->prepare($sql);
		
		$sth->execute($set);
		
		if($update){return true;}
		
		$insert_id = $connect->lastInsertId();
		
		return $insert_id;
		
	}
	
	private function idToKey($array){
			
		$item = array();
			
		for($i = 0;$i<count($array);$i++){
					
			$item[$array[$i]['id']] = $array[$i];

		}
				
		return $item ;
			
	}
	
	public function fieldToKey($array){
			
		$item = array();
			
		for($i = 0;$i<count($array);$i++){
					
			$item[$array[$i]['Field']] = $array[$i];

		}
				
		return $item ;
			
	}
	
	public function getTree($dataset) {
		
		$tree = array();
			
		foreach ($dataset as $id => &$node) {   
			
			if (!$node['parent_id']){
					
				$tree[$id] = &$node;
					
			}else{
					
				$dataset[$node['parent_id']]['childs'][$id] = &$node;
					
			}
				
		}
			
		return $tree;
			
	}
	
}