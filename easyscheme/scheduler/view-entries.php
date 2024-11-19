<?php 
include 'components/header.php';
if(isset($_GET['type']))
{
    $type = $_GET['type'];

    $types = ['student','faculty'];
    if (!in_array($type, $types))
    {
            echo
            "<script>
                window.location.href='profile.php'
            </script>";
    }
}
?>


<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex justify-center items-center p-6">
        <div class="w-full sm:w-1/2">
            <div class="card bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg text-center font-extrabold mb-4 text-transform: uppercase">Select institute for <?=$type?></h2>

                <?php 
                $rows = $db->getAllRowsFromTable('institutes');

                if(count($rows)>0){
                    foreach ($rows as $row ) {
                        $name = $row['name'];
                        $id = $row['id'];
                        echo '<a href="view-'.$type.'-table.php?id='.$id.'">
                                <h2 class="text-lg bg-green-700 rounded text-white px-3 py-2  text-center  mb-4 text-transform: uppercase">'.$name.'</h2>
                            </a>';
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