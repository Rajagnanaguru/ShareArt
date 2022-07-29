<?php
    session_start();

    include "server_conn.php";
    $user = $_SESSION["user"];

    $sql = "SELECT * FROM user where username = '$user'";

    $res = $conn->query($sql);
    $row = $res->fetch_assoc();

    $user = $row['username'];
    $passwd = $row['PASSWD'];
    $email = $row['EMAIL'];

    $photo = $row['PROFILE_PIC'];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../styles/profile.css">

    <title>Profile</title>
</head>
<body>
    <div class="container">
        <form class="box">
            <header class="heading"><h3>EDIT PROFILE</h3></header>
            
            <div class="top">
                <div class ="left">
                    <img src="<?php ?>" alt="Profile image"/>
                    <input type="file" name="new_img"/>
                </div>

                <div class="right">
                    <div class="inbox">
                        <h4>USERID</h4><input class="inp" name="userid" type="text" value="<?php echo $user;?>"/>
                    </div>
                    
                    <div class="inbox">
                        <h4>PASSWORD</h4><input class="inp" name="passwd" type="text" value="<?php echo $passwd;?>"/>
                    </div>

                    <div class="inbox">
                        <h4>EMAIL</h4><input class ="inp" name="email" type="text" value="<?php echo $email;?>"/>
                    </div>
                </div>
            </div>

            <div class="lastinbox">
                <input class="lastinp" type="submit" name="submit" value="Save"/>
                <input class="lastinp" type="submit" name="submit" value="Discard changes and back"/>
            </div>
        </form>
    </div>
</body>
</html>