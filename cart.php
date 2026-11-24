<?php
   include 'config.php';
   session_start();
   $user_id = $_SESSION['user_id'];

   if(!isset($user_id)){
   header('location:login.php');
   }

   // REMOVE PRODUCT
   if(isset($_GET['delete'])){
      $delete_id = $_GET['delete'];
      mysqli_query($conn, "DELETE FROM cart WHERE id = '$delete_id'") or die('query failed');
      header('location:cart.php');
   }
?>

<!DOCTYPE html>
<html>
<head>
   <title>Cart</title>

   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

   <?php include 'header.php'; ?>
   <script src="js/script.js"></script>

      <section class="shopping-cart">
         <h1 class="title">Your Cart</h1>
         <div class="box-container">

         <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'") or die('query failed');

            if(mysqli_num_rows($select_cart) > 0)
            {
            while($fetch_cart = mysqli_fetch_assoc($select_cart))
            {

         ?>

            <div class="box">
               <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
               <h3><?php echo $fetch_cart['name']; ?></h3>
               <p class="price">Rs <?php echo $fetch_cart['price']; ?>/-</p>
               <p class="qty">Qty : <?php echo $fetch_cart['quantity']; ?></p>
               <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="delete-btn">Remove</a>
            </div>

         <?php
            $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $sub_total;
            }
            }else
      
            {
            echo '<p class="empty">Your cart is empty</p>';
            }
         ?>
         </div>

         <div class="cart-total">
            <h2>Total Price : Rs <?php echo $grand_total; ?>/-</h2>
            <a href="checkout.php" class="option-btn">Proceed to checkout</a>
         </div>
      </section>

<?php include 'footer.php'; ?>
</body>
</html>