<?php
include_once("jwt.php");

jwt_set_secret("William's super secret key that no one can guess");
jwt_set_payload(array("name" => "william", "age" => "50"), array("issuer"=>"cairnswm","subject"=>"jwt sample", "audience"=>"GITHub users","expiryperiod"=>2*60)); 
$jwt = jwt_token();
echo $jwt;
echo "<br/>";
echo "<br/>";
echo "<br/>";

?>