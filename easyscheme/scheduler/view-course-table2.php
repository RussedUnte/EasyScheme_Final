<?php 
include 'components/header.php';
?>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">

    <main class="w-full grid grid-cols-3 gap-x-5 p-6 pt-2">
        
        <div class="w-full col-span-3 lg:col-span-2">

                
            <div class="card bg-white shadow-md rounded-lg p-5 mt-4">

                <p class="text-right">
                <input type="text" value="Search" class="border px-2 py-1 text-gray-800 rounded border-gray-400 mb-4">
                </p>


                    <!-- Responsive Table Wrapper -->
                <div class="overflow-scroll w-full my-4">
                    <div class="table-responsive bg-black">
                        <!-- Table -->
                        <table class="bg-white text-center border border-gray-300 rounded-lg shadow-md min-w-full">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 bg-gray-200 text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Code
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Course Title
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-sm font-semibold text-gray-700 border-b border-gray-300">
                                    Designation
                                    </th>
                                    <th class="py-3 px-6 bg-gray-200 text-sm font-semibold text-gray-700 border-b border-gray-300">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">Code here</td>
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">course here</td>
                                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">Major</td>
                                    <td class="py-3 px-6 gap-3 items-center flex border-gray-300 ">
                                        <button class="openModal bg-gray-600 text-white px-3 py-2 rounded-lg">View</button>
                                        <i class="material-icons rounded-lg bg-green-600 text-white px-3 py-2">edit</i>
                                        <i class="material-icons rounded-lg bg-red-600 text-white px-3 py-2">delete</i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="w-full col-span-3 lg:col-span-1">

                
            <div class="card bg-white shadow-md rounded-lg p-5 mt-4">

                <div class="flex flex-col gap-3 items-center">
                        <div class="grid w-full">
                            <p>Course Title :</p>
                            <input type="text" class="border-black border-2 rounded px-4" placeholder="Course Title">
                        </div>
                        <div class="grid w-full">
                            <p>Course Code :</p>
                            <input type="text" class="border-black border-2 rounded px-4" placeholder="Course Code">
                        </div>
                        <div class="grid w-full">
                            <p>Designation :</p>
                            <input type="text" class="border-black border-2 rounded px-4" placeholder="Designation">
                        </div>
                        <div class="w-full ">
                            <button class="w-1/2 bg-green-600 text-white rounded px-3 py-1">Add/Edit</button>
                            <div class="grid grid-cols-2 gap-1 my-2">
                                <button class="bg-gray-600 text-white rounded px-3 py-1">Import .csv file</button>
                                <button class="bg-gray-600 text-white rounded px-3 py-1">Export .csv file</button>
                            </div>
                            
                        </div>
                </div>

            </div>
        </div>
    </main>
</div>
<!-- Modal -->
<div id="myModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg overflow-hidden shadow-lg max-w-xl w-full">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Sections taking this subject</h2>
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        &times;
                    </button>
                </div>
                   
                <div class="grid grid-cols-3 gap-3">
                    <!-- Responsive Table Wrapper -->
                    <div class="overflow-scroll w-full col-span-2 my-4">
                        <div class="table-responsive bg-black">
                            <!-- Table -->
                            <table class="bg-white text-center border border-gray-300 rounded-lg shadow-md min-w-full">
                                <tbody>
                                    <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                        <td class="py-3 px-6 border-b border-gray-300 text-gray-700">2nd</td>
                                        <td class="py-3 px-6 border-b border-gray-300 text-gray-700">I201</td>
                                        <td class="py-3 px-6 gap-3 items-center flex border-gray-300 ">
                                            <i class="material-icons rounded-lg bg-green-600 text-white text-sm px-1 py-0">edit</i>
                                            <i class="material-icons rounded-lg bg-red-600 text-white text-sm px-1 py-0">delete</i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="flex flex-col justify-center items-center">
                            <div class="grid w-full mx-3 my-3">
                                <p class="font-bold">Section</p>
                                <input type="text" class=" w-full border-black border-2 rounded px-4" placeholder="Section">
                            </div>
                            <div class="w-full ">
                                <button class="w-full bg-green-600 text-white rounded px-3 py-1">Add/Edit</button>
                            </div>
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
<script>
    $('.entries,.nav-7').addClass('active-nav-link')
    $('.entries,.nav-7').addClass('opacity-100')
</script>

<script>
        $(document).ready(function() {
            $('.openModal').on('click', function() {
                $('#myModal').removeClass('hidden');
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