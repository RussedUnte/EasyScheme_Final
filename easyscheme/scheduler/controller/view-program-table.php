<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

if(isset($_POST['mode']))
{
    $mode = $_POST['mode'];

    if($mode =="Add")
    {
        //Adding
        if (isset($_POST["program_name"])){

            $program_name = $_POST['program_name'];
            $institute = $_POST['institute'];
            $data = array(
                'program_name' =>$program_name,
                'institute' =>$institute,
            );
        
                if($db->insertData('program_details',$data)){
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
        
        if (isset($_POST["program_name"])){

            $program_name = $_POST['program_name'];
            $institute = $_POST['institute'];
            $data = array(
                'program_name' =>$program_name,
                'institute' =>$institute,
            );
            $whereClause = array(
                'id' => $edit_id
            );
        
                if($db->updateData('program_details',$data,$whereClause)){
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
        
                    if(($db->updateData('program_details',$data,$whereClause))){
                        echo '200';
                    }else{
                        echo '500';
                    }
                  
            }
    }
}
