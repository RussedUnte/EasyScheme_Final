<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();
if(isset($_POST['mode']) && isset($_SESSION['id']) )
{
    $mode = $_POST['mode'];

     if($mode=="Save Changes" )
    {
        $user_id = $_SESSION['id'];
        $username = trim($_POST['username']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);
        $old_password = trim($_POST['old_password']);

        $password = $db->getIdByColumnValue("user","id",$user_id,"password");

        if($confirm_password==$new_password)
        {
            if(password_verify($old_password,$password))
            {
                $data = array(
                    'username' => $username,
                    'password' => password_hash($new_password,PASSWORD_DEFAULT),
                );
                $whereClause = array(
                    'id' => $user_id
                );
    
                if(($db->updateData('user',$data,$whereClause))){
                    echo '200';
                }else{
                    echo '999';
                }
            }else{
                echo '604';
            }
        }else{
            echo '605';
        }

    }
}
