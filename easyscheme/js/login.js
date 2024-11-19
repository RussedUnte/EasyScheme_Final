$("#formSubmit").submit(function(event) {
    // Prevent the default form submission
    event.preventDefault();

    // Get form data
    var formData = $(this).serialize();

    // Send an Ajax POST request
    $.ajax({
      type: "POST",
      url: "controller/login.php", // Replace with your server-side script
      data: formData,
      success: function(response) {
        if (response === '200') {
            console.log(response)
          // Show a success SweetAlert
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Login successful!',
          }).then(function() {
            // Redirect to index.php
            window.location.href = 'checker.php';
          });
        } else {
          // Show an error SweetAlert
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Wrong Password!',
          });
        }
      },
      error: function() {
        // Handle errors
        $("#result").html("An error occurred.");
      }
    });

  });