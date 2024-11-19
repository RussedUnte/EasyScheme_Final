<?php 
session_start();
if(isset($_SESSION['position']))
{
$position = $_SESSION['position'];
    if($position=='scheduler')
    {
        echo "<script>
        window.location.href='scheduler/'
    </script>"; 
    }
    else if($position=='faculty'){
        echo "<script>
        window.location.href='faculty/'
    </script>"; 
    }
    else {
        echo "<script>
        window.location.href='index.php'
    </script>";
    }
}else
{
echo "<script>
    window.location.href='index.php'
</script>";
}
?>
