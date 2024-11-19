<?php 
include 'components/header.php';
?>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">

<div class="flex justify-center sm:justify-end">
    <select id="filter-yearlevel" class="border-black m-2 border-2 rounded px-4 py-1">
        <option value="">Year-Level</option>
        <option value="1st Year">1st Year</option>
        <option value="2nd Year">2nd Year</option>
        <option value="3rd Year">3rd Year</option>
        <option value="4th Year">4th Year</option>
    </select>
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

<?php 
$rows = $db->getSchedules();

foreach ($rows as $row) {
    
    $schedule_id = $row['id'] ?? 'NULL';
    $exam_type = $row['exam_type'] ?? 'NULL';
    $semester = $row['semester'] ?? 'N/a';
    $year_level = ucwords($row['year_level']) ?? 'N/a';
    $school_year = $row['school_year'] ?? 'N/a';
    $program_id = $row['program_id'] ?? 'N/a';
    



    {

        // START SCHEDULE LOOP

        $where = [
            "year_level = '".$year_level."'",
            "program_id = '".$program_id."'"
        ];

        $fetchSections = $db->getAllRowsFromTableWhere("section",$where);

        if(count($fetchSections)>0)
        {
            foreach ($fetchSections as $section_row) {

                // START SECTION LOOP 
    
                $section_id = $section_row['id'];
                $section_program_id = $section_row['program_id'];
                $section_year_level = $section_row['year_level'];
                $section = $section_row['section'] ?? 'N/a';
                $institute_id = $db->getIdByColumnValue("program_details","id",$section_program_id,"institute");
    
                $program_name = $db->getIdByColumnValue("program_details","id",$section_program_id,"program_name");
                   
                echo ' <main class="w-full schedule_card p-6 pt-2" data-yearlevel="'.$section_year_level.'" data-institute="'.$institute_id.'" >
            
        <div class="w-full ">
            <div class="card bg-white shadow-md rounded-lg p-5">
                
              <h2 class="text-lg text-right font-semibold mb-0">
                    <a href="update-schedule.php?i='.$schedule_id.'"><i class="material-icons text-right">edit</i></a>
                </h2>
    
                <h2 class="text-lg text-center font-semibold mb-0">
                    '.$exam_type.' Examination Schedule
                </h2>
                <h2 class="text-lg text-center font-semibold mb-0">
                    '.ucwords($semester).' '.$school_year.'
                </h2>
                <h2 class="text-lg text-center font-semibold mb-0">
                    '.$year_level.' '.strtoupper($program_name).' Students
                </h2>
    
            <div class="overflow-scroll w-full my-4">
                <div class="table-responsive bg-black">
                    <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                        <thead>
                            <tr>
                            <td class="text-center bg-gray-400" colspan="6">'.ucwords($section).'</td>
                                <td class="text-center bg-gray-400" colspan="1">
                                    <a target="_blank" href="edit-schedule.php?e='.$schedule_id.'&i='.$section_id.'"><i class="material-icons p-3">edit</i></a>
                                </td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Code
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Title
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Date
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Time Start
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Time End
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Room
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Proctor
                                </th>
                            </tr>
                        </thead>
                        <tbody>'; 
    
                        //FETCHING SECTION COURSES OR TAKING SUBJECTS
    
                        $fetchSectionCourse = $db->getSectionCourse($section_id);
                        foreach ($fetchSectionCourse as $section_course_row) {
                            // START FECTH SECTION COURSE
    
                            // GETTING DETAILS
                            $title = strtoupper($section_course_row['title']) ?? 'x';
                            $code = strtoupper($section_course_row['code']) ?? 'x';
                            $course_id = strtoupper($section_course_row['id']) ?? 'x';
                            $title = ($section_course_row['title']) ?? '';
    
                            
                            $date = $db->getschedule_detail_column("date", $section_id, $course_id, $schedule_id) ?? 'Not set';
                            $time_start = $db->getschedule_detail_column("time_start", $section_id, $course_id, $schedule_id) ?? 'Not set';
                            $time_end = $db->getschedule_detail_column("time_end", $section_id, $course_id, $schedule_id) ?? 'Not set';
                            $room_id = $db->getschedule_detail_column("room_id", $section_id, $course_id, $schedule_id) ?? 'Not set';
                            $proctor_id = $db->getschedule_detail_column("proctor_id", $section_id, $course_id, $schedule_id) ?? 'Not set';
    
                            $room_name = ucwords($db->getIdByColumnValue("room","id",$room_id,"room_number") ?? 'Not set' ) ;
                            $proctor_name = ucwords($db->getIdByColumnValue("user","id",$proctor_id,"name") ?? 'Not set' ) ;
    
    
    
                            echo'
                                <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <td class="py-3 px-6 border-b whitespace-nowrap border-gray-300 text-gray-700">'.$code.'</td>
                                    <td class="py-3 px-6 border-b whitespace-nowrap border-gray-300 text-gray-700">'.ucwords($title).'</td>
                                    <td class="py-3 px-6 border-b whitespace-nowrap border-gray-300 ">
                                        <a href="#">'.$date.'</a>
                                    </td>
                                    <td class="py-3 px-6 border-b whitespace-nowrap border-gray-300 text-gray-700">'.convert24To12Hour($time_start).'</td>
                                    <td class="py-3 px-6 border-b whitespace-nowrap border-gray-300 text-gray-700">'.convert24To12Hour($time_end).'</td>
                                    <td class="py-3 px-6 border-b whitespace-nowrap border-gray-300 text-gray-700">'.$room_name.'</td>
                                    <td class="py-3 px-6 border-b whitespace-nowrap border-gray-300 text-gray-700">'.$proctor_name.'</td>
                                </tr>
                                ';
    
                            // END FETCH SECTION COURSE
    
    
                        }
    
                        {
                            echo '
                    </tbody>
                </table>
            </div>
        </div>
    
            
        </div>
    </div>
    </main>';
                        }
                // END INSIDE SECTION LOOP
            }
        }
        else
        {

            $institute_id = $db->getIdByColumnValue("program_details","id",$program_id,"institute");

            $program_name = $db->getIdByColumnValue("program_details","id",$program_id,"program_name");
            if(!isset($section_year_level)){
                continue;
            }
            
            echo ' <main class="w-full schedule_card p-6 pt-2" data-yearlevel="'.$section_year_level.'" data-institute="'.$institute_id.'" >
        <div class="w-full ">
            <div class="card bg-white shadow-md rounded-lg p-5">
                
                <h2 class="text-lg text-right font-semibold mb-0">
                    <a href="update-schedule.php?i='.$schedule_id.'"><i class="material-icons text-right">edit</i></a>
                </h2>
    
                <h2 class="text-lg text-center font-semibold mb-0">
                    '.$exam_type.' Examination Schedule
                </h2>
                <h2 class="text-lg text-center font-semibold mb-0">
                    '.ucwords($semester).' '.$school_year.'
                </h2>
                <h2 class="text-lg text-center font-semibold mb-0">
                    '.$year_level.' '.strtoupper($program_name).' Students
                </h2>
    
            <div class="overflow-scroll w-full my-4">
                <div class="table-responsive bg-black">
                    <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                        <thead>
                            <tr>
                            <td class="text-center bg-gray-400" colspan="6">'.ucwords($section).'</td>
                                <td class="text-center bg-gray-400" colspan="1">
                                    <a target="_blank" href="edit-schedule.php?e='.$schedule_id.'&i='.$section_id.'"><i class="material-icons p-3">edit</i></a>
                                </td>
                            </tr>
                            <tr>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Code
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Title
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Date
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Time Start
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Time End
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Room
                                </th>
                                <th class="py-3 px-2 whitespace-nowrap text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Proctor
                                </th>
                            </tr>
                        </thead>
                        <tbody>'; 
                            echo '
                            <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <td colspan=7 class="py-3 text-center px-6 border-b whitespace-nowrap border-gray-300 text-gray-700">No data</td>
                                    </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            
                    
                </div>
            </div>
            </main>';
        }
        

         // END SCHEDULE LOOP
    }
                    
                   




}
function convert24To12Hour($time24) {
    // Convert the time using the date() function
    return date("g:i A", strtotime($time24));
}
?>
           
