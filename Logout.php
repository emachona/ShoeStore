 <?php
 session_start();
 $conn = new mysqli('localhost','root','','shoe_store');
 $email = $_SESSION["email"];
 $del_query = "UPDATE registration SET access_token = '' WHERE email = '$email'";
 $result = mysqli_query($conn,$del_query);
 if($result){
    unset($_SESSION['email']);
    session_destroy();
    header("Location: Home.php");
    exit();
 }
 ?>