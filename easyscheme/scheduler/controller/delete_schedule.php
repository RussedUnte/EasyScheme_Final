<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

if(isset($_POST['id'],$_SESSION['id']))
{

            $schedule_id = $_POST['id'];

            $where = array(
                'schedule_id' =>$schedule_id,
            );
        
            if($db->hardDeleteScheduleDetails($schedule_id)){
                if($db->hardDeleteSchedule($schedule_id))
                {
                    echo 202;
                }else{
                    echo 500;
                }
            }else{
                echo 500;
            }
            
             
}
else{
    echo 500;
}