jQuery(function($){
	
	$(document).ready(function(){
		
		
		$('#zendvn-sp-zaproduct-button').click(open_media_window);
		zendvn_sp_remove_image('#zendvn-sp-zaproduct-show-images');
	});
	
	function open_media_window(){

		if(this.window === undefined){
			this.window = wp.media({
					title: 'Insert pictures for product',
					library: {type: 'image'},
					multiple: true,
					button: {text: 'Insert pictures'}			
				});
			var self = this;
			this.window.on('select', function(){
				var imgs = self.window.state().get('selection').toJSON();
				
				zendvn_sp_insert_image('#zendvn-sp-zaproduct-show-images', imgs);
				zendvn_sp_remove_image('#zendvn-sp-zaproduct-show-images');
			});			
		}
		this.window.open();
		return false;
	}
	
	function zendvn_sp_remove_image(img_content){

		$(img_content + ' a.remove-img').on("click", function(){
			
			var elemt;
			elemt = $(this).parents("div.content-img");
			$(elemt).fadeOut('slow',function(){
				$(this).remove();
			});
		});
	}
	//zendvn-sp-zaproduct-show-images
	function zendvn_sp_insert_image(img_content, imgs){
		if($(imgs).length > 0){
			$.each(imgs, function(key, obj){
				var imgUrl =  obj.url;
				var newImg = '';
				console.log(imgUrl);
				
				newImg += '<div class="content-img">';
				newImg += '<img width="100" height="100"';
				newImg += '	src="' + imgUrl + '">';
				newImg += '<div>';
				newImg += '	<a class="remove-img">Remove</a>';
				newImg += '</div>';
				newImg += '<div class="div-ordering">';
				newImg += '	<input type="text" value="1" class="ordering"';
				newImg += '		name="zendvn-sp-zaproduct-img-ordering[]"> <input type="hidden"';
				newImg += '		name="zendvn-sp-zaproduct-img-url[]"';
				newImg += '		value="' + imgUrl + '">';
				newImg += '</div>';
				newImg += '</div>';
				
				$(newImg).insertBefore(img_content + " .clr");
				
			});
		}
	}
});











