<?php 
include 'components/header.php';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full p-6 pt-2">
        <div class="w-full">
            <div class="card bg-white shadow-md rounded-lg p-5 mt-4">
                <!-- Responsive Table Wrapper -->
                <div class="overflow-scroll w-full my-4">
                    <div class="table-responsive ">
                        <!-- Table -->
                        <table class="bg-white border border-gray-300 rounded-lg shadow-md min-w-full">
                            <thead>
                                <tr>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">Section</th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">Course Code</th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">Course Title</th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">Exam Link</th>
                                    <th class="py-3 px-6 bg-gray-200 text-left text-sm font-semibold text-gray-700 border-b border-gray-300">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $rows = $db->getAllRowsFromTable("exam_links");
                                $count = 0;
                               if(count($rows)>0){
                                    foreach ($rows as $row) {
                                    $schedule_details_id = $row['schedule_details_id'];
                                    $course_id = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"course_id"));
                                    $section_id = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"section_id"));
                                    $schedule_id = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"schedule_id"));
                                    $proctor_id = ($db->getIdByColumnValue("schedule_details","id",$schedule_details_id,"proctor_id"));
                                   
                                   
                                    $section_name = ($db->getIdByColumnValue("section","id",$section_id,"section"));
                                    $title = ucwords($db->getIdByColumnValue("course","id",$course_id,"title"));
                                    $code = strtoupper($db->getIdByColumnValue("course","id",$course_id,"code"));
                                    $exam_type = strtoupper($db->getIdByColumnValue("schedule","id",$schedule_id,"exam_type"));

                                    $link = $row['link'];
                                    $password = $row['password'];

                                    if($proctor_id!=$_SESSION['id'])
                                    {
                                        continue;
                                    }
                                    $count+=1;
                                ?>
                                    <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200" data-id="<?php echo $row['id']; ?>" data-course-code="<?php echo $code; ?>" data-course-title="<?php echo $title; ?>" data-link="<?php echo $link; ?>">
                                        <td class="py-3 px-6 whitespace-nowrap border-b border-gray-300 text-gray-700"><?php echo $exam_type.' - '.$section_name; ?></td>
                                        <td class="py-3 px-6 border-b border-gray-300 text-gray-700"><?php echo $code; ?></td>
                                        <td class="py-3 px-6 border-b border-gray-300 text-gray-700"><?php echo $title; ?></td>
                                        <td class="py-3 px-6 border-b border-gray-300 ">
                                            <a target="_blank" href="<?php echo $link; ?>"><?php echo $link; ?></a>
                                        </td>
                                        <td class="py-3 px-6 border-b border-gray-300">
                                            <div class="relative">
                                                <input type="password" style="width: 150px;" value="<?=$password?>" class="password-field pr-10 pl-3 py-2 border border-gray-300 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                                <i class="material-icons toggle-password absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 cursor-pointer">visibility</i>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                                } 
                                
                                if($count==0){
                                    echo '
                                    <tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                        <td colspan="7" class="text-center py-3 px-6 border-b border-gray-300 text-gray-700">No data</td>
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

<?php 
include 'components/footer.php';
?>

<script>
    $('.nav-3').addClass('active-nav-link');
    $('.nav-3').addClass('opacity-100');
</script>

<script>
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const passwordField = this.previousElementSibling;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.textContent = 'visibility_off';
            } else {
                passwordField.type = 'password';
                this.textContent = 'visibility';
            }
        });
    });
</script>
