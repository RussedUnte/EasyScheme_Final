<?php 
include 'components/header.php';

// Check if program_id is set in the URL
if(!isset($_GET['i'])) {
    echo "<script>window.location.href='profile.php'</script>";
} else {
    $program_id = htmlentities($_GET['i']);
}
?>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex justify-center items-center p-6">
        <div class="w-full sm:w-1/2">
            <div class="card bg-white shadow-md rounded-lg p-6">
                <form id="formSubmit">
                    <div class="flex flex-col gap-3 items-center mt-3">
                        <!-- Hidden Program ID input -->
                        <input type="text" hidden name="program_id" id="program_id" value="<?=$program_id?>">
                        
                        <!-- Year Level Dropdown -->
                        <div class="grid w-full">
                            <p>Choose Year Level</p>
                            <select name="yearlevel" id="yearlevel" class="border-black border-2 rounded px-4">
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                        </div>

                        <!-- Input Field for Batch Count -->
                        <div class="grid w-full">
                            <p>Enter Number of Batches</p>
                            <input type="number" name="batch_count" id="batch_count" class="border-black border-2 rounded px-4" min="1" placeholder="Enter number of batches">
                        </div>

                        <!-- Submit Button -->
                        <div class="w-full">
                            <button type="submit" id="btnMode" class="bg-green-600 text-white rounded px-3 py-1">Create Batches Now</button>
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
    // Ensure that the form is submitted to the correct action
    action('controller/batch_generator.php');
</script>
