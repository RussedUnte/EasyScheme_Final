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
                                    Faculty Name
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Title
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Description
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $rows = $db->getAllRowsFromTable("concerns");
                               if(count($rows)>0){
                                    foreach ($rows as $row) {
                                    $title = $row['title'];
                                    $faculty_id = $row['faculty_id'];
                                    $faculty_name =ucwords( $db->getIdByColumnValue('user','id',$faculty_id,'name'));
                                    $description = $row['description'];
                                    $status = $row['concern_status'];
                                ?>
                                  <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200" data-id="<?php echo $row['id']; ?>">
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700"><?php echo $faculty_name; ?></td>
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700"><?php echo $title; ?></td>
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700"><?php echo $description; ?></td>
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">
                                        <select class="statusDropdown bg-white border rounded p-1" data-id="<?php echo $row['id']; ?>">
                                            <option value="Pending" <?php echo $status == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Resolved" <?php echo $status == 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                        </select>
                                    </td>
                                  </tr>
                               <?php }
                               } else{
                                echo '
                                <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200"">
                                        <td colspan="4"  class="text-center py-3 px-6 border-b border-gray-300 text-gray-700">
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

    // Handle status change
    $(document).on('change', '.statusDropdown', function() {
        var id = $(this).data('id');
        var status = $(this).val();

        Swal.fire({
            title: 'Are you sure?',
            text: `Change status to ${status}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'controller/raise-concerns.php',
                    method: 'POST',
                    data: { id: id, status: status, mode: 'updateStatus' },
                    success: function(response) {
                        Swal.fire(
                            'Updated!',
                            `The status has been changed to ${status}.`,
                            'success'
                        ).then(() => {
                            location.reload(); // Reloads the page to reflect changes
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update status.',
                        });
                    }
                });
            } else {
                location.reload(); // Revert the change visually if not confirmed
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

    $('.nav-10').addClass('active-nav-link');
    $('.nav-10').addClass('opacity-100');
});

</script>
