<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<style>
    body{
    background-color: #dee9ff;
    }
	.login-form {
		width: 340px;
    	margin: 50px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
</style>
</head>
<body>
<div class="login-form">
    <form action="" method="post">
        <h2 class="text-center">Log in</h2>   
        <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
            }                   
         ?> 
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" name="username" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block">
        </div>             
      <p class="text-center"> Don't have an account? <a href="signup.php">Create an Account</a></p>
    </form>
    
</div>
    <?php
        if(isset($_POST['submit']))
        {
            //Process for Login
            //1. Get the Data from Login form
            // $username = $_POST['username'];
            // $password = md5($_POST['password']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            
           
            $password = mysqli_real_escape_string($conn, $_POST['password']);        
            //2. SQL to check whether the user with username and password exists or not
            $sql = "SELECT * FROM account WHERE username='$username'";
            
            //3. Execute the Query
            $res = mysqli_query($conn, $sql);
    
            //4. COunt rows to check whether the user exists or not
            $count = mysqli_num_rows($res);
            $row = mysqli_fetch_array($res);      
            if($count>=1)
            {            
                //User AVailable and Login Success
                if(password_verify($password,$row['password'])){                                
                    $_SESSION['user'] = $username; //TO check whether the user is logged in or not and logout will unset it                
                    //REdirect to HOme Page/Dashboard    
                    if(strcmp($username,"Admin")==0){
                        header('location:'.SITEURL.'admin/index.php');
                    }
                    else{
                        header('location:'.SITEURL.'index.php');                    
                    }
                    
                }
                else{
                    $_SESSION['login'] = "<div class='text-danger text-center'>Username or Password did not match.</div>";
                    //REdirect to HOme Page/Dashboard
                    
                    header('location:'.SITEURL.'login.php');
                }
                
            }
            else
            {
                //User not Available and Login FAil
                $_SESSION['login'] = "<div class='text-danger text-center'>Username or Password did not match.</div>";
                //REdirect to HOme Page/Dashboard
                header('location:'.SITEURL.'login.php');
            }
    
    
        }
    ?>
</body>

</html>                                		