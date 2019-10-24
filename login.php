<?php
include('functions.php');
ini_set("display_errors", true);
if (session_id() === "") {
  session_start();
}
// if (!isset($_SESSION))
//   {
//     echo "starting session";
//     session_start();
//   }
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Camagru</title>
    <link rel="stylesheet" href="styles/index.css" media="all" />
    </head>
<body>
    <div class="main_wrapper">
        <div class="header_wrapper">
            <a href="index.php">
              <img id="banner" src="images/logom.png">
            </a>
        </div>
        <!--Navigation bar starts-->
        <div class="menubar">
            <ul id="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="my_account.php">My Account</a></li>
                    <li><a href="#">PH</a></li>
            </ul>
            <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn">Login - Register</button>
                    <div id="myDropdown" class="dropdown-content">
                    <?php
                       if(isset($_SESSION['user_email'])) {
                          echo "<a href='login.php?Logout=TRUE'>Logout</a>";
                        } else {
                          echo "<a href='login.php'>Login</a>";
                        }
                      ?>
                      <a href="register.php">Register</a>
                      <a href="fml.php">Forgot account-temp-</a>
                    </div>
                  </div>
                  <script>
                  /* When the user clicks on the button, 
                  toggle between hiding and showing the dropdown content */
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
                        if (openDropdown.classList.contains('show')) {
                          openDropdown.classList.remove('show');
                        }
                      }
                    }
                  }
                  </script>
        </div>
        <!--content wrapper starts-->
        <div class="content_wrapper">
        <div class="loginForm" align="center">
    <form method="post" action="">
        <table width="500" align="center" bgcolor="gray">
            <tr align="center">
                <td colspan="4"><h2>Login or Register<h2></td>
            </tr>
            <tr>
                <td align="right"><b>Email: </b></td>
                <td><input type="text" name="email" placeholder="Enter Email" required/></td>
            </tr>
            <tr>
                <td align="right"><b>Password: </b></td>
                <td><input type="password" name="pass" placeholder="Enter Password" required/></td>
            </tr>
            <tr align="center">
                <td colspan="3"><input type="submit" name="login" value="login" /></td>
            </tr>



        </table>
        <h2 style="float:center; padding='15px' "><a href="register.php" style="text-decoration:none; color:white">Register Here</a><h2>
    </form>
        </div>
                </div>
        <!--content wrapper ends-->
        <!--footer starts-->
        <div id="footer">
            <h2 style="text-align:center; padding-top:30px;">jrheeder</h2>
        </div>
        <!--footer ends-->
  </body>
</html>

<?php
      //********* Try connect to db, else echo error *********
      try {
        include ('config/connect.php');
      } catch(PDOException $e) {
        echo "ERROR: ".$e->getMessage();
        exit(2);
      }
      //******************************************************
       
        if (isset($_POST['login'])) {
          try {
            $email = $_POST['email'];
            $passwd = hash('whirlpool', $_POST['pass']);
        
            //********* Select password and email from the database to check whether it's a match. Then login... *********
            // $verifySQL = ("SELECT user_passwd, user_email, user_name FROM `users` WHERE user_passwd=:user_passwd AND user_email=:user_email AND user_name=:user_name");
            $verifySQL = ("SELECT * FROM `users` WHERE user_passwd=:user_passwd AND user_email=:user_email");
            $verify = $dbh->prepare($verifySQL);
            $verify->bindParam(':user_email', $email, PDO::PARAM_STR);
            $verify->bindParam(':user_passwd', $passwd, PDO::PARAM_STR);
            // $verify->bindParam(':user_name', $, PDO::PARAM_STR);
            // print_r($verifySQL);
            $verify->execute();
            //************************************************************************************************************
          
            //********* Fetch from table to verify *********
            $row = $verify->fetch();
            $check_email  = $row['user_email'];
            $check_passwd  = hash('whirlpool', $row['user_passwd']);
            $check_userID = $row['user_id'];
            //**********************************************
            
            //********* Compare values from DB to input, IF match THEN Login ELSE kick off *********

            // print("email=: $email -> DB-email=: $check_email\npasswd=:$passwd -> DB-passwd=:$check_passwd\n");
            // print("user_name=:  $user_name\n");
            if (($email === $check_email) && (hash('whirlpool',$passwd) === $check_passwd)) {
              // echo "email: ".$email;
              echo "<script>alert('Logged in');</script>";
              echo "<script>window.open('login.php', '_self')</script>";
                $_SESSION['user_email'] = $email;
            }else {
              echo "<script>alert('Incorrect email or password');</script>";
            }
            } catch(PDOException $e) {
              echo "ERROR: ".$e->getMessage();
              exit(2);
            }
          }
        // ******* LOG OUT ********
        if (isset($_GET['Logout'])) {
          logout();
        }
        // ************************
?>