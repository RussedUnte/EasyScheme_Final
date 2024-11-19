<?php 
include 'components/header.php';
?>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex justify-center items-center p-6">
        <div class="w-full sm:w-1/2">
            <div class="card bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg text-center font-semibold mb-4">Create Schedule</h2>
                <form id="formSubmit">
                    <div class="flex flex-col gap-3 items-center mt-3">
                        <div class="grid w-full">
                            <p>Choose School Year :</p>
                            <select id="school_year" name="school_year" class="border-black border-2 rounded px-4">
                            <?php
                                for ($startYear = 2023; $startYear < 2100; $startYear++) {
                                    $endYear = $startYear + 1;
                                    echo "<option value=\"$startYear-$endYear\">$startYear-$endYear</option>";
                                }
                                ?>
                            </select>

                        </div>
                        <div class="grid w-full">
                            <p>Choose Semester :</p>
                            <select id="semester" name="semester" class="border-black border-2 rounded px-4">
                                <option value="1st Semester">1st Semester</option>
                                <option value="2nd Semester">2nd Semester</option>
                            </select>
                        </div>
                        <div class="grid w-full">
                            <p>Choose Exam Type :</p>
                            <select id="exam_type" name="exam_type" class="border-black border-2 rounded px-4">
                                <option value="Midterm">Midterm</option>
                                <option value="Finals">Finals</option>
                            </select>
                        </div>
                        <div class="grid w-full">
                            <p>Choose Institute :</p>
                            <select id="institute" name="institute" class="border-black border-2 rounded px-4 w-full">
                                <option value="">Choose Institute</option>
                                <?php 
                                $rows = $db->getAllRowsFromTable('institutes');
                                foreach ($rows as $row) {
                                    echo '<option value="'.$row['id'].'">'.ucwords($row['name']).'</option>';
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
                                    $institute = $row['institute'];
                                    echo '<option data-institute="'.$institute.'" value="'.$row['id'].'">'.ucwords($row['program_name']).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="grid w-full">
                            <p>Choose Year-Level :</p>
                            <select id="year_level" name="year_level" class="border-black border-2 rounded px-4">
                                <option value="1st year">1st year</option>
                                <option value="2nd year">2nd year</option>
                                <option value="3rd year">3rd year</option>
                                <option value="4th year">4th year</option>
                            </select>
                        </div>
                        
                        <div class="w-full">
                            <button id="btnMode" class="bg-green-600 text-white rounded px-3 py-1">Save Changes</button>
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
    action('controller/schedule.php')
    $('.nav-1').addClass('active-nav-link')
    $('.nav-1').addClass('opacity-100')
</script>
<script>
    $('#program option').hide()
    $('#institute').change(function() {
        $('#program').val("")
        var id = $(this).val();
        $('#program option').each(function() {
            if($(this).data('institute')==id){
                $(this).show()
            }else{
                $(this).hide()
            }
        });
});

</script>