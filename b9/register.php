<?php
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . __ROOT_CORE__ . '/Database.php';
$db = new Database();
$table = 'user_roles'; // Exact table name on phpadmin

$sql = "SELECT id, role_name FROM $table";
$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Bootstrap alert (hidden initially) -->
<div id="successAlert" class="alert alert-success alert-dismissible fade show mt-3" role="alert" style="display: none;">
    <strong>You have successfully registered!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<!-- Bootstrap alert for errors (hidden initially) -->
<div id="errorAlert" class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="display: none;">
    <strong id="errorMessage">Error: </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="container">
    <h2 class="mt-5">Register New Account</h2>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role" required>
            <option value="">Select your role</option>
            <?php
            foreach ($result as $role) {
                $value = $role['id'];
                $name = $role['role_name'];
                echo "<option value='$value'>$name</option>";
            }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" id="email" name="email" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>

    <button id="register_new_user" class="btn btn-primary">Register</button>
    <script>
        $(document).ready(function() {
            $('#register_new_user').click(function() {
                // Get the input values
                var username = $('#username').val();
                var role = $('#role').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var confirm_password = $('#confirm_password').val();

                if (confirm_password !== password) {
                    $('#response').html('<p>Error: ' + 'Mismatch confirm passwkrd' + '</p>');
                }

                // Send the POST request via AJAX
                $.ajax({
                    url: '<?php echo __ROOT_DIR__; ?>/b9/utils/perform_register.php',
                    type: 'POST',
                    data: {
                        username: username,
                        email: email,
                        role: role,
                        password: password
                    },
                    success: function(response) {
                        document.getElementById('successAlert').style.display = 'block';
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        document.getElementById('errorMessage').textContent = 'Error: Something went wrong!';
                        document.getElementById('errorAlert').style.display = 'block';
                    }
                });
            });
        });
    </script>
</div>