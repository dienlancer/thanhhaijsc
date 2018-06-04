<?php
if(!class_exists('WP_List_Table')){
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class AdminInvoiceModel extends WP_List_Table{
	private $_per_page = 5;
	private $_sql;
	public function __construct(){
		parent::__construct(array(
				'plural' => 'id',
				'singular' => 'id',
				'ajax' => false,
				'screen' => null,
		) );
	}
	public function prepare_items(){
		$columns 	= $this->get_columns();
		$hidden 	= $this->get_hidden_columns();
		$sortable 	= $this->get_sortable_columns();
		$this->_column_headers 	= array($columns,$hidden,$sortable);
		$this->items 			= $this->table_data();
		$total_items 	= $this->total_items();
		$per_page 		= $this->_per_page;
		$total_pages 	= ceil($total_items/$per_page);
		$this->set_pagination_args(array(
				'total_items' 	=> $total_items,
				'per_page' 		=> $per_page,
				'total_pages' 	=> $total_pages
		));
	}
	public function get_bulk_actions(){
		$actions = array(
				'delete' => 'Delete',
				'active' => 'Active',
				'inactive' => 'Inactive'
		);
		return $actions;
	}
	public function column_status($item){
		global $zController;
		$page = $zController->getParams('page');
		if($item['status'] == 1 ){
			$action = 'inactive';
			$src =  PLUGIN_URL . "/public/backend/images/active.png" ;
		}else{
			$action = 'active';
			$src =  PLUGIN_URL . "/public/backend/images/inactive.png" ;
		}
		$paged = max(1,@$_REQUEST['paged']);
		$name 		= 'security_code';
		$lnkStatus 	= add_query_arg(array('action'=>$action,'id'=>$item['id'],'paged'=> $paged));
		$action 	= $action . '_id_' . $item['id'];
		$lnkStatus 	= wp_nonce_url($lnkStatus,$action,$name);
		$html = '<img alt="" src="' . $src . '">';
		$html = '<a href="' . $lnkStatus . '">' . $html . '</a>';
		return $html;
	}
	public function column_name($item){		
		global $zController;
		$page = $zController->getParams('page');
		$name = 'security_code';
		$lnkDelete =  add_query_arg(array('action'=>'delete','id'=>$item['id']));
		$action 	= 'delete_id_' . $item['id'];
		$lnkDelete = wp_nonce_url($lnkDelete,$action,$name);
		$actions = array(
				'edit' 		=> '<a href="?page=' . $page . '&action=edit&id=' . $item['id'] . '">Edit</a>',
				'delete' 	=> '<a href="' . $lnkDelete . '">Delete</a>',				
		);
		$html = '<strong><a href="?page=' . $page . '&action=edit&id=' . $item['id'] . '">' . $item['code'] .'</a></strong>'
				. $this->row_actions($actions);		
		return $html;
	}
	public function column_cb($item){
		$singular = $this->_args['singular'];
		$html = '<input type="checkbox" name="' . $singular .'[]" value="' . $item['id'] .'" />';
		return $html;
	}
	public function column_default($item, $column_name){
		return $item[$column_name];
	}
	private function total_items(){
		global $wpdb;
		return $wpdb->query($this->_sql);
	}
	private function table_data(){	
		$data = array();	
		global $wpdb,$zController;			
		$orderby 	= ($zController->getParams('orderby') == '')? 'id' : $_GET['orderby'];
		$order		= ($zController->getParams('order') == '')? 'DESC' : $_GET['order'];	
		$table = $wpdb->prefix . 'shk_invoice';	
		$sql = 'SELECT m.*
				FROM ' . $table . ' AS m ';	
		$whereArr = array();	
		if(!empty($zController->getParams('filter_status'))){
			$status = ($zController->getParams('filter_status') == 'active')? 1:0;
			$whereArr[] = " (m.status = $status) ";
		}	
		if(!empty($zController->getParams('s'))){
			$s = esc_sql($zController->getParams('s'));
			$whereArr[] = " (m.code LIKE '%$s%') ";
		}	
		if(count($whereArr)>0){
			$sql .= " WHERE " . join(" AND ", $whereArr);				
		}	
		$sql .= ' ORDER BY m.' . esc_sql($orderby) . ' ' . esc_sql($order);
		$this->_sql  = $sql;
		$paged 		= max(1,@$_REQUEST['paged']);
		$offset 	= ($paged - 1) * $this->_per_page;
		$sql .= ' LIMIT ' . $this->_per_page . ' OFFSET ' . $offset;
		$data = $wpdb->get_results($sql,ARRAY_A);
		$data =  $zController->getHelper('DataConverter')->convertInvoiceToArrayData($data); 
		return $data;
	}
	
	public function get_sortable_columns(){
		return array(
				'name' => array('name',true),
				'id'	=> array('id', true)
		);
	}
	
	public function get_columns(){
		$arr = array(
				'cb'			=> 	'<input type="checkbox" />',
				'name' 			=> 	'Code',					
				"created_date"	=>	"Created date",
				"username"		=>	"Username",				
				"fullname"		=>	"Name",				
				"phone"			=>	"Phone",
				"mobilephone"	=>	"Mobile phone",				
				"quantity"		=>	"Quantity",
				"total_price"	=>	"Total price",							
				'status' 		=> 	'Status',
				'id'			=> 	'ID'
		);
		return $arr;
	}
	
	
	public function get_hidden_columns(){
		return array();
	}
	
	public function deleteItem(){		
		global $wpdb,$zController;	
		$arrData = $zController->getParams();		
		$tbl_invoice 			= $wpdb->prefix . 'shk_invoice';	
		$tbl_invoice_detail 	= $wpdb->prefix . 'shk_invoice_detail';				
		$arrID=array();
		if(is_array($arrData["id"])){
			$arrID=$arrData["id"];
		}
		else{
			$arrID[]=$arrData["id"];
		}		
		$ids = implode(",",$arrID);			
		$sql_invoice 		= "DELETE FROM ".$tbl_invoice." 		WHERE id 			IN (".$ids.")";
		$sql_invoice_detail = "DELETE FROM ".$tbl_invoice_detail." 	WHERE invoice_id 	IN (".$ids.")";		
		$wpdb->query($sql_invoice);				
		$wpdb->query($sql_invoice_detail);
	}
	public function changeStatus(){		
		global $wpdb,$zController;	
		$arrData = $zController->getParams();	
		$status=1;
		switch ($arrData["action"]) {
			case "active":
				$status=1;
				break;
			case "inactive":
				$status=0;
				break;			
		}
		$tbl_invoice 			= $wpdb->prefix . 'shk_invoice';	
		$tbl_invoice_detail 	= $wpdb->prefix . 'shk_invoice_detail';				
		$arrID=array();
		if(is_array($arrData["id"])){
			$arrID=$arrData["id"];
		}
		else{
			$arrID[]=$arrData["id"];
		}
		$ids = implode(",",$arrID);			
		$sql_invoice 		= "UPDATE ".$tbl_invoice." 	 set status = ".$status."		WHERE id 			IN (".$ids.")";		
		$wpdb->query($sql_invoice);						
	}	
	public function getItem(){
		global $wpdb,$zController;
		$tbl_invoice = $wpdb->prefix . 'shk_invoice';
		$tbl_payment_method = $wpdb->prefix . 'shk_payment_method';
		$arrData=$zController->getParams();		
		$id = absint($arrData['id']);			
		$sql = "SELECT 
					i.*
					
				FROM `".$tbl_invoice."` i
					  
				WHERE i.id =".$id;		
		$result = $wpdb->get_row($sql, ARRAY_A);	
		return $result;
	}	
	public function save_item(){			
		global $zController, $wpdb;
		$arrParam  		= 	$zController->getParams();		
		$action 		= 	$arrParam['action'];				
		$id 			=	(int)$arrParam['id'];								
		$email			=	$arrParam["email"];
		$fullname 		=	$arrParam["fullname"];
		$address		=	$arrParam["address"];
		$phone 			=	$arrParam["phone"];
		$mobilephone	=	$arrParam["mobilephone"];
		$fax 			=	$arrParam["fax"];
		$status 		=	$arrParam["status"];		
		$table 			= 	$wpdb->prefix . 'shk_invoice';					
		switch ($action) {			
			case "edit":			
				$query 	= "update {$table} set 
								email = %s
							,  fullname = %s 
							, address = %s
							, phone = %s
							, mobilephone = %s
							, fax = %s							
							, status = %d 
							where id =  %d " ;
				$info 	= $wpdb->prepare($query
											,$email
											,$fullname
											,$address
											,$phone
											,$mobilephone
											,$fax											
											,$status
											,$id);
				break;	
		}				
		$wpdb->query($info);		
	}	
	public function getInvoiceDetail(){	
		global $zController, $wpdb;
		$id = $zController->getParams('id');
		$table = $wpdb->prefix . 'shk_invoice_detail';	
		$sql = "SELECT * FROM `".$table."` p where p.invoice_id = ".$id."  order by p.product_name ASC " ;		
		$result = $wpdb->get_results($sql,ARRAY_A);		
		return $result;
	}
}