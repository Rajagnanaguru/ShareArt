<?php
    include "server_conn.php";

    if(isset($_POST['auth'])){
        $curr_user = $_POST['user'];
        $auth = $_POST['auth'];
        
        $ctime = $_POST['ctime'];
        $imgsno = $_POST['imgsno'];
        $add = $_POST['add'];

        $curr_likes = 0;

        $sql = "SELECT * FROM kolam_image where SNO = '$imgsno'";
        $res = $conn->query($sql);
        if($res->num_rows == 1){
            while($row = $res->fetch_assoc()){
                $curr_likes = $row['LIKES'];
            }
        }

        $curr_likes += $add;

        if($add == 1){
            $sql = "INSERT INTO likes_count (userid, imgid) values('$curr_user','$imgsno')";
            echo "<script>alert('Added');</script>";
        }else{
            $sql = "DELETE FROM likes_count where userid = '$curr_user' and imgid = '$imgsno'";
            echo "<script>alert('Deleted');</script>";
        }

        if($conn->query($sql))
            echo "<script>console.log('Like details updated');</script>";
        
        $sql = "UPDATE kolam_image SET LIKES = '$curr_likes' WHERE AUTHOR = '$auth' and C_TIMESTAMP = '$ctime'";
        if($conn->query($sql)){
            echo "<script>console.log('Like count updated');</script>";
            return '1';
        }
        // }
    }
    return 0;
?>