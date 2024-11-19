<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();
if(isset($_POST['mode']))
{
    $mode = $_POST['mode'];

    if($mode =="Add")
    {
        //Adding
        if (isset($_POST["section"])){

            $section_id = $_POST['section_id'];
            $section_name = $_POST['section'];
            $course = $_POST['course_id'];

            $section_id = $db->getIdByColumnValue("section","section",$section_name,"id");

            $where = ["
            section_id='$section_id'
            ",
            "course_id='$course'"
        
        ];
            
            $sectionChecker= count($db->getAllRowsFromTableWhere("section_course",$where));
            //CHECKING IF NOT NULL IN SECTION FIRST
            if($section_id!="") 
            {
                if($sectionChecker==0)
                {
                    $data = array(
                        'section_id' =>$section_id,
                        'course_id' =>$course,
                    );
                    
                    if($db->insertData('section_course',$data)){
                        echo '200';
                    }else{
                        echo '403';
                    }
                }else{
                    echo '702';
                }
            }else{
                echo '701';
            }
            }else{
                echo '500';
            }
    }
    else if($mode=="Edit")
    {
        //Editing 
        $section_id = $_POST["section_id"];
        $section = $_POST["section"];
        $year_level = $_POST["year_level"];
        
        //Adding
        if (isset($_POST["year_level"])){

            $data = array(
                'section' =>$section,
            );
            $whereClause = array(
                'id' => $section_id
            );
        
                if($db->updateData('section_course',$data,$whereClause)){
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
        $section_course_id = $_POST["section_course_id"];

        if ($section_course_id !=0){

            $data = array(
                'status' =>1,
            );
            $whereClause = array(
                'id' => $section_course_id
                );
        
                    if(($db->updateData('section_course',$data,$whereClause))){
                        echo '200';
                    }else{
                        echo '500';
                    }
                  
            }
    }
}
