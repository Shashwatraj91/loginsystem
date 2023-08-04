<?php
    $showalert = false;
    $showError = false;
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        include 'partials/dbconnect.php';
        $username=$_POST["username"];
        $password=$_POST["password"];
        $cpassword=$_POST["cpassword"];
        $existsql="SELECT * FROM `users` WHERE `username` LIKE '$username'";
        $existresult=mysqli_query($conn,$existsql);
        $numrows=mysqli_num_rows($existresult);
        if($numrows>0){
          $showError="user already exists!";
        }
        else{
            if(($password==$cpassword)){
              $hashpass=password_hash($password,PASSWORD_DEFAULT);
              $sql="INSERT INTO `users` (`username`, `password`, `time`) VALUES ('$username', '$hashpass', current_timestamp())";
              $result=mysqli_query($conn,$sql);
              if($result){
                  $showalert=true;
              }
            }
            else{
              $showError="password do not match";
            }
        }
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SignUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  </head>
  <body>
    <?php require 'partials/_navbar.php' ?>
    <?php
    if($showalert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success</strong> Account successfully created and you can login<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
    if($showError){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>'.$showError.'</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
    
    ?>
    
    <div class="container">
        <h1 class="text-center">Signup to our Website</h1>
        <form action="/loginsystem/signup.php" method="post">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" maxlength="11" name="username" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" maxlength="15" id="password" name="password">
  </div>
  <div class="mb-3">
    <label for="cpassword" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="cpassword" name="cpassword">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>