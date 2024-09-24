<?php
    // require $_SERVER['DOCUMENT_ROOT'] . 'config.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
?>
<?php
// Kết nối db
require_once $_SERVER['DOCUMENT_ROOT'] . __ROOT_CORE__ . '/Database.php';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST["firstname"]) && empty($_POST["lastname"]) && empty($_POST["email"]) && !empty($_POST["id"])) {

    $table = 'myguests'; // Exact table name on phpadmin
    $id = $_POST['id'];
    $condition = "id = " . $id;

    $stmt = $db->delete($table, $condition);
}

?>

<div class="container mt-5">
    <h2 class="text-center">Delete selected guest</h2>

    <!-- Dropdown to select a guest -->
    <div class="mb-3">
        <label for="guestSelect" class="form-label">Select a Guest to Delete:</label>
        <select id="guestSelect" class="form-select">
            <option value="">Loading guests...</option>
        </select>
    </div>

    <!-- Button to delete the selected guest -->
    <button type="button" class="btn btn-danger" id="deleteBtn" disabled>Delete Guest</button>

    <!-- Response Placeholder -->
    <div id="response" class="mt-3"></div>

</div>

<script>
    $(document).ready(function() {
        // Fetch guests from the server (as done before)
        $.ajax({
            url: '<?php echo __ROOT_DIR__ ?>/b5_mydb/utils/getGuests.php', // The PHP script that returns guests as JSON
            type: 'GET',
            dataType: 'json',
            success: function(guests) {
                // Empty the guest select dropdown
                $('#guestSelect').empty();
                $('#guestSelect').append('<option value="">Select a guest...</option>');

                // Populate the dropdown with guest data
                guests.forEach(function(guest) {
                    $('#guestSelect').append('<option value="' + guest.id + '">' + guest.firstname + ' ' + guest.lastname + '</option>');
                });

                $('#deleteBtn').prop('disabled', true); // Disable the delete button initially
            },
            error: function() {
                $('#guestSelect').empty();
                $('#guestSelect').append('<option value="">Error loading guests</option>');
            }
        });

        // Enable the delete button when a guest is selected
        $('#guestSelect').change(function() {
            var selectedGuest = $(this).val();
            if (selectedGuest) {
                $('#deleteBtn').prop('disabled', false);
            } else {
                $('#deleteBtn').prop('disabled', true);
            }
        });

        // Handle the "Delete" button click
        $('#deleteBtn').click(function() {
            var guestId = $('#guestSelect').val();

            // Confirm the deletion
            if (confirm('Are you sure you want to delete this guest?')) {
                // Perform the AJAX POST request to delete the guest
                $.ajax({
                    url: '<?php echo __ROOT_DIR__ ?>/b5_mydb/delete.php', // The PHP script that handles the deletion
                    type: 'POST',
                    data: {
                        id: guestId
                    },
                    success: function(response) {
                        // Redirect to list
                        loadContent('<?php echo __ROOT_DIR__ ?>/b5_mydb/list.php')
                    },
                    error: function() {
                        $('#response').html('<div class="alert alert-danger">An error occurred while deleting the guest.</div>');
                    }
                });
            }
        });
    });
</script>