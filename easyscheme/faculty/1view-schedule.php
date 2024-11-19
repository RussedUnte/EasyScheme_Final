<?php 
include 'components/header.php';
?>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">

<div class="flex justify-center sm:justify-end">
    <select class="border-black m-2 border-2 rounded px-4 py-1">
        <option value="">Year-Level</option>
        <option value="">2024</option>
    </select>
    <select class="border-black m-2 border-2 rounded px-4 py-1">
        <option value="">Institute</option>
        <option value="">2024</option>
    </select>
</div>


    <main class="w-full  p-6 pt-2">
        
        <div class="w-full ">
            <div class="card bg-white shadow-md rounded-lg p-5">
                <h2 class="text-lg text-center font-semibold mb-0">
                    Midterm Examination Schedule
                </h2>
                <h2 class="text-lg text-center font-semibold mb-0">
                    First semester 2023 - 2024
                </h2>
                <h2 class="text-lg text-center font-semibold mb-0">
                    1st Year BSIS Students
                </h2>

                <!-- Responsive Table Wrapper -->
            <div class="overflow-scroll w-full my-4">
                <div class="table-responsive bg-black">
                    <!-- Table -->
                    <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                        <thead>
                            <tr>
                            <td class="text-center bg-gray-400" colspan="7">I101</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Code
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Title
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Date
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Time Start
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Time End
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Room
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Proctor
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">CS101</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">Introduction to Computer Science</td>
                                <td class="py-3 px-6 border-b border-gray-300 ">
                                    <a href="#">01/01/2023</a>
                                </td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">01-01-2024</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">09:00 AM</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">12:00 PM</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">Room 101</td>
                            </tr>
                            <tr class="bg-white hover:bg-gray-100 transition-colors duration-200">
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">ENG102</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">English Literature</td>
                                <td class="py-3 px-6 border-b border-gray-300 ">
                                    <a href="#">01/01/2023</a>
                                </td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">02-01-2024</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">10:00 AM</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">01:00 PM</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">Room 202</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="overflow-scroll w-full my-4">
                <div class="table-responsive bg-black">
                    <!-- Table -->
                    <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                        <thead>
                            <tr>
                                <td class="text-center bg-gray-400" colspan="7">I102</td>
                            </tr>
                            <tr>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Code
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Title
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Date
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Time Start
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Time End
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Room
                                </th>
                                <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Proctor
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">CS101</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">Introduction to Computer Science</td>
                                <td class="py-3 px-6 border-b border-gray-300 ">
                                    <a href="#">01/01/2023</a>
                                </td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">01-01-2024</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">09:00 AM</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">12:00 PM</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">Room 101</td>
                            </tr>
                            <tr class="bg-white hover:bg-gray-100 transition-colors duration-200">
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">ENG102</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">English Literature</td>
                                <td class="py-3 px-6 border-b border-gray-300 ">
                                    <a href="#">01/01/2023</a>
                                </td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">02-01-2024</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">10:00 AM</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">01:00 PM</td>
                                <td class="py-3 px-6 border-b border-gray-300 text-gray-700">Room 202</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                
            </div>
        </div>
    </main>
</div>

<?php 
include 'components/footer.php';
?>
<script>
    $('.nav-2').addClass('active-nav-link')
    $('.nav-2').addClass('opacity-100')
</script>