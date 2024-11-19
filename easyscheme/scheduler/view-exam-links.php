<?php 
include 'components/header.php';
?>
<style>
    /* Initial state (hidden) */
    #examLinkModal {
        opacity: 0;
        transform: scale(0.95);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    /* Visible state (shown) */
    #examLinkModal.show {
        opacity: 1;
        transform: scale(1);
    }

</style>
<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">

    <main class="w-full  p-6 pt-2">
        
        <div class="w-full ">

            <div class="card bg-white shadow-md rounded-lg p-5 mt-4">

                <h2 class="text-lg text-right font-semibold mb-0">
                    <i class="material-icons bg-black text-white text-right cursor-pointer" id="addExamLink">add</i>
                </h2>

                <h2 class="text-lg text-center font-semibold mb-0">
                    Exam Links
                </h2>

                <!-- Responsive Table Wrapper -->
                <div class="overflow-scroll w-full my-4">
                    <div class="table-responsive ">
                        <!-- Table -->
                        <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Section
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Course Code
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Course Title
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Exam Link
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $rows = $db->getAllRowsFromTable("exam_links");

                               if(count($rows)>0){
                                    foreach ($rows as $row) {
                                    $schedule_details_id = $row['schedule_details_id'];
                                    $course_id = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"course_id"));
                                    $section_id = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"section_id"));
                                    $schedule_id = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"schedule_id"));
                                    $section_name = ($db->getIdByColumnValue("section","id",$section_id,"section"));

                                    $title = ucwords($db->getIdByColumnValue("course","id",$course_id,"title"));
                                    $code = strtoupper($db->getIdByColumnValue("course","id",$course_id,"code"));
                                    $exam_type = strtoupper($db->getIdByColumnValue("schedule","id",$schedule_id,"exam_type"));

                                    $link = $row['link'];
?>
                                    <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200" data-id="<?php echo $row['id']; ?>" data-course-code="<?php echo $code; ?>" data-course-title="<?php echo $title; ?>" data-link="<?php echo $link; ?>">
                                        <td class="py-3 px-6 border-b whitespace-nowrap border-gray-300 text-gray-700"><?php echo $exam_type.' - '. $section_name; ?></td>
                                        <td class="py-3 px-6 border-b border-gray-300 text-gray-700"><?php echo $code; ?></td>
                                        <td class="py-3 px-6 border-b border-gray-300 text-gray-700"><?php echo $title; ?></td>
                                        <td class="py-3 px-6 border-b border-gray-300 ">
                                            <a target="_blank" href="<?php echo $link; ?>"><?php echo $link; ?></a>
                                        </td>
                                        <td class="py-3 px-6 border-b border-gray-300">
                                            <i class="material-icons cursor-pointer editExamLink"
                                             data-course="<?php echo $row['schedule_details_id']; ?>" 
                                             data-id="<?php echo $row['id']; ?>"
                                             data-password="<?php echo $row['password']; ?>"
                                             >edit</i>
                                            <i class="material-icons cursor-pointer deleteExamLink ml-2" data-course="<?php echo $row['schedule_details_id']; ?>" data-id="<?php echo $row['id']; ?>">delete</i>
                                        </td>
                                    </tr>

                               <?php }
                               } else{
                                echo '
                                <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200"">
                                        <td colspan="9"  class="text-center py-3 px-6 border-b border-gray-300 text-gray-700">
                                            No data
                                        </td>
                                    </tr>
                                ';
                               }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>

