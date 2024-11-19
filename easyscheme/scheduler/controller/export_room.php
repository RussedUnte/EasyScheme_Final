<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();


// Fetch the room data from the database
$rows = $db->getAllRoom();

if (count($rows) > 0) {
    // Set the headers to force download of the CSV file
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=rooms.csv');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Add the CSV column headers
    fputcsv($output, array('Room Name'));

    // Add the data rows
    foreach ($rows as $row) {
        fputcsv($output, array($row['room_number']));
    }

    // Close the output stream
    fclose($output);
    exit();
} else {
    echo "No data found";
}
?>
