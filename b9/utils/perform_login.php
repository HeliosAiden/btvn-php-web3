<?php
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . __ROOT_CORE__ . '/Database.php';
$db = new Database();
$table = 'users'; // Exact table name on phpadmin

// Check if the username exists and the password matches
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    $sql = "SELECT username, role_id, email, id, password FROM $table WHERE username = '$username' AND role_id = '$role'";
    $result = $db->query($sql) -> fetchAll(PDO::FETCH_ASSOC);

    if(isset($result)){
        $user = $result[0];
        if (isset($user) && password_verify($password, $user['password']) && $user['role_id'] == $role) {
            session_start();
            $_SESSION['user'] = $user;
            header("Content-Type: application/json");
            http_response_code(200);
        } else {
            header("Content-Type: application/json");
            http_response_code(401);
            echo json_encode('Unauthorized: invalid credentials');
            exit;
        }
    }
} else {
    header("Content-Type: application/json");
    http_response_code(400);
    echo json_encode('Bad request');
    exit;
}
