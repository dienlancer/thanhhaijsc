function openMedia(ctrl,prefix_key){
	jQuery(ctrl).click({param1:ctrl,param2:prefix_key},open_media_window);
	zendvn_sp_remove_image(ctrl);
}
function open_media_window(event){
	var ctrl=event.data.param1;
	var prefix_key=event.data.param2;
	if(this.window === undefined){
		this.window = wp.media({
			title: 'Insert pictures for product',
			library: {type: 'image'},
			multiple: true,
			button: {text: 'Insert pictures'}			
		});
		var self = this;
		this.window.on('select', function(){
			var attachment = self.window.state().get('selection').toJSON();
			zendvn_sp_insert_image(ctrl,prefix_key, attachment);			
		});			
	}
	this.window.open();
	return false;
}
function zendvn_sp_remove_image(ctrl){
	var elemt=jQuery(ctrl).closest('div.box-img');		
	jQuery(elemt).fadeOut('slow',function(){
		jQuery(this).remove();
	});
}	
function zendvn_sp_insert_image(ctrl,prefix_key, attachment){
	var frm=jQuery(ctrl).closest('form');	
	var img_content=jQuery(frm).find('.show-images');	
	if(jQuery(attachment).length > 0){
		var k=1;
		jQuery.each(attachment, function(key, obj){
			var imgUrl =  obj.url;
			var newImg = '';			
			newImg += '<div class="box-img">';			
			newImg += '<div class="baramen">';
			newImg += '<div><img src="'+ imgUrl +'" /></div>';			
			newImg += '<div><center><a class="remove-img" href="javascript:void(0);" onclick="zendvn_sp_remove_image(this);">Remove</a></center></div>';
			newImg += '<div><center><input type="text" value="1" class="ordering" name="'+prefix_key+'img-ordering[]" /></center></div>';			
			newImg += '<div><input type="hidden" value="' + imgUrl + '" name="'+prefix_key+'img-url[]" /></div>';						
			newImg += '</div>';
			newImg += '</div>';
			if(parseInt(k)%4==0 || parseInt(k) == jQuery(attachment).length){
				newImg +='<div class="clr"></div>';
			}
			k++;
			jQuery(img_content).append(newImg);
		});
	}
}