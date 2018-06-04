<?php
class ImgThumbnail{
	public function __construct(){
		
	}	
	public function resizeImage($fileUrl,$width,$height){   		
		global $zController;		
	    $vHtml=new HtmlControl();
	    $currentName=$vHtml->getFileName($fileUrl);	    
		$filePath=wp_upload_dir()["path"] . DS . $currentName;
		$newFilePath=wp_upload_dir()["path"] . DS . $width . "x" . $height . "-" . $currentName;		
		require_once PLUGIN_PATH . DS . "scripts" . DS . "PhpThumb" . DS . "ThumbLib.inc.php" ;    
	    $thumb = PhpThumbFactory::create($filePath);	    
	    $thumb->adaptiveResize($width,$height);
	    $thumb->save($newFilePath);
  	}
}
?>