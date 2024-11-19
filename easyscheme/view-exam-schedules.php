<?php 
include 'conn/conn.php';
$db = new DatabaseHandler();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyScheme</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> <!-- Include html2canvas -->
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: 'Karla', sans-serif;
        }

        .bg-sidebar {
            background: #3d68ff;
        }

        .cta-btn {
            color: #3d68ff;
        }

        .upgrade-btn {
            background: #1947ee;
        }

        .upgrade-btn:hover {
            background: #0038fd;
        }

        .active-nav-link {
            background: #1947ee;
        }

        .nav-item:hover {
            background: #1947ee;
        }

        .account-link:hover {
            background: #3d68ff;
        }

        .bg-body {
            background: #1e502d;
        }

        .bg-darkgreen {
            background: #1b4728;
        }

        .bg-orange {
            background: #f27c22;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body class="bg-body font-family-karla p-4">

    <p class="sm:text-right m-3 mt-0">
        <a href="login.php" class="w-2/5 px-3 py-2 hover:bg-orange-600 text-white font-bold rounded-full">Login</a>
    </p>
    <div class="flex items-center justify-center">
        <div class="flex flex-col items-center bg-white text-black rounded-lg sm:p-8 p-10 shadow-md sm:w-3/5 w-full">
            <img class="w-36 mb-0 p-0" src="assets/image/logo.png" alt="Logo">
            <h1 class="text-xl my-4 font-bold ">EasyScheme </h1>

            <input type="text" id="searchInput" placeholder="Search..." class="border px-2 py-1 text-gray-800 rounded border-gray-400 mb-4">

            <!-- Responsive Table Wrapper -->
            <div class="overflow-x-auto w-full">
                <div class="table-responsive overflow-hidden ">
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

                $isCurrentYear = date('Y') === substr($school_year, 0, 4) || date('Y') === substr($school_year, 5, 4);

                if($isCurrentYear != 1) {
                    continue;
                }

                echo ' <main class="w-full schedule_card p-6 pt-2" data-yearlevel="'.$section_year_level.'" data-institute="'.$institute_id.'" >
     
                    <div class="w-full ">


                    

                        <div class="card bg-white shadow-md rounded-lg p-5">

                     

                            <h2 class="text-lg text-center font-semibold mb-0">'.$exam_type.' Examination Schedule</h2>
                            <h2 class="text-lg text-center font-semibold mb-0">'.ucwords($semester).' '.$school_year.'</h2>
                            <h2 class="text-lg text-center font-semibold mb-0">'.$year_level.' '.strtoupper($program_name).' Students</h2>
    
                            <div class="overflow-scroll w-full my-4">
                                <div class="table-responsive ">
                                    <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                                        <thead>
                                            <tr>
                                                <td class="text-center bg-gray-400" colspan="7">'.ucwords($section).'</td>
                                            </tr>
                                            <tr>
                                                <th class="py-3 px-2 text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                                    Course Code
                                                </th>
                                                <th class="py-3 px-2 text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                                    Course Title
                                                </th>
                                                <th class="py-3 px-2 text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                                    Date
                                                </th>
                                                <th class="py-3 px-2 text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                                    Time Start
                                                </th>
                                                <th class="py-3 px-2 text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                                    Time End
                                                </th>
                                                <th class="py-3 px-2 text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                                    Room
                                                </th>
                                                <th class="py-3 px-2 text-center bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                                    Proctor
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>'; 
    
                        //FETCHING SECTION COURSES OR TAKING SUBJECTS
                        $fetchSectionCourse = $db->getSectionCourse($section_id);
                        $count = 0; //counter

                        foreach ($fetchSectionCourse as $section_course_row) {
                            // START FETCH SECTION COURSE
                            // GETTING DETAILS
                            $code = strtoupper($section_course_row['code']) ?? 'x';
                            $course_id = strtoupper($section_course_row['id']) ?? 'x';
                            $title = ($section_course_row['title']) ?? '';

                            $date = $db->getschedule_detail_column("date", $section_id, $course_id, $schedule_id) ?? 'Not set';

                            if($date != "Not set") {
                                $Date = new DateTime($date);
                                // Get the current date
                                $currentDate = (new DateTime())->modify('-1 day');
                                // Compare input date with current date
                                if ($currentDate > $Date) {
                                    continue;
                                }
                            } else {
                                continue;
                            }
                            $count++;

                            $time_start = $db->getschedule_detail_column("time_start", $section_id, $course_id, $schedule_id) ?? 'Not set';
                            $time_end = $db->getschedule_detail_column("time_end", $section_id, $course_id, $schedule_id) ?? 'Not set';
                            $room_id = $db->getschedule_detail_column("room_id", $section_id, $course_id, $schedule_id) ?? 'Not set';
                            $proctor_id = $db->getschedule_detail_column("proctor_id", $section_id, $course_id, $schedule_id) ?? 'Not set';

                            $room_name = ucwords($db->getIdByColumnValue("rooms","id",$room_id,"room_number") ?? 'Not set' ) ;
                            $proctor_name = ucwords($db->getIdByColumnValue("user","id",$proctor_id,"name") ?? 'Not set' ) ;

                            $room_name = ucwords($db->getIdByColumnValue("room","id",$room_id,"room_number") ?? 'Not set' ) ;
                            $proctor_name = ucwords($db->getIdByColumnValue("user","id",$proctor_id,"name") ?? 'Not set' ) ;

                            echo'
                                <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.$code.'</td>
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">Introduction to Computer Science</td>
                                    <td class="py-3 px-6 border-b border-gray-300 ">
                                        <a href="#">'.$date.'</a>
                                    </td>
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.convert24To12Hour($time_start).'</td>
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.convert24To12Hour($time_end).'</td>
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.$room_name.'</td>
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.$proctor_name.'</td>
                                </tr>
                                ';
    
                            // END FETCH SECTION COURSE
                        }
                        if($count==0) {
                            echo'
                                <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <td colspan="8" class="py-3 text-center px-6 border-b border-gray-300 text-gray-700">No scheduled examination yet.</td>
                                </tr>
                                ';
                        }

                        {
                            echo '
                    </tbody>
                </table>
            </div>
            
        </div>
             <div class="flex justify-end mt-4">
    <button class="save-image-btn flex items-center bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out" onclick="saveTableImage(this)">
        <i class="material-icons mr-2">download</i>
        Save Image
    </button>
</div>

       

        </div>
    </div>
    </main>';
                        }
                // END INSIDE SECTION LOOP
            }
        }
         // END SCHEDULE LOOP
    }

}

