<?php
    session_start();
    $user = $_SESSION["user"];

    include "../templates/server_conn.php";
    $sql = "SELECT * FROM kolam_image WHERE APPROVED = 0 ORDER BY C_TIMESTAMP DESC";

    $result = $conn->query($sql);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../styles/approval.css">
    <title>Approval Page</title>
    
</head>
<body>
    <div class="container">
        <a id="back" href="../templates/admin_logout.php">
            LOGOUT
        </a>

        <div class="heading">
            GALLERY (TO APPROVE)
        </div>

        <div class="viewer">
            <?php
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){ 
                        // Calling getimagesize() function
                        $ht = $row['HT'];
                        $wt = $row['WT'];
                        $auth = $row['AUTHOR'];

                        $desc = $row['DESCRIP'];
                        $imgsno = $row['SNO'];
                        $classn = "napproved";
                        
            ?>
                <div class="single">
                    <img class="responsive" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['KIMAGE']);?>" height="<?php echo $ht."px"?>" width="<?php echo $wt."px"?>" />
                    <pre class="description">
<?php echo $desc; ?><br>
By <h3 style="display: inline"><?php echo $auth; ?></h3>
                    </pre>   
                    <button id="approvebtn" class="<?php echo $classn; ?>" data-sno = "<?php echo $imgsno?>" >
                    APPROVE
                    </button>
                </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '.napproved', func);
        //$(document).on('click', '.approved', func);
        function func(){
            alert("Clicked");
            var imgsno = $(this).data('sno');
            //var name = $(this).attr('class');
            //alert(name);
            
            // Getting current likes 
            //var curr_likes = 0;
            // $.ajax({
            //     type: "GET",
            //     url: "get_like.php",
            //     async: false,
            //     data: {imgsno: imgsno},
            //     dataType: "text",
            //     success: function(response){
            //         curr_likes = response;
            //     }
            // });

            // var msg = "likes now: ."+curr_likes+". ";
            // alert(msg);

            // End of getting current like
            
            like_dis = "APPROVED !!!";
            $(this).addClass('approved').removeClass('napproved');
            $(this).html(like_dis);  
            
            $.ajax({
                url     :   'update_approve.php',
                method  :   'post',
                data    :   {imgsno: imgsno},
                success :   function(response){
                    // console.log("Response: .%s.",response);
                    // var flag = response;
                    console.log(response);
                }
            });

            function func(response){
                alert(response);
            }

        }
    });
</script>

</html>