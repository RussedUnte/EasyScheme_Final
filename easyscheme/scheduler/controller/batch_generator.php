<?php
require '../../conn/conn.php';
$db = new DatabaseHandler();

if (isset($_POST['mode'], $_POST['yearlevel'], $_POST['batch_count'], $_POST['program_id']) && isset($_SESSION['id'])) {
    $mode = $_POST['mode'];

    if ($mode == "Create Batches Now") {
        $user_id = $_SESSION['id'];
        $year_level = $_POST['yearlevel'];
        $batch_count = (int) $_POST['batch_count']; // Ensure batch_count is an integer
        $program_id = $_POST['program_id'];

        // Fetch the program name and replace spaces with underscores
        $program_name = $db->getIdByColumnValue('program_details', 'id', $program_id, 'program_name');
        $institute_id = $db->getIdByColumnValue('program_details', 'id', $program_id, 'institute');
        $program_name = $program_name . ' ' . $year_level; // Program name with year level

        $current_date = date('Ymd'); // Current date for batch name uniqueness

        // Initialize batch arrays
        $batch_array = array_fill(0, $batch_count, []); // Create empty arrays for each batch
        $current_batch = 0; // Initialize the batch index

        // Prepare conditions to select sections
        $where_conditions = [
            'year_level' => $year_level,
            'program_id' => $program_id
        ];

        // Fetch sections based on year level and program id
        $sections = $db->getAllRowsFromTableWhereOrderBy('section', $where_conditions);

        // Distribute students into batches
        foreach ($sections as $section) {
            $section_id = $section['id'];

            $where_section = [
                'section' => $section_id
            ];

            $section_students = $db->getAllRowsFromTableWhereOrderBy('student_details', $where_section, 'name ASC');

            foreach ($section_students as $student) {
                $id = $student['id'];

                // Distribute student to the current batch
                $batch_array[$current_batch][] = $id;

                // Move to the next batch, cycling back to the first batch if needed
                $current_batch = ($current_batch + 1) % $batch_count;
            }
        }

        // Insert students into batches
        $inserted_count = 0;
        foreach ($batch_array as $batch_index => $student_ids) {
            $random_suffix = substr(bin2hex(random_bytes(4)), 0, 8); // Create random string
            $batch_name = $program_name  . ' Batch ' . ($batch_index + 1) .' #'.$random_suffix; // Batch name

            foreach ($student_ids as $student_id) {
                $data = [
                    'batch_name' => $batch_name,
                    'student_id' => $student_id,
                    'program_id' => $program_id,
                    'institute' => $institute_id,
                    'year_level' => $year_level
                ];

                // Insert student into the batch table
                if ($db->insertData('batch', $data)) {
                    $inserted_count++;
                }
            }
        }

        // Check if any records were inserted and return response
        if ($inserted_count > 0) {
            echo "802"; // Success
        } else {
            echo "803"; // Failure
        }

    } else {
        echo "Invalid mode selected.";
    }
} else {
    echo "Required parameters are missing.";
}
