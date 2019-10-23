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
        <form action="index.php" method="post" enctype="multipart/form-data">
                    <h2 align="center">Create an account</h2>
                    <table align="center" width="750">
                    <tr>
                        <td align="right" style="color: white">Username:</td>
                        <td><input type="text" name="user_name" required/></td>
                    </tr>
                    <tr>
                        <td align="right" style="color: white">Password:</td>
                        <td><input type="password" name="user_passwd" required/></td>
                    </tr>
                    <tr>
                        <td align="right" style="color: white">First Name:</td>
                        <td><input type="text" name="firstname" required/></td>
                    </tr>

                    <tr>
                        <td align="right" style="color: white">Surname:</td>
                        <td><input type="text" name="surname" required/></td>
                    </tr>
                    <tr>
                        <td align="right" style="color: white">Profile Photo:</td>
                        <td><input type="file" name="profilePhoto" required/></td>
                    </tr>
                    <tr>
                        <td align="right" style="color: white">Contact:</td>
                        <td><input type="text" name="PhoneNumber" required/></td>
                    </tr>
                    <tr>
                        <td align="right" style="color: white">Email:</td>
                        <td><input type="text" name="email" required></td>
                    </tr>

                <tr align="right">
                    <td><input type="submit" name="register" value="Create Account" style="margin-left: 70px;"/></td>
                </tr>
            </table> 
</form>    
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
    if (isset($_POST['register'])) {;
        $username = $_POST['user_name'];
        $password = $_POST['user_passwd'];
        $firstname = $_POST['firstname'];
        $surname = $_POST['surname'];
        $image = $_FILES['profilePhoto']['name'];
        $image_tmp = $_FILES['profilePhoto']['tmp_name'];
        $contact = $_POST['PhoneNumber'];
        $email = $_POST['email'];
        move_uploaded_file($image_tmp, "users/user_images/$image");
        $sql = "INSERT INTO users (`user_name`, `user_passwd`, `user_firstname`, `user_surname`, `user_email`, `user_contact`, `user_image`) VALUES ('$username','$password','$firstname','$surname','$image_tmp','$contact','$email')";
        $pdo->prepare($sql)->execute([$username,$password,$firstname,$surname,$image_tmp,$contact,$email]);
    }
?>