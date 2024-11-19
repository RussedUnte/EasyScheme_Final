<?php 
include 'components/header.php';
?>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex justify-center items-center p-6">
        <div class="w-full sm:w-1/2">
            <div class="card bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg text-center font-semibold mb-4">Update Account Details:</h2>
                <form id="formSubmit">
                <div class="flex flex-col gap-3 items-center mt-3">
                        <div class="grid w-full">
                            <p>Username : <?=$username?></p>
                            <input type="text" name="username" placeholder="New Username" class="border-black border-2 rounded px-4">
                        </div>
                        <div class="grid w-full">
                            <p>Change Password</p>
                            <input type="password" name="new_password" placeholder="Type new password" class="border-black border-2 rounded px-4">
                        </div>
                        <div class="grid w-full">
                            <p>Confirm Password</p>
                            <input type="password" name="confirm_password" placeholder="Type new password" class="border-black border-2 rounded px-4">
                        </div>
                        <div class="grid w-full">
                            <p>Enter old password to save changes</p>
                            <input type="password" name="old_password" placeholder="Type old password" class="border-black border-2 rounded px-4">
                        </div>
                        <div class="w-full">
                            <button type="submit" id="btnMode" class="bg-green-600 text-white rounded px-3 py-1">Save Changes</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php 
include 'components/footer.php';
?>

<script src="js/addForm.js"></script>
<script>
    action('controller/profile.php')
</script>