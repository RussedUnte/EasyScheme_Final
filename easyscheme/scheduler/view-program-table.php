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

                <button type="button" id="btnDeleteSelected" class="bg-red-600 text-white rounded px-3 py-1 hidden">Delete Selected</button>

                    <!-- Responsive Table Wrapper -->
                <div class="overflow-scroll w-full my-4">
                    <div class="table-responsive bg-black">
                        <!-- Table -->
                        <table id="programTable" class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                        <thead>
    <tr>
        <th class="py-3 whitespace-nowrap px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
            <input type="checkbox" id="selectAll"> <!-- Select All Checkbox -->
        </th>
        <th class="py-3 whitespace-nowrap px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
            Program Name
            <span class="sort-icon cursor-pointer" onclick="sortTable(1)">
                &#x25B2;&#x25BC;
            </span>
        </th>
        <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
            Institute
            <span class="sort-icon cursor-pointer" onclick="sortTable(2)">
                &#x25B2;&#x25BC;
            </span>
        </th>
        <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
            Action
        </th>
    </tr>
</thead>
<tbody>
    <?php 
        $rows = $db->getAllProgram();
    foreach ($rows as $row) {
       
        $id = ucwords($row['id']);
        $program_name = ucwords($row['program_name']);
        $institute = ucwords($row['institute']);
        $name = ucwords($row['name']);
        
        echo '<tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
            <td class="py-3 px-6 border-b border-gray-300">
                <input type="checkbox" class="selectRow" data-id="'.$id.'"> <!-- Checkbox for each row -->
            </td>
            <td class="py-3 px-6 border-b border-gray-300">'.$program_name.'</td>
            <td class="py-3 px-6 border-b border-gray-300">'.$name.'</td>
            <td class="py-3 px-6 border-b border-gray-300">
                <i class="btnEdit text-blue-500 material-icons cursor-pointer hover:opacity-40">edit</i>
                <i class="btnDelete text-red-500 material-icons cursor-pointer hover:opacity-40">delete</i>
            </td>
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
                                <p>Institute :</p>
                                <input type="text" value="0" name="edit_id" id="edit_id" hidden>

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
                                <p>Program Name :</p>
                                <input required type="text" id="program_name" name="program_name" class="border-black border-2 rounded px-4" placeholder="Program Name">
                            </div>
                            
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
    action('controller/view-program-table.php')
    $('.entries,.nav-8').addClass('active-nav-link')
    $('.entries,.nav-8').addClass('opacity-100')
</script>

<script>
// Sorting function for columns
function sortTable(columnIndex) {
    var table = document.getElementById("programTable");
    var rows = Array.from(table.rows).slice(1); // Exclude the header row
    var isAscending = table.getAttribute("data-order") === "asc"; // Check current sorting order

    rows.sort(function(rowA, rowB) {
        var cellA = rowA.cells[columnIndex].innerText.toLowerCase();
        var cellB = rowB.cells[columnIndex].innerText.toLowerCase();

        if (cellA < cellB) return isAscending ? -1 : 1;
        if (cellA > cellB) return isAscending ? 1 : -1;
        return 0;
    });

    rows.forEach(function(row) {
        table.tBodies[0].appendChild(row); // Reappend sorted rows
    });

    table.setAttribute("data-order", isAscending ? "desc" : "asc"); // Toggle sorting order
}
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

<!-- IMPORT & EXPORT CSV Scripts Here -->



<script>
        $(document).ready(function() {
            $('.openModal').on('click', function() {
                //Checking if room is not null
                if($.trim($('#program_name').val())!=""){
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
            var institute = $(this).data('institute');
            var program_name = $(this).data('program_name');

            $('#edit_id').val(id)
            $('#program_name').val(program_name)
            $('#institute').val(institute)

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
            processCSV(csvContent); // Process the CSV data
        };
        reader.readAsText(file);
    }
});

// Process CSV content and send all rows and columns to the server
function processCSV(csvContent) {
    const rows = csvContent.split('\n').map(row => row.split(',')); // Split rows and columns
    sendToServer(rows); // Send all rows and columns
}

// Send the CSV data (all rows and columns) to the PHP server via AJAX
function sendToServer(csvData) {
    fetch('controller/import_program.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ data: csvData }), // Send all rows and columns
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            icon: 'success',
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

<script>
// Handle CSV export on button click
document.getElementById('exportCsvBtn').addEventListener('click', function() {
    window.location.href = 'controller/export_program.php'; // Trigger export by redirecting to PHP script
});
</script>

<script>
    $(document).ready(function () {
    // Handle "Select All" checkbox functionality
    $('#selectAll').on('change', function () {
        $('.selectRow').prop('checked', this.checked);
        toggleDeleteButton(); // Show or hide delete button based on selection
    });

    // Handle individual row checkbox change
    $('.selectRow').on('change', function () {
        toggleDeleteButton(); // Show or hide delete button based on selection
    });

    // Show or hide the delete button based on if any checkbox is checked
    function toggleDeleteButton() {
        var anyChecked = $('.selectRow:checked').length > 0;
        if (anyChecked) {
            $('#btnDeleteSelected').removeClass('hidden'); // Show button
        } else {
            $('#btnDeleteSelected').addClass('hidden'); // Hide button
        }
    }

    // Handle delete action for selected rows
    $('#btnDeleteSelected').on('click', function () {
        var selectedIds = [];
        $('.selectRow:checked').each(function () {
            selectedIds.push($(this).data('id'));
        });

        if (selectedIds.length > 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you really want to delete the selected programs?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'controller/delete_program_table.php',
                        method: 'POST',
                        data: { ids: selectedIds },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'Something went wrong.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            });
        }
    });
});

</script>