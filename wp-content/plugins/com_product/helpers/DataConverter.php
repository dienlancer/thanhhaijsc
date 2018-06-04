<?php
class DataConverter{
	public static function convertInvoiceToArrayData($data){
    	global $zController;
        $vHtml=new HtmlControl();        
        $result=array();
        for ($i=0; $i < count($data); $i++) { 
            $created_date     = $zController->getHelper('DateTimeConverter')->datetimeConverterVn($data[$i]["created_date"]);
            $result[$i]=array(
                    "id"                    =>  $data[$i]["id"],
                    "code"                  =>  $data[$i]["code"],
                    "user_id"               =>  $data[$i]["user_id"],
                    "created_date"          =>  $created_date,
                    "username"              =>  $data[$i]["username"],
                    "email"                 =>  $data[$i]["email"],
                    "fullname"              =>  $data[$i]["fullname"],
                    "address"               =>  $data[$i]["address"],
                    "phone"                 =>  $data[$i]["phone"],
                    "mobilephone"           =>  $data[$i]["mobilephone"],
                    "fax"                   =>  $data[$i]["fax"],
                    "payment_method_title"  =>  $data[$i]["payment_method_title"],
                    "quantity"              =>  $data[$i]["quantity"],
                    "total_price_text"           =>  $vHtml->fnPrice($data[$i]["total_price"]),
                    "total_price"           =>  $data[$i]["total_price"],
                    "status"                =>  (int)$data[$i]["status"]
                );
        }
        return $result;
    }
}