<?php
class SettingConfig{
	
	public function get(){
		
		$arr = array(
				'product_number' 	=> 15,
				'article_number' 	=> 15,
				'currency_unit' 	=> 'vi_VN',				
				'smtp_host' 		=> 'smtp.gmail.com',	
				'smtp_port' 		=> "465",	
				'encription' 		=> 'ssl',
				'smtp_auth' 		=> true,
				'smtp_username' 	=> 'dienit342@gmail.com',
				'smtp_password' 	=> 'vjmrrzkoptcrwuja',
				'email_from' 		=> 'tenchu300488@gmail.com',
				'email_to' 			=> 'cloudspa2017@gmail.com',
				'from_name' 		=> 'Hệ thống',
				'to_name' 			=> 'Cloud Beauty - Trung tâm thẩm mỹ công nghệ cao',
				'product_width' 		=> 420,	
				'product_height' 		=> 560,	
			
				
		);
		
		return $arr;
	}
	
}