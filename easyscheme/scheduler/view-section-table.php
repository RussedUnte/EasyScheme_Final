<?php 
include 'components/header.php';
?>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">

    <main class="w-full grid grid-cols-3 gap-x-5 p-6 pt-2">
        
        <div class="w-full col-span-3 lg:col-span-2">

                
            <div class="card bg-white shadow-md rounded-lg p-5 mt-4">

                <p class="text-right">
                <input type="text" placeholder="Search" id="searchInput" class="border px-2 py-1 text-gray-800 rounded border-gray-400 mb-4">
                </p>
                <button id="bulkDeleteBtn" class="bg-red-600 text-white rounded px-3 py-1 hidden">
    Delete Selected
</button>

                    <!-- Responsive Table Wrapper -->
                <div class="overflow-scroll w-full my-4">
                    <div class="table-responsive bg-black">
                        <!-- Table -->
                        <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                        <thead>
                            
    <tr>
        <th>
            <input type="checkbox" id="selectAll"> <!-- Master Checkbox -->
        </th>
        <th onclick="sortTable(1)" class="cursor-pointer py-3 whitespace-nowrap px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
            Program Name &#9650;
        </th>
        <th class="py-3 whitespace-nowrap px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
            Section Name
        </th>
        <th onclick="sortTable(3)" class="cursor-pointer py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
            Year level &#9650;
        </th>
        <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
            Action
        </th>
    </tr>
</thead>

<tbody>
    <?php 
    $rows = $db->getAllRowsFromTable('section');

    if(count($rows)>0) {
        foreach ($rows as $row) {
            $id = ucwords($row['id']);
            $section = ucwords($row['section']);
            $year_level = ucwords($row['year_level']);
            $program_id = ucwords($row['program_id']);

            $program_name = $db->getIdByColumnValue("program_details","id",$program_id,"program_name");

            //for datas
            $data = "
                data-id = '$id' 
                data-section = '$section' 
                data-year_level = '$year_level' 
                data-program_id = '$program_id' 
                ";
                
            echo '<tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                <td class="py-3 text-center px-6 border-b border-gray-300 text-gray-700">
                    <input type="checkbox" class="rowCheckbox" value="'.$id.'">
                </td>
                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.$program_name.'</td>
                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.$section.'</td>
                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.$year_level.'</td>
                <td class="py-3 px-6 border-b border-gray-300 ">
                    <i '.$data.' class="btnEdit text-blue-500 material-icons cursor-pointer hover:opacity-40">edit</i>
                    <i '.$data.' class="btnDelete text-red-500 material-icons cursor-pointer hover:opacity-40">delete</i>
                </td>
            </tr>';
        }
    } else {
        echo '<tr class="bg-gray-50 text-center hover:bg-gray-100 transition-colors duration-200">
            <td colspan=5  class="py-3 px-6 border-b border-gray-300 text-gray-700">
            No data found.</td>
        </tr>';
    }
    ?>
