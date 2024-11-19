<?php 
include 'components/header.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id === null || !count($db->getAllRowsFromTableWhere('institutes', ["id='$id'"])) > 0) {
    echo "<script>window.location.href='profile.php'</script>";
}
?>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">

    <main class="w-full grid grid-cols-3 gap-x-5 p-6 pt-2">
        
        <div class="w-full col-span-3 lg:col-span-2">

                
            <div class="card bg-white shadow-md rounded-lg p-5 mt-4">

                <p class="text-right">
                <input type="text" placeholder="Search" id="searchInput" class="border px-2 py-1 text-gray-800 rounded border-gray-400 mb-4">
                </p>


                    <!-- Responsive Table Wrapper -->
                <div class="overflow-scroll w-full my-4">
                    <div class="table-responsive bg-black">
                        <!-- Table -->
                        <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Salutations
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Name
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
                            $rows = $db->getAllFaculty($_GET['id']);

                           if(count($rows)>0)
                           {
                            foreach ($rows as $row) {
                                $user_id = ucwords($row['user_id']);
                                $id = ucwords($row['id']);
                                $name = ucwords($row['name']);
                                $salutation = $row['salutation'];
                                $status = $row['status'];

                                //for datas
                                    $data = "
                                    data-id = '$id' 
                                    data-user_id = '$user_id' 
                                    data-name = '$name' 
                                    data-salutation = '$salutation' 
                                    data-status = '$status'
                                    ";

                                echo '<tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.ucwords($salutation).'</td>
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.$name.'</td>
                                    <td class="py-3 px-6 border-b border-gray-300 ">
                                        <a href="#">'.$status.'</a>
                                    </td>
                                    <td class="py-3 px-6 border-b border-gray-300 ">
                                        <i '.$data.' class="btnEdit text-blue-500 material-icons cursor-pointer hover:opacity-40">edit</i>
                                        <i '.$data.' class="btnDelete text-red-500 material-icons cursor-pointer hover:opacity-40">delete</i>
                                    </td>
                                </tr>';
                            }
                           }else 
                           {
                            echo '<tr class="bg-gray-50 text-center hover:bg-gray-100 transition-colors duration-200">
                            <td colspan=4  class="py-3 px-6 border-b border-gray-300 text-gray-700">
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
                                <p>Name :</p>
                                <input type="text" value="0" name="edit_user_id" id="edit_id" hidden>
                                <input type="text" value="0" name="edit_user_details_id" id="edit_id2" hidden>
                                <input hidden type="text" value="<?=$_GET['id']?>" name="institute" >
                                <input required type="text" id="name" name="name" class="border-black border-2 rounded px-4" placeholder="Full Name">
                            </div>
                            <div class="grid w-full">
                                <p>Salutation :</p>
                                <select name="salutation" id="salutation" class="border-black border-2 rounded px-4">
                                    <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Mrs.">Mrs.</option>
                                    <option value="Dr.">Dr.</option>
                                </select>
                            </div>
                            <div class="grid w-full">
                                <p>Status :</p>
                                <select name="status" id="status" class="border-black border-2 rounded px-4">
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                </select>
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
    action('controller/faculty-table.php')
    $('.entries,.nav-4').addClass('active-nav-link')
    $('.entries,.nav-4').addClass('opacity-100')
</script>

<script>
        $(document).ready(function() {
            $('.openModal').on('click', function() {
                //Checking if name is not null
                if($.trim($('#name').val())!=""){
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
            var id = $(this).data('user_id');
            var user_id = $(this).data('id');
            var name = $(this).data('name');
            var salutation = $(this).data('salutation');
            var status = $(this).data('status');

            $('#edit_id').val(id)
            $('#edit_id2').val(user_id)
            $('#name').val(name)
            $('#salutation').val(salutation)
            $('#status').val(status)

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
    fetch('controller/import_faculty.php', {
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
    var id = <?php echo json_encode($_GET['id'])?>;
document.getElementById('exportCsvBtn').addEventListener('click', function() {
    window.location.href = 'controller/export_faculty.php?id='+id; // Trigger export by redirecting to PHP script
});
</script>