<?php
class ProductModel{
	private $_per_page =0;	
	private $_sql;
	private $_items;
	private $_total_items;
	private $_total_pages=0;
	private $_catID="";
	private $_wpquery=array();
	// items
	public function __construct(){		
		
	}
	public function setWpQuery($wpquery=array()){
		$this->_wpquery=$wpquery;
		
	}
	public function getWpQuery(){
		return $this->_wpquery;
	}
	public function setCatID($catids) {
  		$this->_catID = $catids;
	}
	public function getCatID() {
	  return $this->_catID;
	}	 
	public function setItems($items) {
  		$this->_items = $items;
	}
	public function getItems() {
	  return $this->_items;
	}
	// total items
	public function setTotalIems($total_items) {
  		$this->_total_items = $total_items;
	}
	public function getTotalItems() {
	  return $this->_total_items;
	}
	// total pages
	public function setTotalPages($total_pages) {
  		$this->_total_pages = $total_pages;
	}
	public function getTotalPages() {
	  return $this->_total_pages;
	}	
	// per_page
	public function setPerpage($per_page) {
  		$this->_per_page = $per_page;
	}
	public function getPerpage() {
	  return $this->_per_page;
	}	
	public function getLstNewProducts(){	
		global $wpdb;
		$table = $wpdb->prefix . 'shk_product';	
		$sql = "SELECT p.id , p.product_sku , p.product_name , p.product_image , p.product_slug , p.product_status,p.product_price FROM {$table} p where p.product_status = 1 and p.product_new = 1 order by p.product_published_date DESC " ;
		$result = $wpdb->get_results($sql,ARRAY_A);		
		return $result;
	}
	public function getLstBestSeller(){	
		global $wpdb;
		$table = $wpdb->prefix . 'shk_product';	
		$sql = "SELECT p.id , p.product_sku , p.product_name , p.product_image , p.product_slug , p.product_status , p.product_price FROM {$table} p where p.product_status = 1 and p.product_best_seller = 1 order by p.product_published_date DESC " ;
		$result = $wpdb->get_results($sql,ARRAY_A);		
		return $result;
	}
	public function getDetail(){	
		global $wpdb,$zController;
		$id= $zController->getParams('id');
		$table = $wpdb->prefix . 'shk_product';	
		$sql = "SELECT p.* FROM {$table} p where p.id =  " . $id;
		$result = $wpdb->get_results($sql,ARRAY_A);		
		return $result;
	}
	public function prepare_items(){						
		$this->setItems($this->table_data());
		$this->setTotalIems($this->total_items());		
		$wpQuery=new WP_Query();
		$wpQuery=$this->table_data();		
		if(count($wpQuery->posts) > 0){
			$this->setTotalPages(ceil($this->getTotalItems()/$this->getPerpage()));
		}					
	}	
	private function total_items(){
		$wpQuery=$this->getWpQuery();
		$totalItems=0;
		$totalItems=$wpQuery->found_posts;
		return $totalItems;
	}
	private function table_data(){
		$wpQuery=$this->getWpQuery();		
		$currentPage=1;	
		if(!empty(@$_POST["filter_page"]))			
            $currentPage=@$_POST["filter_page"];
        $offset 	= ($currentPage - 1) * $this->getPerpage();	 	
        $args = $wpQuery->query;
        $args["posts_per_page"]=$this->getPerpage();
        $args["offset"]=$offset;
        $args["paged"]=$currentPage;
        $args['orderby']='id';
        $args['order']='DESC';        
		$wpQuery->query($args);				
		return $wpQuery;
	}
}