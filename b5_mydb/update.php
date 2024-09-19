<?php
// require $_SERVER['DOCUMENT_ROOT'] . 'config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
?>

<?php

require_once __DIR__ . '/Database.php';

$db = new Database();
$table = 'myguests'; // Exact table name on phpadmin

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["firstname"]) && !empty($_POST["lastname"]) && !empty($_POST["email"]) && !empty($_POST["id"])) {

    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    $data = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
    ];
    $condition = "id = " . $id;

    $stmt = $db->update($table, $data, $condition);
}
?>

<body class="container mt-5">

    <h1 class="text-center">Update Guest Information</h1>
    <br />
    <br />
    <br />

    <!-- Dropdown to select a guest -->
    <div class="mb-3">
        <label for="guestSelect" class="form-label">Select a Guest:</label>
        <select id="guestSelect" class="form-select">
            <!-- Guests will be dynamically populated here -->
        </select>
    </div>

    <!-- Display guest info with disabled inputs initially -->
    <input type="hidden" id="id">

    <div class="mb-3">
        <label for="firstname" class="form-label">First Name</label>
        <input type="text" class="form-control" id="firstname" disabled>
    </div>

    <div class="mb-3">
        <label for="lastname" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="lastname" disabled>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" disabled>
    </div>

    <!-- Buttons to Edit and Update -->
    <div class="text-center mt-2">
        <button type="button" class="btn btn-primary" id="editBtn">Edit</button>
        <button type="button" class="btn btn-success" id="updateBtn" disabled>Update</button>
    </div>

    <!-- Response Placeholder -->
    <div id="response" class="mt-3"></div>

    <script>
        $(document).ready(function() {
            // Load guests from the database via an AJAX request to a PHP script that returns the guests as JSON
            $.ajax({
                url: `<?php echo __ROOT_DIR__ ?>/b5_mydb/utils/getGuests.php`, // The PHP script that returns guests as JSON
                type: 'GET',
                dataType: 'json',
                success: function(guests) {
                    // Empty the guest select dropdown
                    $('#guestSelect').empty();
                    $('#guestSelect').append('<option value="">Select a guest...</option>');

                    // Populate the dropdown with guest data
                    guests.forEach(function(guest) {
                        $('#guestSelect').append('<option value="' + guest.id + '" data-firstname="' + guest.firstname + '" data-lastname="' + guest.lastname + '" data-email="' + guest.email + '">' + guest.firstname + ' ' + guest.lastname + '</option>');
                    });
                },
                error: function() {
                    $('#guestSelect').empty();
                    $('#guestSelect').append('<option value="">Error loading guests</option>');
                }
            });

            // When a guest is selected, populate the fields
            $('#guestSelect').change(function() {
                var selectedGuest = $(this).find(':selected');
                var id = selectedGuest.val();
                var firstname = selectedGuest.data('firstname');
                var lastname = selectedGuest.data('lastname');
                var email = selectedGuest.data('email');

                // Populate the form fields
                $('#id').val(id);
                $('#firstname').val(firstname);
                $('#lastname').val(lastname);
                $('#email').val(email);

                // Disable the form fields initially
                $('#firstname, #lastname, #email').prop('disabled', true);
                $('#updateBtn').prop('disabled', true);
            });

            // Enable editing when "Edit" button is clicked
            $('#editBtn').click(function() {
                $('#firstname, #lastname, #email').prop('disabled', false);
                $('#updateBtn').prop('disabled', false);
            });

            // Handle the "Update" button click
            $('#updateBtn').click(function() {
                // Get the updated values
                var id = $('#id').val();
                var firstname = $('#firstname').val();
                var lastname = $('#lastname').val();
                var email = $('#email').val();

                // Perform the AJAX POST request
                $.ajax({
                    url: `<?php echo __ROOT_DIR__ ?>/b5_mydb/update.php`, // The PHP script that handles the update
                    type: 'POST',
                    data: {
                        id: id,
                        firstname: firstname,
                        lastname: lastname,
                        email: email
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            // Redirect to list
                            console.log('success!')
                            loadContent(`<?php echo __ROOT_DIR__ ?>/b5_mydb/list.php`)
                        } else {
                            $('#response').html('<div class="alert alert-danger">' + result.message + '</div>');
                        }
                    },
                    error: function() {
                        console.log('something went wrong');
                        $('#response').html('<div class="alert alert-danger">An error occurred while updating the guest.</div>');
                    }
                });

                loadContent(`<?php echo __ROOT_DIR__ ?>/b5_mydb/list.php`)
            });
        });
    </script>