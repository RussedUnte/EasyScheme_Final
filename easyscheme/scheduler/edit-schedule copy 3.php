<?php 
include 'components/header.php';

function getRooms($db, $room_id) {
    // Fetch all rooms from the database
    $fetchRooms = $db->getAllRowsFromTable('room');
    $optionRoom = '';

    // Generate options for the dropdown
    foreach ($fetchRooms as $room_rows) {
        // Check if this room_id matches the one to be pre-selected
        $selected = ($room_rows['id'] == $room_id) ? 'selected' : '';
        $optionRoom .= "<option value='".$room_rows['id']."' $selected>".$room_rows['room_number']."</option>";
    }

    return $optionRoom;
}



function getProctor($db, $selected_proctor_id = null) {
    // Fetch all users from the database
    $fetchUsers = $db->getAllRowsFromTable('user');
    $optionProctor = '';

    // Generate options for the dropdown
    foreach ($fetchUsers as $user) {
        if ($user['position'] == "faculty") {
            $faculty_id = $user['id'];
            $scheduleMonday = $db->getIdByColumnValue('prof_schedule', 'user_id', $faculty_id, 'monday') ?: 'not available';
            $scheduleTuesday = $db->getIdByColumnValue('prof_schedule', 'user_id', $faculty_id, 'tuesday') ?: 'not available';
            $scheduleWednesday = $db->getIdByColumnValue('prof_schedule', 'user_id', $faculty_id, 'wednesday') ?: 'not available';
            $scheduleThursday = $db->getIdByColumnValue('prof_schedule', 'user_id', $faculty_id, 'thursday') ?: 'not available';
            $scheduleFriday = $db->getIdByColumnValue('prof_schedule', 'user_id', $faculty_id, 'friday') ?: 'not available';
            $scheduleSaturday = $db->getIdByColumnValue('prof_schedule', 'user_id', $faculty_id, 'saturday') ?: 'not available';
            $scheduleSunday = $db->getIdByColumnValue('prof_schedule', 'user_id', $faculty_id, 'sunday') ?: 'not available';

            // scheduleMonday example is 8:00AM - 5:00PM
            // scheduleTuesday example is not available
            // scheduleWednesday example is not available
            // scheduleThursday example is 8:00AM - 5:00PM
            // scheduleFriday example is 4:00PM - 5:00PM
            // scheduleSaturday example is 4:00PM - 5:00PM
            // scheduleSunday example is not available

            $data = '
            data-monday="'.$scheduleMonday.'"
            data-tuesday="'.$scheduleTuesday.'"
            data-wednesday="'.$scheduleWednesday.'"
            data-thursday="'.$scheduleThursday.'"
            data-friday="'.$scheduleFriday.'"
            data-saturday="'.$scheduleSaturday.'"
            data-sunday="'.$scheduleSunday.'"
            ';
            // Check if this user_id matches the one to be pre-selected
            $selected = ($user['id'] == $selected_proctor_id) ? 'selected' : '';
            $optionProctor .= "<option  $data value='".$faculty_id."' $selected>".$user['name']."</option>";
        }
    }

    return $optionProctor;
}

