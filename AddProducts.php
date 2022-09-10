<?php
session_start();
$conn = new mysqli('localhost','root','','shoe_store');
 if(isset($_SESSION['email'])){
  $jej = 1;
  $email = $_SESSION['email'];
  $verify = "SELECT access_token FROM registration WHERE email ='$email'";
  $res = mysqli_query($conn,$verify);
 }
 else{
    $jej = 0;
 }
// error_reporting(0);

if (isset($_POST['upload'])) {
 
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./images/" . $filename;

    if(!isset($brand)){
        $brand = $_POST['brand'] ?? '';
    }
    if(!isset($model)){
        $model = $_POST['model'] ?? '';
    }
    if(!isset($gender)){
        $gender = $_POST['gender'] ?? '';
    }
    if(!isset($size)){
        $size = $_POST['size'] ?? '';
    }
    if(!isset($price)){
        $price = $_POST['price'] ?? '';
    }

    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);
    }
    else{
        $stmt = $conn->prepare("insert into product(filename, brand, model, price, size, gender) values(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiis", $filename, $brand, $model, $price, $size, $gender);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header("Location: Kicks.php");
    }
 
    // $sql = "INSERT INTO product (filename, brand, model, price) VALUES ('$filename')";

    // mysqli_query($conn, $sql);

    if (move_uploaded_file($tempname, $folder)) {
        echo "<h3>  Image uploaded successfully!</h3>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }
}
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Add Product</title>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    </head>
 
<body>
<div class="wrapper">
    <div class="main_content">
        <div class="header">
            <div class="leftIcon">
                <a href="./Kicks.php"><i class="fas fa-arrow-left">  Back</i></a>
            </div>
            <span style="color:white">Add Product for Sale</span>
            <div class="rightIcons" style="font-size: 0.5rem;">
                <?php if($jej == 0){ ?>
                <a href="Login.php"><i class="far fa-door-open fa-3x" style="color:white;"></i></a>
                <?php }else {?>
                <a href="Logout.php"><i class="far fa-door-closed fa-3x" style="color:white;"></i></a>
                <?php } ?>
            </div>
        </div>
        <div id="content">
            <form method="POST" action="" enctype="multipart/form-data">
                <label for="brand">Brand</label>
                <input type="text" name="brand" size="40" class="pom" required="required"><br>
                <label for="model">Model Name</label>
                <input type="text" name="model" size="40" class="pom" required="required"><br>
                <label for="model">Gender</label>
                <input type="text" name="gender" size="40" class="pom" required="required"><br>
                <label for="model">Size</label><br>
                <input type="number" name="size" size="40" class="pom" required="required"><br>
                <label for="price">Price</label><br>
                <input type="number" step="0.01" name="price" size="40" class="pom" required="required"><br>
                <label for="filename">Picture</label><br>
                <div class="form-group">
                    <br>
                    <input class="form-control" type="file" name="uploadfile" value="" />
                </div>
                <div class="form-group">
                    <br>
                    <button class="btn" type="submit" name="upload">UPLOAD</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
 
</html>
<style>
    @import url('https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap');

*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  list-style: none;
  text-decoration: none;
}
* {box-sizing: border-box;}

.rightIcons {
    position: fixed;
    right: 0;
    top: 0;
    margin-top: 30px;
    margin-right: 20px;
}
.leftIcon{
    position: fixed;
    left: 0;
    top: 0;
    margin-top: 30px;
    margin-left: 20px;
    color: white;
    font-size: 20px;
}

body{
   background-color: #e6e6e6;
}

.wrapper{
  display: flex;
  position: relative;
}

.wrapper .main_content{
  width: 100%;
  /* margin-left: 160px; */
}
.wrapper .main_content .header{
  padding: 20px;
  background: #262626;
  color: #34b8d1;
  text-align: center;
  font-size: 40px;
  font-family: 'Times New Roman', serif;
  font-weight: bold;
  border-bottom: 1px solid #e0e4e8;
  margin-bottom: 20px;
}
.wrapper .main_content .header a{
    color: #34b8d1;
}
.wrapper .main_content .header a:hover{
    color: #fff;
}

#content{
	width: 50%;
	justify-content: center;
	align-items: center;
	margin: 20px auto;
	border: 1px solid #cbcbcb;
    font-size: 18px;
    background: #262626;
    border-radius: 15px;
    color: #d5f0f6;
}
form{
	width: 50%;
	margin: 20px auto;
}

#display-image{
	width: 100%;
	justify-content: center;
	padding: 5px;
	margin: 15px;
}
img{
	margin: 5px;
	width: 350px;
	height: 250px;
}
.btn{
    padding: 10px 30px;
    font-size: 15px;
    border-radius: 15px;
    cursor: pointer;
    background: #34b8d1;
    margin-left: 30%;
}
.pom{
    margin: 10px;
    padding: 8px;
    border-radius: 10px;
}
.form-control{
    margin-left: 10px;
    padding: 3px;
    font-size: 17px;
}