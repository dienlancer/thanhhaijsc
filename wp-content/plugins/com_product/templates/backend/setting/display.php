<?php
global $zController;	
$data=array();
$option_name = 'zendvn_sp_setting';
if(!$zController->isPost()){
	$data = get_option('zendvn_sp_setting',array());
	if(count($data)==0){
		$data = $zController->getConfig('SettingConfig')->get();
	}
}
$vHtml 				= new HtmlControl();



$inputID 			= $option_name . '_article_number';
$inputName 			= $option_name . '[article_number]';
$inputValue 		= !empty(@$data['article_number']) ? @$data['article_number'] : '';	
$article_number		= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_article_width';
$inputName 			= $option_name . '[article_width]';
$inputValue 		= !empty(@$data['article_width']) ? @$data['article_width'] : '';			
$article_width		= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_article_height';
$inputName 			= $option_name . '[article_height]';
$inputValue 		= !empty(@$data['article_height']) ? @$data['article_height'] : '';			
$article_height		= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);	

$inputID 			= $option_name . '_product_number';
$inputName 			= $option_name . '[product_number]';
$inputValue 		= !empty(@$data['product_number']) ?  @$data['product_number'] : '';	
$product_number		= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_product_width';
$inputName 			= $option_name . '[product_width]';
$inputValue 		= !empty(@$data['product_width']) ? @$data['product_width'] : '';			
$product_width		= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_product_height';
$inputName 			= $option_name . '[product_height]';
$inputValue 		= !empty(@$data['product_height']) ? @$data['product_height'] : '';			
$product_height		= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);	



$inputID 			= $option_name . '_currency_unit';
$inputName 			= $option_name . '[currency_unit]';
$inputValue 		= !empty(@$data['currency_unit']) ? @$data['currency_unit'] : '';			
$currency_unit		= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);	

$inputID 			= $option_name . '_smtp_host';
$inputName 			= $option_name . '[smtp_host]';
$inputValue 		= !empty(@$data['smtp_host']) ? @$data['smtp_host'] : '';			
$smtp_host			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_smtp_port';
$inputName 			= $option_name . '[smtp_port]';
$inputValue 		= !empty(@$data['smtp_port']) ? @$data['smtp_port'] : '';			
$smtp_port			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_encription';
$inputName 			= $option_name . '[encription]';
$inputValue 		= !empty(@$data['encription']) ? @$data['encription'] : '';
$encription			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_smtp_auth';
$inputName 			= $option_name . '[smtp_auth]';
$inputValue 		= !empty(@$data['smtp_auth']) ? @$data['smtp_auth'] : '';
$options			= array('data' => array(false=> 'No',true=>'Yes'),
	'separator' => ' ');			
$smtp_auth			= $vHtml->cmsRadio($inputName,"regular-text", $inputValue,$attr,$options);

$inputID 			= $option_name . '_smtp_username';
$inputName 			= $option_name . '[smtp_username]';
$inputValue 		= !empty(@$data['smtp_username']) ? @$data['smtp_username'] : '';			
$smtp_username		= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_smtp_password';
$inputName 			= $option_name . '[smtp_password]';
$inputValue 		= !empty(@$data['smtp_password']) ? @$data['smtp_password'] : '';			
$smtp_password		= $vHtml->cmsPassword($inputID,$inputName,"regular-text", $inputValue);				

$inputID 			= $option_name . '_email_to';
$inputName 			= $option_name . '[email_to]';
$inputValue 		= !empty(@$data['email_to']) ? @$data['email_to'] : '';			
$arr 				= array('size' =>'25','id' => $inputID);
$email_to			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_address';
$inputName 			= $option_name . '[address]';
$inputValue 		= !empty(@$data['address']) ?  @$data['address'] : '';			
$address			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_website';
$inputName 			= $option_name . '[website]';
$inputValue 		= !empty(@$data['website']) ? @$data['website'] : '';			
$website			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_telephone';
$inputName 			= $option_name . '[telephone]';
$inputValue 		= !empty(@$data['telephone']) ? @$data['telephone'] : '';			
$telephone			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_contacted_name';
$inputName 			= $option_name . '[contacted_name]';
$inputValue 		= !empty(@$data['contacted_name']) ? @$data['contacted_name'] : '';			
$contacted_name			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_facebook_url';
$inputName 			= $option_name . '[facebook_url]';
$inputValue 		= !empty(@$data['facebook_url']) ? @$data['facebook_url'] : '';			
$facebook_url			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_twitter_url';
$inputName 			= $option_name . '[twitter_url]';
$inputValue 		= !empty(@$data['twitter_url']) ? @$data['twitter_url'] : '';			
$twitter_url			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_google_plus';
$inputName 			= $option_name . '[google_plus]';
$inputValue 		= !empty(@$data['google_plus']) ? @$data['google_plus'] : '';			
$google_plus			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_youtube_url';
$inputName 			= $option_name . '[youtube_url]';
$inputValue 		= !empty(@$data['youtube_url']) ? @$data['youtube_url'] : '';			
$youtube_url			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_instagram_url';
$inputName 			= $option_name . '[instagram_url]';
$inputValue 		= !empty(@$data['instagram_url']) ? @$data['instagram_url'] : '';			
$instagram_url			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_pinterest_url';
$inputName 			= $option_name . '[pinterest_url]';
$inputValue 		= !empty(@$data['pinterest_url']) ? @$data['pinterest_url'] : '';			
$pinterest_url			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_linkedin_url';
$inputName 			= $option_name . '[linkedin_url]';
$inputValue 		= !empty(@$data['linkedin_url']) ? @$data['linkedin_url'] : '';			
$linkedin_url			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_google_analytics';
$inputName 			= $option_name . '[google_analytics]';
$inputValue 		= !empty(@$data['google_analytics']) ? @$data['google_analytics'] : '';			
$google_analytics			= $vHtml->cmsTextbox($inputID,$inputName,"regular-text", $inputValue);

