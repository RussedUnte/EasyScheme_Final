<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

if(isset($_POST['mode']))
{
    $mode = $_POST['mode'];

    if($mode =="Add")
    {
        //Adding
        if (isset($_POST["name"])){
            $name = preg_replace('/[^a-zA-Z\s]/', '', $_POST['name']);
            $password =strtolower(preg_replace('/[^a-zA-Z]/', '', $_POST["name"]));
            $data = array(
                'name' =>$name,
                'username' =>$password,            
                'password' => password_hash($password, PASSWORD_DEFAULT),         
                'position' => 'faculty'       
            );
        
            
                    if(!is_string($db->insertData('user',$data))){
                        $lastId = $db->getLastInsertId();
                
                        //User Details 
                        $details = array(
                            'user_id' => $lastId,            
                            'salutation' => $_POST["salutation"],            
                            'status' => $_POST["status"],    
                            'institute' => $_POST["institute"],    
                        );
                         //User Details 
                         $details_schedule = array(
                            'user_id' => $lastId,            
                        );
        
                        if($db->insertData('user_details',$details)){
                            if($db->insertData('prof_schedule',$details_schedule)){
                                echo '200';
                            }
                        }else{
                                // echo '403';
                            }
                    }else{
                        echo '500';
                    }
                  
            }
    }
    else if($mode=="Edit")
    {
        //Editing 
        $edit_id = $_POST["edit_user_id"];
        $edit_user_details_id = $_POST["edit_user_details_id"];
        
        if ($edit_id !=0 && $edit_user_details_id !=0){

            $name = preg_replace('/[^a-zA-Z\s]/', '', $_POST['name']);
            $data = array(
                'name' =>$name,
            );
            $whereClause = array(
                    'id' => $_POST['edit_user_id']
                );
        
            
                    if(($db->updateData('user',$data,$whereClause))){
                
                        //User Details 
                        $details = array(
                            'salutation' => $_POST["salutation"],            
                            'status' => $_POST["status"],    
                        );

                        $whereClause = array(
                            'id' => $_POST['edit_user_details_id']
                        );
        
                        if($db->updateData('user_details',$details,$whereClause)){
                                echo '200';
                        }else{
                                // echo '403';
                            }
                    }else{
                        echo '500';
                    }
                  
            }
    }

    else if($mode=="Delete")
    {
        //Soft Delete 
        $edit_id = $_POST["edit_user_id"];
        
        if ($edit_id !=0){

            $data = array(
                'status' =>1,
            );
            $whereClause = array(
                    'id' => $_POST['edit_user_id']
                );
        
            
                    if(($db->updateData('user',$data,$whereClause))){
                        echo '200';
                    }else{
                        echo '500';
                    }
                  
            }
    }
}
