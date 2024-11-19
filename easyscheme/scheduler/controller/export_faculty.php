<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();


// Fetch the room data from the database
$rows = $db->getAllFaculty($_GET['id']);
$institute_name = $db->getIdByColumnValue('institutes','id',$_GET['id'],'name');


if (count($rows) > 0 && $institute_name!="") {
    // Set the headers to force download of the CSV file
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=faculty.csv');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Add the CSV column headers
    fputcsv($output, array('Salutations','Name','Status','Institute','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'));
   
    // Add the data rows
    foreach ($rows as $row) {

        $faculty_id = $row['user_id'];
        $scheduleMonday = $db->getIdByColumnValue('prof_schedule','user_id',$faculty_id,'monday');
        $scheduleTuesday = $db->getIdByColumnValue('prof_schedule','user_id',$faculty_id,'tuesday');
        $scheduleWednesday = $db->getIdByColumnValue('prof_schedule','user_id',$faculty_id,'wednesday');
        $scheduleThursday = $db->getIdByColumnValue('prof_schedule','user_id',$faculty_id,'thursday');
        $scheduleFriday = $db->getIdByColumnValue('prof_schedule','user_id',$faculty_id,'friday');
        $scheduleSaturday = $db->getIdByColumnValue('prof_schedule','user_id',$faculty_id,'saturday');
        $scheduleSunday = $db->getIdByColumnValue('prof_schedule','user_id',$faculty_id,'sunday');
    


        fputcsv($output, array($row['salutation'],$row['name'],$row['status'],$institute_name,$scheduleMonday,$scheduleTuesday,$scheduleWednesday,$scheduleThursday,$scheduleFriday,$scheduleSaturday,$scheduleSunday));
    }

    // Close the output stream
    fclose($output);
    exit();
} else {
    echo "No data found";
}
?>
