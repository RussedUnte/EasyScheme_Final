<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();
if(isset($_POST['mode'])) {
    $mode = $_POST['mode'];

    if($mode == "Add") {
        if (isset($_POST["schedule_id"], $_POST['exam_link'])) {

            $schedule_id = $_POST['schedule_id'];
            $exam_link = $_POST['exam_link'];
            $exam_password = $_POST['exam_password'];
                    
            $data = array(
                'schedule_details_id' => $schedule_id,
                'link' => $exam_link,
                'password' => $exam_password,
            );
                    
            if($db->insertData('exam_links', $data)) {
                echo '200';
            } else {
                echo '403';
            }
        } else {
            echo '500';
        }
    } else if($mode == "Update") {
        if (isset($_POST["schedule_id"], $_POST['exam_link'])) {

            $link_id = $_POST['id'];
            $exam_link = $_POST['exam_link'];
            $schedule_id = $_POST['schedule_id'];
            $exam_password = $_POST['exam_password'];
                    
            $data = array(
                'schedule_details_id' => $schedule_id,
                'password' => $exam_password,
                'link' => $exam_link,
            );
            $whereClause = array(
                'id' => $link_id
            );
                    
            if($db->updateData('exam_links', $data, $whereClause)) {
                echo '200';
            } else {
                echo '403';
            }
        } else {
            echo '500';
        }
    } else if($mode == "delete") {
        if (isset($_POST["id"])) {
            $link_id = $_POST['id'];
                    
            if($db->hardDeleteExamLink($link_id)) {
                echo '200';
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
