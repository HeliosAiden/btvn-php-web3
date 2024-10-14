<?php
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . __ROOT_CORE__ . '/Database.php';
$db = new Database();
$table = 'user_roles'; // Exact table name on phpadmin

$sql = "SELECT id, role_name FROM $table";
$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container">
    <h2 class="mt-5">Login</h2>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role" required>
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
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <button id="login" class="btn btn-primary">Login</button>
    <script>
        $(document).ready(function() {
            $('#login').click(function() {
                // Get the input values
                var username = $('#username').val();
                var role = $('#role').val();
                var password = $('#password').val();

                // Send the POST request via AJAX
                $.ajax({
                    url: '<?php echo __ROOT_DIR__; ?>/b9/utils/perform_login.php',
                    type: 'POST',
                    data: {
                        username: username,
                        role: role,
                        password: password
                    },
                    success: function(response) {
                        loadContent('<?php echo __ROOT_DIR__; ?>/b9/user_info.php')
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#response').html('<p>Error: ' + textStatus + '</p>');
                    }
                });
            });
        });
    </script>
</div>