</tbody>

                        </table>
                    

                    </div>
                </div>

            </div>
        </div>
        <div class="w-full col-span-3 lg:col-span-1">

                
            <div class="card bg-white shadow-md rounded-lg p-5 mt-4">

                <form id="formSubmit">
                        <div class="flex flex-col gap-3 items-center">
                            <div class="grid w-full">
                                <p>Program :</p>
                                <input type="text" value="0" name="edit_id" id="edit_id" hidden>

                                <select id="program" name="program" class="border-black border-2 rounded px-4 w-full">
                            <option value="">Choose program</option>
                            <?php 
                            $rows = $db->getAllRowsFromTable('program_details');
                            foreach ($rows as $row) {
                                echo '<option value="'.$row['id'].'">'.ucwords($row['program_name']).'</option>';
                            }
                            ?>
                        </select>
                            </div>

                            <div class="grid w-full">
                                <p>Section Name :</p>
                                <input required type="text" id="section_name" name="section_name" class="border-black border-2 rounded px-4" placeholder="Section Name">
                            </div>

                            <div class="grid w-full">
                                <p>School Year :</p>
                                <select name="year_level" id="year_level" class="border-black border-2 rounded px-4">
                                        <option value="1st Year">1st Year</option>
                                        <option value="2nd Year">2nd Year</option>
                                        <option value="3rd Year">3rd Year</option>
                                        <option value="4th Year">4th Year</option>
                                    </select>                            </div>
                            
                            <div class="w-full ">
                                <div class="grid grid-cols-2 gap-1 my-2">
                                <button type="button" id="btnMode" class="openModal bg-green-600 text-white rounded px-3 py-1">Add</button>

                                <button type="button" id="btnReload" class="openModal bg-yellow-600 text-white rounded px-3 py-1">Reload</button>

                                </div>    

                                <div class="grid grid-cols-2 gap-1 my-2">
                                <input type="file" class="not-required" id="csvFileInput" accept=".csv" style="display:none;" />
                                    <button type="button" id="importCsvBtn" class="bg-gray-600 text-white rounded px-3 py-1">Import .csv file</button>
                                    <button type="button" id="exportCsvBtn" class="bg-gray-600 text-white rounded px-3 py-1">Export .csv file</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                </form>

            </div>
        </div>
    </main>
</div>

<!-- Modal -->
<div id="myModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-xl w-full">
        <div class="px-6 py-4 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold">Warning</h2>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    &times;
                </button>
            </div>
        </div>
        <div class="px-6 py-4">
            <h2 class="text-xl" id="textModal">Please confirm if you want to add or edit the data.</h2>
        </div>
        <div class="px-6 py-4 bg-gray-100 text-right border-t">
            <button id="confirmButton" class="bg-blue-600 text-white px-4 py-2 rounded-lg focus:outline-none">
                Confirm
            </button>
            <button id="closeModalBottom" class="bg-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none">
                Close
            </button>
        </div>
    </div>
</div>

<?php 
include 'components/footer.php';
?>
<script src="js/addForm.js"></script>
<script>
    action('controller/section-table.php')
    $('.entries,.nav-9').addClass('active-nav-link')
    $('.entries,.nav-9').addClass('opacity-100')
</script>

<script>
        $(document).ready(function() {
            $('.openModal').on('click', function() {
                //Checking if room is not null
                if($.trim($('#section_name').val())!=""){
                 $('#myModal').removeClass('hidden');
                 $('#textModal').text("Please confirm if you want to add or edit the data.")

                 $('#confirmButton').click(function() {
                        $('#formSubmit').submit();
                    });

                }else{
                    Swal.fire({
                    icon: 'error',
                    title: 'Please fill out all fields.',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    })
                }
            });

            $('#closeModal, #closeModalBottom').on('click', function() {
                $('#myModal').addClass('hidden');
            });

            // Optional: Close the modal when clicking outside of it
            $(window).on('click', function(event) {
                if ($(event.target).is('#myModal')) {
                    $('#myModal').addClass('hidden');
                }
            });
        });
    </script>

    <script>
        //FOR EDIT && DELETE

        $('.btnEdit,.btnDelete').click(function(){
            var id = $(this).data('id');
            var section = $(this).data('section');
            var year_level = $(this).data('year_level');
            var program_id = $(this).data('program_id');

            $('#edit_id').val(id)
            $('#section_name').val(section)
            $('#year_level').val(year_level)
            $('#program').val(program_id)

            $('#btnMode').text('Edit')
        })

        $('#btnReload').click(function(){
            window.location.reload()
        })


        //DELETE

        $('.btnDelete').click(function(){
            $('#myModal').removeClass('hidden');
            $('#textModal').text("Please confirm if you want to delete the data.")
            $('#btnMode').text('Delete')

            $('#confirmButton').click(function() {
                $('#formSubmit').submit();
            });
        })
    </script>

