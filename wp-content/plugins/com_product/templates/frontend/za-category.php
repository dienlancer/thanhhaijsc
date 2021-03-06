<?php get_header(); ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "top-sidebar.php"; ?>
<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "banner.php"; ?>
<div class="vc_row wpb_row section vc_row-fluid grid_section">
	<div class="section_inner clearfix">
		<div class="section_inner_margin clearfix">
			<div class="wpb_column vc_column_container vc_col-sm-3">
				<div class="vc_column-inner">
					<?php require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "manufacturer-sidebar.php"; ?>
				</div>				
			</div>
			<div class="wpb_column vc_column_container vc_col-sm-9">
				<div class="vc_column-inner">
					<div class="col-right margin-top-15">				
						<div class="section_inner_margin clearfix">
							<div class="wpb_column vc_column_container vc_col-sm-12">    
								<div class="vc_column-inner">
									<h1 class="category-title">
										<div>Trang chủ</div>
										<div class="margin-left-5"><i class="fas fa-angle-right"></i></div>
										<div class="margin-left-5"><?php single_cat_title(); ?></div>
									</h1>
								</div>                 								
							</div>
						</div>
						<?php 						
						$term_id = get_queried_object_id();
						$source_termchildren = get_term_children( $term_id,'za_category');	
						if(count($source_termchildren) > 0){
							?>
							<div class="section_inner_margin clearfix">
								<div class="wpb_column vc_column_container vc_col-sm-12">    
									<div class="vc_column-inner">
										<div class="lita">
											<?php
											foreach ($source_termchildren as $key => $value) {
												$term = get_term_by( 'id', $value, 'za_category');												
												$term_link= get_term_link($term,'za_category');
												?>
												<div><div class="niu"><a href="<?php echo $term_link; ?>"><?php echo $term->name; ?></a></div></div>
												<?php 
											}					
											?>
										</div>
									</div>									
								</div>
							</div>
							<?php
						}						
						require_once PLUGIN_PATH . DS . "templates" . DS . "frontend". DS . "loop-za-category.php";
						?>																					
					</div>			
				</div>				
			</div>
		</div>
	</div>	
</div>
<?php get_footer(); ?>
<?php wp_footer();?>