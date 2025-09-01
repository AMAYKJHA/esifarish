<?php
session_start();
$is_admin = isset($_SESSION['admin_id']);
session_unset();
session_destroy();
if ($is_admin) {
    header('Location: ../admin-login.html');
} else {
    header('Location: ../citizen-login.html');
}
exit();
?>
