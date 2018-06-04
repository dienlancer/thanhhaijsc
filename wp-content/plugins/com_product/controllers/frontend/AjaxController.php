<?php
class AjaxController{
	
	public function __construct(){				
		add_action('wp_ajax_add_to_cart',array($this,'add_to_cart'));
		add_action('wp_ajax_show_lst_invoice_detail',array($this,'show_lst_invoice_detail'));
		add_action('wp_ajax_load_payment_method_info',array($this,'load_payment_method_info'));		
		add_action('wp_ajax_nopriv_show_lst_invoice_detail', array($this,'show_lst_invoice_detail'));
		add_action('wp_ajax_nopriv_load_payment_method_info', array($this,'load_payment_method_info'));
		add_action('wp_ajax_nopriv_add_to_cart', array($this,'add_to_cart'));
		add_action('wp_head',array($this,'add_ajax_library'));
	}
	public function add_to_cart(){
		global $zController;
		$vHtml=new HtmlControl();  
		$id=(int)($zController->getParams("id"));	
		$quantity=(int)($zController->getParams("quantity"));	
		$arg=array(
			'p'=>$id,
			'post_type'=>'zaproduct'
		);		
		$meta_key = "_zendvn_sp_zaproduct_";            
		$product_id=(int)0;
		$product_code='';
		$product_name='';
		$product_image='';
		$product_price=0;
		$product_quantity=0;	
		$total_quantity=0;	
		$permalink="";				
		$data=array();
		$the_query=new WP_Query($arg);			
		if($the_query->have_posts()){
			while ($the_query->have_posts()) {
				$the_query->the_post();                            
				$post_id=$the_query->post->ID;                                             				              
				$title=get_the_title($post_id);                    				
				$featureImg=wp_get_attachment_url(get_post_thumbnail_id($post_id));
				$featureImg=$vHtml->getFileName($featureImg);
				$product_image=$featureImg;				
				$price=get_post_meta( $post_id, $meta_key . 'price', true );
				$sale_price=get_post_meta( $post_id, $meta_key . 'sale_price', true );       				       
				$product_id=$post_id;
				$product_code=get_post_meta( $post_id, 'code', true );
				$product_name=$title; 		
				$product_price=$price;
				if(!empty($sale_price)){
					$product_price=$sale_price;
				}		
				$product_quantity=(int)$quantity;				
				$ssName="vmart";
				$ssValue="zcart";				
				$ssCart 	= $zController->getSession('SessionHelper',$ssName,$ssValue);
				$arrCart = @$ssCart->get($ssValue)["cart"];												
				if($product_id > 0){						
					if(count($arrCart) == 0){
						$arrCart[$product_id]["product_quantity"] = $product_quantity;
					}else{
						if(!isset($arrCart[$product_id])){
							$arrCart[$product_id]["product_quantity"] = $product_quantity;
						}else{					
							$arrCart[$product_id]["product_quantity"] = $arrCart[$product_id]["product_quantity"] + $product_quantity;
						}
					}					
					$arrCart[$product_id]["product_id"]=$product_id;	
					$arrCart[$product_id]["product_code"]=$product_code;
					$arrCart[$product_id]["product_name"]=$product_name;			
					$arrCart[$product_id]["product_image"]=$product_image;					
					$arrCart[$product_id]["product_price"]=$product_price;											
					$product_quantity=(float)$arrCart[$product_id]["product_quantity"];
					$product_total_price=$product_price * $product_quantity;
					$arrCart[$product_id]["product_total_price"]=($product_total_price);
					
					$cart["cart"]=$arrCart;
					$ssCart->set($ssValue,$cart);	
					$arrCart = @$ssCart->get($ssValue)["cart"];
					if(count($arrCart)){
						foreach($arrCart as $cart){    
					    	$total_quantity+=(int)$cart['product_quantity'];
						}	
					}									 					
					$pageID = $zController->getHelper('GetPageId')->get('_wp_page_template','zcart.php');	
					$permalink = get_permalink($pageID);	
					$data=array(
									'total_quantity'=>$total_quantity,
									'permalink'=>$permalink
								);				
				}
			}
			wp_reset_postdata();                 
		}	
		echo json_encode($data);	
		die();
	}	
	public function show_lst_invoice_detail(){
		global $zController;
		$id=(int)($zController->getParams("id"));	
		$invoice_model=$zController->getModel("/frontend","InvoiceModel");
		$lstCartInvoice=array();
		$lstCartInvoice=$invoice_model->getInvoiceDetailById($id);	
		echo json_encode($lstCartInvoice);
		die();
	}
	public function load_payment_method_info(){
		global $zController;
		$payment_method_id=(int)@$zController->getParams("payment_method_id");	
		$data=array();
		$args=array(
			"p"=>$payment_method_id,
			"post_type"=>"payment_method"
		);
		$the_query = new WP_Query( $args );
	    if($the_query->have_posts()){
	        while ($the_query->have_posts()) {
	            $the_query->the_post();
	            $post_id=$the_query->post->ID;
	            $title=get_the_title($post_id);
	            $content=get_the_content($post_id);	            
	            $data["id"]=$post_id;
	            $data["title"]=$title;
	            $data["content"]=$content;	            
	        }
	    }		
		echo json_encode($data);
		die();
	}
	public function add_ajax_library(){
	
		$ajax_nonce = wp_create_nonce('ajax-security-code');
	
		$html = '<script type="text/javascript">';
		$html .= ' var ajaxurl = "' . admin_url('admin-ajax.php') . '"; ';
		$html .= ' var security_code = "' . $ajax_nonce . '"; ';
		$html .= '</script>';
	
		echo $html;
	}
	
	
}