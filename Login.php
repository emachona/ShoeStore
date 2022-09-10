<?php
session_start();
?>
<?php
$conn = new mysqli('localhost','root','','shoe_store');
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM registration WHERE email = '$email' and password = '$password'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1){
        $auth_code = session_id();
        $_SESSION["email"] = $email;
        $auth_query = "UPDATE registration SET access_token = '$auth_code' WHERE email = '$email'";
        $res = mysqli_query($conn,$auth_query);
        if($res){
            header("Location: Home.php");
            exit();
        }
    }
    else{
        $error = 1;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    </head>
    <body>
        <div class="main_content">
            <div class="header">
                <div class="leftIcon">
                    <a href="./Home.php"><i class="fas fa-arrow-left">  Home</i></a>
                    <p style="color: #34b8d1; font-size: 50px;">Login</p>
                </div>
            </div>
        </div>
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <label for="email">Email</label><br>
            <input type="text" name="email" size="50" placeholder="@example.com"><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" size="50" placeholder="**********"><br>
            <input type="submit" value="Login" class="btn" name="login">
            <?php if(isset($error) and $error==1){?>
               <p>Incorrect Username or Password. Please try again!</p>
            <?php } ?>
        </form>
        <div style="text-align:center; color: #2aa3bb; font-size: 20px; padding-top: 20px;">No account? <a href="Register.php" style="color: #217f91;">Create one!</a></div>
    </body>
</html>
<style>
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  list-style: none;
}
body{
   background-color: #e6e6e6;
}
.main_content .header{
  background: #262626;
  color: #34b8d1;
  text-align: center;
  font-size: 20px;
  font-family: 'Times New Roman', serif;
  font-weight: bold;
  border-bottom: 1px solid #e0e4e8;
  margin: 0;
  padding: 20px;
  text-decoration: none;
}
.main_content .header a{
    color: #34b8d1;
    position: fixed;
    bottom: 0;
    left: 0;
    top: 0;
    margin-top: 35px; 
    margin-left: 30px;
}
.main_content .header a:hover{
    color: #fff;
}
form{
    text-align: center;
    margin-top: 50px;
    font-size:20px;
    font-family: 'Times New Roman', serif;
    font-weight: bold;
}
form input{
    padding: 10px;
    margin: 10px;
}
.btn{
    border-radius: 15px;
    padding: 15px 30px;
    background-color: #262626;
    color: #fff;
}
.btn:hover{
    background-color: #333333;
}
</style>