<?php
session_start();
$conn = new mysqli('localhost','root','','shoe_store');
 if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    $verify = "SELECT access_token FROM registration WHERE email ='$email'";
    $res = mysqli_query($conn,$verify);
    if(mysqli_num_rows($res)==1){
        $r = mysqli_fetch_assoc($res);
        $auth_code = $r['access_token'];
        if($auth_code != $_COOKIE['PHPSESSID']){
            header("Location: Home.php");
            exit();
        }
    }
    else{
        header("Location: Home.php");
        exit();
    }
 }
 else{
    header("Location: Home.php");
    exit();
 }
$email = $_SESSION["email"];
$query = mysqli_query($conn, "select * from registration where email = '$email'");
$row1 = mysqli_fetch_array($query);
if(isset($_POST['edit'])){
    $phoneNumber=$_POST['phoneNumber'];
    $address=$_POST['address'];
    $query1 = "UPDATE registration SET phoneNumber = '$phoneNumber' WHERE email = '$email'";
    $query2 = "UPDATE registration SET address = '$address' WHERE email = '$email'";
    $res1 = mysqli_query($conn,$query1);
    $res2 = mysqli_query($conn,$query2);
        if($res1 && $res2){
            header("Location: Profile.php");
        }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Profile</title>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    </head>
    <body>
        <div class="main_content">
            <div class="header">
                <div class="leftIcon">
                    <a href="./Home.php"><i class="fas fa-arrow-left">  Home</i></a>
                </div>
            </div>
            <div style="border: solid 2px;" id="div1">
                    <form action="Profile.php" method="post">
                    <b>First Name:  </b>
                    <input type="text" value="<?php echo $row1['firstName']?>" class="pom" style="cursor:default;" readonly> <br>
                    <b>Last Name:  </b>
                    <input type="text" value="<?php echo $row1['lastName']?>" class="pom" style="cursor: default;" readonly> <br>
                    <b>Email:  </b>
                    <input type="text" value="<?php echo $row1['email']?>" class="pom" style="cursor:default;" readonly> <br>
                    <b>Address:  </b>
                    <input type="text" name="address" value="<?php echo $row1['address']?>" class="pom"> <br>
                    <b>Phone number:  </b>
                    <input type="text" name="phoneNumber" value="<?php echo $row1['phoneNumber']?>" class="pom"> <br>
                    <input type="submit" value="Edit" name="edit" id="btn">
                    </form>
            </div>
            <!-- <?php if(isset($flag) and $flag==1){?>
               <p style="text-align: center; font-size: 25px; color: black;">Your profile has been updated</p>
            <?php } ?> -->
        </div>
    </body>
</html>
<style>
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  list-style: none;
  text-decoration: none;
}
#btn{
    padding: 10px 30px;
    font-size: 15px;
    border-radius: 15px;
    cursor: pointer;
    background: #34b8d1;
}
#div1{
    font-size: 30px;
    position: relative;
    display: block;
    /* float: left; */
    justify-content: center;
    margin: 3% 20%;
    padding: 3%;
    background: #262626;
    border-radius: 15px;
}
#div1 b{
    color: #d5f0f6;
}
.pom{
    margin: 10px;
    padding: 10px;
    border-radius: 10px;
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
  padding: 30px;
}
.main_content .header a{
    color: #34b8d1;
    position: fixed;
    left: 0;
    top: 0;
    margin-top: 20px;
    margin-left: 30px;

}
.main_content .header a:hover{
    color: #fff;
}
</style>