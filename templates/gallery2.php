<?php
    session_start();
    $user = $_SESSION["user"];

    include "server_conn.php";
    $sql = "SELECT KIMAGE FROM kolam_image ORDER BY C_TIMESTAMP DESC";

    $result = $conn->query($sql);

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/gallery.css">
    <title>Gallery</title>
    <!-- <script>
    $(document).ready(function(
        $("#back").click(function(
            location.href = "dashboard.php";
        ));
    ));
    </script> -->
</head>
<body>
    <div class="container">
        <a id="back" href="dashboard.php">
            BACK
        </a>
        <div class="heading">
            GALLERY
        </div>
        <div class="viewer">
            <?php
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){ 
            ?>
                <img class="images" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['KIMAGE']);?>" height="350px" width="400px" />
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>
</html>