<?php
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/homework/' . '/b9/middleware/Authenticate.php'; // Middleware to check if user is logged in
require_once $_SERVER['DOCUMENT_ROOT'] . __ROOT_CORE__ . '/Database.php';
$db = new Database();

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

// If logged in, display user info
$user = $_SESSION['user'];
$table = 'user_roles';
$user_role = "";

$sql = "SELECT id, role_name FROM $table";
$roles = $db->query($sql) -> fetchAll(PDO::FETCH_ASSOC);
foreach($roles as $role) {
    $id = $role['id'];
    $role_name = $role['role_name'];
    if ($user['role_id'] == $id) {
        $user_role = $role_name;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">User Information</h5>
            <p class="card-text"><strong>User ID:</strong> <?php echo $user['id']; ?></p>
            <p class="card-text"><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p class="card-text"><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p class="card-text"><strong>Role:</strong> <?php echo $user_role; ?></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
