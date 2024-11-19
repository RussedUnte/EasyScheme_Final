<?php 
require '../conn/conn.php';
$db = new DatabaseHandler();

if($db->loginUser($_POST['username'],$_POST['password'])){
    echo '200';
}else{
    echo '404';
}
