<?php
    session_start();
    session_destroy();

    echo "<script>location.href = 'admin_login.php'</script>";
?>