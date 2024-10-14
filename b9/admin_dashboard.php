<?php

require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/homework/' . '/b9/middleware/Authenticate.php'; // Middleware to check if user is logged in
require_once $_SERVER['DOCUMENT_ROOT'] . '/homework/' . '/b9/middleware/Permission.php'; // Middleware to check if user is logged in

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

$permission = new Permission();
$user_info_url =  __ROOT_DIR__ . '/b9/user_info.php';

if (!$permission->is_admin()) {
    echo "
    <div class='modal fade' id='notAdminModal' tabindex='-1' aria-labelledby='notAdminModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='notAdminModalLabel'>Invalid permission</h5>
                </div>
                <div class='modal-body'>
                    <p>You are not admin. The site content is forbiddent.</p>
                </div>
                <div class='modal-footer'>
                    <a id='user_info_button' class='btn btn-primary'>Go to User info</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        var notAdminModal = new bootstrap.Modal(document.getElementById('notAdminModal'));
        notAdminModal.show();
        var confirmButton = document.getElementById('user_info_button')
        confirmButton.addEventListener('click', () => {
            loadContent('$user_info_url')
            notAdminModal.hide()
        })
    </script>";
    exit;
}



require_once $_SERVER['DOCUMENT_ROOT'] . __ROOT_CORE__ . '/Database.php';
$db = new Database();
$user_table = 'users';
$role_table = 'user_roles';

// Pagination logic
$limit = 10; // Number of entries to show per page
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$start_from = ($page - 1) * $limit;

// Fetch records with pagination
$user_sql = "SELECT id, username, password, email, role_id FROM $user_table LIMIT $start_from, $limit";
$role_sql = "SELECT id, role_name FROM $role_table";

$users = $db->query($user_sql)->fetchAll(PDO::FETCH_ASSOC);
$roles = $db->query($role_sql)->fetchAll(PDO::FETCH_ASSOC);


?>
<div class="container mt-5">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($users)) {
                // Output data of each row
                foreach ($users as $row) {
                    $user_role = 'undefined';
                    foreach ($roles as $role) {
                        echo $role['id'];
                        if ($role['id'] == $row['role_id']) {
                            $user_role = $role['role_name'];
                        }
                    }
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['password']}</td>
                        <td>{$row['email']}</td>
                        <td>{$user_role}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    // Pagination controls
    $sql = "SELECT COUNT(id) FROM $user_table";
    $result = $db->query($sql);
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    $total_records = $row[0]['COUNT(id)'];
    $total_pages = ceil($total_records / $limit);


    echo '<nav aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-center">';
    $root = __ROOT_DIR__;

    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<li class='page-item'><a class='page-link' href='#' onclick=loadContent(" . "'$root/b9/admin_dashboard.php?page=" . $i . "') >" . $i . "</a></li>";
    }

    echo '</ul>';
    echo '</nav>';

    ?>
</div>