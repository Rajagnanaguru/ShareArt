<?php
    session_start();

    if(!isset($_SESSION["user"]))
        header('location: login.php');
        
    $user = $_SESSION["user"];

    include "server_conn.php";
    $sql = "SELECT * FROM kolam_image WHERE APPROVED = 1 ORDER BY C_TIMESTAMP DESC";

    $result = $conn->query($sql);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../styles/gallery.css">
    <title>Gallery</title>
    
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
                        // Calling getimagesize() function
                        $ht = $row['HT'];
                        $wt = $row['WT'];
                        $likes = $row['LIKES'];
                        $auth = $row['AUTHOR'];
                        $desc = $row['DESCRIP'];
                        $time = $row['C_TIMESTAMP'];
                        $imgsno = $row['SNO'];
                        
                        $classn = "likes";
                        $liked = 0;
                        $res = $conn->query("SELECT * from likes_count where userid='$user' and imgid='$imgsno'");
                        if($res->num_rows > 0){
                            $classn = "pressed";
                            $liked = 1;
                        } 
                        
                        // Displaying dimensions of the image
                        // echo "Width of image : " . $width . "<br>";
                        
                        // echo "Height of image : " . $height . "<br>";
                        
                        // echo "Image type :" . $type . "<br>";
                        
                        // echo "Image attribute :" .$attr;
            ?>
                <div class="single">
                    <img class="responsive" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['KIMAGE']);?>" height="<?php echo $ht."px"?>" width="<?php echo $wt."px"?>" />
                    <pre class="description">
<?php echo $desc; ?><br>
By <h3 style="display: inline"><?php echo $auth; ?></h3>
                    </pre>   
                    <button id="likebtn" class="<?php echo $classn; ?>" data-liked = "<?php echo $liked;?>" data-sno = "<?php echo $imgsno?>" data-likes = "<?php echo $likes?>" data-time="<?php echo $time?>" data-user="<?php echo $user?>" data-id="like_id" data-author="<?php echo $auth;?>">
                    &#x1F44D;<?php echo $likes; ?>
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
        $(document).on('click', '.likes', func);
        $(document).on('click', '.pressed', func);
        function func(){
            //alert($(this).data('author'))
            //var curr_likes = $(this).data('likes');
            var auth = $(this).data('author');
            var user = $(this).data('user');
            var ctime = $(this).data('time');
            var imgsno = $(this).data('sno');
            var liked = $(this).data('liked');

            var name = $(this).attr('class');
            //alert(name);
            
            // Getting current likes 
            var curr_likes = 0;
            $.ajax({
                type: "GET",
                url: "get_like.php",
                async: false,
                data: {imgsno: imgsno},
                dataType: "text",
                success: function(response){
                    curr_likes = response;
                }
            });

            // var msg = "likes now: ."+curr_likes+". ";
            // alert(msg);

            // End of getting current likes

            var add = -1;
            
            let like_dis = "";
            var thumb = "&#x1F44D;";
            if(name == 'pressed'){
                curr_likes = curr_likes - 1;
                like_dis = thumb.concat(curr_likes);
                add = -1;
                //alert('Liked before itself');
                $(this).addClass('likes').removeClass('pressed');
               
            }else{
                curr_likes = curr_likes - (-1);
                like_dis = thumb.concat(curr_likes);
                add = 1;
                //alert('Not liked before');
                $(this).addClass('pressed').removeClass('likes');
            
            }
            $(this).html(like_dis);  
            
            $.ajax({
                url     :   'updatelike.php',
                method  :   'post',
                data    :   {user: user, auth: auth, curr_likes: curr_likes, ctime: ctime, imgsno: imgsno, add: add},
                success :   function(response){
                    // console.log("Response: .%s.",response);
                    // var flag = response;
                    console.log(Response);
                }
            });

        }
    });
</script>

</html>