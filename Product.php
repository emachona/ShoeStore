<?php
session_start();
$conn = new mysqli('localhost','root','','shoe_store');
$var_value = $_REQUEST['var'];
$query = " select * from product where id='$var_value'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result); //produktot za prikazuvanje

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

//  $productId=$data['id'];
//  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['edit'])){
//   $p=$_POST['priceEdit'];
//   $s=$_POST['sizeEdit'];
//   $query1 = "UPDATE product SET price = '$p' WHERE id = '$productId'";
//   $query2 = "UPDATE product SET size = '$s' WHERE id = '$productId'";
//   $res1 = mysqli_query($conn,$query1);
//   $res2 = mysqli_query($conn,$query2);
//       if($res1 && $res2){
//           header("Location: Kicks.php");
//           exit();
//       }
// }
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Product</title>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    </head>
    <body>
        <div class="wrapper">
            <div class="main_content">
              <div class="header">
                <div class="leftIcon">
                  <a href="./Kicks.php"><i class="fas fa-arrow-left">Back</i></a>
                </div>
                <span style="color:white">Product Details</span>
              </div>
              <div class="contents">
                <div class="products">
                  <div class="product_img">
                    <img src="./images/<?php echo $data['filename']; ?>" alt="Shoes picture" style="height:100%; width:100%">
                  </div>
                </div>
                <div class="details">
                  <h2><?php echo $data['brand']." ".$data['model']; ?></h2>
                  <!--      if ($admin ==1)
                    <form action="Product.php" method="post">
                      <br>
                      <b>Price: </b>
                      <input type="number" name="priceEdit" value="<?php echo $data['price']?>" class="pom"> <br>
                      <b>Gender:  </b>
                      <input type="text" value="<?php echo $data['gender']?>" class="pom" style="cursor: default;" readonly> <br>
                      <b>Size:  </b>
                      <input type="number" name="sizeEdit" value="<?php echo $data['size']?>" class="pom"> <br>
                      <input type="submit" value="Edit" name="edit" id="btn">
                    </form> -->
                    <p class="price">$<?php echo $data['price']; ?></p>
                    <br><br>
                    <p style="font-size: 20px;">Gender: <?php echo $data['gender']; ?></p><br>
                    <p style="font-size: 20px;">Size: <?php echo $data['size']; ?></p>
                </div>
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

.pom{
    margin: 10px;
    padding: 10px;
    border-radius: 10px;
}
#btn{
    padding: 10px 30px;
    font-size: 15px;
    border-radius: 15px;
    cursor: pointer;
    background: #34b8d1;
}
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
  height: 100%;
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
.contents{
  display: flex;
  max-height: 90%;
}
.price {
  color: black;
  font-size: 26px;
}

.product_img{
  width: 500px;
  height: 500px;
  text-align: center;
}

.products{
    display: block;
    float: left;
    width: 50%;
    max-height: 80%;
    margin-top: 2%;
    border: 1px solid #bababa;
    margin-left:5%;
    margin-right: 5%;
    padding-left: 8%;
    background-color: whitesmoke;
}
.details{
    display: block;
    float: right;
    width: 34%;
    /* border: 1px solid #bababa; */
    margin-top: 4%;
    margin-bottom: 4%;
    padding: 32px;
    /* background-color: #e6e6e6; */
    /* background-color: rgb(220,220,220); */
}