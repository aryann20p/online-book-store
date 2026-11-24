<?php
if(session_status() === PHP_SESSION_NONE){
   session_start();
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">
   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">The Book Shop.</a>
         <section class="messages">
            <div class="box-container">

   <?php
      $select_messages = mysqli_query($conn, "SELECT * FROM contact WHERE user_id='$user_id'");

      if(mysqli_num_rows($select_messages) > 0){
         while($fetch_message = mysqli_fetch_assoc($select_messages)){
   ?>

   
    <?php
         }
      }else{
         // echo '<p class="empty">No messages found!</p>';
      }
   ?> 

   </div>

</section>
         <nav class="navbar">
            <a href="home.php">home</a>
            <a href="shop.php">shop</a>
            <a href="orders.php">orders</a>
            <a href="contact.php">contact</a>
            <a href="about.php">about</a>
         </nav>

         <div class="icons">
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <!-- <?php
               // $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               // $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?> -->
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i>  </a>
         </div>

         <!-- <div class="user-box">
            <p>username : </p>
            <p>email : </p>
            <a href="logout.php" class="delete-btn">logout</a>
         </div> -->

         <div class="user-box">

         <?php 
            if(isset($_SESSION['user_id'])){ 
         ?>

         <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
         <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
         <a href="logout.php" class="delete-btn">logout</a>

         <?php 
            }else{ 
         ?>

         <a href="login.php" class="option-btn">login</a>
         <a href="register.php" class="btn">register</a>

         <?php 
         } ?>
         </div>
      </div>
   </div>
</header>