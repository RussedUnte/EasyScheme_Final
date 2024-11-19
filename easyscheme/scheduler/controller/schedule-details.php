<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();
// echo '<pre>';
// var_dump($_POST);
function getAndCheckSchedules($db, $room_id, $date, $desired_time_start, $desired_time_end,$section_id,$course_id,$schedule_id)
{
    // GET SCHEDULES FOR THE GIVEN ROOM AND DATE
    $where = [
        "room_id = '".$room_id."'",
        "date = '".$date."'",
        "section_id != '".$section_id."'",
        
        // "schedule_id != '".$schedule_id."'",
    ];
    $fetchSchedule = $db->getAllRowsFromTableWhere("schedule_details", $where);

    // Early return if no schedules found
    if (empty($fetchSchedule)) {
        // var_dump($where);
        return true;
    } else {
        // Check for overlap with existing schedules
        foreach ($fetchSchedule as $schedules) {
            $time_start = $schedules['time_start'];
            $time_end = $schedules['time_end'];

            // Check if desired start time is within any existing schedule
            if (($desired_time_start >= $time_start && $desired_time_start < $time_end) ||
                ($desired_time_end > $time_start && $desired_time_end <= $time_end) ||
                ($desired_time_start <= $time_start && $desired_time_end >= $time_end)) {
                // Return conflict details
                return [
                    'existing_date' => $date,
                    'existing_time_start' => $time_start,
                    'existing_time_end' => $time_end,
                    'conflict' => true
                ];
            }
        }
    }

    return true; // No conflict found
}
function getProctorSchedule($db, $room_id, $date, $desired_time_start, $desired_time_end,$section_id,$proctor_id)
{
    // GET SCHEDULES FOR THE GIVEN ROOM AND DATE
    $where = [
        "date = '".$date."'",
        "section_id != '".$section_id."'",
        "proctor_id = '".$proctor_id."'",
        
        // "schedule_id != '".$schedule_id."'",
    ];
    $fetchSchedule = $db->getAllRowsFromTableWhere("schedule_details", $where);

    // Early return if no schedules found
    if (empty($fetchSchedule)) {
        // var_dump($where);
        return true;
    } else {
        // Check for overlap with existing schedules
        foreach ($fetchSchedule as $schedules) {
            $time_start = $schedules['time_start'];
            $time_end = $schedules['time_end'];

            // Check if desired start time is within any existing schedule
            if (($desired_time_start >= $time_start && $desired_time_start < $time_end) ||
                ($desired_time_end > $time_start && $desired_time_end <= $time_end) ||
                ($desired_time_start <= $time_start && $desired_time_end >= $time_end)) {
                // Return conflict details
                $proctor_name = ucwords($db->getIdByColumnValue('user','id',$proctor_id,'name'));

                return [
                    'proctor' => $proctor_name .' Has Already Scheduled',
                    'conflict' => true
                ];
            }
        }
    }

    return true; // No conflict found
}




if (isset($_POST['course_id'])) {
    // ARRAYS
    $array_schedule_id = $_POST['schedule_id'];
    $array_section_id = $_POST['section_id'];
    $array_course_id = $_POST['course_id'];
    $array_date = $_POST['date'];
    $array_time_start = $_POST['time_start'];
    $array_time_end = $_POST['time_end'];
    $array_room = $_POST['room'];
    $array_proctor = $_POST['proctor'];


    $_SESSION['conflicts'] = []; // Initialize the session array to store conflicts

    foreach ($array_course_id as $key => $course_id) {
        
        // PER ROW IN ARRAY FOR CHECKING
        $schedule_id = $array_schedule_id[$key];
        $section_id = $array_section_id[$key];
        $date = $array_date[$key];
        $time_start = $array_time_start[$key];
        $time_end = $array_time_end[$key];
        $room_id = $array_room[$key];
        $proctor_id = $array_proctor[$key];

        //Schedule Checker 
        $checker = getAndCheckSchedules($db,$room_id,$date,$time_start,$time_end,$section_id,$course_id,$schedule_id);


        $proctorChecker = getProctorSchedule($db, $room_id, $date, $time_start, $time_end,$section_id,$proctor_id);



        // If a conflict is found, add the conflict details to the session
        if (is_array($checker) && $checker['conflict']  ) {
            $_SESSION['conflicts'][] = [
                'desired_date' => $date,
                'desired_time_start' => $time_start,
                'desired_time_end' => $time_end,
                'existing_date' => $checker['existing_date'],
                'existing_time_start' => $checker['existing_time_start'],
                'existing_time_end' => $checker['existing_time_end'],
                'proctor' => $checker['proctor'],
            ];
        }

        // If a conflict is found, add the conflict details to the session
        if (is_array($proctorChecker) && $proctorChecker['conflict']  ) {
            $_SESSION['conflicts'][] = [
                'proctor' => $proctorChecker['proctor'],
            ];
        }
    }




    if (empty($_SESSION['conflicts'])) {

        // DELETE FIRST THE INSERTED ID IF MERON THEN PROCEED TO INSERT
        $schedule_id = $db->getschedule_detail_column("schedule_id", $array_section_id[0], $array_course_id[0], $array_schedule_id[0]) ;

        $section_id = $db->getschedule_detail_column("section_id", $array_section_id[0], $array_course_id[0], $array_schedule_id[0]) ;

        // Check if $id is set and not empty
        if (isset($schedule_id) && !empty($schedule_id) && isset($section_id) && !empty($section_id)) {
            // hardDelete if not empty
            $db->hardDelete($schedule_id,$section_id);
        }

        // THEN ADD

        // No conflicts found, proceed with the operation
        foreach ($array_course_id as $key => $course_id) {
            $schedule_id = $array_schedule_id[$key];
            $section_id = $array_section_id[$key];
            $date = $array_date[$key];
            $time_start = $array_time_start[$key];
            $time_end = $array_time_end[$key];
            $room_id = $array_room[$key];
            $proctor_id = $array_proctor[$key];
    
            $data = array(
                'schedule_id' => $schedule_id,
                'section_id' => $section_id,
                'course_id' => $course_id,
                'date' => $date,
                'time_start' => $time_start,
                'time_end' => $time_end,
                'room_id' => $room_id,
                'proctor_id' => $proctor_id,
            );
    
            $db->insertData('schedule_details', $data);
        }
        echo '200';

    } else {
        // Handle conflicts
        echo '101';
        echo json_encode($_SESSION['conflicts']);
    }
}
