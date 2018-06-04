<?php 
global $zController,$zendvn_sp_settings;    
$vHtml=new HtmlControl();
?>
<div class="tina relative">    
	<div class="oppo">
		<div class="relative">
			<div class="nina">
				<?php 
				if(have_posts()){                                   
					while (have_posts()) {
						the_post();                                                                                     
						the_title();
					}
					wp_reset_postdata();                                
				}
				?>    
			</div>
			<div class="tma"></div>
		</div>            
	</div>    
	<div>
		<script type="text/javascript" language="javascript">        
			jQuery(document).ready(function(){
				jQuery(".linda").slick({
					dots: true,
					autoplay:true,
					arrows:false,
					adaptiveHeight:true,
					loop:true
				});  
			});     
		</script>
		<div class="linda">
			<div class="lumberjack">                            
				<img src="<?php echo site_url('wp-content/uploads/banner-top.jpg'); ?>" />                               
			</div>
		</div>
	</div>       
</div> 
<div class="clr"></div>
<div class="container">
	<?php if(is_active_sidebar('reservation')):?>
        <?php dynamic_sidebar('reservation')?>
    <?php endif; ?>
    <center><hr class="search-food-hr"></center>
</div>
<div class="container padding-bottom-45 padding-top-15">
	<div class="row">
		<div class="col-lg-5">
			<?php 
				if(have_posts()){                                   
					while (have_posts()) {
						the_post();                                                                                     
						$post_id= get_the_id();
						$featureImg=get_the_post_thumbnail_url($post_id, 'full');       
						?>
						<center><img src="<?php echo $featureImg; ?>" ></center>
						<?php
					}
					wp_reset_postdata();                                
				}
				?>    
		</div>
		<div class="col-lg-7">
			<script type="text/javascript" language="javascript">
				jQuery(document).ready(function(){
					jQuery( "input[name='datebooking']" ).datepicker({
						dateFormat: "dd/mm/yy",
						defaultDate: "+3d",
						changeYear: true,
						changeMonth: true,
						yearRange: "2000:2015"
					});
					jQuery("input[name='timebooking']").timepicker();
				});            
			</script>     
			<form name="frm-reservation" method="POST" >
				<input type="hidden" name="action" value="reservation" />                      
				<?php wp_nonce_field("reservation",'security_code',true);?>     
				<?php 
				$data=array();   
				$error=$zController->_data["error"];
            	$success=$zController->_data["success"]; 				           
				if(count($zController->_data["data"]) > 0){
					$data=$zController->_data["data"];					
				}
				?>
            	<div class="cybertang">
            		<?php 
            		if(count($error) > 0 || count($success) > 0){
            			?>
            			<div class="form-group alert">
            				<?php             			            		
            				if(count($error) > 0){
            					?>
            					<ul class="comproduct33">
            						<?php 
            						foreach ($error as $key => $value) {
            							?>
            							<li><?php echo $value; ?></li>
            							<?php
            						}
            						?>            					
            					</ul>
            					<?php
            				}
            				if(count($success) > 0){
            					?>
            					<ul class="comproduct50">
            						<?php 
            						foreach ($success as $key => $value) {
            							?>
            							<li><?php echo $value; ?></li>
            							<?php
            						}
            						?>            					
            					</ul>
            					<?php
            				}
            				?>            			            			
            			</div>            	
            			<?php
            		}
            		?>            			
            		<div class="form-group relative">
						<i class="icofont icofont-ui-user"></i><input name="fullname" value="<?php echo @$data['fullname']; ?>"  placeholder="Họ và tên" class="form-control" type="text">
					</div>
					<div class="form-group relative">
						<i class="icofont icofont-ui-message"></i><input name="email" value="<?php echo @$data['email']; ?>" placeholder="Email" class="form-control" type="text">
					</div>
					<div class="form-group relative">
							<i class="icofont icofont-phone"></i><input name="mobile" value="<?php echo @$data['mobile']; ?>" placeholder="Mobile" class="form-control" type="text">
					</div>
					<div class="form-group relative">
						<i class="icofont icofont-ui-calendar"></i><input name="datebooking" value="<?php echo @$data['datebooking']; ?>" placeholder="Ngày đặt bàn" class="form-control" type="text">
					</div>
					<div class="form-group relative">
						<i class="icofont icofont-clock-time"></i><input name="timebooking" value="<?php echo @$data['timebooking']; ?>"  placeholder="Thời gian đặt bàn" class="form-control" type="text">
					</div>
					<div class="form-group relative">
						<i class="fa fa-key"></i>
						<select name="number_person" class="btn-group bootstrap-select form-control">
							<option value="0">Số người</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
						</select>
					</div>
					<div class="form-group relative">
						<i class="icofont icofont-ui-message"></i><textarea class="form-control" name="message"  placeholder="Message"><?php echo @$data['message']; ?></textarea>
					</div>
					<div class="form-group">
						<div class="about-us-readmore margin-top-15"><a href="javascript:void(0);" onclick="document.forms['frm-reservation'].submit();">Đặt bàn</a></div>
					</div>
            	</div>            
			</form>
		</div>
		<div class="clr"></div>
	</div>
</div>