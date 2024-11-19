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
                    Concerns
                </h2>

                <!-- Responsive Table Wrapper -->
                <div class="overflow-scroll w-full my-4">
                    <div class="table-responsive ">
                        <!-- Table -->
                        <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Title
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Description
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Status
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $rows = $db->getAllRowsFromTableWhere("concerns",['faculty_id='.$_SESSION['id']]);

                               if(count($rows)>0){
                                    foreach ($rows as $row) {
                                    $title = $row['title'];
                                    $description = $row['description'];
                                    $status = $row['concern_status'];
                                ?>
                                    <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200" data-id="<?php echo $row['id']; ?>" >
                                        <td class="py-3 px-6 border-b border-gray-300 text-gray-700"><?php echo $title; ?></td>
                                        <td class="py-3 px-6 border-b border-gray-300 text-gray-700"><?php echo $description; ?></td>
                                        <td class="py-3 px-6 border-b border-gray-300 text-gray-700"><?php echo $status; ?></td>
                                        <td class="py-3 px-6 border-b border-gray-300">
                                            <i class="material-icons cursor-pointer editExamLink"
                                             data-id="<?php echo $row['id']; ?>"
                                             data-title="<?php echo $row['title']; ?>"
                                             data-description="<?php echo $row['description']; ?>"
                                             >edit</i>
                                            <i class="material-icons cursor-pointer deleteExamLink ml-2" 
                                            data-id="<?php echo $row['id']; ?>">delete</i>
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
        <h2 id="tltitle" class="text-xl font-semibold mb-4">Add Concern</h2>
        <form id="examLinkForm">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" id="concern_title" placeholder="Enter title" name="concern_title" class="w-full p-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Concern Description</label>
                <textarea id="concern_description" name="concern_description" placeholder="Enter Description" id="concern_description" class="w-full p-2 border rounded-lg"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2" id="cancelBtn">Cancel</button>
                <button type="button" id="btnSubmitConcern" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add</button>
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
        $('#tltitle').text("Add Concern");
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

    // Edit Concern
    $(document).on('click', '.editExamLink', function() {
        $('#tltitle').text("Edit Concern");
        var id = $(this).data('id');
        var title = $(this).data('title');
        var description = $(this).data('description');

        // Set the data in the form fields
        $('#concern_title').val(title); // Corrected to 'schedule_id'
        $('#concern_description').val(description);

        // Change button text to 'Update'
        $('#btnSubmitConcern').text('Update');

        // Show the modal
        $('#examLinkModal').removeClass('hidden');
        setTimeout(function() {
            $('#examLinkModal').addClass('show');
        }, 10);

        // Store the ID for submission
        $('#examLinkForm').data('id', id);
    });

    // Delete Concern
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
                    url: 'controller/raise-concerns.php',
                    method: 'POST',
                    data: { id: id, mode: 'delete' },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The Concern has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();  // Reloads the page after the alert is closed
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete Concern.',
                        });
                    }
                });
            }
        });
    });


    $('#btnSubmitConcern').on('click', function() {
        var concern_title = $('#concern_title').val();
        var concern_description = $('#concern_description').val();
        var id = $('#examLinkForm').data('id') || ''; 

        if (!concern_title || !concern_description) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please fill in all fields.',
            });
            return;
        }

        var mode = $(this).text(); // Get the mode (text of the button)
        var formData = $('#examLinkForm').serialize() + '&mode=' + encodeURIComponent(mode) + '&id=' + encodeURIComponent(id);
      

        $.ajax({
            url: 'controller/raise-concerns.php',
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
                    text: 'Failed to ' + (mode === 'Add' ? 'add' : 'update') + ' Concern.',
                });
            }
        });
    });

    $('.nav-4').addClass('active-nav-link');
    $('.nav-4').addClass('opacity-100');
});

</script>