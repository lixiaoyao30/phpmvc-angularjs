<?php
require_once("Rest.inc.php");
  class Db extends REST{
    private static $instance = NULL;
    public $data = "";
    
    const DB_SERVER = "127.0.0.1";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB = "angularcode_customer";
    
    public function __construct() {
    	
    	parent::__construct();
    	
    }

    private function __clone() {}

    public static function getInstance() {
      if (!isset(self::$instance)) {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        self::$instance = new PDO('mysql:host='.self::DB_SERVER.';dbname='.self::DB, self::DB_USER, self::DB_PASSWORD, $pdo_options);
      }
      return self::$instance;
    }
  }
?>