<?php
  class Post {
    // we define 3 attributes
    // they are public so that we can access them using $post->author directly
  	public $customerNumber;
    public $customerName;
    public $email;
    public $address;
    public $city;
    public $country;

    public function __construct($customerNumber,$customerName, $email, $address,$city,$country) {
      $this->customerNumber= $customerNumber;
      $this->customerName= $customerName;
      $this->email  = $email;
      $this->address = $address;
      $this->city = $city;
      $this->country = $country;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT distinct c.customerNumber, c.customerName, c.email, c.address, c.city, c.state, c.postalCode, c.country FROM angularcode_customers c order by c.customerNumber desc');
    
      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $post) {
     
        $list[] = new Post($post['customerNumber'],$post['customerName'], $post['email'], $post['address'], $post['city'], $post['country']);
      }

      return $list;
      
      
      
      
      
      
      
      
      
      
    }

    public static function find($id) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      if($id > 0){
      $req = $db->prepare('SELECT distinct c.customerNumber, c.customerName, c.email, c.address, c.city, c.state, c.postalCode, c.country FROM angularcode_customers c where c.customerNumber='.$id);
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $post = $req->fetch(PDO::FETCH_ASSOC);

      return ($post);
      }
     

     
     // $getOne=new Post($post['customerName'], $post['email'], $post['address'], $post['city'], $post['country']);
      //return $getOne;
    }
    
    public static function insert(){
    	$request = file_get_contents('php://input');
    	$customer = json_decode($request);
 
//     	$column_names = array('customerName', 'email', 'city', 'address', 'country');
//     	$keys = array_keys($customer);
    	
//     	$columns = '';
//     	$values = '';
//     	foreach($column_names as $desired_key){ // Check the customer received. If blank insert blank into the array.
//     		if(!in_array($desired_key, $keys)) {
//     			$$desired_key = '';
//     		}else{
//     			$$desired_key = $customer[$desired_key];
//     		}
//     		$columns = $columns.$desired_key.',';
//     		$values = $values."'".$$desired_key."',";
//     	}
		$data['customerName']=$customer->customerName;
		$data['email']=$customer->email;
		$data['city']=$customer->city;
		$data['address']=$customer->address;
		$data['country']=$customer->country;
    	$db = Db::getInstance();
    	$query = "INSERT INTO angularcode_customers(customerName, email, city, address, country) VALUES('{$data['customerName']}', '{$data['email']}','{$data['city']}','{$data['address']}','{$data['country']}')";
    	if(!empty($customer)){
    		$db->exec($query);
    		$success = array('status' => "Success", "msg" => "Customer Created Successfully.", "data" => $customer);
    		return $success;
    	}else{
    		return -1;
    	}
    
    }
    
    public static function insert1(){
    	$request = file_get_contents('php://input');
    	$customer = json_decode($request);
        $column_names = array('customerName', 'email', 'city', 'address', 'country');
        $data['customerName']=$customer->customerName;
        $data['email']=$customer->email;
        $data['city']=$customer->city;
        $data['address']=$customer->address;
        $data['country']=$customer->country;
    	$keys = array_keys($data);
    
		$columns = '';
		$values = '';
		foreach($column_names as $desired_key){ // Check the customer received. If blank insert blank into the array.
			if(!in_array($desired_key, $keys)) {
		   		$$desired_key = '';
			}else{
				$$desired_key = $customer->$desired_key;
			
			}
			
			$columns = $columns.$desired_key.',';
			$values = $values."'".$$desired_key."',";
		
		};
	
		$db = Db::getInstance();
		$query = "INSERT INTO angularcode_customers(".trim($columns,',').") VALUES(".trim($values,',').")";
    	if(!empty($customer)){
    		$db->exec($query);
    		$success = array('status' => "Success", "msg" => "Customer Created Successfully.", "data" => $customer);
    		return $success;
    	}else{
    		return -1;
    	}
    
    }   
    
  public static function object_array($obj){
	$ret = array();
	foreach($obj as $key =>$value){
		if(gettype($value) == 'array' || gettype($value) == 'object'){
			$ret[$key] = objtoarr($value);
		}
		else{
			$ret[$key] = $value;
		}
	}
	return $ret;
}
    
    public static function update(){
    	 $request=file_get_contents('php://input');
    	 $customer=json_decode($request);
    	 $column_names = array('customerName', 'email', 'city', 'address', 'country');
    	 $data['id']= $customer->id;    
    	 $str=$customer->customer;
    	 $a=self::object_array($str);
//     	 $a['customerName']=$str->customerName;
//     	 $a['email']=$str->email;
//     	 $a['city']=$str->city;
//     	 $a['address']=$str->address;
//     	 $a['country']=$str->country;
    	
    	 $keys = array_keys($a);
    	 
    
    	$columns = '';
    	$values = '';
    	$n='';
    	foreach($column_names as $desired_key){ // Check the customer received. If blank insert blank into the array.
    		if(!in_array($desired_key, $keys)) {
    			$$desired_key = '';
    		}else{
    			$$desired_key = $str->$desired_key;		
    		}
    		
    		//$n=$n.$$desired_key;
    		$columns = $columns.$desired_key."='".$$desired_key."',";
    	};
    
    	$db = Db::getInstance();
    	$query = "UPDATE angularcode_customers SET ".trim($columns,',')." WHERE customerNumber=".$data['id'];
    	if(!empty($customer)){
    		$db->exec($query);
    		$success = array('status' => "Success", "msg" => "Customer ".$data['id']." Updated Successfully.", "data" => $customer);
    		return $success;
    	}else
    		return -1;	// "No Content" status
    }
    
    public static function delete($id){
    	$db = Db::getInstance();
    	// we make sure $id is an integer
    	$id = intval($id);
    	if($id > 0){
    		$query="DELETE FROM angularcode_customers WHERE customerNumber = $id";
    		$r =$db->exec($query);
    		$success = array('status' => "Success", "msg" => "Successfully deleted one record.");
    		return $success;
    	}else
    		return -1;	// If no records "No Content" status
    }
    
  }
?>