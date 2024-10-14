<?php
require_once $_SERVER['DOCUMENT_ROOT'] . __ROOT_CORE__ . '/Database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Permission {

    private $roles = [];

    function __construct()
    {
        $role_table = 'user_roles';
        $role_sql = "SELECT id, role_name FROM $role_table";
        $db = new Database();
        $roles = $db->query($role_sql)->fetchAll(PDO::FETCH_ASSOC);
        $this -> roles = $roles;
    }

    public function get_user_role_name() {
        // Check if user info is saved in the session
        if (isset($_SESSION['user']['role_id']) ) {
            $user_role = $_SESSION['user']['role_id'];
            foreach ($this -> roles as $role) {
                if ($role['id'] == $user_role) {
                    return $role['role_name'];
                }
            }
            return null;
        } else {
            return null;
        }
    }

    public function is_admin() {
        if ($this -> get_user_role_name() == 'admin') {
            return true;
        }
        return false;
    }

    public function is_employee() {
        if ($this -> get_user_role_name() == 'employee') {
            return true;
        }
        return false;
    }
}


?>