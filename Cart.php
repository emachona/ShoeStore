<?php
session_start();
$conn = new mysqli('localhost','root','','shoe_store');
$total= 0;
 if(isset($_SESSION['email'])){
    $jej = 1;
    $email = $_SESSION['email'];
    $curr=mysqli_query($conn,"SELECT * FROM registration WHERE email ='$email'");
    $current_user=mysqli_fetch_assoc($curr);
    $adr=$current_user['address'];
    $cartId = $current_user['Id'];

    $verify = "SELECT access_token FROM registration WHERE email ='$email' AND admin = '0'";
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
    $jej = 0;
    exit();
 }

 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['click']))
{
  $find=$_POST['clicked'];
  $query1 = "UPDATE product SET cart = 0 WHERE id = '$find'";
  $res1=mysqli_query($conn,$query1);
  if($res1){
    header("Location: Cart.php");
    exit();
  }
}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['order'])){

  $query2="UPDATE product SET ordered = 1 WHERE cart = '$cartId'";
  $products=mysqli_query($conn,$query2);
}
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Shopping Cart</title>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    </head>
    <body>
        <div class="wrapper">
            <div class="sidebar">
                <h2>Menu</h2>
                <ul>
                    <li><a href="./Home.php"><i class="fas fa-home"></i>Home</a></li>
                    <li><a href="./Profile.php"><i class="fas fa-user"></i>Profile</a></li>
                    <li><a href="./About.php"><i class="fas fa-address-card"></i>About</a></li>
                    <li><a href="./Orders.php"><i class="fas fa-credit-card"></i>Orders</a></li>
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
                        <!-- <a href="./Cart.php"><i class="far fa-cart-plus fa-3x" style="color:white; margin-right: 15px;"></i></a> -->
                        <a href="Logout.php"><i class="far fa-door-closed fa-3x" style="color:white;"></i></a>
                      <?php } ?>
                    </div>   
                </div>
                <div class="products">
                <p style="text-align: center; font-size: 20px;">Shipping to: " <?php echo $adr; ?> "</p>
                  <?php
                          $query = " select * from product where cart='$cartId' and ordered=0";
                          $result = mysqli_query($conn, $query);
                  
                          while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                      
                          <div class="card">
                            <div class="product_img">
                              <img src="./images/<?php echo $data['filename']; ?>" alt="Shoes picture" style="height:100%">
                            </div>
                            <div class="product_txt">
                              <h3><?php echo $data['brand']; ?></h3><br> 
                              <h3><?php echo $data['model']; ?></h3><br><br>   
                              <p class="price">$<?php echo $data['price']; ?></p><br>
                              <form action="Cart.php" method="post">
                                <input type="hidden" name="clicked" value="<?php echo $data['id']; ?>"/>
                                <input type="submit" class="button" name="click" value="Remove from Cart" />
                              </form>
                            </div>
                          </div>
                        <?php
                        }
                  ?>
                </div>
                <div class="cart_totals">
                  <?php
                    $query = " select * from product where cart = '$cartId' and ordered=0";
                    $result = mysqli_query($conn, $query);
            
                    while ($data = mysqli_fetch_assoc($result)) {
                      $total += $data['price'];
                    }
                  ?>
                    <h4 style="position: center">ORDER SUMMARY</h4>
                    <br>
                    <hr></hr>
                    <br>
                    <p>Products: <span class="tab">$<?php echo $total; ?></span></p>
                    <br>
                    <p>Shipping: <span class="tab"></span>+$15</p>
                    <br>
                    <br>
                    <p>Subtotal: <span class="tab" style="font-weight: bold;">$<?php echo $total+15; ?></span>
                      <!-- <h4 style="text-align: right">$<?php echo $total+15; ?></h4> -->
                    </p>
                  <hr></hr>
                  <div style="text-align: center;">
                    <br>
                    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                      <button class="btn" type="submit" name="order">Order</button>
                    </form>
              </div>
              <br>
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
.tab{
  display: inline-block;
  margin-left: 200px;
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

.rightIcons {
    position: fixed;
    right: 0;
    top: 0;
    margin-top: 30px;
    margin-right: 20px;
}

.products{
    display: block;
    float: left;
    width: 62%;
    margin-top: 32px;
    border: 1px solid #bababa;
    padding: 32px;
    margin-left: 2%;
}

.card {
  display:flex;
  width: 100%;
  max-height: 500px;
  color: black;
  font-size: 17px;
  font-family: 'Times New Roman', serif;
  text-align: right;
  margin-right: 5px;
  margin-top:15px;
  margin-bottom:5px;
  padding: 8px;
  border: 1px solid #bababa;
  background: rgba(52,184,209,0.3);
}

.price {
  color: black;
  font-size: 20px;
  text-align: right;
}

.product_img{
  max-width:30%;
  height: 210px;
  margin: 10px;
  margin-left:20px;
}

.product_txt{
  text-align:right; 
  width:100%; 
  margin-right:7%;
  margin-top:20px;
}

.cart_totals{
    display: block;
    float: right;
    width: 28%;
    margin-right: 3%;
    border: 1px solid #bababa;
    margin-top: 64px;
    padding: 32px;
    background-color: rgb(220,220,220);
}

.button {
  border: none;
  outline: 0;
  padding: 5px;
  color:black;
  text-align: center;
  cursor: pointer;
  font-size: 15px;
}

.btn{
    padding: 10px 30px;
    font-size: 15px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    background: #34b8d1;
}

/* @keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
} */

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}

@media screen and (max-width: 1023px) {
    .cart_totals{
        margin-top: 0px;
    }
}
</style>
<script>
    let slideIndex = 0;
    showSlides();
</script>