function convert24To12Hour($time24) {
    // Convert the time using the date() function
    return date("g:i A", strtotime($time24));
}
?>  

                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script>
        $(document).ready(function(){
        $('#searchInput').on('input', function(){
            var query = $(this).val().toLowerCase(); // Get the search query and convert to lowercase

            // Loop through all schedule cards
            $('.schedule_card').each(function(){
                var scheduleCard = $(this);
                var match = false;

                // Check the section name for a match
                var sectionName = scheduleCard.find('thead td[colspan="7"]').text().toLowerCase();
                if(sectionName.indexOf(query) !== -1) {
                    match = true;
                } else {
                    // Loop through all table rows within this schedule card
                    scheduleCard.find('tbody tr').each(function(){
                        var row = $(this);
                        var rowMatch = false;

                        // Check each cell in the row for a match
                        row.find('td').each(function(){
                            var cell = $(this).text().toLowerCase();
                            if(cell.indexOf(query) !== -1){
                                rowMatch = true;
                                return false; // Stop checking cells if a match is found
                            }
                        });

                        // Show or hide the row based on whether a match was found in this row
                        row.toggle(rowMatch);

                        // If any row matches within this schedule card, set match to true
                        if(rowMatch) {
                            match = true;
                        }
                    });
                }

                // Show or hide the entire schedule card based on whether a match was found
                scheduleCard.toggle(match);
            });
        });
    });


    function saveTableImage(button) {
        const table = $(button).closest('main').find('table')[0]; // Find the closest table to the button

        // Use html2canvas to capture the table and download it as an image
        html2canvas(table, { 
            useCORS: true, // Enable CORS
            allowTaint: true, // Allow tainted images
            scale: 2 // Increase scale for better quality
        }).then(canvas => {
            // Create a link to download the image
            const link = document.createElement('a');
            link.href = canvas.toDataURL("image/png");
            link.download = 'schedule_image.png'; // Set the desired image name
            link.click();
        });
    }
</script>
