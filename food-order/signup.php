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
        background: #dee9ff;
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
        <h2 class="text-center">Sign Up</h2>   
       <?php 
                if(isset($_SESSION['signup']))
                {
                    echo $_SESSION['signup'];
                    unset($_SESSION['signup']);
                }
                if(isset($_SESSION['val']))
                {
                    echo $_SESSION['val'];
                    unset($_SESSION['val']);
                }
                
       ?> 
        <div class="form-group">
                <input type="text" class="form-control item" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control item" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="email" placeholder="Email" required>
            </div>            
            <div class="form-group">
                <input type="date" class="form-control item" name="date" placeholder="Birth Date" required>
            </div>            
            <div class="form-group">
                <input type="submit" name="submit" value="Create Account" class="btn btn-primary btn-block create-account">
            </div>
    </form>
    
</div>

</body>
</html>                         

<?php 

    //CHeck whether the Submit Button is Clicked or NOt
    if(isset($_POST['submit']))
    {
        //Process for Login
        //1. Get the Data from Login form
        // $username = $_POST['username'];
        // $password = md5($_POST['password']);
        $username = $_POST['username'];                        
        $password = $_POST['password'];
        $email=$_POST['email'];
        $date=$_POST['date'];    
        if(strlen($username)<3)
            $_SESSION['val']="<div class='text-danger'>enter valid username</div>";
        else if(strlen($password)<4)
            $_SESSION['val']="<div class='text-danger'>enter valid password</div>";
        else if(filter_var($email,FILTER_VALIDATE_EMAIL)===false)
            $_SESSION['val']="<div class='text-danger'>enter valid email id</div>";
        else if(empty($date))
            $_SESSION['val']="<div class='text-danger'>enter your date of birth</div>";        
        else{
            $username = mysqli_real_escape_string($conn, $username);
            $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']),PASSWORD_BCRYPT,array('cost'=>12));

            $sql="select * from account where username='$username'";
            $res=mysqli_query($conn,$sql);
            $count=mysqli_num_rows($res);
            if(count>=1){
                $_SESSION['val']="<div class='text-danger text-center'>Already exist username</div>";
                header('location:'.SITEURL.'signup.php');
            }
            $sql="select * from account where email='$email'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);            
            if($count==0){
                $row="insert into account(username,password,email,dob) values('$username','$password','$email','$date')";
                $res=mysqli_query($conn, $row);
                if($res){                   
                    header('location:'.SITEURL.'login.php');
                }
                else{                                        
                    $_SESSION['signup']="<div class='text-danger'>Enter valid Data</div>";
                    header('location:'.SITEURL.'signup.php');
                }
            }
            else{                                    
                $_SESSION['signup']="<div class='text-danger text-center'>Already exist account</div>";
                header('location:'.SITEURL.'signup.php');
            }
        }
    }

?>