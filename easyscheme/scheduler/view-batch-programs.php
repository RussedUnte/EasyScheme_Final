<?php 
include 'components/header.php';
if(!isset($_GET['i']))
{
        echo
        "<script>
            window.location.href='profile.php'
        </script>";
}else{
    $institute_id = htmlentities($_GET['i']);
}
?>


<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex justify-center items-center p-6">

    
        <div class="w-full sm:w-1/2">

        <a href="generated_batches.php?i=<?=$institute_id ?>" class="bg-green-600 text-white rounded px-3 py-1">View Generated Batches</a>



            <div class="card bg-white shadow-md rounded-lg p-6">

            

                <h2 class="text-lg text-center font-extrabold mb-4 text-transform: uppercase">Select Program</h2>

                <?php 
                $rows = $db->getAllRowsFromTable('program_details');

                if(count($rows)>0){
                    foreach ($rows as $row ) {
                        $name = $row['program_name'];
                        $id = $row['id'];
                        if($row['institute']==$institute_id)
                        {
                            echo '<a href="batch-generator.php?i='.$id.'">
                                <h2 class="text-lg bg-green-700 rounded text-white px-3 py-2  text-center  mb-4 text-transform: uppercase">'.$name.'</h2>
                            </a>';
                        }
                    }
                }
                ?>
              
            </div>
        </div>
        
    </main>
</div>

<?php 
include 'components/footer.php';
?>
<script>
    var type = <?php echo json_encode($type);?>;
    
    if(type=='faculty')
    {
        $('.entries,.nav-4').addClass('active-nav-link')
        $('.entries,.nav-4').addClass('opacity-100')
    }
    if(type=='student')
    {
        $('.entries,.nav-5').addClass('active-nav-link')
        $('.entries,.nav-5').addClass('opacity-100')
    }
</script>