$inputID 			= $option_name . '_ban_do';
$inputName 			= $option_name . '[ban_do]';
$inputValue 		= !empty(@$data['ban_do']) ? @$data['ban_do'] : '';			
$ban_do			=$vHtml->cmsTextarea($inputID,$inputName,"widefat",$inputValue,8,120);

?>
<div class="wrap">
	<h1>Setting</h1>
	<form method="post" action="" id="<?php echo $option_name;?>" name="<?php echo $option_name;?>"enctype="multipart/form-data">
		<h2><i><font color="red">Show article in FrontEnd</font></i></h2>
		<div class="zendvn-sp-form-table">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<b><i><label >Articles in a page</label></i></b>
						</th>
						<td><?php echo $article_number;?></td>
					</tr>			
					<tr>
						<th scope="row">
							<b><i><label >Width</label></i></b>
						</th>
						<td><?php echo $article_width;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >Height</label></i></b>
						</th>
						<td><?php echo $article_height;?></td>
					</tr>					
				</tbody>
			</table>
		</div>
		<h2><i><font color="red">Show product in FrontEnd</font></i></h2>
		<div class="zendvn-sp-form-table">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<b><i><label >Products in a page</label></i></b>
						</th>
						<td><?php echo $product_number;?></td>
					</tr>		
					<tr>
						<th scope="row">
							<b><i><label >Width</label></i></b>
						</th>
						<td><?php echo $product_width;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >Height</label></i></b>
						</th>
						<td><?php echo $product_height;?></td>
					</tr>		
				</tbody>			
			</table>
		</div>		
		<h2><i><font color="red">Currency</font></i></h2>
		<div class="zendvn-sp-form-table">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<b><i><label >Currency unit</label></i></b>
						</th>
						<td><?php echo $currency_unit;?></td>
					</tr>
				</tbody>			
			</table>
		</div>	
		<h2><i><font color="red">Email configs</font></i></h2>
		<div class="zendvn-sp-form-table">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<b><i><label >SMTP Host</label></i></b>
						</th>
						<td><?php echo $smtp_host;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >SMTP Port</label></i></b>
						</th>
						<td><?php echo $smtp_port;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >Type of Encription</label></i></b>
						</th>
						<td><?php echo $encription;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >SMTP Authentication</label></i></b>
						</th>
						<td><?php echo $smtp_auth;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >SMTP username</label></i></b>
						</th>
						<td><?php echo $smtp_username;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >SMTP password</label></i></b>
						</th>
						<td><?php echo $smtp_password;?></td>
					</tr>					
					<tr>
						<th scope="row">
							<b><i><label >Email to</label></i></b>
						</th>
						<td><?php echo $email_to;?></td>
					</tr>						
					<tr>
						<th scope="row">
							<b><i><label >Contacted name</label></i></b>
						</th>
						<td><?php echo $contacted_name;?></td>
					</tr>									
				</tbody>			
			</table>
		</div>					
		<h2><i><font color="red">Contact</font></i></h2>
		<div class="zendvn-sp-form-table">
			<table class="form-table">
				<tbody>		
					<tr>
						<th scope="row">
							<b><i><label >Google analytics</label></i></b>
						</th>
						<td><?php echo $google_analytics;?></td>
					</tr>			
					<tr>
						<th scope="row">
							<b><i><label >Address</label></i></b>
						</th>
						<td><?php echo $address;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >Website</label></i></b>
						</th>
						<td><?php echo $website;?></td>
					</tr>					
					<tr>
						<th scope="row">
							<b><i><label >Tel</label></i></b>
						</th>
						<td><?php echo $telephone;?></td>
					</tr>
									
					<tr>
						<th scope="row">
							<b><i><label >Facebook</label></i></b>
						</th>
						<td><?php echo $facebook_url;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >Twitter</label></i></b>
						</th>
						<td><?php echo $twitter_url;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >Google Plus</label></i></b>
						</th>
						<td><?php echo $google_plus;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >Youtube</label></i></b>
						</th>
						<td><?php echo $youtube_url;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >Instagram</label></i></b>
						</th>
						<td><?php echo $instagram_url;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >Pinterest</label></i></b>
						</th>
						<td><?php echo $pinterest_url;?></td>
					</tr>
					<tr>
						<th scope="row">
							<b><i><label >Linked in</label></i></b>
						</th>
						<td><?php echo $linkedin_url;?></td>
					</tr>					
					<tr>
						<th scope="row">
							<b><i><label >Bản đồ</label></i></b>
						</th>
						<td><?php echo $ban_do;?></td>
					</tr>
				</tbody>			
			</table>
		</div>			
		<!--Send mail - End -->
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
	</form>
</div>