<?php
session_start();
$conn = new mysqli('localhost','root','','shoe_store');
 if(isset($_SESSION['email'])){
  $jej = 1;
  $email = $_SESSION['email'];
  $verify = "SELECT access_token FROM registration WHERE email ='$email'";
  $res = mysqli_query($conn,$verify);
  $permission = mysqli_query($conn,"SELECT admin FROM registration WHERE email ='$email'");
  $c=mysqli_fetch_assoc($permission);
  $admin=$c['admin'];
  $verify = "SELECT access_token FROM registration WHERE email ='$email' AND admin = '0'";
   // if(mysqli_num_rows($res)==0){
  //   $jej=0;
  // }
  // else{
  //   $jej=1;
  // }
 }
 else{
    $jej = 0;
 }
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    </head>
    <body>
        <div class="wrapper">
            <div class="sidebar">
                <h2>Menu</h2>
                <ul>
                    <li><a href="./Home.php"><i class="fas fa-home"></i>Home</a></li>
                    <?php if($jej !== 0){ ?>
                    <li><a href="./Profile.php"><i class="fas fa-user"></i>Profile</a></li>
                    <?php }?>
                    <li><a href="./About.php"><i class="fas fa-address-card"></i>About</a></li>
                    <?php if($jej !== 0 and $admin !=1){ ?>
                    <li><a href="./Orders.php"><i class="fas fa-credit-card"></i>Orders</a></li>
                    <?php }?>
                </ul> 
                <div class="social_media">
                    <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="main_content">
                <div class="header">
                    <a href="Kicks.php" style="text-decoration:none;">Kicks</a>
                    <div class="rightIcons" style="font-size: 0.5rem;">

                      <?php if($jej == 0){ ?>
                        <a href="Login.php"><i class="far fa-door-open fa-3x" style="color:white;"></i></a>
                      <?php }else {?>
                        <?php if(isset($_SESSION['email']) and $admin == 0){ ?>
                          <a href="./Cart.php"><i class="far fa-cart-plus fa-3x" style="color:white; margin-right: 15px;"></i></a>
                        <?php }?>
                        <a href="Logout.php"><i class="far fa-door-closed fa-3x" style="color:white;"></i></a>
                      <?php } ?>
                    </div>
                </div> 
                <div class="slideshow-container">

                <div class="mySlides fade">
                  <div class="numbertext">1 / 3</div>
                  <img src="./images/shadowpastel.jpg" style="height:500px; width:500px;">
                </div>

                <div class="mySlides fade">
                  <div class="numbertext">2 / 3</div>
                  <img src="./images/superstar.jpg" style="height:500px; width:500px;">
                </div>

                <div class="mySlides fade">
                  <div class="numbertext">3 / 3</div>
                  <img src="./images/newbcore.jpg" style="height:500px; width:500px;">
                </div>

                </div>
                <br>

                <div style="text-align:center">
                  <span class="dot"></span> 
                  <span class="dot"></span> 
                  <span class="dot"></span> 
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
body{
   background-color: #e6e6e6;
}

.wrapper{
  display: flex;
  position: relative;
}

.wrapper .sidebar{
  width: 160px;
  height: 100%;
  background: #34b8d1;
  padding: 30px 0px;
  position: fixed;
}

.wrapper .sidebar h2{
  color: #fff;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 30px;
}

.wrapper .sidebar ul li{
  padding: 15px;
  border-bottom: 1px solid #bdb8d7;
  border-bottom: 1px solid rgba(0,0,0,0.05);
  border-top: 1px solid rgba(255,255,255,0.05);
}    

.wrapper .sidebar ul li a{
  color: #d5f0f6;
  display: block;
}

.wrapper .sidebar ul li a .fas{
  width: 25px;
}

.wrapper .sidebar ul li:hover{
  background-color: #59c4d9;
}
    
.wrapper .sidebar ul li:hover a{
  color: #fff;
}
 
.wrapper .sidebar .social_media{
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  margin-bottom: 10%;
}

.wrapper .sidebar .social_media a{
  display: block;
  width: 40px;
  background: #d5f0f6;
  height: 40px;
  line-height: 45px;
  text-align: center;
  margin: 0 5px;
  color: #34b8d1;
  border-radius: 5px;
}

.wrapper .main_content{
  width: 100%;
  margin-left: 160px;
}
.wrapper .main_content .header{
  padding: 20px;
  background: #262626;
  color: #34b8d1;
  text-align: center;
  font-size: 50px;
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
.mySlides {display: none;}
img {display: block;
  margin-left: auto;
  margin-right: auto;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  max-height: 500px;
  position: relative;
  margin:auto;
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}
.rightIcons {
    position: fixed;
    right: 0;
    top: 0;
    margin-top: 30px;
    margin-right: 20px;

}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>
<script>
           let slideIndex = 0;
showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}
        </script>