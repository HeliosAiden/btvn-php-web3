<?php

require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/homework/' . '/b9/middleware/Authenticate.php'; // Middleware to check if user is logged in

$auth = new Authenticate();
$login_url = __ROOT_DIR__ . '/b9/login.php';

if (!$auth->checkLogin()) {
    echo "
    <div class='modal fade' id='notLoggedInModal' tabindex='-1' aria-labelledby='notLoggedInModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='notLoggedInModalLabel'>Not Logged In</h5>
                </div>
                <div class='modal-body'>
                    <p>You are not logged in. Please log in to continue.</p>
                </div>
                <div class='modal-footer'>
                    <a id='login_button' class='btn btn-primary'>Go to Login</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        var notLoggedInModal = new bootstrap.Modal(document.getElementById('notLoggedInModal'));
        notLoggedInModal.show();
        var confirmButton = document.getElementById('login_button')
        confirmButton.addEventListener('click', () => {
            loadContent('$login_url')
            notLoggedInModal.hide()
        })
    </script>";
    exit;
}

?>

<!-- Bootstrap alert (hidden initially) -->
<div id="successAlert" class="alert alert-success alert-dismissible fade show mt-3" role="alert" style="display: none;">
    <strong>You have successfully change your password!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<!-- Bootstrap alert for errors (hidden initially) -->
<div id="errorAlert" class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="display: none;">
    <strong id="errorMessage">Error: </strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="container">
    <h2 class="mt-5">Change Password</h2>

    <!-- Bootstrap success alert (hidden by default) -->
    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <strong><?php echo $successMessage; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Bootstrap error alert (hidden by default) -->
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <strong><?php echo $errorMessage; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Change password form -->
    <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" class="form-control" id="current_password" name="current_password" required>
    </div>
    <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" class="form-control" id="new_password" name="new_password" required>
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>
    <button id="change_password_button" class="btn btn-primary">Change Password</button>

    <script>
        $(document).ready(function() {
            $('#change_password_button').click(function() {
                var currentPassword = $('#current_password').val();
                var newPassword = $('#new_password').val();
                var confirmPassword = $('#confirm_password').val();

                $.ajax({
                    url: '<?php echo __ROOT_DIR__; ?>/b9/utils/perform_change_password.php',
                    type: 'POST',
                    data: {
                        current_password: currentPassword,
                        new_password: newPassword,
                        confirm_password: confirmPassword
                    },
                    success: function(response) {
                        document.getElementById('successAlert').style.display = 'block';
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        document.getElementById('errorMessage').textContent = 'Error: Something went wrong!';
                        document.getElementById('errorAlert').style.display = 'block';
                    }
                })
            });
        })
    </script>
</div>