<?php get_header();?>
<div class="full_width">
	<div class="full_width_inner">
		<div class="vc_row wpb_row section vc_row-fluid  grid_section">
			<div class=" section_inner clearfix">
				<div class="section_inner_margin clearfix">
					<div class="wpb_column vc_column_container vc_col-sm-12">
						<div class="vc_column-inner ">
							<div class="wpb_wrapper">
								<?php
								$post_type=get_query_var('post_type'); 
								switch ($post_type) {									
									case 'album_construction':												
									case 'za_album':			
									require_once get_theme_file_path() . DS . "loop-za-album.php"; 
									break;
									case 'product':										
									default:
									require_once get_theme_file_path() . DS . "loop-post.php"; 
									break;
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>