<!-- Modal Structure -->
<div id="examLinkModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 id="tltitle" class="text-xl font-semibold mb-4">Add Exam Link</h2>
        <form id="examLinkForm">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                <select name="schedule_id" class="w-full p-2 border rounded-lg">
                    <option value="">Select Schedule</option>
                    <?php 
                    $courseRow = $db->getAllRowsFromTable('schedule_details');

                    foreach ($courseRow as $row) {
                        $id = $row['id'];
                        $schedule_id = $row['schedule_id'];
                        $section_id = $row['section_id'];
                        $course_id = $row['course_id'];

                        $section_name = strtoupper($db->getIdByColumnValue("section","id",$section_id,"section"));
                        $exam_type = strtoupper($db->getIdByColumnValue("schedule","id",$schedule_id,"exam_type"));
                       
                        $course_name = ucwords($db->getIdByColumnValue("course","id",$course_id,"title"));
                        echo '<option value="'.$id.'">'.$section_name.' - '.$course_name.' - '.$exam_type.'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Exam Link</label>
                <input type="text" placeholder="Enter Link" name="exam_link" class="w-full p-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Exam Password</label>
                <input type="text" placeholder="Enter Password" name="exam_password" class="w-full p-2 border rounded-lg">
            </div>

            <div class="flex justify-end">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2" id="cancelBtn">Cancel</button>
                <button type="button" id="btnSubmitLink" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add</button>
            </div>
        </form>
    </div>
</div>

<?php 
include 'components/footer.php';
?>
<script>
 $(document).ready(function() {
    // Show Modal with animation
    $('#addExamLink').on('click', function() {
        $('#tltitle').text("Add Exam Link");
        $('#examLinkForm')[0].reset(); // Clear the form
        $('#btnSubmitLink').text('Add'); // Set button text to 'Add'
        $('#examLinkModal').removeClass('hidden');
        setTimeout(function() {
            $('#examLinkModal').addClass('show');
        }, 10);
    });

    // Hide Modal with animation
    $('#cancelBtn').on('click', function() {
        $('#examLinkModal').removeClass('show');
        setTimeout(function() {
            $('#examLinkModal').addClass('hidden');
        }, 300);
    });

    // Edit Exam Link
    $(document).on('click', '.editExamLink', function() {
        $('#tltitle').text("Edit Exam Link");
        var id = $(this).data('id');
        var course = $(this).data('course');
        var password = $(this).data('password');
        var examLink = $(this).closest('tr').data('link');

        // Set the data in the form fields
        $('select[name="schedule_id"]').val(course); // Corrected to 'schedule_id'
        $('input[name="exam_link"]').val(examLink);
        $('input[name="exam_password"]').val(password);

        // Change button text to 'Update'
        $('#btnSubmitLink').text('Update');

        // Show the modal
        $('#examLinkModal').removeClass('hidden');
        setTimeout(function() {
            $('#examLinkModal').addClass('show');
        }, 10);

        // Store the ID for submission
        $('#examLinkForm').data('id', id);
    });

    // Delete Exam Link
    $(document).on('click', '.deleteExamLink', function() {
        var id = $(this).data('id');

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
                    url: 'controller/exam_link.php',
                    method: 'POST',
                    data: { id: id, mode: 'delete' },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The exam link has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();  // Reloads the page after the alert is closed
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete exam link.',
                        });
                    }
                });
            }
        });
    });


    $('#btnSubmitLink').on('click', function() {
        var courseCode = $('select[name="schedule_id"]').val(); // Corrected to 'schedule_id'
        var examLink = $('input[name="exam_link"]').val();
        var examPassword = $('input[name="exam_password"]').val();
        var id = $('#examLinkForm').data('id') || ''; 

        if (!courseCode || !examLink || !examPassword ) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please fill in all fields.',
            });
            return;
        }
        // var urlPattern = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([\/\w .-]*)*\/?$/i;

        // if (!urlPattern.test(examLink)) {
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Invalid Link',
        //         text: 'Please enter a valid URL for the exam link.',
        //     });
        //     return;
        // }

        var mode = $(this).text(); // Get the mode (text of the button)
        var formData = $('#examLinkForm').serialize() + '&mode=' + encodeURIComponent(mode) + '&id=' + encodeURIComponent(id);

        $.ajax({
            url: 'controller/exam_link.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: mode === 'Add' ? 'Added successfully' : 'Updated successfully',
                }).then(() => {
                    location.reload();  // Reloads the page after the alert is closed
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to ' + (mode === 'Add' ? 'add' : 'update') + ' exam link.',
                });
            }
        });
    });

    $('.nav-3').addClass('active-nav-link');
    $('.nav-3').addClass('opacity-100');
});

</script>