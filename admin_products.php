<?php
    include 'config.php';
    session_start();

    if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
    }

    if($_SESSION['user_type'] != 'admin'){
    header('location:login.php');
    exit();
    }
?>

<?php include 'admin_header.php'; ?>
<link rel="stylesheet" href="css/admin_style.css">

<?php

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_tmp = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product = mysqli_query($conn, "SELECT * FROM products WHERE name='$name'");

   if(mysqli_num_rows($select_product) > 0){
      $message[] = 'Product already exists!';
   }else{
      mysqli_query($conn, "INSERT INTO products(name, price, image) VALUES('$name','$price','$image')");
      move_uploaded_file($image_tmp, $image_folder);
      $message[] = 'Product added successfully!';
   }

}

// if(isset($_POST['add_product'])){

//    $name = mysqli_real_escape_string($conn, $_POST['name']);
//    $price = $_POST['price'];
//    $image = $_FILES['image']['name'];
//    $image_tmp = $_FILES['image']['tmp_name'];
//    $image_folder = 'uploaded_img/'.$image;

//    $select_product = mysqli_query($conn, "SELECT * FROM products WHERE name='$name'");

//    if(mysqli_num_rows($select_product) > 0){
//       $message[] = 'Product already exists!';
//    }else{
//       // 🔥 CHECK IMAGE UPLOAD FIRST
//       if(move_uploaded_file($image_tmp, $image_folder)){

//          mysqli_query($conn, "INSERT INTO products(name, price, image) VALUES('$name','$price','$image')");
//          $message[] = 'Product added successfully!';

//       }else{

//          $message[] = 'Image upload failed!';

//       }

//    }

// }
?>
 <!-- add products -->
<section class="add-products">

   <h1 class="title">Add Product</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <input type="text" name="name" placeholder="enter product name" required class="box">
      <input type="number" name="price" placeholder="enter product price" required class="box">
      <input type="file" name="image" accept="image/jpg,image/jpeg,image/webp, image/png" required class="box">
      <input type="submit" name="add_product" value="add product" class="btn">
   </form>

</section>

<!-- show products -->
 <section class="show-products">

   <div class="box-container">

   <?php
      $select_products = mysqli_query($conn, "SELECT * FROM products");

      if(mysqli_num_rows($select_products) > 0){
         while($fetch_products = mysqli_fetch_assoc($select_products)){
   ?>

   <div class="box">
      <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price">Rs <?php echo $fetch_products['price']; ?></div>
      <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn">Delete</a>
   </div>

   <?php
         }
      }else{
         echo '<p class="empty">No products added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- delete product -->
<?php
    if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = '$delete_id'");
    header('location:admin_products.php');
    exit();
    }
?>