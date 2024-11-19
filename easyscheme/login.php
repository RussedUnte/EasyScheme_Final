<?php 
// $password = password_hash('scheduler', PASSWORD_DEFAULT);
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
        .font-family-karla { font-family: 'Karla', sans-serif; }
        .bg-sidebar { background: #3d68ff; }
        .cta-btn { color: #3d68ff; }
        .upgrade-btn { background: #1947ee; }
        .upgrade-btn:hover { background: #0038fd; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
        .account-link:hover { background: #3d68ff; }
        .bg-body { background: #1e502d; }
        .bg-darkgreen { background: #1b4728;}
        .bg-orange { background: #f27c22; }
        
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body class="bg-body font-family-karla  p-4">

   
<p class="sm:text-right m-3 mt-0">
    <a href="index.php" class="w-2/5 px-3 py-2 hover:bg-orange-600 text-white font-bold rounded-full">Back to Portal</a>
</p>
<div class="flex items-center justify-center">
    <div class="flex flex-col items-center bg-white text-black rounded-lg sm:p-8  p-10 shadow-md  sm:w-1/2 w-full ">
        <img class="w-36 mb-0 p-0" src="assets/image/logo.png" alt="Logo">
        <h1 class="text-xl my-4 font-bold ">EasyScheme </h1>
    
        <form id="formSubmit" class="w-full flex flex-col items-center">
            <div class="mb-4 w-1/2">
                <input type="text" id="username" name="username" placeholder="Username" class="w-full p-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-black">
            </div>

            <div class="mb-4 w-1/2 relative">
                <input type="password" id="password" name="password" placeholder="Password" class="w-full p-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-black pr-10">
                <span class="absolute right-3 top-1/2 transform -translate-y-1/2">
                    <i id="password-eye" class="fas fa-eye cursor-pointer text-gray-500 hover:text-gray-700"></i>
                </span>
            </div>
            
            
            <button type="submit" id="login" class="w-2/5 py-2 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-full">Sign-in</button>
        </form>
        <div class="mt-4 w-full flex justify-end" >
            <p hidden class="text-sm text-gray-400 hover:underline cursor-pointer" id="forgot">Forgot your Password?</p>
        </div>
    </div>
</div>

</body>
</html>
<script src="js/login.js"></script>
<script>
    $(document).ready(function() {
        $('#password-eye').click(function(){
            var password = $('#password').attr('type');
            
            if(password==='password')
            {
                $(this).removeClass('fa-eye')
                $(this).addClass('fa-eye-slash')
                $('#password').attr('type','text')
            }else{
                $(this).addClass('fa-eye')
                $(this).removeClass('fa-eye-slash')
                $('#password').attr('type','password')
            }
        })
    });
</script>