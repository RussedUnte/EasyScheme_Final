<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();
if(isset($_POST['mode'],$_SESSION['id']))
{
    $mode = $_POST['mode'];

    if($mode =="Save Changes")
    {
        //Adding
        if (isset($_POST["school_year"])){

            $school_year = $_POST['school_year'];
            $semester = $_POST['semester'];
            $exam_type = $_POST['exam_type'];
            $institute = $_POST['institute'];
            $program = $_POST['program'];
            $year_level = $_POST['year_level'];

            $data = array(
                'school_year'=>$school_year,
                'semester' =>$semester,
                'exam_type' =>$exam_type,
                'institute' =>$institute,
                'program' =>$program,
                'year_level' =>$year_level,
            );
        
                if($db->insertData('schedule',$data)){
                        echo '200';
                }else{
                        echo '403';
                    }
                   
                  
            }else{
                echo '500';
            }
    }else if($mode =="Update Schedule")
    {
        //Adding
        if (isset($_POST["school_year"])){

            $school_year = $_POST['school_year'];
            $semester = $_POST['semester'];
            $exam_type = $_POST['exam_type'];
            $institute = $_POST['institute'];
            $program = $_POST['program'];
            $year_level = $_POST['year_level'];

            $data = array(
                'school_year'=>$school_year,
                'semester' =>$semester,
                'exam_type' =>$exam_type,
                'institute' =>$institute,
                'program' =>$program,
                'year_level' =>$year_level,
            );
            $where = array(
                'id' => $_POST['schedule_id']
            );
        
                if($db->updateData('schedule',$data,$where)){
                        echo '200';
                }else{
                        echo '403';
                    }
                   
                  
            }else{
                echo '500';
            }
    }
    
}