<script>
    $(document).ready(function () {
        $('#searchInput').on('keyup', function () {
            var query = $(this).val().toLowerCase(); // Get the search query
            $('tbody tr').filter(function () {
                $(this).toggle(
                    $(this).text().toLowerCase().indexOf(query) > -1
                ); // Show/hide rows based on the query
            });
        });
    });
</script>

<script>
    let sortDirection = true; // True means ascending, false means descending

    function sortTable(columnIndex) {
        const table = document.querySelector('table');
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        const arrowUp = "&#9650;";
        const arrowDown = "&#9660;";

        // Toggle the sort direction
        sortDirection = !sortDirection;

        // Sort rows based on the column index
        rows.sort((a, b) => {
            const cellA = a.cells[columnIndex].textContent.trim().toLowerCase();
            const cellB = b.cells[columnIndex].textContent.trim().toLowerCase();

            if (cellA < cellB) {
                return sortDirection ? -1 : 1;
            }
            if (cellA > cellB) {
                return sortDirection ? 1 : -1;
            }
            return 0;
        });

        // Append the sorted rows back to the table body
        const tbody = table.querySelector('tbody');
        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));

        // Update the arrow icon based on the sorting direction
        const header = table.querySelectorAll('th')[columnIndex];
        if (sortDirection) {
            header.innerHTML = header.innerHTML.replace(arrowDown, arrowUp);
        } else {
            header.innerHTML = header.innerHTML.replace(arrowUp, arrowDown);
        }
    }
</script>



<!-- IMPORT -->
<script>
        // Trigger the hidden file input on button click
        document.getElementById('importCsvBtn').addEventListener('click', function() {
            document.getElementById('csvFileInput').click();
        });

        // Handle CSV file input change
        document.getElementById('csvFileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const csvContent = e.target.result;
                    processCSV(csvContent);
                };
                reader.readAsText(file);
            }
        });

       // Process CSV content and send all rows and columns to the server
        function processCSV(csvContent) {
            const rows = csvContent.split('\n').map(row => row.split(',')); // Split rows and columns
            sendToServer(rows); // Send all rows and columns
        }

        // Send the first column data to the PHP server via AJAX
        function sendToServer(firstColumnData) {
            fetch('controller/import_section.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ data: firstColumnData }),
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success', // Corrected the typo here
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                }).then(() => {
                    location.reload(); // Reload the page after the SweetAlert closes
                });

            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
    </script>


<!-- EXPORT -->

<script>
    // Handle CSV export on button click
document.getElementById('exportCsvBtn').addEventListener('click', function() {
    window.location.href = 'controller/export_section.php'; // Trigger export by redirecting to PHP script
});
</script>

<script>
    $(document).ready(function() {
    // Select/Unselect all checkboxes
    $('#selectAll').on('change', function() {
        $('.rowCheckbox').prop('checked', $(this).prop('checked'));
        toggleBulkDeleteButton();
    });

    // Toggle master checkbox if all row checkboxes are checked/unchecked
    $('.rowCheckbox').on('change', function() {
        if ($('.rowCheckbox:checked').length === $('.rowCheckbox').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
        toggleBulkDeleteButton();
    });

    // Show/Hide the Bulk Delete button
    function toggleBulkDeleteButton() {
        if ($('.rowCheckbox:checked').length > 0) {
            $('#bulkDeleteBtn').removeClass('hidden');
        } else {
            $('#bulkDeleteBtn').addClass('hidden');
        }
    }

    // Bulk Delete with SweetAlert Confirmation
    $('#bulkDeleteBtn').on('click', function() {
        let selectedIds = $('.rowCheckbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length > 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete " + selectedIds.length + " section(s).",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send selected IDs to the server for deletion
                    $.ajax({
                        url: 'controller/delete_sections.php',
                        type: 'POST',
                        data: { ids: selectedIds },
                        success: function(response) {
                           alertMaker(response)
                        },
                        error: function() {
                            Swal.fire('Error', 'Something went wrong while deleting.', 'error');
                        }
                    });
                }
            });
        }
    });
});

</script>