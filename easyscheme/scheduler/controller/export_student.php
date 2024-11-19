<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();


// Fetch the room data from the database
$rows = $db->getAllStudents($_GET['id']);

if (count($rows) > 0) {
    // Set the headers to force download of the CSV file
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=students.csv');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Add the CSV column headers
    fputcsv($output, array('Name','Student Number','Section'));

    // Add the data rows
    foreach ($rows as $row) {
        fputcsv($output, array($row['name'],$row['student_number'],$row['section_title']));
    }

    // Close the output stream
    fclose($output);
    exit();
} else {
    echo "No data found";
}
?>
