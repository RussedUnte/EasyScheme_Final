<?php 
include 'conn/conn.php';
$db = new DatabaseHandler();

if(!isset($_GET['i'])) {
    echo "<script>window.location.href='index.php'</script>";
} else {
    $program_id = htmlentities($_GET['i']);
}

// Fetch batches from the database
$batches = $db->getAllRowsFromTableWhereOrderBy('batch', ['institute' => $program_id]); // Adjust the method based on your DatabaseHandler implementation

// Group batches by batch_name
$grouped_batches = [];
foreach ($batches as $batch) {
    $grouped_batches[$batch['batch_name']][] = $batch; // Group by batch name
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyScheme</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> <!-- Include html2canvas -->
    
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: 'Karla', sans-serif;
        }

        .bg-body {
            background: #1e502d;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-body font-family-karla p-4">

    <p class="sm:text-right m-3 mt-0">
        <a href="login.php" class="w-2/5 px-3 py-2 hover:bg-orange-600 text-white font-bold rounded-full">Login</a>
    </p>
    <div class="flex flex-col items-center justify-center">
        <div class="flex flex-col items-center bg-white text-black rounded-lg sm:p-8 p-4 w-full sm:w-4/5 lg:w-1/2 xl:w-1/2 shadow-md">
            <img class="w-36 mb-4" src="assets/image/logo.png" alt="Logo">
            <h1 class="text-xl my-4 font-bold">EasyScheme</h1>

            <input id="searchInput" type="text" placeholder="Search..." class="border px-2 py-1 text-gray-800 rounded border-gray-400 mb-4 w-full sm:w-3/4 lg:w-1/2">

            <!-- Table -->
            <div class="w-full overflow-x-auto">
                <div class="w-full col-span-3">
                    <div class="card bg-white shadow-md rounded-lg p-5 mt-4">
                        <h2 class="text-3xl font-bold text-center mb-6">Generated Batches</h2>
                        <?php if (empty($batches)): ?>
                            <div class="alert alert-warning text-center bg-yellow-100 text-yellow-800 border border-yellow-300 rounded-lg p-4 mb-4" role="alert">
                                No batches have been generated yet.
                            </div>
                        <?php else: ?>
                            <?php foreach ($grouped_batches as $batch_name => $students): ?>
                                <div class="mt-8">
                                    <div class="overflow-x-auto">
                                        <table id="table-<?php echo htmlspecialchars($batch_name); ?>" class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                                            <thead>
                                                <tr class="bg-gray-200">
                                                    <th class="py-2 px-4 text-left text-gray-600 text-center" colspan="3"><?php echo htmlspecialchars($batch_name); ?></th>
                                                </tr>
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
                                        <!-- Save Button -->
                                        <div class="flex justify-end mt-4">
                                            <button class="flex items-center bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition duration-200 ease-in-out" onclick="saveTableAsImage('table-<?php echo htmlspecialchars($batch_name); ?>')">
                                            <i class="material-icons ">download</i>
                                                Save as Image
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Search functionality
            $(document).ready(function() {
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        var matchFound = false;

        // Hide all tables initially
        $('.card > div').hide(); // Hide all tables initially

        // Iterate through each table's rows and check for matches
        $('.card > div').each(function() {
            var table = $(this).find('table');
            var tableContainsMatch = false;

            // Collect all rows and create an array for sorting
            var rows = [];
            table.find('tbody tr').each(function() {
                var studentName = $(this).children('td').first().text().toLowerCase();
                var studentNumber = $(this).children('td').eq(1).text().toLowerCase();
                
                var match = studentName.indexOf(value) > -1 || studentNumber.indexOf(value) > -1;

                // If match is found, set tableContainsMatch to true
                if (match) {
                    tableContainsMatch = true;
                }

                // Push the row and whether it matches into the array
                rows.push({ row: $(this), match: match });
            });

            // If a match is found, show the table and reorder rows
            if (tableContainsMatch) {
                // Sort rows so that matching ones come first
                rows.sort(function(a, b) {
                    return b.match - a.match;  // Matches come first
                });

                // Empty tbody and append sorted rows back to the table
                table.find('tbody').empty();
                $.each(rows, function(index, value) {
                    table.find('tbody').append(value.row);
                });

                $(this).show();  // Show the table with matches
                matchFound = true;
            }
        });
    });
});



        });

        function saveTableAsImage(tableId) {
            const tableElement = document.getElementById(tableId);
            html2canvas(tableElement).then(canvas => {
                // Create a link element
                const link = document.createElement('a');
                // Set the download attribute with a filename
                link.download = tableId + '.png';
                // Convert canvas to data URL and set it as the link's href
                link.href = canvas.toDataURL('image/png');
                // Programmatically click the link to trigger the download
                link.click();
            }).catch(err => {
                console.error('Error capturing table as image:', err);
            });
        }
    </script>

</body>
</html>
