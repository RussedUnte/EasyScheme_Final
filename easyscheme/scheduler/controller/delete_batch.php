<?php
require '../../conn/conn.php';
$db = new DatabaseHandler();

// Check if the batch names are set in the POST request
if (isset($_POST['batch_names']) && is_array($_POST['batch_names'])) {
    $batch_names = $_POST['batch_names'];
    $response = ['success' => false, 'message' => ''];

    try {
        foreach ($batch_names as $batch_name) {
            // Delete the batch from the database based on the batch name
            $where_conditions = ['batch_name' => $batch_name];
            $db->deleteData('batch', $where_conditions);
        }

        $response['success'] = true;
        $response['message'] = 'Batches deleted successfully.';
    } catch (Exception $e) {
        $response['message'] = 'Error deleting batches: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'No batch names were provided.';
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
