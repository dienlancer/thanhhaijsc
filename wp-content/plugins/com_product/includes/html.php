<?php

class HtmlControl{
	
	public function __construct($options = null){
		
	}
	
	public function btn_media_script($button_id,$input_id){
		$script = "<script language=\"javascript\" type=\"text/javascript\">
						jQuery(document).ready(function($){
							$('#{$button_id}').zendvnBtnMedia('{$input_id}');
						});
					</script>";
		return $script;
	}
	public function pTag($value = '', $attr = array(), $options = null){
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		
		return '<p ' . $strAttr .' >' . $value . '</p>';
	}
	
	public function label($value = '',$attr = array(), $options = null){
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		return '<label ' . $strAttr . ' >' . $value . '</label>';
	}
	
	//Phần tử TEXTBOX
	public function cmsTextbox($id="",$name = "",$class="", $value = ""){		
		$xhtml = '<input type="text" id="'.$id.'" name="'.$name.'" class="'.$class.'"   value="'.$value.'"  />';    
		return $xhtml;
	}	
	
	//Phần tử FILEUPLOAD
	public function cmsFileupload($id="",$name = "",$class="", $value = ""){
		$xhtml = '<input type="file" id="'.$id.'" name="'. $name . '"   />';
		return $xhtml;
	}
	
	//Phần tử PASSWORD
	public function cmsPassword($id="",$name = "",$class="", $value = ""){		
		$xhtml = '<input type="password" id="'.$id.'" name="'.$name.'" class="'.$class.'"   value="'.$value.'"  />';    
		return $xhtml;
	}	
	
	
	//Phần tử TEXTAREA
	public function cmsTextarea($id="",$name = "",$class="", $value = "",$rows=5,$cols=5){		
		$xhtml = '<textarea id="'.$id.'" name="'. $name . '" rows="'.$rows.'" cols="'.$cols.'">' . $value . '</textarea>';
		return $xhtml;
	}		
	//Phần tử RADIO
	public function cmsRadio($name = "",$class="", $value = "",$attr=array(),$options=null){
		$html = '';
	
		//1. Tạo chuỗi thuộc tính từ tham số $attr
		$strAttr = '';
		if(count($attr)> 0){
			foreach ($attr as $key => $val){
				if($key != "type" && $key != 'value'){
					$strAttr .= ' ' . $key . '="' . $val . '" ';
				}
			}
		}
		
		
		//2. Kiểm tra giá trị của $value
		$strValue = $value;
		
		//3.Kiểm tra ký tự phân cách giữa các nút radio
		if(!isset($options['separator'])){
			$options['separator'] = ' ';
		}
		
		//4. Tạo các nút radio
		$html = '';
		$data = $options['data'];
		if(count($data)){
			foreach ($data as $key => $val){
				$checked = '';
				if(preg_match('/^(' . $strValue .')$/i', $key)){
					$checked = ' checked="checked" ';
				}				
				$html  .= '<input type="radio" id="'.$id.'" name="' . $name . '" ' . $checked . ' value="' . $key . '"/>' 
						  . $val  . $options['separator'];
			}
		}
			
		return $html;
	}
function cmsSelectbox($id="",$name = "",$class="",$arrValue=array(), $keySelect = "",$disabled){
  $xhtml = '<select id="'.$id.'" name="'.$name.'" class="'.$class.'" '.$disabled.' >';
  foreach($arrValue as $key => $value){
    if($key == $keySelect ){
      $xhtml .= '<option selected="selected" value = "'.$key.'">'.$value.'</option>';
    }else{
      $xhtml .= '<option value = "'.$key.'">'.$value.'</option>';
    }
  }
  $xhtml .= '</select>';
  return $xhtml;
}
public function fnPrice($value){
	$data = get_option('zendvn_sp_setting',array());
	$language = $data["currency_unit"] ;
	$strCurrency="";
	switch ($language) {
		case "vi_VN":
		$strCurrency= number_format($value,0,",",".") . ' đ';
		break;
		case "en_US":
		$strCurrency='$'.number_format($value,0,".",",");
		break;
	}
	return $strCurrency;
}
	public function randomString($length = 5){	
		$result=rand(0,999999999);
		return $result;
	}	
	public function getFileName($fileUrl){
		preg_match("/[^\/|\\\]+$/", $fileUrl,$currentName);
		$fileName = $currentName[0];     
		return $fileName;
	}
	public function getResizedImg($file_url,$width,$height)
	{		
		preg_match("/[^\/|\\\]+$/", $file_url,$current_name);
		$image_name = $current_name[0];
		$ext = pathinfo($image_name, PATHINFO_EXTENSION);  
		$image_slug=sanitize_title($image_name);		
		$pattern_ext='#.png|.jpg|.gif#';
  		$pattern_dot='#\.#';
  		$pattern_ngang='#-#';
  		$image_slug=preg_replace($pattern_ngang, '.', $image_slug);           
  		$image_slug=preg_replace($pattern_ext, '', $image_slug);
  		$image_slug=preg_replace($pattern_dot, '-', $image_slug);
  		$image_name=$image_slug.'-'.$width.'x'.$height.'.'.$ext;
		$image_url=site_url("wp-content/uploads/".$image_name);
		return $image_url;	
	}
}