?>
<div class="w-full h-screen overflow-x-hidden border-t flex p-5 justify-center">
    <main class="w-full max-w-5xl">
        <div class="card bg-white shadow-md rounded-lg p-5 w-full">
            <p class="error text-red-600"></p>

            <form id="formSubmit">
            <div class="w-full my-4">
            <div class="overflow-scroll table-responsive ">
                <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full ">
                    <thead>
                        <tr>
                            <th class="py-3 whitespace-nowrap text-center  bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Course Code
                            </th>
                            <th class="py-3 whitespace-nowrap text-center  bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Date
                            </th>
                            <th class="py-3 whitespace-nowrap text-center  bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Time Start
                            </th>
                            <th class="py-3 whitespace-nowrap text-center  bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Time End
                            </th>
                            <th class="py-3 whitespace-nowrap text-center  bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Room
                            </th>
                            <th class="py-3 whitespace-nowrap text-center  bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Proctor
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php 
                            $section_id = $_GET['i'];
                            $schedule_id = $_GET['e'];

                            

                             $fetchSectionCourse = $db->getSectionCourse($section_id);

                             foreach ($fetchSectionCourse as $section_course_row) {
                                 // START FECTH SECTION COURSE
                                 $code = strtoupper($section_course_row['code']) ?? 'x';
                                 $course_id = strtoupper($section_course_row['id']) ?? 'x';
                                 $title = ($section_course_row['title']) ?? '';

                                 $date = $db->getschedule_detail_column("date", $section_id, $course_id, $schedule_id) ?? '';
                                 $time_start = $db->getschedule_detail_column("time_start", $section_id, $course_id, $schedule_id) ?? '';
                                 $time_end = $db->getschedule_detail_column("time_end", $section_id, $course_id, $schedule_id) ?? '';
                                 $room_id = $db->getschedule_detail_column("room_id", $section_id, $course_id, $schedule_id) ?? '';
                                 $proctor_id = $db->getschedule_detail_column("proctor_id", $section_id, $course_id, $schedule_id) ?? '';

                              
                                 $optionRoom = getRooms($db,$room_id);
                                 $optionProctor = getProctor($db,$proctor_id);


                                 echo'
                                 <input name="schedule_id[]" value="'.$schedule_id.'" hidden>
                                 <input name="course_id[]" value="'.$course_id.'" hidden>
                                 <input name="section_id[]" value="'.$section_id.'" hidden>
                                     <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                         <td class="py-3 text-center border-b border-gray-300 text-gray-700">'.$code.'</td>
                                         <td class="py-3 text-center border-b border-gray-300 ">
                                             <input type="date" name="date[]" value="'.$date.'" class="border-black dateChanger border-2 rounded px-2">
                                         </td>
                                         <td class="py-3 text-center border-b border-gray-300 text-gray-700">
                                         <input type="time" value="'.$time_start.'" name="time_start[]" class="time_start border-black border-2 rounded px-2">
                                         </td>
                                         <td class="py-3 text-center border-b border-gray-300 text-gray-700">
                                         <input type="time" value="'.$time_end.'" name="time_end[]" class="time_end border-black border-2 rounded px-2">
                                         </td>
                                         <td class="py-3 text-center border-b border-gray-300 text-gray-700">
                                         <select name="room[]" value="'.$room_id.'" class="border-black border-2 rounded px-2">
                                            <option value="">Select Room</option>
                                            '.$optionRoom.'
                                         </select>
                                         </td>
                                         <td class="py-3 text-center border-b border-gray-300 text-gray-700">
                                         <select name="proctor[]" class="border-black border-2 rounded px-2">
                                            <option value="">Select Proctor</option>
                                            '.$optionProctor.'
                                         </select>
                                         </td>
                                     </tr>
                                     ';
         
                                 // END FETCH SECTION COURSE
         
         
                             }
                            ?>
                           
                </tbody>
            </table>
            </div>
            <button id="btnMode" class="w-full sm:w-1/5 p-2 my-2 rounded-lg border hover:opacity-75 bg-green-700 text-white mx-auto block">Submit</button>

            </form>
           
        </div>
     
    </main>
</div>


<?php 
include 'components/footer.php';
?>
<script src="js/addForm.js"></script>
<script>
    action('controller/schedule-details.php')
    $('.nav-2').addClass('active-nav-link')
    $('.nav-2').addClass('opacity-100')
</script>
<script>
    function validateProctorAvailability() {
        let isValid = true;

        $('table tbody tr').each(function() {
            let date = $(this).find('input[type="date"]').val();
            let time_start = $(this).find('.time_start').val();
            let time_end = $(this).find('.time_end').val();
            let proctor_select = $(this).find('select[name="proctor[]"]');
            let selected_proctor = proctor_select.val();
            if (!date || !time_start || !time_end || !selected_proctor) {
                return;
            }

            // Check if the selected proctor is available on the chosen date and time range
            let proctor_option = proctor_select.find('option:selected');
            let day = new Date(date).toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();
            let proctor_schedule = proctor_option.data(day);

            if (proctor_schedule) {
                let [start_time, end_time] = proctor_schedule.split(' - ').map(t => new Date(`1970-01-01T${t}:00`).getTime());
                let start_check = new Date(`1970-01-01T${time_start}:00`).getTime();
                let end_check = new Date(`1970-01-01T${time_end}:00`).getTime();

                if (start_check < end_time && end_check > start_time) {
                    // Proctor is not available during the selected time
                    proctor_select.find('option[value="' + selected_proctor + '"]').hide();
                    $('.error').show().text('The selected proctor is not available during this time.');
                    $('#btnMode').hide();
                    isValid = false;
                } else {
                    proctor_select.find('option[value="' + selected_proctor + '"]').show();
                }
            } else {
                // Proctor is not scheduled on the selected date
                proctor_select.find('option[value="' + selected_proctor + '"]').hide();
                $('.error').show().text('The selected proctor is not available on this day.');
                $('#btnMode').hide();
                isValid = false;
            }
        });

        if (isValid) {
            $('.error').hide();
            $('#btnMode').show();
        }
    }


