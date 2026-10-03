<?php
$sessionPath = str_replace('\\', '/', dirname(__DIR__)) . '/session_data';
session_save_path($sessionPath);
session_start();

$_SESSION = [];
session_unset();
session_destroy();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

header("Location: login.php");
exit;
?>
