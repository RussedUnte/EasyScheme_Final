<?php 
include 'components/header.php';
?>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">

<div class="flex justify-center sm:justify-end">
    <!-- Year-Level Filter -->
    <select id="filter-yearlevel" class="border-black m-2 border-2 rounded px-4 py-1">
        <option value="">Year-Level</option>
        <option value="1st Year">1st Year</option>
        <option value="2nd Year">2nd Year</option>
        <option value="3rd Year">3rd Year</option>
        <option value="4th Year">4th Year</option>
    </select>
    
    <!-- Institute Filter -->
    <select id="filter-institute" class="border-black m-2 border-2 rounded px-4 py-1 w-1/2 sm:w-1/6">
        <option value="">Select Institute</option>
        <?php 
        $rows = $db->getAllRowsFromTable('institutes');
        foreach ($rows as $row) {
            echo '<option value="'.$row['id'].'">'.ucwords($row['name']).'</option>';
        }
        ?>
    </select>
</div>

<div class="flex items-center justify-center">
    <!-- No results message -->
    <p class="w-1/2 hidden text-red-500 bg-white border border-red-300 rounded-lg p-4 shadow-md" id="no-results">
        No results found.
    </p>
</div>

<?php 
$rows = $db->getSchedules();
$count = 0;

foreach ($rows as $row) {
    $schedule_id = $row['id'] ?? 'NULL';
    $exam_type = $row['exam_type'] ?? 'NULL';
    $semester = $row['semester'] ?? 'N/a';
    $year_level = ucwords($row['year_level']) ?? 'N/a';
    $school_year = $row['school_year'] ?? 'N/a';
    $program_id = $row['program_id'] ?? 'N/a';

    // Fetch proctor details
    $proctor_ids = $db->getAllRowsFromTableWhere('schedule_details',['proctor_id='.$_SESSION['id']]);
    $is_proctor = false;

    foreach ($proctor_ids as $proctor_table) {
        // Check if the current user is a proctor for this schedule
        if (!empty($proctor_table['proctor_id']) && $proctor_table['proctor_id'] == $_SESSION['id']) {
            $is_proctor = true;
            break;  // Exit loop if the user is assigned as a proctor
        }
    }

    // Skip the loop if the current user is not the proctor for this schedule
    if (!$is_proctor) {
        continue;
    }

    $count += 1;

    // Get sections for the current program and year level
    $where = [
        "year_level = '".$year_level."'",
        "program_id = '".$program_id."'"
    ];
    $fetchSections = $db->getAllRowsFromTableWhere("section", $where);

    if (count($fetchSections) > 0) {
        foreach ($fetchSections as $section_row) {
            // Section details
            $section_id = $section_row['id'];
            $section_program_id = $section_row['program_id'];
            $section_year_level = $section_row['year_level'];
            $section = $section_row['section'] ?? 'N/a';
            $institute_id = $db->getIdByColumnValue("program_details", "id", $section_program_id, "institute");
            $program_name = $db->getIdByColumnValue("program_details", "id", $section_program_id, "program_name");
            
            // Display the schedule
            echo ' 
            <main class="w-full schedule_card p-6 pt-2" data-yearlevel="'.$section_year_level.'" data-institute="'.$institute_id.'">
                <div class="w-full">
                    <div class="card bg-white shadow-md rounded-lg p-5">
                        <h2 class="text-lg text-center font-semibold mb-0">'.$exam_type.' Examination Schedule</h2>
                        <h2 class="text-lg text-center font-semibold mb-0">'.ucwords($semester).' '.$school_year.'</h2>
                        <h2 class="text-lg text-center font-semibold mb-0">'.$year_level.' '.strtoupper($program_name).' Students</h2>
                        
                        <div class="overflow-scroll w-full my-4">
                            <div class="table-responsive">
                                <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                                    <thead>
                                        <tr>
                                            <td class="text-center bg-gray-400" colspan="7">'.ucwords($section).'</td>
                                        </tr>
                                        <tr>
                                            <th class="py-3 px-2 text-left text-sm font-semibold text-gray-700 bg-gray-200 border-b">Course Code</th>
                                            <th class="py-3 px-2 text-left text-sm font-semibold text-gray-700 bg-gray-200 border-b">Course Title</th>
                                            <th class="py-3 px-2 text-left text-sm font-semibold text-gray-700 bg-gray-200 border-b">Date</th>
                                            <th class="py-3 px-2 text-left text-sm font-semibold text-gray-700 bg-gray-200 border-b">Time Start</th>
                                            <th class="py-3 px-2 text-left text-sm font-semibold text-gray-700 bg-gray-200 border-b">Time End</th>
                                            <th class="py-3 px-2 text-left text-sm font-semibold text-gray-700 bg-gray-200 border-b">Room</th>
                                            <th class="py-3 px-2 text-left text-sm font-semibold text-gray-700 bg-gray-200 border-b">Proctor</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

            // Fetch courses for each section
            $fetchSectionCourse = $db->getSectionCourse($section_id);
            foreach ($fetchSectionCourse as $section_course_row) {
                $code = strtoupper($section_course_row['code']) ?? 'x';
                $course_id = strtoupper($section_course_row['id']) ?? 'x';
                $title = $section_course_row['title'] ?? 'Introduction to Computer Science';

                $date = $db->getschedule_detail_column("date", $section_id, $course_id, $schedule_id) ?? 'Not set';
                $time_start = $db->getschedule_detail_column("time_start", $section_id, $course_id, $schedule_id) ?? 'Not set';
                $time_end = $db->getschedule_detail_column("time_end", $section_id, $course_id, $schedule_id) ?? 'Not set';
                $room_id = $db->getschedule_detail_column("room_id", $section_id, $course_id, $schedule_id) ?? 'Not set';
                $proctor_id = $db->getschedule_detail_column("proctor_id", $section_id, $course_id, $schedule_id) ?? 'Not set';

                $room_name = ucwords($db->getIdByColumnValue("room", "id", $room_id, "room_number") ?? 'Not set');
                $proctor_name = ucwords($db->getIdByColumnValue("user", "id", $proctor_id, "name") ?? 'Not set');

                // Display only if the course belongs to the current proctor
                if ($proctor_id == $_SESSION['id']) {
                    echo '
                    <tr class="bg-gray-50 hover:bg-gray-100 transition-colors">
                        <td class="py-3 px-6 border-b">'.$code.'</td>
                        <td class="py-3 px-6 border-b">'.$title.'</td>
                        <td class="py-3 px-6 border-b">'.$date.'</td>
                        <td class="py-3 px-6 border-b">'.convert24To12Hour($time_start).'</td>
                        <td class="py-3 px-6 border-b">'.convert24To12Hour($time_end).'</td>
                        <td class="py-3 px-6 border-b">'.$room_name.'</td>
                        <td class="py-3 px-6 border-b">'.$proctor_name.'</td>
                    </tr>';
                }
            }

            echo '
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>';
        }
    } else {
        // If no sections found, display a "No data" message
        echo '
        <main class="w-full schedule_card p-6 pt-2" data-yearlevel="'.$year_level.'" data-institute="'.$institute_id.'">
            <div class="w-full">
                <div class="card bg-white shadow-md rounded-lg p-5">
                    <h2 class="text-lg text-center font-semibold mb-0">'.$exam_type.' Examination Schedule</h2>
                    <h2 class="text-lg text-center font-semibold mb-0">'.ucwords($semester).' '.$school_year.'</h2>
                    <h2 class="text-lg text-center font-semibold mb-0">'.$year_level.' '.strtoupper($program_name).' Students</h2>

                    <div class="overflow-scroll w-full my-4">
                        <div class="table-responsive">
                            <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                                <thead>
                                    <tr>
                                        <td class="text-center bg-gray-400" colspan="7">'.ucwords($section).'</td>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>';
    }
}


