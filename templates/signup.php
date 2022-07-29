<?php
  session_start();

  if(isset($_POST["submit"])){
    $user = $_POST["userid"];
    $passwd = $_POST["passwd"];

    $_SESSION["user"] = $user;

    include 'server_conn.php';

    // Searching if there exists a username
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
      echo '<script>alert("Username already exists try new one");</script>';
    }else{
      $sql = "insert into user (username, PASSWD, ABOUT, USERID, RATING, PROFILE_PIC)
      VALUES('$user','$passwd', 'nothing', '1', '0', 'pic')";
      
      if($conn->query($sql) == TRUE){
          echo '<script>alert("Data entered in db");</script>';
          echo '<script>location.href = "login.php"</script>';
      }else
          die("Error in inserting: ".$conn->error);
    }
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
    <title>Signup Page</title>
  </head>

  <body>
    <div class="left_container">
      <img class="kolam_image" src="../images/kolam_banner.png" width="80%" height="80%" alt="Kolam banner">
    </div>
    
    <div class="right_container">
      <div class="in_container">
        <h2 class="font1">SIGNUP</h2>

        <form action="signup.php" method="POST" class="innerbox">

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

        <a class="signupbtn font1" href="login.php">
          Already having account? SignIn here
        </a>
      </div>  
    </div>

  </body>
</html>