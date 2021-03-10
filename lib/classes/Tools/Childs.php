<?php

class Childs{
	
	public function getChildsId(array $array, int $id){
		
		$childsId = $this->ChildsId($array,$id);
		
		return rtrim($childsId, ',');
		
	}
	
	private function ChildsId(array $array, int $id){
		
		(string) $data = "";
		
		foreach($array as $item):
		
			if( $item['parent_id'] == $id ):
			
				$data .= $item['id'] . ",";
				$data .= $this->ChildsId($array, $item['id']);
			
			endif;
		
		endforeach;
		
		return $data;
		
	}
	
}