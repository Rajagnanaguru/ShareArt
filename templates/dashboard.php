<?php
    session_start();

    if(!isset($_SESSION["user"]))
        echo '<script>location.href = "login.php"</script>';

    include "server_conn.php";
    $user = $_SESSION["user"];

    if(isset($_POST["submit"])){
        $status = $statusMsg = '';

        //  Testing  $_FILES['image] attributes
        // echo "Name: ".$_FILES['image']['name'];
        // echo "Type: ".$_FILES['image']['type'];
        //echo "tmp_name: ".$_FILES['image']['tmp_name'];
        // echo "Error: ".$_FILES['image']['error'];
        // echo "Size: ".$_FILES['image']['size'];

        /*
        Name: kolam7.jpg
        Type: image/jpeg
        tmp_name: C:\xampp\tmp\php6E24.tmp
        Error: 0
        Size: 204096
        */
        
        if(!empty($_FILES['image']['name'])){
            $file_name = pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
            $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            $ext_array = array("jpeg", "png", "jpg", "JPG", "JPEG", "PNG");
            $found = 0;
            $n = count($ext_array);
            for($i = 0; $i < $n; $i++)
                if($file_ext == $ext_array[$i])
                    $found = 1;
            
            if($found == 0){
                $statusMsg = "File format not acceptable";
                echo "<script>alert('$statusMsg');</script>";
                goto end;
            }else
                $statusMsg = "File format accepted";
        }else {
            $statusMsg = "Please select a file";
            echo "<script>alert('$statusMsg');</script>";
            goto end;
        }
        //echo "The author is ".$user;

        
  
        // Calling getimagesize() function
        list($width, $height, $type, $attr) = getimagesize($_FILES['image']['tmp_name']);
        
        //Displaying dimensions of the image
        // echo "Width of image : " . $width . "<br>";
        
        // echo "Height of image : " . $height . "<br>";
        
        // echo "Image type :" . $type . "<br>";
        
        // echo "Image attribute :" .$attr."  Done";
        
        // The author is user1Width of image : 413
        // Height of image : 531
        // Image type :2
        // Image attribute :width="413" height="531" Done


        $des = $_POST["text"];
        $image = $_FILES['image']['tmp_name'];
        $img_content = addslashes(file_get_contents($image));

        $sql = "INSERT INTO kolam_image (KIMAGE, HT, WT, AUTHOR, DESCRIP, APPROVED, C_TIMESTAMP, LIKES)
                VALUES ('$img_content','$height','$width','$user', '$des', '0', NOW(), '0')";

        if($conn->query($sql)){
            $statusMsg = "File uploaded successfully";
        }else {
            $statusMsg = "Error in uploading file";
        }


        // Responding and redirecting to same page to avoid duplicate submission while refreshing
        echo ("<script>
            alert('File uploaded!');
            location.href = 'dashboard.php';
        </script>");
    }

    end:
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../styles/dashboard.css">
</head>
<body>
    <div class="container">
        <div class="leftbar">
            <h3 style="color: black">Today: <?php echo date('d/m/Y'); ?> <br></h3> 
            <h3 style="color: black;">Hello! <?php echo $user; ?> <br></h3> 

            <a href="gallery.php" class="buttons">View gallery</a>
            <!-- <a href="profile.php" class="buttons">Edit profile</a> -->
        </div>
        

        <div class="rightbar">
            <a class="logout" href="logout.php">
                LOGOUT
            </a>

            <div class="dropdown">
                <button onclick="myFunction()" class="dropbtn">MENU</button>
                <div id="myDropdown" class="dropdown-content">
                    <!-- <div style="display: block">Hello,!</div> -->
                    <div class="navbtn">
                        <a class="navlinks" href="gallery.php">GALLERY</a>
                        <!-- <a class="navlinks" href="gallery.php">EDIT PROFILE</a> -->
                    </div>
                </div>
            </div>

            <a class="short-logout" href="logout.php">
                <img src="../images/icons/logout.png" alt="LOGOUT" />
            </a>

            
            <form class="centry" action="dashboard.php" method="POST" enctype="multipart/form-data" >
                <div class="heading">
                    <h2>UPLOAD TODAY'S ART</h2>
                </div>
                <div class="right_input">
                    <input style="color: white;" type="file" name="image">
                </div>
                <div class="right_input">
                    <textarea class="textbox" name="text" cols="40" rows="4"></textarea>
                </div>
                <div class="right_input">
                    <input class="subbtn" type="submit" name="submit" value="UPLOAD">
                </div>
            </form>
        </div>
    </div>
</body>

<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show'))
                    openDropdown.classList.remove('show');
            }
        }
    }
</script>

</html>