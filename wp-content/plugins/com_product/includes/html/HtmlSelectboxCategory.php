<?php

class HtmlSelectboxCategory{
	public static function create($name,$value = null,$attribs = array(), $options ){		
		$strAttribs = '';
		if(count($attribs)>0){
			foreach ($attribs as $keyAttribs => $valueAttribs){
				$strAttribs .= $keyAttribs . '="' . $valueAttribs . '" ';
			}
		}
				
		$xhtml = '<select name="' . $name . '" id="' . $name . '" ' . $strAttribs . ' >';
		
		foreach ($options as $key=> $info){
			$strSelect = '';
			if($info['id'] == $value){
				$strSelect = 'selected="selected"';
			}
			
			if($info['level'] == 1){
				$xhtml .= '<option value="' . $info['id'] . '" ' . $strSelect . '>+' . $info['name'] . '</option>';
			}else{
				$string = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$newString = '';
				for($i=1;$i<$info['level']; $i++){
					$newString .= $string;
				}
				$info['name'] = $newString . '-' . $info['name'];
				$xhtml .= '<option value="' . $info['id'] . '" ' . $strSelect . '>' . $info['name'] . '</option>';
			}
		}
		
		$xhtml .= '</select>';

		return $xhtml;
	}
	
}
