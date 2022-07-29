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
      echo '<script>alert("USERID NOT REGISTER, PLEASE REGISTER :) '. $user .'");</script>';
      
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
    <div class="left_container">
      <img class="kolam_image" src="../images/loginart.jpg" width="80%" height="80%" alt="Kolam banner">
    </div>
    
    <div class="right_container">
      <div class="in_container">
        <h2 class="font1">LOGIN</h2>

        <form action="login.php" method="POST" class="innerbox">

          <div class="form_user flexi">
            <input class="inp" type="text" name="userid" placeholder="Username"/>
          </div>
          <div class="form_passwd flexi">
            <input class="inp" type="password" name="passwd" placeholder="Password"/>
          </div>
          <div class="form_submit flexi">
            <input class="subbtn" type="submit" name="submit" class="centry" value="Enter"/>
          </div>

        </form>

        <a class="signupbtn" href="admin_login.php">
          <h3 class="font1">ADMIN</h3>
        </a>

        <a class="signupbtn font1" style="text-align: center" href="signup.php">
          Not having an account? SIGNUP here
        </a>
      </div>  
    </div>
  </body>
</html>