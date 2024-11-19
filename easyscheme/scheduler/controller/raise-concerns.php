<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();
if(isset($_POST['mode'],$_POST['status'])) {
    $mode = $_POST['status'];

        if (isset($_POST["id"])) {
                    
            $data = array(
                'concern_status' => $mode,
            );
            $whereClause = array(
                'id' => $_POST['id'],
            );
                    
            if($db->updateData('concerns', $data, $whereClause)) {
                echo '202';
            } else {
                echo '403';
            }
        } else {
            echo '500';
        }
} else {
    echo '500';
}
