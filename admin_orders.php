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

if(isset($_POST['update_order'])){

   $order_id = $_POST['order_id'];
   $update_status = $_POST['update_payment'];

   mysqli_query($conn, "UPDATE orders SET payment_status='$update_status' WHERE id='$order_id'");

   $message[] = 'Order status updated!';

}
?>

<?php
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM orders WHERE id='$delete_id'");
   header('location:admin_orders.php');
   exit();
}
?>

<section class="orders">

   <h1 class="title">Placed Orders</h1>

   <div class="box-container">

   <?php
      $select_orders = mysqli_query($conn, "SELECT * FROM orders");

      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
   ?>

   <div class="box">
      <p>User ID : <span><?php echo $fetch_orders['user_id']; ?></span></p>
      <p>Name : <span><?php echo $fetch_orders['name']; ?></span></p>
      <p>Number : <span><?php echo $fetch_orders['number']; ?></span></p>
      <p>Email : <span><?php echo $fetch_orders['email']; ?></span></p>
      <p>Address : <span><?php echo $fetch_orders['address']; ?></span></p>
      <p>Total Products : <span><?php echo $fetch_orders['total_products']; ?></span></p>
      <p>Total Price : <span>Rs <?php echo $fetch_orders['total_price']; ?></span></p>
      <p>Payment Method : <span><?php echo $fetch_orders['method']; ?></span></p>
      <p>Payment Status : <span><?php echo $fetch_orders['payment_status']; ?></span></p>

      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
         <select name="update_payment">
            <option value="" selected disabled>Update Status</option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
         </select>
         <input type="submit" value="Update" name="update_order" class="option-btn">
      </form>

      <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="delete-btn">Delete</a>
   </div>

   <?php
         }
      }else{
         echo '<p class="empty">No orders placed yet!</p>';
      }
   ?>

   </div>

</section>