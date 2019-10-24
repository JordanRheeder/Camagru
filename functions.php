<?php
function logout() {
    if (isset($_GET['Logout'])) {
        if ($_GET['Logout'] == 'TRUE') {
            session_destroy();
            echo "<script>window.open('index.php', '_self')</script>";
        }
    }
}
?>

