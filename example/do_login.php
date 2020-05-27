<?php
session_start();
include_once "../jwt.php";

if(isset($_POST['do_login']))
{
    $host="localhost";
    $username="jwtexample";
    $password="jwtexample";
    $databasename="jwtexample";
    
    $db = mysqli_connect($host,$username,$password,$databasename);

    $email = $_POST['email'];
    $pass = $_POST['password'];
    
    $result = $db->query("select * from user where email='$email' and password='$pass'");
    if($row = $result->fetch_assoc()) {
        $_SESSION['email'] = $row['email'];
        jwt_set_secret("William's super secret key that no one can guess");
        jwt_set_payload(array("name" => "william", "age" => "50", "email" => $email)); 
        $jwt = jwt_token();
        echo '{ "result": "success", "jwt": "'.$jwt.'"}';
    } else {
        echo "fail";
    }
    exit();
}
?>