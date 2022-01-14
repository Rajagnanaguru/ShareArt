<?php
    include "server_conn.php";

    $imgno = $_GET["imgsno"];
    $sql = "SELECT * FROM kolam_image where SNO = '$imgno'";

    $res = $conn->query($sql);

    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            echo $row["LIKES"];
            return $row["LIKES"];
        }
    }

    echo 0;
    return 0;
?>