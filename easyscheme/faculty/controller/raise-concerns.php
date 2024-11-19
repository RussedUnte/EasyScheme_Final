<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();
if(isset($_POST['mode'])) {
    $mode = $_POST['mode'];

    if($mode == "Add") {
        if (isset($_POST["concern_title"],$_SESSION['id'], $_POST['concern_description'])) {

            $concern_title = $_POST['concern_title'];
            $concern_description = $_POST['concern_description'];
                    
            $data = array(
                'faculty_id' => $_SESSION['id'],
                'title' => $concern_title,
                'description' => $concern_description,
            );
                    
            if($db->insertData('concerns', $data)) {
                echo '200';
            } else {
                echo '403';
            }
        } else {
            echo '500';
        }
    } else if($mode == "Update") {
        if (isset($_POST["concern_title"], $_POST['concern_description'])) {

            $concern_title = $_POST['concern_title'];
            $concern_description = $_POST['concern_description'];
                    
            $data = array(
                'title' => $concern_title,
                'description' => $concern_description,
            );
            $whereClause = array(
                'faculty_id' => $_SESSION['id'],
                'id' => $_POST['id'],
            );
                    
            if($db->updateData('concerns', $data, $whereClause)) {
                echo '201';
            } else {
                echo '403';
            }
        } else {
            echo '500';
        }
    } else if($mode == "delete") {
        if (isset($_POST["id"])) {
                    
            $data = array(
                'status' => 1,
            );
            $whereClause = array(
                'faculty_id' => $_SESSION['id'],
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
} else {
    echo '500';
}
