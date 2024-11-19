function createTableFromJSON(jsonData) {
  let html = '<table style="width: 100%; border-collapse: collapse;">';

  // Create table headers
  html += '<thead><tr>';
  if (jsonData.length > 0) {
      Object.keys(jsonData[0]).forEach(key => {
          html += `<th class="whitespace-nowrap" style="border: 1px solid #ddd; padding: 8px; background-color: #f4f4f4;">${key}</th>`;
      });
      html += '</tr></thead><tbody>';

      // Create table rows
      jsonData.forEach(item => {
          html += '<tr>';
          Object.values(item).forEach(value => {
              html += `<td style="border: 1px solid #ddd; padding: 8px;">${value}</td>`;
          });
          html += '</tr>';
      });
      html += '</tbody>';
  } else {
      html += '<tr><td colspan="100%" style="text-align: center; padding: 8px;">No data available</td></tr></tbody>';
  }
  html += '</table>';
  return html;
}

function alertMaker(response) {
  // Separate the code from the JSON data
  var code = response.substring(0, 3).trim(); // Extract '101'
  var conflictsJson = response.substring(3).trim(); // Extract the JSON string

  // Handle different response codes
  switch (code) {
    
      case "101":
          // Check if JSON part is not empty before parsing
          if (conflictsJson) {
            try {
                // Parse the JSON string into an object
                const conflicts = JSON.parse(conflictsJson);

                // Handle the data based on the code
                if (code === '101' && conflicts.length > 0) {
                  Swal.fire({
                    icon: 'warning',
                    title: 'You have conflicted schedules!',
                    html: createTableFromJSON(conflicts),
                    width: '80%',
                    showCloseButton: true,
                    confirmButtonText: 'Got it!',
                    confirmButtonColor: '#3085d6',
                    background: '#fff', // Optional: Background color of the alert
                    customClass: {
                        popup: 'alert-popup' // Custom class for additional styling if needed
                    }
                });
                } else {
                    console.log('No conflicts found or wrong code.');
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
            }
          } else {
            console.log('No JSON data received.');
          }

        break;

      case "200":
          Swal.fire({
              icon: 'success',
              title: 'Data saved',
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
          }).then(() => {
              location.reload();
          });
          break;

      case "403":
          Swal.fire({
              icon: 'error',
              title: 'Data Error',
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
          }).then(() => {
              location.reload();
          });
          break;

      case "604":
          Swal.fire({
              icon: 'error',
              title: 'Old password wrong',
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
          }).then(() => {
              location.reload();
          });
          break;

      case "605":
          Swal.fire({
              icon: 'error',
              title: 'Password is not same',
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
          });
          break;

      case "701":
          Swal.fire({
              icon: 'error',
              title: 'Please make sure you added the section first',
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
          });
          break;

      case "702":
          Swal.fire({
              icon: 'error',
              title: 'The section you are trying to add is already in the list',
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
          });
          break;

      default:
          Swal.fire({
              icon: 'error',
              title:  code,
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
          });
          break;
  }
}


function action(page){
  $('#formSubmit').submit(function(event) {
      event.preventDefault(); 
      var formData = $(this).serialize();
      var isValid = true; // Assume the form is valid initially

      // Checking if all input fields are not empty
      $(this).find('input, select, textarea').each(function() {
        // Skip elements with the class 'not-required'
        if ($(this).hasClass('not-required')) {
            return true; // Continue to the next iteration
        }
    
        // Check if the field value is empty
        if ($.trim($(this).val()) === '') {
            isValid = false; // Set the form as invalid if any required field is empty
            return false; // Exit the loop
        }
    });
    


      if (isValid) {
          var formData = $(this).serialize();

          //For edit and Delete and Add
          var mode = $('#btnMode').text();

          formData = formData + '&mode='+mode

          $.ajax({
            url: page,
            type: 'POST',
            data: formData, // Corrected data format
            success: function(response) {
                   alertMaker(response);
                  }
                });


      } else {
          Swal.fire({
            icon: 'error',
            title: 'Please fill out all fields.',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            })
      }

      
      });
}

function actionModified(formID,page){
  $(formID).submit(function(event) {
    event.preventDefault(); 
    var formData = $(this).serialize();
    var isValid = true; // Assume the form is valid initially

    // Checking if all input fields are not empty
    if ($.trim($('#section').val()) === '') {
        Swal.fire({
            icon: 'error',
            title: 'Please fill out all fields.',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        });

        isValid = false; // Set the form as invalid if any field is empty
        return false; // Exit the function
    }

    if (isValid) {
        var formData = $(this).serialize();

        // For edit and Delete and Add
        var mode = $('#btnMode2').text();
        formData = formData + '&mode=' + mode;


        // Disable the submit button to prevent multiple clicks
        $(this).find('button[type="submit"]').prop('disabled', true);

        $.ajax({
            url: page,
            type: 'POST',
            data: formData, // Corrected data format
            success: function(response) {
                alertMaker(response);
                $(formID).find('button[type="submit"]').prop('disabled', false);

            },
            error: function() {
                // Re-enable the submit button after success or failure
                $(formID).find('button[type="submit"]').prop('disabled', false);
                
                Swal.fire({
                    icon: 'error',
                    title: 'An error occurred. Please try again.',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                });
            }
        });

    } else {
        Swal.fire({
            icon: 'error',
            title: 'Please fill out all fields.',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
        });
    }
});

}