<div class="flex items-center justify-center h-screen text-center">
    <p class="w-1/2 hidden text-red-500 bg-white border border-red-300 rounded-lg p-4 shadow-md" id="no-results">
        No results found.
    </p>
</div>


</div>

<?php 
include 'components/footer.php';
?>
<script>
    $('.nav-2').addClass('active-nav-link')
    $('.nav-2').addClass('opacity-100')
</script>

<script>
    $('#filter-yearlevel, #filter-institute').change(function(){
    var yearlevel_filter = $('#filter-yearlevel').val();
    var institute_filter = parseInt($('#filter-institute').val(), 10); // Convert to integer
    var cardsVisible = false; // Flag to check if any cards are visible

    $('.schedule_card').each(function(){
        var card_yearlevel = $(this).data('yearlevel');
        var card_institute = $(this).data('institute');
        console.log(card_institute)

        if ((yearlevel_filter === "" || yearlevel_filter === card_yearlevel) &&
            (institute_filter === "" || institute_filter === card_institute)) {
            $(this).show();
            cardsVisible = true; // Set flag to true if at least one card is visible
        } else {
            $(this).hide();
        }
    });

    // Display message if no cards are visible
    if (!cardsVisible) {
        $('#no-results').show(); // Show the "No results found" message
    } else {
        $('#no-results').hide(); // Hide the "No results found" message
    }
});

</script>