function filterProctorsByAvailability(date, row) {
    let proctor_select = row.find('select[name="proctor[]"]');
    let day = new Date(date).toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();
    // Iterate through proctor options to show/hide based on availability
    proctor_select.find('option').each(function() {
        let proctor_id = $(this).val();
        let proctor_schedule = $(this).data(day);

        if (proctor_schedule && proctor_schedule !== 'not available') {
            $(this).show();
        } else {
            $(this).hide();
        }
    });

    // Ensure "Select Proctor" option is always visible
    proctor_select.find('option[value=""]').show();
}


</script>


<script>
$('table tbody tr').each(function() {
    let date = $(this).find('input[type="date"]').val();
    let row = $(this); // Reference to the current row
    filterProctorsByAvailability(date, row); // Pass the row to the function
});
$('table tbody').on('change', 'tr .dateChanger', function() {
    let date = $(this).val();
    let row = $(this).closest('tr'); // Correctly reference the current row
    // Clear the selected proctor in the current row
    row.find('select[name="proctor[]"]').val('');
    filterProctorsByAvailability(date, row); // Pass the row to the function
});

</script>
<script>
$('table tbody tr').each(function() {
    let date = $(this).find('input[type="date"]').val();
    let row = $(this); // Reference to the current row
    filterProctorsByAvailability(date,row)
});
$(document).ready(function() {
    $('.error').hide();

    function validateTimeConflict(time_start_check, time_end_check, date_check, room_check, proctor_check) {
        let isConflict = false;
        // First, check if the time_start is not greater than time_end
        if (time_start_check >= time_end_check) {
            $('.error').show().text('Time Start must not be greater than Time End.');
            $('#btnMode').hide();
            return true; // Return true to indicate there's a conflict
        }

        $('table tbody tr').each(function() {

            let date = $(this).find('input[type="date"]').val();
            let time_start = $(this).find('.time_start').val();
            let time_end = $(this).find('.time_end').val();
            let room = $(this).find('select[name="room[]"]').val();
            let proctor = $(this).find('select[name="proctor[]"]').val();

            // Skip rows that don't have complete values or are empty
            if (!date || !time_start || !time_end || !room || !proctor) {
                return; // Skip this iteration if any value is missing
            }

            // Skip the current row if it matches the changed values exactly (i.e., no change)
            if (date === date_check && room === room_check && time_start === time_start_check && time_end === time_end_check && proctor === proctor_check) {
                return;
            }

            // Time conflict check: Check for conflicting times in the same room
            if (date === date_check && room === room_check) {
                if (
                    (time_start_check >= time_start && time_start_check < time_end) || 
                    (time_end_check > time_start && time_end_check <= time_end) ||
                    (time_start_check <= time_start && time_end_check >= time_end)
                ) {
                    $('.error').show().text('There is a conflict between schedules in the same room.');
                    $('#btnMode').hide();
                    isConflict = true;
                    return false; // Break the loop as we already found a conflict
                }
            }
            
            console.log(proctor_check)

            // Proctor conflict check: Check if the same proctor is assigned in overlapping time slots
            if (date === date_check && proctor === proctor_check) {
                if (
                    (time_start_check >= time_start && time_start_check < time_end) || 
                    (time_end_check > time_start && time_end_check <= time_end) ||
                    (time_start_check <= time_start && time_end_check >= time_end)
                ) {
                    $('.error').show().text('The selected proctor is already assigned to another schedule during this time.');
                    $('#btnMode').hide();
                    isConflict = true;
                    return false; // Break the loop as we already found a conflict
                }
            }
        });

        if (!isConflict) {
            $('.error').text('');
            $('.error').hide();
            $('#btnMode').show();
        }

        return isConflict;
    }

    // Detach any previous handlers and attach a new one
    $('.time_start, .time_end, input[type="date"], select[name="room[]"], select[name="proctor[]"]').off('change').on('change', function() {
        var time_start = $(this).closest('tr').find('.time_start').val();
        var time_end = $(this).closest('tr').find('.time_end').val();
        var date = $(this).closest('tr').find('input[type="date"]').val();
        var room = $(this).closest('tr').find('select[name="room[]"]').val();
        var proctor = $(this).closest('tr').find('select[name="proctor[]"]').val();
        validateTimeConflict(time_start, time_end, date, room, proctor);
    });
});


</script>


