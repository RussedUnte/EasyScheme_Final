<?php 
session_start();
if(isset($_SESSION['position']))
{
$position = $_SESSION['position'];
    if($position=='faculty')
    {
        echo "<script>
        window.location.href='profile.php'
    </script>"; 
    }
    else {
        echo "<script>
        window.location.href='../index.php'
    </script>";
    }
}else
{
echo "<script>
    window.location.href='../index.php'
</script>";
}
?>
