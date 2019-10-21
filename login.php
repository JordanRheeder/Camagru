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
