<?php
ini_set("display_errors", true);
    session_start();
    // include("functions/functions.php");
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
                    <li><a href="#">PH</a></li>
                    <li><a href="#">PH</a></li>
            </ul>
            <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn">Login - Register</button>
                    <div id="myDropdown" class="dropdown-content">
                      <a href="login.php">Login</a>
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
        if (isset($_POST['login'])) {
            $c_email = $_POST['email'];
            $c_pass = $_POST['pass'];
            $sel_c = "select * from customers where customer_pass='$c_pass' AND customer_email='$c_email'";
            $run_c = mysqli_query($con, $sel_c);
            $check_customer = mysqli_num_rows($run_c);
            if ($check_customer==0) {
                echo "<script>alert('Password or email is incorrect, please try again.')</script>";
                // exit();
                echo "<script>window.open('index.php','_self')</script>";
                exit();
            }
            $ip = getIP();
            $sel_cart = "select * from cart where ip_add='$ip'";
            $run_cart = mysqli_query($con, $sel_cart);
            $check_cart = mysqli_num_rows($run_cart);
            if ($check_customer>0 AND $check_cart==0){
                $_SESSION['customer_email'] = $c_email;
                echo "<script>alert('You logged in')</script>";
                echo "<script>window.open('index.php','_self')</script>";
            }
            else {
                $_SESSION['customer_email'] = $c_email;
                echo "<script>alert('You logged in')</script>";
                echo "<script>window.open('checkout.php','_self')</script>";
            }
        }
    ?>