<?php 
include '../conn/conn.php';
$db = new DatabaseHandler();
$username = ($db->getIdByColumnValue('user', 'id',$_SESSION['id'],'username'));
$user_name = ucwords($db->getIdByColumnValue('user', 'id',$_SESSION['id'],'name'));
$user_position = ucwords($db->getIdByColumnValue('user', 'id',$_SESSION['id'],'position'));
if(isset($_SESSION['position'])){
    $position = $_SESSION['position'];
    if($position !="faculty"){
        header("Location:../login.php");
    }
}else{
    header("Location:../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyScheme</title>
    <meta name="author" >
    <meta name="description" content="">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #1e502d; }
        .cta-btn { color: #1e502d; }
        .active-nav-link { background: #f27c22; }
        .searchicon { color: #f27c22; }
        .nav-item:hover { background: #f27c22; }
        .account-link:hover { background: #1e502d; }
        .bg-orange { background: #f8ecdc; }
        .text-orange { color: #e07330; }
        
    </style>
</head>
<body class="bg-gray-100 font-family-karla flex">

    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-2  text-center">
            <a href="" class="text-white  font-semibold uppercase hover:text-gray-300">
                    <!-- <div class="flex flex-row items-center rounded"> -->
                        <!-- <img src="assets/image/logo.png" width="80px" alt=""> -->
                        <p>EasyScheme</p>
                    <!-- </div> -->
            </a>
        </div>
        <nav class="text-white text-base font-semibold pt-3 ">
            <a href="view-schedule.php" class="nav-2 flex items-center text-white opacity-75 hover:opacity-100 py-3 m-2 rounded-lg  pl-4 nav-item">
                <i class="material-icons mr-3">calendar_month</i>
                View Schedules
            </a>
            <a href="view-exam-links.php" class="nav-3 flex items-center text-white opacity-75 hover:opacity-100 py-3 m-2 rounded-lg  pl-4 nav-item">
                <i class="material-icons mr-3">link</i>
                Exam Links
            </a>
            <a href="raise-concerns.php" class="nav-4 flex items-center text-white opacity-75 hover:opacity-100 py-3 m-2 rounded-lg  pl-4 nav-item">
                <i class="material-icons mr-3">rocket</i>
               Raise Concernss
            </a>
            <a href="edit-my-schedule.php" class="nav-5 flex items-center text-white opacity-75 hover:opacity-100 py-3 m-2 rounded-lg  pl-4 nav-item">
                <i class="material-icons mr-3">calendar_month</i>
                Edit My Schedule
            </a>
        </nav>
    </aside>

    <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <header class="w-full items-center bg-white py-3 px-6 hidden sm:flex">
            <div class="w-1/2">
                <div class="relative w-3/4">
                </div>
            </div>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <div class="grid grid-cols-2 items-center justify-center">
                    <div class="grid mr-3 flex justify-end">
                        <!-- <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                            <img src="https://cdn.pixabay.com/photo/2014/03/25/16/54/user-297566_640.png">
                            
                        </button> -->
                    </div>
                    <div class="grid " style="cursor:pointer" @click="isOpen = !isOpen">
                        <p class="text-base font-bold"><?=$user_name?></p>
                        <p class="text-sm font-light"><?=$user_position?></p>
                    </div>
                </div>
                <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="profile.php" class="block px-4 py-2 account-link hover:text-white">Profile</a>
                    <a href="../" class="block px-4 py-2 account-link hover:text-white">Log Out</a>
                </div>
            </div>
        </header>

        <!-- Mobile Header & Nav -->
        <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
            <div class="flex items-center justify-between">
                <a href="departments.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
                <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                    <i x-show="!isOpen" class="fas fa-bars"></i>
                    <i x-show="isOpen" class="fas fa-times"></i>
                </button>
            </div>

            <!-- Dropdown Nav -->
            <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
                <a href="view-schedule.php" class="nav-2 flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item rounded-lg m-1">
                    <i class="material-icons mr-3">calendar_month</i>
                    View Schedules
                </a>
                <a href="view-exam-links.php" class="nav-3 flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item rounded-lg m-1">
                    <i class="material-icons mr-3">link</i>
                    Exam Links
                </a>
                <a href="raise-concerns.php" class="nav-4 flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item rounded-lg m-1">
                    <i class="material-icons mr-3">rocket</i>
                    Raise Concerns
                </a>
                
            </nav>
        </header>
