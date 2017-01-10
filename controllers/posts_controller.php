<?php
require "CommonController.php";
  class PostsController extends CommonController {
  	
  	public $task = "";
    public function index() {
      // we store all the posts in a variable
     // $results = Post::all();
     
   require_once('views/partials/index.html');
    }
     public function all(){
     	$results = Post::all();
     	
     $this->response($this->json($results), 200);
     	
     }
     
     public function getCustomer(){
     	if($this->get_request_method() != "GET"){
     		$this->response('',406);
     	}
     	$id = $_GET['id'];
  
       if($id>0){
       	$results = Post::find($_GET['id']);
       	
       	$this->response($this->json($results), 200);
       }else{
       	$this->response('',204);
       }
     }
     public function insertCustomer(){
     	if($this->get_request_method() != "POST"){
     		 
     		$this->response('',406);
     	}
     	$results = Post::insert1();
     
     	if($results!=-1){
     		$this->response($this->json($results), 200);
     	}else{
     		$this->response('',204);
     	}
     	
     
     }
     
     public function updateCustomer(){
     	if($this->get_request_method() != "POST"){
     		$this->response('',406);
     	}
     	$results = Post::update();
     	if($results!=-1){
     		$this->response($this->json($results), 200);
     	}else{
     		$this->response('',204);
     	}	
     }
     
   public function deleteCustomer(){
   	if($this->get_request_method() != "DELETE"){
    		$this->response('',406);
    	}
    	$id = $_GET['id'];
   	$results = Post::delete($id);
   	if($results!=-1){
   		$this->response($this->json($results), 200);
   	}else{
   		$this->response('',204);
   	}
   }  
    
    public function show() {
      // we expect a url of form ?controller=posts&action=show&id=x
      // without an id we just redirect to the error page as we need the post id to find it in the database
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $post = Post::find($_GET['id']);
      require_once('views/posts/show.php');
    }
    
    
    private function json($data){
    	if(is_array($data)){
    		return json_encode($data);
    	}
    }
    


  }
?>