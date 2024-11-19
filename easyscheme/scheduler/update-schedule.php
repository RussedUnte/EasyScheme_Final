<?php 
include 'components/header.php';
?>
<?php 
    if(isset($_GET['i']) && $_GET['i']!="")
    {
        $id = preg_replace('/\D/', '', $_GET['i']);
        $scheduleExists = $db->getIdByColumnValue("schedule", "id", $id, 'id');
        if($scheduleExists == "")
        {
            echo '
            <script>
                window.location.href="profile.php";
            </script>
            ';
        } else {
            // Fetch the existing schedule data
            $schoolyear = $db->getIdByColumnValue("schedule", "id", $id, 'school_year');
            $semester = $db->getIdByColumnValue("schedule", "id", $id, 'semester');
            $exam_type = $db->getIdByColumnValue("schedule", "id", $id, 'exam_type');
            $institute = $db->getIdByColumnValue("schedule", "id", $id, 'institute');
            $program = $db->getIdByColumnValue("schedule", "id", $id, 'program');
            $year_level = $db->getIdByColumnValue("schedule", "id", $id, 'year_level');
        }
    } else {
        echo '
        <script>
            window.location.href="profile.php";
        </script>
        ';
    }
?>
<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex justify-center items-center p-6">
        <div class="w-full sm:w-1/2">
            <div class="card bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg text-center font-semibold mb-4">Update Schedule</h2>
                <form id="formSubmit">
                    <input type="hidden" name="schedule_id" value="<?php echo $id; ?>">
                    <div class="flex flex-col gap-3 items-center mt-3">
                        <div class="grid w-full">
                            <p>Choose School Year :</p>
                            <select id="school_year" name="school_year" class="border-black border-2 rounded px-4">
                            <?php
                                for ($startYear = 2023; $startYear < 2100; $startYear++) {
                                    $endYear = $startYear + 1;
                                    $selected = ($schoolyear == "$startYear-$endYear") ? 'selected' : '';
                                    echo "<option value=\"$startYear-$endYear\" $selected>$startYear-$endYear</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="grid w-full">
                            <p>Choose Semester :</p>
                            <select id="semester" name="semester" class="border-black border-2 rounded px-4">
                                <option value="1st Semester" <?php echo ($semester == '1st Semester') ? 'selected' : ''; ?>>1st Semester</option>
                                <option value="2nd Semester" <?php echo ($semester == '2nd Semester') ? 'selected' : ''; ?>>2nd Semester</option>
                            </select>
                        </div>
                        <div class="grid w-full">
                            <p>Choose Exam Type :</p>
                            <select id="exam_type" name="exam_type" class="border-black border-2 rounded px-4">
                                <option value="Prelim" <?php echo ($exam_type == 'Prelim') ? 'selected' : ''; ?>>Prelim</option>
                                <option value="Midterm" <?php echo ($exam_type == 'Midterm') ? 'selected' : ''; ?>>Midterm</option>
                                <option value="Finals" <?php echo ($exam_type == 'Finals') ? 'selected' : ''; ?>>Finals</option>
                            </select>
                        </div>
                        <div class="grid w-full">
                            <p>Choose Institute :</p>
                            <select id="institute" name="institute" class="border-black border-2 rounded px-4 w-full">
                                <option value="">Choose Institute</option>
                                <?php 
                                $rows = $db->getAllRowsFromTable('institutes');
                                foreach ($rows as $row) {
                                    $selected = ($institute == $row['id']) ? 'selected' : '';
                                    echo '<option value="'.$row['id'].'" '.$selected.'>'.ucwords($row['name']).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="grid w-full">
                            <p>Choose Program :</p>
                            <select id="program" name="program" class="border-black border-2 rounded px-4 w-full">
                                <option value="">Choose Program</option>
                                <?php 
                                $rows = $db->getAllRowsFromTable('program_details');
                                foreach ($rows as $row) {
                                    $selected = ($program == $row['id']) ? 'selected' : '';
                                    $instituteId = $row['institute'];
                                    echo '<option data-institute="'.$instituteId.'" value="'.$row['id'].'" '.$selected.'>'.ucwords($row['program_name']).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="grid w-full">
                            <p>Choose Year-Level :</p>
                            <select id="year_level" name="year_level" class="border-black border-2 rounded px-4">
                                <option value="1st year" <?php echo ($year_level == '1st year') ? 'selected' : ''; ?>>1st year</option>
                                <option value="2nd year" <?php echo ($year_level == '2nd year') ? 'selected' : ''; ?>>2nd year</option>
                                <option value="3rd year" <?php echo ($year_level == '3rd year') ? 'selected' : ''; ?>>3rd year</option>
                                <option value="4th year" <?php echo ($year_level == '4th year') ? 'selected' : ''; ?>>4th year</option>
                            </select>
                        </div>
                        
                        <div class="w-full flex justify-between">
                            <button id="btnMode" class="bg-green-600 text-white rounded px-3 py-1">Update Schedule</button>
                            <button type="button" id="btnDelete" class="bg-red-600 text-white rounded px-3 py-1">Delete Schedule</button>
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
<script src="js/addForm.js"></script>
<script>
    action('controller/schedule.php'); // Adjusted to update controller
    $('.nav-1').addClass('active-nav-link');
    $('.nav-1').addClass('opacity-100');

    $('#program option').hide();
    $('#institute').change(function() {
        $('#program').val("");
        var id = $(this).val();
        $('#program option').each(function() {
            if($(this).data('institute') == id){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Delete button functionality
    $('#btnDelete').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'controller/delete_schedule.php',
                    type: 'POST',
                    data: { id: "<?php echo $id; ?>" },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The schedule has been deleted.',
                            'success'
                        ).then(() => {
                            window.location.href = 'profile.php';
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was an issue deleting the schedule.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
