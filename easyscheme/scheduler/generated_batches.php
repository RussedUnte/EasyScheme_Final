<?php 
include 'components/header.php';
if (!isset($_GET['i'])) {
    echo "<script>window.location.href='profile.php'</script>";
} else {
    $institute_id = htmlentities($_GET['i']);
}

// Fetch batches from the database
$batches = $db->getAllRowsFromTableWhereOrderBy('batch', ['institute' => $institute_id]);

// Group batches by batch_name and add year_level and program_id for filtering
$grouped_batches = [];
foreach ($batches as $batch) {
    $grouped_batches[$batch['batch_name']][] = $batch; // Group by batch name
}
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
        <select id="filter-program" class="border-black m-2 border-2 rounded px-4 py-1 w-1/2 sm:w-1/6">
            <option value="">Select Program</option>
            <?php 
            $rows = $db->getAllRowsFromTableWhereOrderBy('program_details', ['institute' => $institute_id]);
            foreach ($rows as $row) {
                echo '<option value="' . $row['id'] . '">' . ucwords($row['program_name']) . '</option>';
            }
            ?>
        </select>
    </div>

    <main class="w-full grid grid-cols-3 gap-x-2 p-6 pt-0">
        <div class="w-full col-span-3">
            <div class="card bg-white shadow-md rounded-lg p-5 mt-4">
                <h2 class="text-3xl font-bold text-center mb-6">Generated Batches</h2>

                <div class="flex justify-between items-center mb-4">
                    <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" id="delete-selected">
                        Delete Selected Batches
                    </button>
                </div>

                <!-- Mark All Checkbox -->
                <div class="flex justify-end items-center mb-4 mt-6">
                    <input type="checkbox" id="select-all" class="mr-2 rounded border-gray-300 focus:ring-red-500">
                    <label for="select-all" class="text-gray-700">Select All</label>
                </div>

                <?php if (empty($batches)): ?>
                    <div class="alert alert-warning text-center bg-yellow-100 text-yellow-800 border border-yellow-300 rounded-lg p-4 mb-4" role="alert">
                        No batches have been generated yet.
                    </div>
                <?php else: ?>
                    <?php foreach ($grouped_batches as $batch_name => $students): ?>
                        <div class="mt-8 batch" data-yearlevel="<?php echo htmlspecialchars($students[0]['year_level']); ?>" data-program="<?php echo htmlspecialchars($students[0]['program_id']); ?>">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-xl font-semibold"><?php echo htmlspecialchars($batch_name); ?></h4>
                                <input type="checkbox" class="select-batch" data-batch-name="<?php echo htmlspecialchars($batch_name); ?>">
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                                    <thead>
                                        <tr class="bg-gray-200">
                                            <th class="py-2 text-xs px-4 text-left text-gray-600">Student Name</th>
                                            <th class="py-2 text-xs px-4 text-left text-gray-600">Student Number</th>
                                            <th class="py-2 text-xs px-4 text-left text-gray-600">Section</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($students as $student): 
                                            $id = $student['student_id'];
                                            $student_number = $db->getIdByColumnValue('student_details', 'id', $id, 'student_number');
                                            $student_name = $db->getIdByColumnValue('student_details', 'id', $id, 'name');
                                            $student_section_id = $db->getIdByColumnValue('student_details', 'id', $id, 'section');
                                            $section_name = $db->getIdByColumnValue('section', 'id', $student_section_id, 'section');
                                        ?>
                                            <tr class="hover:bg-gray-100">
                                                <td class="py-2 px-4 border-b border-gray-300"><?php echo htmlspecialchars(ucwords($student_name)); ?></td>
                                                <td class="py-2 px-4 border-b border-gray-300"><?php echo htmlspecialchars(ucwords($student_number)); ?></td>
                                                <td class="py-2 px-4 border-b border-gray-300"><?php echo htmlspecialchars($section_name); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Handle delete selected button click
        $('#delete-selected').click(function() {
            const selectedBatches = [];
            $('.select-batch:checked').each(function() {
                selectedBatches.push($(this).data('batch-name'));
            });

            if (selectedBatches.length === 0) {
                Swal.fire('No batches selected', 'Please select at least one batch to delete.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!',
                cancelButtonText: 'No, keep them'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'controller/delete_batch.php',
                        type: 'POST',
                        data: { batch_names: selectedBatches },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Deleted!', 'The selected batches have been deleted.', 'success').then(() => {
                                    location.reload(); // Reload the page to see the changes
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'An error occurred while trying to delete the batches.', 'error');
                        }
                    });
                }
            });
        });

        // Mark All functionality
        $('#select-all').change(function() {
            const isChecked = $(this).is(':checked');
            $('.select-batch').prop('checked', isChecked);
        });

        // Filtering functionality
        $('#filter-yearlevel, #filter-program').change(function() {
            const yearLevel = $('#filter-yearlevel').val();
            const programId = $('#filter-program').val();

            $('.batch').each(function() {
                const batchYearLevel = $(this).data('yearlevel');
                const batchProgramId = $(this).data('program');

                // Check if the batch matches the filters
                const yearLevelMatch = yearLevel ? batchYearLevel === yearLevel : true;
                const programMatch = programId ? batchProgramId == programId : true;

                // Show or hide the batch based on the filter matches
                $(this).toggle(yearLevelMatch && programMatch);
            });
        });
    });
</script>

<?php 
include 'components/footer.php';
?>
