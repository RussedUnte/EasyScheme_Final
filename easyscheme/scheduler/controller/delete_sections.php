<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids = $_POST['ids'];  // Get selected section IDs from the POST request

    // Check if any IDs are provided
    if (!empty($ids)) {
        // Start the transaction
        try {
            // Loop through each section ID and update the status
            foreach ($ids as $section_id) {
                // Prepare the data to be updated
                $data = array('status' => 1);
                
                // Prepare the where clause for the current section ID
                $whereClause = array('id' => $section_id);

                // Execute the update for the current section
                if (!$db->updateData('section', $data, $whereClause)) {
                    throw new Exception("Failed to update section with ID: $section_id");
                }
            }

            echo (200);
        } catch (Exception $e) {
            echo (500);
        }
    } else {
        echo (500);
    }
}
?>
