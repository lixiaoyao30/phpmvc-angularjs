<?php
  function call($controller, $action) {
    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
      case 'pages':
        $controller = new PagesController();
      break;
      case 'posts':
        // we need the model to query the database later in the controller
        require_once('models/post.php');
        $controller = new PostsController();
      break;
    }
 
    $controller->{ $action }();
  }
//    $arr=array('a'=>['a1','a2'],'b'=>['b1','b2']);
//    $a='a';
//    if (array_key_exists($a, $arr)) {
   	
//    	print_r($arr);
//    }
// print_r('</br></br>');
  // we're adding an entry for the new controller and its actions
  $controllers = array('pages' => ['home', 'error'],
                       'posts' => ['index', 'show','all','getCustomer','json','insertCustomer','updateCustomer','deleteCustomer']);

 //  print_r($controllers);
   //print_r(array_key_exists($controller, $controllers));
  if (array_key_exists($controller, $controllers)) {
  	//print_r($action);
  	
    if (in_array($action, $controllers[$controller])) {
    	
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
?>