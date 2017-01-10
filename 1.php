<?php 

echo "var testjson = ". urldecode(json_encode(array("fruit"=>array(array("apple"=>urlencode("苹果")),array("banana"=> urlencode ("香蕉"))))));?>