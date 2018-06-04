<?php
class GetPageId{
	
	public function get($meta_key = null, $meta_value = null){
		global $wpdb;
		
		$whereArr = array();
		
		if($meta_key != null){
			$whereArr[] = " (meta_key = '$meta_key') ";
		}
		

		if($meta_value != null){
			$whereArr[] = " (meta_value = '$meta_value') ";
		}
		
		if(count($whereArr)>0){
			$sql = " WHERE " . join(" AND ", $whereArr);
		}
		
		if($meta_key != null || $meta_value != null){
			$sql = "SELECT * FROM $wpdb->postmeta " . $sql;
			
			$data = $wpdb->get_row($sql, ARRAY_A);
		}
		
		if(is_array($data)){
			return $data['post_id'];
		}else{
			return false;
		}
	}
}