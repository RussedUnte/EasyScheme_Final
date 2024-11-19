<?php
require '../../conn/conn.php';
$db = new DatabaseHandler();

if (isset($_POST['mode']) && $_POST['mode'] == 'Save Changes' && isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $old_password = trim($_POST['old_password']);
    
    // Get stored password for the current user
    $stored_password = $db->getIdByColumnValue("user", "id", $user_id, "password");
    
    // Verify old password
    if (!password_verify($old_password, $stored_password)) {
        echo '604'; // Incorrect old password
        exit;
    }

    // Prepare the data for each day of the week
    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $scheduleData = [];
    
    foreach ($daysOfWeek as $day) {
        // Get start and end times for each day
        $start_time = $_POST[$day . '_start'] ?? '';
        $end_time = $_POST[$day . '_end'] ?? '';

        // Debugging print to check each day's start and end time
        error_log("Day: $day, Start: $start_time, End: $end_time");
        
        // Format each time to "h:iA" (e.g., "8:00AM") if provided
        if (!empty($start_time) && !empty($end_time)) {
            $start_formatted = date("g:iA", strtotime($start_time));
            $end_formatted = date("g:iA", strtotime($end_time));
            $scheduleData[$day] = "$start_formatted - $end_formatted";
        } else {
            $scheduleData[$day] = 'not available';
        }
    }

    // Update the schedule in the database
    $whereClause = ['user_id' => $user_id];
    if ($db->updateData('prof_schedule', $scheduleData, $whereClause)) {
        echo '200'; // Success
    } else {
        echo '999'; // Update failed
    }
} else {
    echo '605'; // Invalid request
}
