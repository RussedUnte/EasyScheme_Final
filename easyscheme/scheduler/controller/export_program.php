<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();


$rows = $db->getAllProgram();

if (count($rows) > 0) {
    // Set the headers to force download of the CSV file
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=program.csv');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Add the CSV column headers
    fputcsv($output, array('Program Name','Insititute'));

    // Add the data rows
    foreach ($rows as $row) {
        fputcsv($output, array($row['program_name'],$row['name']));
    }

    // Close the output stream
    fclose($output);
    exit();
} else {
    echo "No data found";
}
?>
