<?php
    session_start();
    include "../templates/server_conn.php";
    $user = $_SESSION['user'];

    $imgsno = $_POST['imgsno'];
    
    $sql = "UPDATE kolam_image SET APPROVED = 1 WHERE SNO = '$imgsno'";

    if($conn->query($sql)){
        echo "Approved and updated!";
        return "updated!";
    }else{
        echo "Error in approval";
        return "Error";
    }
?>