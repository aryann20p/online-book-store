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
        // TOTAL USERS
        $total_users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE user_type='user'"));

        // TOTAL PRODUCTS
        $total_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products"));

        // TOTAL ORDERS
        $total_orders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders"));

        // TOTAL REVENUE
        $result = mysqli_query($conn, "SELECT SUM(total_price) AS total FROM orders");
        $row = mysqli_fetch_assoc($result);
        $total_revenue = $row['total'] ? $row['total'] : 0;
?>

<section class="dashboard">

   <h1 class="title">Dashboard Overview</h1>
   <div class="box-container">
      <div class="box">
         <h3><?php echo $total_users; ?></h3>
         <p>Total Users</p>
      </div>

      <div class="box">
         <h3><?php echo $total_products; ?></h3>
         <p>Total Products</p>
      </div>

      <div class="box">
         <h3><?php echo $total_orders; ?></h3>
         <p>Total Orders</p>
      </div>

      <div class="box">
         <h3>Rs <?php echo $total_revenue; ?></h3>
         <p>Total Revenue</p>
      </div>
   </div>
</section>
<!-- <h1>Admin Dashboard</h1>
<p>Welcome Admin ✅</p> -->