<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

if(isset($_POST['mode']))
{
    $mode = $_POST['mode'];

    if($mode =="Add")
    {
        //Adding
        if (isset($_POST["room"])){

            $room = $_POST['room'];
            $data = array(
                'room_number' =>$room,
            );
        
                if($db->insertData('room',$data)){
                        echo '200';
                }else{
                        echo '403';
                    }
                   
                  
            }else{
                echo '500';
            }
    }
    else if($mode=="Edit")
    {
        //Editing 
        $edit_id = $_POST["edit_id"];
        
        //Adding
        if (isset($_POST["room"])){

            $room = $_POST['room'];
            $data = array(
                'room_number' =>$room,
            );
            $whereClause = array(
                'id' => $edit_id
            );
        
                if($db->updateData('room',$data,$whereClause)){
                        echo '200';
                }else{
                        echo '403';
                    }
                   
                  
            }else{
                echo '500';
            }
    }

    else if($mode=="Delete")
    {
        //Soft Delete 
        $edit_id = $_POST["edit_id"];
        
        if ($edit_id !=0){

            $data = array(
                'status' =>1,
            );
            $whereClause = array(
                'id' => $edit_id
                );
        
                    if(($db->updateData('room',$data,$whereClause))){
                        echo '200';
                    }else{
                        echo '500';
                    }
                  
            }
    }
}
