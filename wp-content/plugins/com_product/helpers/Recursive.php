<?php
class Recursive{
	
	protected $_sourceArr;
	public function __construct(){		
	}
	public function setSource($sourceArr){
		$this->_sourceArr=$sourceArr;
	}
	public function buildArray($parents = 0){
		$resultArr = array();
		$this->recursive($this->_sourceArr,$parents,1,$resultArr);
		
		return $resultArr;
	}
	
	public function getParentsIdArray($id,$options = null){
		if($options['type'] == 1){
			$arrParents[] = $id;
		}
		$this->findParents($this->_sourceArr,$id, $arrParents);
		return $arrParents;
	}
	
	public function recursive($sourceArr,$parents = 0,$level = 1,&$resultArr){
		if(count($sourceArr)>0){
			foreach ($sourceArr as $key => $value){
				if($value['parents'] == $parents){
					$value['level'] = $level;
					$resultArr[] = $value;
					$newParents = $value['id'];
					unset($sourceArr[$key]);
					$this->recursive($sourceArr,$newParents, $level + 1,$resultArr);
				}
			}
		}
	}
	
	public function findParents($sourceArr,$id, &$arrParents){
			foreach ($sourceArr as $key => $value){		
				if($value['id'] == $id){
					if( $value['parents'] >0 ){
						$arrParents[] = $value['parents'];
						unset($sourceArr[$key]);
						$newID = $value['parents'];
						$this->findParents($sourceArr,$newID, $arrParents);
					}
				}
			}
		}
	
}