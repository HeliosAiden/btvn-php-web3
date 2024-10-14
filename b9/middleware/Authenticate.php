<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Authenticate {
    public static function checkLogin() {
        // Check if user info is saved in the session
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }
}

?>
