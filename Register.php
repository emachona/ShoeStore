<?php
if(!isset($firstName)){
    $firstName = $_POST['firstName'] ?? '';
}
if(!isset($lastName)){
    $lastName = $_POST['lastName'] ?? '';
}
if(!isset($address)){
    $address = $_POST['address'] ?? '';
}
if(!isset($email)){
    $email = $_POST['email'] ?? '';

}
if(!isset($password)){
    $password = $_POST['password'] ?? '';
}
if(!isset($phoneNumber)){
    $phoneNumber = $_POST['phoneNumber'] ?? '';
}
if(!empty($firstName) && !empty($lastName) && !empty($address) && !empty($email) && !empty($password) && !empty($phoneNumber)){
$conn = new mysqli('localhost','root','','shoe_store');
if($conn->connect_error){
    die('Connection Failed : '.$conn->connect_error);
}
else{
    $stmt = $conn->prepare("insert into registration(firstName, lastName, address, email, password, phoneNumber) values(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $firstName, $lastName, $address, $email, $password, $phoneNumber);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("Location: http://localhost/ShoeStore/Login.php");
}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    </head>
    <body>
        <div class="main_content">
            <div class="header">
                <div class="leftIcon">
                    <a href="./Home.php"><i class="fas fa-arrow-left">  Home</i></a>
                    <p style="color: #34b8d1; font-size: 50px;">Registration</p>
                </div>
            </div>
        </div>
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <label for="firstName">First Name</label><br>
            <input type="text" name="firstName" size="50" required="required"><br>
            <label for="lastName">Last Name</label><br>
            <input type="text" name="lastName" size="50" required="required"><br>
            <label for="address">Address</label><br>
            <input type="text" name="address" size="50" required="required"><br>
            <label for="email">Email</label><br>
            <input type="text" name="email" size="50" required="required" placeholder="@example.com"><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" size="50" required="required" placeholder="**********"><br>
            <label for="phoneNumber">Phone Number</label><br>
            <input type="text" name="phoneNumber" size="50" required="required"><br>
            <input type="submit" value="Submit" class="btn">
        </form>
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
    padding: 7px;
    margin: 7px;
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