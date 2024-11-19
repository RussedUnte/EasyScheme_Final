<?php 
include 'conn/conn.php';
$db = new DatabaseHandler();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyScheme</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: 'Karla', sans-serif;
        }

        .bg-sidebar {
            background: #3d68ff;
        }

        .cta-btn {
            color: #3d68ff;
        }

        .upgrade-btn {
            background: #1947ee;
        }

        .upgrade-btn:hover {
            background: #0038fd;
        }

        .active-nav-link {
            background: #1947ee;
        }

        .nav-item:hover {
            background: #1947ee;
        }

        .account-link:hover {
            background: #3d68ff;
        }

        .bg-body {
            background: #1e502d;
        }

        .bg-darkgreen {
            background: #1b4728;
        }

        .bg-orange {
            background: #f27c22;
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
                <table id="examTable" class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead>
                        <tr>
                            <th class="py-3 px-2 sm:px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Section
                            </th>
                            <th class="py-3 px-2 sm:px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Course Code
                            </th>
                            <th class="py-3 px-2 sm:px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Course Title
                            </th>
                            <th class="py-3 px-2 sm:px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Date
                            </th>
                            <th class="py-3 px-2 sm:px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Time
                            </th>
                            <th class="py-3 px-2 sm:px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                Exam Link
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $rows = $db->getAllRowsFromTable("exam_links");
                        $count =0;
                        if(count($rows)>0){
                            foreach ($rows as $row) {

                            $schedule_details_id = $row['schedule_details_id'];
                            $course_id = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"course_id"));
                            $date = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"date"));
                            
                            
                            $Date = new DateTime($date);
                            // Get the current date
                            $currentDate = (new DateTime());
                            // Compare input date with current date
                            if ($Date->format('Y-m-d') != $currentDate->format('Y-m-d')) {
                                continue;
                            }
                            $count ++;
                            
                            $time_start = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"time_start"));
                          
                            $section_id = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"section_id"));
                            $schedule_id = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"schedule_id"));

                            $section_name = ($db->getIdByColumnValue("section","id",$section_id,"section"));


                            $exam_date = (new DateTime($date))->format('M d Y');
                            $exam_time = (new DateTime($time_start))->format('g:i A');


                            $title = ucwords($db->getIdByColumnValue("course","id",$course_id,"title"));
                            $code = strtoupper($db->getIdByColumnValue("course","id",$course_id,"code"));
                            $exam_type = strtoupper($db->getIdByColumnValue("schedule","id",$schedule_id,"exam_type"));



                            $link = $row['link'];
                                echo '
                                <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <td class="py-3 px-2 whitespace-nowrap sm:px-6 border-b border-gray-300 text-gray-700">'.$exam_type.' - '.$section_name.'</td>
                                    <td class="py-3 px-2 sm:px-6 border-b border-gray-300 text-gray-700">'.$code.'</td>
                                    <td class="py-3 px-2 sm:px-6 border-b border-gray-300 text-gray-700">'.$title.'</td>
                                    <td class="py-3 px-2 sm:px-6 whitespace-nowrap border-b border-gray-300 text-gray-700">'.$exam_date.'</td>
                                    <td class="py-3 px-2 sm:px-6 whitespace-nowrap border-b border-gray-300 text-gray-700">'.$exam_time.'</td>
                                    <td class="py-3 px-2 sm:px-6 whitespace-nowrap border-b border-gray-300 text-blue-600 hover:text-blue-800">
                                        <a target="_blank" href="'.$link.'">Take Exam</a>
                                    </td>
                                </tr>
                                ';
                            
                            }
                        }
                        if($count==0)
                        {
                            echo '
                            <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                <td colspan="7" class="py-3 px-2 whitespace-nowrap sm:px-6 border-b border-gray-300 text-gray-700 text-center">No scheduled exam links today</td>
                            </tr>
                            ';
                        }
                        
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#examTable tbody tr');

            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let rowText = '';
                cells.forEach(cell => {
                    rowText += cell.textContent.toLowerCase() + ' ';
                });

                if (rowText.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>
