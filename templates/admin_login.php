<?php
    session_start();

    if(isset($_POST["submit"])){
        $user = $_POST["userid"];
        $passwd = $_POST["passwd"];


        include 'server_conn.php';
        $sql = "SELECT * FROM admins";
        $result = $conn->query($sql);

        $usermatchflag = 0;
        $passmatchflag = 0;
        if($result->num_rows > 0){
        while(($row = $result->fetch_assoc())) {
            if($row["adminid"] == $user){
                $usermatchflag = 1;
                if($row["password"] == $passwd)
                $passmatchflag = 1;
                break;
            }
        }
        }

        if($usermatchflag == 1){
        if($passmatchflag == 1){
            $_SESSION["user"] = $user;
            echo '<script>alert("Login successful!")</script>';
            echo '<script>location.href = "../admin/approval.php"</script>';
        }else
            echo '<script>alert("The userid and password mismatch. Try again!");</script>';
        }else
            echo '<script>alert("User id not in db: '. $user .'");</script>';
    }

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="../styles/admin_login.css">
    <title>Admin</title>
</head>
<body>
    <div class="container">
        <form class="card" action="admin_login.php" method="POST">
            <i class='fas fa-user-tie icon'></i>
            <div class="inbox">
                <div class="left-part">
                    <h4>ID</h4>
                </div>
                <input class="inp right-part" type="text" name="userid" placeholder="Enter admin id">
            </div>
            
            <div class="inbox">
                <div class="left-part">
                    <h4>PASSWORD</h4>
                </div>
                <input class="inp right-part" type="password" name="passwd" placeholder="Enter password">
            </div>
            <input class="submitbtn" type="submit" name="submit" value="Login">
        </form>
    </div>
</body>
</html>

