<?php
  session_start();

  if(isset($_POST["submit"])){
    $user = $_POST["userid"];
    $passwd = $_POST["passwd"];

    $_SESSION["user"] = $user;

    include 'server_conn.php';
    $sql = "SELECT * FROM USER";
    $result = $conn->query($sql);

    $userfoundflag = 0;
    $passmatchflag = 0;
    if($result->num_rows > 0){
      while(($row = $result->fetch_assoc())) {
          if($row["username"] == $user){
            $userfoundflag = 1;
            if($row["PASSWD"] == $passwd)
              $passmatchflag = 1;
            break;
          }
      }
    }

    if($userfoundflag == 1){
      if($passmatchflag == 1){
        $_SESSION["user"] = $user;
        echo '<script>alert("Login successful!")</script>';
        echo '<script>location.href = "dashboard.php"</script>';
      }else
        echo '<script>alert("The userid and password mismatch. Try again!");</script>';
    }else
      echo '<script>alert("User id not in db: '. $user .'");</script>';
  }
?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../styles/login_form.css">
    <title>Login Page</title>
  </head>

  <body>
    <div class="section_container">
      <a class="adminbtn" href="admin_login.php">
        Admin
      </a>
      <h2>LOGIN</h2>
      <form action="login.php" method="POST" class="innerbox">
      <img class="item" src="../images/kolam_banner.png" width="384px" height="288px" alt="Kolam banner">
      <div class="form_user flexi">
        Userid <input type="text" name="userid" />
      </div>
      <div class="form_passwd flexi">
        Password:<input type="password" name="passwd" />
      </div>
      <div class="form_submit flexi">
        <input type="submit" name="submit" class="centry"/>
      </div>   
      </form>
      <a class="signupbtn" href="signup.php">
        Not having an account? SIGNUP here
      </a>
    </div>
  </body>
</html>