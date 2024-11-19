<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

if(isset($_POST['mode']))
{
    $mode = $_POST['mode'];

    if($mode =="Add")
    {
        //Adding
        if (isset($_POST["program"])){

            $program_id = $_POST['program'];
            $section_name = $_POST['section_name'];
            $year_level = $_POST['year_level'];

                $data = array(
                    'section' => $section_name,
                    'year_level' =>$year_level,
                    'program_id' =>$program_id,
                );

                if($db->insertData2('section',$data)){
                    echo '200';
                }
                else
                {
                    echo 'Section is already in the database';
                }

                  
            }else{
                echo '500';
            }
    }else if($mode=="Edit")
    {

        
        //Adding
        if (isset($_POST["year_level"])){

            $section_id = $_POST["edit_id"];

            $program_id = $_POST['program'];
            $section_name = $_POST['section_name'];
            $year_level = $_POST['year_level'];

            $data = array(
                'section' => $section_name,
                'year_level' =>$year_level,
                'program_id' =>$program_id,
              );
                $whereClause = array(
                    'id' => $section_id
                );
        
                if($db->updateData('section',$data,$whereClause)){
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
        $section_id = $_POST["edit_id"];

        if ($section_id !=0){

            $data = array(
                'status' =>1,
            );

            $whereClause = array(
                'id' => $section_id
                );
        
                    if(($db->updateData('section',$data,$whereClause))){
                        echo '200';
                    }else{
                        echo '500';
                    }
                  
            }
    }
    
}
