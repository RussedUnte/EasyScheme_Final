<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

if(isset($_POST['mode']))
{
    $mode = $_POST['mode'];

    if($mode =="Add")
    {
        //Adding
        if (isset($_POST["title"])){

            $title = $_POST['title'];
            $code = $_POST['code'];
            $designation = $_POST['designation'];
            $program = $_POST['program'];

            $data = array(
                'title' =>$title,
                'code' =>$code,
                'program' =>$program,
                'designation' =>$designation,
            );
        
                if($db->insertData('course',$data)){
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
        
        if (isset($_POST["title"])){

            $title = $_POST['title'];
            $code = $_POST['code'];
            $designation = $_POST['designation'];
            $program = $_POST['program'];

            $data = array(
                'title' =>$title,
                'code' =>$code,
                'designation' =>$designation,
                'program' =>$program,
            );

            $whereClause = array(
                'id' => $edit_id
            );
        
                if($db->updateData('course',$data,$whereClause)){
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
        
                    if(($db->updateData('course',$data,$whereClause))){
                        echo '200';
                    }else{
                        echo '500';
                    }
                  
            }
    }
}
