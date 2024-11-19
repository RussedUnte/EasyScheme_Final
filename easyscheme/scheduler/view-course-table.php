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


                    <!-- Responsive Table Wrapper -->
                <div class="overflow-scroll w-full my-4">
                    <div class="table-responsive bg-black">
                        <!-- Table -->
                        <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 bg-gray-200 text-center text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Action
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Code
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Program Name
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Title
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Designation
                                    </th>
                                   
                                </tr>
                            </thead>
                            <tbody>

                            <?php 
                            $rows = $db->getAllCourse();

                           if(count($rows)>0)
                           {
                            foreach ($rows as $row) {
                                $id = ucwords($row['id']);
                                $code = ucwords($row['code']);
                                $title = ucwords($row['title']);
                                $designation = ucwords($row['designation']);
                                $institute = ucwords($row['institute']);
                                $program = ucwords($row['program']);

                                $program_name = $db->getIdByColumnValue("program_details","id",$program,"program_name");

                                //for datas
                                    $data = "
                                    data-id = '$id' 
                                    data-code = '$code' 
                                    data-title = '$title' 
                                    data-designation = '$designation' 
                                    data-institute = '$institute' 
                                    data-program = '$program' 
                                    ";

                                echo '<tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">

                                     <td class="py-3 px-6 border-b gap-3 items-center flex border-gray-300 ">
                                        <button '.$data.' type="button" class="openViewModal bg-gray-600 text-white text-sm px-1 py-0 rounded-lg">View</button>
                                        <i '.$data.' class="cursor-pointer hover:opacity-75 material-icons btnEdit rounded-lg bg-green-600 text-white text-sm px-1 py-0">edit</i>
                                        <i '.$data.' class="btnDelete cursor-pointer hover:opacity-75 material-icons rounded-lg bg-red-600 text-white text-sm px-1 py-0">delete</i>
                                    </td>
                                    <td class="py-3  px-6 border-b border-gray-300 text-gray-700">'.$code.'</td>
                                    <td class="py-3  px-6 border-b border-gray-300 text-gray-700">'.$program_name.'</td>
                                    <td class="py-3 whitespace-nowrap px-6 border-b border-gray-300 text-gray-700">'.$title.'</td>
                                    <td class="py-3  px-6 border-b border-gray-300 text-gray-700">'.$designation.'</td>
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
                            <input type="text" value="0" name="edit_id" id="edit_id" hidden>
                            <div class="grid w-full">
                            <p>Course Title :</p>
                                <input type="text" id="title" name="title" class="border-black border-2 rounded px-4" placeholder="Course Title">
                            </div>
                            <div class="grid w-full">
                                <p>Course Code :</p>
                                <input type="text" id="code" name="code" class="border-black border-2 rounded px-4" placeholder="Course Code">
                            </div>
                            <div class="grid w-full">
                                <p>Designation :</p>
                                <select id="designation" name="designation" class="border-black border-2 rounded px-4 w-full">
                                    <option value="">Select Designation</option>
                                    <option value="Minor">Minor</option>
                                    <option value="Major">Major</option>
                                </select>
                            </div>
                            <div class="grid w-full">
                                <p>Program :</p>
                                <select id="program" name="program" class="border-black border-2 rounded px-4 w-full" placeholder="Designation">
                                    <option value="">Select Program</option>
                                    <?php 
                                    $rows = $db->getAllRowsFromTable('program_details');
                                    foreach ($rows as $row) {
                                        echo '<option value="'.$row['id'].'">'.ucwords($row['program_name']).'</option>';
                                    }
                                    ?>
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

<!-- Modal 2 -->
<div id="myViewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg overflow-y-auto shadow-lg w-full md:w-1/2 h-3/5 flex flex-col">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Sections taking this subject</h2>
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        &times;
                    </button>
                </div>
                   
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                    <!-- Responsive Table Wrapper -->
                            <!-- Table -->
                            <div class="overflow-y-auto h-full col-span-2 my-4">
                            <table class="bg-white text-center border border-gray-300 rounded-lg shadow-md min-w-full max-h-screen">
                                <tbody id="sectionBody">
                                </tbody>
                            </table>
                            </div>


                    <div class="flex flex-col  ">
                            <form id="formSection">
                            <input type="text" value="0" name="section_id" id="section_id" hidden>
                            <input type="text" value="0" name="section_course_id" id="section_course_id" hidden>
                            <input type="text" value="0" name="course_id" id="course_id" hidden>

                                <div class="grid w-full my-3">
                                    <p class="font-bold">Section</p>
                                    <input type="text" list="sections" name="section" id="section" class="w-full border-black border-2 rounded px-4" placeholder="Section">

                                    <datalist id="sections">
                                        <?php 
                                        $rows = $db->getAllRowsFromTable("section");
                                        foreach ($rows as $row) {
                                            echo '<option data-section_id="'.$row['id'].'" data-sy="'.$row['year_level'].'" value="'.$row['section'].'">';
                                        }
                                        ?>
                                    </datalist>
                                </div>
                                <div class="grid w-full  my-3">
                                    <p class="font-bold">Year Level</p>
                                    <select name="year_level" disabled id="year_level" class="w-full border-black border-2 rounded px-4">
                                        <option value="1st Year">1st Year</option>
                                        <option value="2nd Year">2nd Year</option>
                                        <option value="3rd Year">3rd Year</option>
                                        <option value="4th Year">4th Year</option>
                                    </select>
                                </div>
                                <div class="w-full ">
                                    <button id="btnMode2" class="w-full bg-green-600 text-white rounded px-3 py-1">Add</button>
                                </div>
                            </form>
                    </div>
                    </div>




            </div>
            <div class="px-6 py-4 bg-gray-100 text-right">
                <button id="closeModalBottom" class="bg-gray-600 text-white px-3 py-2 rounded-lg focus:outline-none">
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
    action('controller/view-course-table.php')
    $('.entries,.nav-7').addClass('active-nav-link')
    $('.entries,.nav-7').addClass('opacity-100')
</script>

<script>
        $(document).ready(function() {
            $('.openModal').on('click', function() {
                //Checking if room is not null
                if($.trim($('#title').val())!="" 
                    && $.trim($('#code').val())!="" 
                    && $.trim($('#designation').val())!=""){
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
        //FOR EDIT && DELETE COURSE

        $('.btnEdit,.btnDelete').click(function(){
            var id = $(this).data('id');
            var code = $(this).data('code');
            var title = $(this).data('title');
            var designation = $(this).data('designation');
            var program = $(this).data('program');


            $('#edit_id').val(id)
            $('#code').val(code)
            $('#title').val(title)
            $('#designation').val(designation)
            $('#program').val(program)

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
    $(document).ready(function() {
        $('.openViewModal').on('click', function() {
            $('#myViewModal').removeClass('hidden');

            $('#sectionBody').empty();

            var id = $(this).data('id');
            var institute = $(this).data('institute');

            $('#course_id').val(id)

            $.ajax({
            url: 'controller/get-section-rows.php',
            type: 'POST',
            data: {
                id:id,
                institute:institute
            }, // Corrected data format
            success: function(response) {
                $('#sectionBody').append(response);
                actionModified('#formSection','controller/section.php')

                // After adding to tbody then click event
                $('.btnSectionEdit,.btnSectionDelete').click(function(){

                   var id = $(this).data('id')
                   var section = $(this).data('section')
                   var year_level = $(this).data('year_level')
                   var section_course_id = $(this).data('section_course_id')
                   
                   $('#section_id').val(id)
                   $('#section').val(section)
                   $('#year_level').val(year_level)
                   $('#section_course_id').val(section_course_id)

                   var mode = $(this).text();
                   $('#btnMode2').text(ucwords(mode))


                })

                }
            });
        });

        $('#closeModal, #closeModalBottom').on('click', function() {
            $('#myViewModal').addClass('hidden');
        });

        // Optional: Close the modal when clicking outside of it
        $(window).on('click', function(event) {
            if ($(event.target).is('#myViewModal')) {
                $('#myViewModal').addClass('hidden');
            }
        });
    });
</script>

<script>
    // Function to convert text to ucwords
    function ucwords(str) {
        return str.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
</script>


<script>
    $('#section').on('input', function() {
        var selectedValue = $(this).val();
        var selectedOption = $('#sections option').filter(function() {
            return this.value === selectedValue;
        });

        if (selectedOption.length) {
            var sy = selectedOption.data('sy');
            var section_id = selectedOption.data('section_id');
            $('#year_level').val(sy)
            $('#section_id').val(section_id)

            
        }
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
    fetch('controller/import_course.php', {
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
    window.location.href = 'controller/export_course.php'; // Trigger export by redirecting to PHP script
});
</script>