<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();


$rows = $db->getAllRowsFromTable('section');


if (count($rows) > 0) {
    // Set the headers to force download of the CSV file
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=section.csv');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Add the CSV column headers
    fputcsv($output, array('Program Name','Section Name','Year level'));

    // Add the data rows
    foreach ($rows as $row) {
        $program_name = $db->getIdByColumnValue('program_details','id',$row['program_id'],'program_name');
        fputcsv($output, array($program_name,$row['section'],$row['year_level']));
    }

    // Close the output stream
    fclose($output);
    exit();
} else {
    echo "No data found";
}
?>
