<?php 
include 'components/header.php';

$prof_schedule = $db->getAllColumnsByColumnValue('prof_schedule', 'user_id', $_SESSION['id']);

// Function to split and format the schedule times
function getScheduleTimes($schedule) {
    // Check if the schedule string contains ' - ' delimiter
    if ($schedule && strpos($schedule, ' - ') !== false) {
        list($start, $end) = explode(' - ', $schedule);
        return [
            'start' => date("H:i", strtotime($start)),  // Convert to 24-hour format
            'end' => date("H:i", strtotime($end))
        ];
    }
    // Return empty values if schedule is not valid
    return ['start' => '', 'end' => ''];
}

$daysOfWeek = [
    'Monday' => getScheduleTimes($prof_schedule['monday'] ?? ''),
    'Tuesday' => getScheduleTimes($prof_schedule['tuesday'] ?? ''),
    'Wednesday' => getScheduleTimes($prof_schedule['wednesday'] ?? ''),
    'Thursday' => getScheduleTimes($prof_schedule['thursday'] ?? ''),
    'Friday' => getScheduleTimes($prof_schedule['friday'] ?? ''),
    'Saturday' => getScheduleTimes($prof_schedule['saturday'] ?? ''),
    'Sunday' => getScheduleTimes($prof_schedule['sunday'] ?? ''),
];

?>

<!-- HTML for the Schedule Form -->
<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex justify-center items-center p-6">
        <div class="w-full sm:w-1/2 lg:w-1/3">
            <div class="card bg-white shadow-lg rounded-lg p-8">
                <h2 class="text-2xl text-center font-semibold mb-6">Update My Schedule</h2>
                <form id="formSubmit">
                    <div class="flex flex-col gap-5">
                        <?php
                        foreach ($daysOfWeek as $day => $times) {
                            echo "
                            <div class='grid w-full mb-4'>
                                <p class='text-gray-700 font-medium'>$day</p>
                                <label class='text-sm text-gray-500'>Start Time</label>
                                <input type='time' name='{$day}_start' value='{$times['start']}' class='border-gray-300 border rounded px-3 py-2'>
                                <label class='text-sm text-gray-500 mt-2'>End Time</label>
                                <input type='time' name='{$day}_end' value='{$times['end']}' class='border-gray-300 border rounded px-3 py-2'>
                            </div>";
                        }
                        ?>
                        <div class="grid w-full mt-4">
                            <p class="text-gray-700 font-medium">Enter password to save changes</p>
                            <input type="password" name="old_password" placeholder="Type password" class="border-gray-300 border-2 rounded px-4 py-2">
                        </div>
                        <div class="w-full mt-6">
                            <button type="submit" id="btnMode" class="bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg px-4 py-2 w-full">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php 
include 'components/footer.php';
?>

<!-- Include SweetAlert2 from CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/addForm.js"></script>
<script>
    $('.nav-5').addClass('active-nav-link');
    $('.nav-5').addClass('opacity-100');

    $('#formSubmit').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'controller/edit-my-schedule.php',
            method: 'POST',
            data: $(this).serialize() + '&mode=Save Changes',
            success: function(response) {
                if (response == '200') {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Schedule updated successfully!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                } else if (response == '604') {
                    Swal.fire({
                        title: 'Incorrect Password',
                        text: 'The old password you entered is incorrect.',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Try Again'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Server Error',
                    text: 'Could not connect to the server. Please try again later.',
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