function convert24To12Hour($time24) {
    // Convert the time using the date() function
    return date("g:i A", strtotime($time24));
}
?>
<?php include 'components/footer.php'; ?>

<!-- JavaScript for Filtering -->
<script>
$(document).ready(function() {
    // Initial check to hide empty schedule cards
    checkAndHideEmptyCards();

    // Add change event listeners for the filters
    $('#filter-yearlevel, #filter-institute').change(filterSchedules);

    function filterSchedules() {
        var yearlevel = $('#filter-yearlevel').val().toLowerCase();
        var institute = $('#filter-institute').val();
        var scheduleCards = $('.schedule_card');
        var found = false;

        // Iterate over each schedule card
        scheduleCards.each(function() {
            var card = $(this);
            var cardYearlevel = card.data('yearlevel').toLowerCase();
            var cardInstitute = card.data('institute').toString();

            var matchYearlevel = (yearlevel === '' || cardYearlevel === yearlevel);
            var matchInstitute = (institute === '' || cardInstitute === institute);

            // Check if the card matches the filters
            if (matchYearlevel && matchInstitute) {
                // Check if the card has any <td> elements
                var hasData = card.find('table tbody td').length > 0;

                // Show or hide the card based on data presence
                if (hasData) {
                    card.show();
                    found = true;
                } else {
                    card.hide();
                }
            } else {
                card.hide();
            }
        });

        // Show or hide the "No results" message
        $('#no-results').toggle(!found);
    }

    // Function to check and hide cards with no data on initial load
    function checkAndHideEmptyCards() {
        $('.schedule_card').each(function() {
            var hasData = $(this).find('table tbody td').length > 0;
            if (!hasData) {
                $(this).hide();
            }
        });
    }
});
</script>

