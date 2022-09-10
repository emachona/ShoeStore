<?php
session_start();
$conn = new mysqli('localhost','root','','shoe_store');

 if(isset($_SESSION['email'])){
    $jej = 1;
    $email = $_SESSION['email'];
    $permission = mysqli_query($conn,"SELECT admin FROM registration WHERE email ='$email'");
    $c=mysqli_fetch_assoc($permission);
    $admin=$c['admin'];
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
    $jej = 0;
    exit();
 }

 $s='AllSizes';
 $g='AllGenders';
 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['filter']))
{
  if (isset($_POST['genderFilter']))
    $g=$_POST['genderFilter'];
  if (isset($_POST['sizeFilter'])) 
    $s=$_POST['sizeFilter'];
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['click']))
{
  $email = $_SESSION['email'];
  $userId= mysqli_query($conn,"SELECT Id FROM registration WHERE email ='$email'");
  $UID=mysqli_fetch_assoc($userId);
  $user=$UID['Id'];
  $find=$_POST['clicked'];
  //proverka dali e veke dodadeno vo cart, ako e da se pikaze poraka
  $query1 = "UPDATE product SET cart = '$user' WHERE id = '$find'";
  $res1=mysqli_query($conn,$query1);
  if($res1){
    header("Location: Cart.php");
    exit();
  }
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['delete']))
{
  $findItem=$_POST['deleteId'];
  $sql = "DELETE FROM product WHERE id='$findItem'";

  if (mysqli_query($conn, $sql)) {
    header("Location: Kicks.php");
    exit();
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
  }
}
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Kicks</title>
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
                    <?php if($admin == 0){ ?>
                    <li><a href="./Orders.php"><i class="fas fa-credit-card"></i>Orders</a></li>
                    <?php }  ?>
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
                        <?php if($admin == 0){ ?>
                          <a href="./Cart.php"><i class="far fa-cart-plus fa-3x" style="color:white; margin-right: 15px;"></i></a>
                        <?php }?>
                        <a href="Logout.php"><i class="far fa-door-closed fa-3x" style="color:white;"></i></a>
                      <?php } ?>
                    </div>
                </div>
                <?php if($admin == 1){?>
                  <p style="margin-left: 5%;"><a href="AddProducts.php" class="price">+ Add a Product</a></p>
                <?php } ?>
                <?php if($admin == 0){?>
                  <form action="Kicks.php" method="post">
                   <p style="text-align: right; margin-right:5%;"> 
                   <select name="genderFilter">  
                      <option value="AllGenders">All Genders</option>}  
                      <option value="female">Female</option>  
                      <option value="male">Male</option>
                    </select>  
                    <select name="sizeFilter">  
                      <option value="AllSizes">All Sizes</option>}  
                      <option value="36">36</option>  
                      <option value="37">37</option>
                      <option value="38">38</option>  
                      <option value="39">39</option>
                      <option value="40">40</option>  
                      <option value="41">41</option>
                      <option value="42">42</option>  
                      <option value="43">43</option>
                      <option value="44">44</option>  
                      <option value="45">45</option>
                      <option value="46">46</option>  
                      <option value="47">47</option>
                    </select>
                    &ensp;
                    <input type="submit" class="button" name="filter" value="Filter Products" />
                  </p> 
                  </form> 
                <?php
                  }
                ?>
                <div class="products">
                <?php
                  if($s=='AllSizes' and $g=='AllGenders'){
                    $query = " select * from product where ordered = 0";
                    $result = mysqli_query($conn, $query);
                  }else if($s=='AllSizes' and $g!='AllGenders'){
                    $query = " select * from product where gender='$g' and ordered=0";
                    $result = mysqli_query($conn, $query);
                  }else if($s!='AllSizes' and $g=='AllGenders'){
                    $query = " select * from product where size='$s' and ordered=0";
                    $result = mysqli_query($conn, $query);
                  }else if($s!='AllSizes' and $g!='AllGenders'){
                    $query = " select * from product where gender='$g' and size='$s' and ordered=0";
                    $result = mysqli_query($conn, $query);
                  }
                          while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                            <div class="card">
                            <?php if($admin == 0){?>
                              <form action="Kicks.php" method="post">
                                <input type="hidden" name="clicked" value="<?php echo $data['id']; ?>"/>
                                <input type="submit" class="button" name="click" value="Add to Cart" />
                              </form>
                              <?php } ?>
                              <?php if($admin == 1){?>
                                <form action="Kicks.php" method="post">
                                <input type="hidden" name="deleteId" value="<?php echo $data['id']; ?>"/>
                                <input type="submit" class="button" name="delete" value="Delete Item" />
                              </form>
                              <?php } ?>
                              <div class="product_img">
                                <a href="Product.php?var=<?php echo $data['id'] ?>">
                                <img src="./images/<?php echo $data['filename']; ?>" alt="Shoes picture" style="height:100%; width:100%"></a>
                              </div>
                              <h3><?php echo $data['brand']." ".$data['model']; ?></h3>
                              <p class="price">$<?php echo $data['price']; ?></p>
                            </div> 
                        <?php
                        }
                  ?>
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
.card {
  /* box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); */
  width: 240px;
  height: 370px;
  margin: auto;
  text-align: center;
  color: black;
  font-size: 17px;
  font-family: 'Times New Roman', serif;
  float: left;
  margin-right: 8px;
  margin-left: 8px;
  margin-top:32px;
  margin-bottom:5px;
  padding-bottom: 8px;
  border: 1px solid #bababa;
}

.card:hover {
  opacity: 0.9;
}

.price {
  color: black;
  font-size: 20px;
}

.card .button {
  border: none;
  outline: 0;
  padding: 12px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

.card .button:hover {
  opacity: 0.7;
}

.product_img{
  width: 225px;
  height: 210px;
  margin: 10px;
  text-align: center;
  float: center;
}

.products{
  align-items: center;
  padding: 15px;
}
