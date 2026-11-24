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
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM users WHERE id = '$delete_id'");
   header('location:admin_users.php');
   exit();
}
?>

<section class="users">

   <h1 class="title">User Accounts</h1>

   <div class="box-container">

   <?php
      $select_users = mysqli_query($conn, "SELECT * FROM users");

      if(mysqli_num_rows($select_users) > 0){
         while($fetch_users = mysqli_fetch_assoc($select_users)){
   ?>

   <div class="box">
      <p>User ID : <span><?php echo $fetch_users['id']; ?></span></p>
      <p>Name : <span><?php echo $fetch_users['name']; ?></span></p>
      <p>Email : <span><?php echo $fetch_users['email']; ?></span></p>
      <p>User Type : <span><?php echo $fetch_users['user_type']; ?></span></p>

      <?php if($fetch_users['user_type'] == 'user'){ ?>
         <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" class="delete-btn">Delete</a>
      <?php } ?>
   </div>

   <?php
         }
      }else{
         echo '<p class="empty">No users found!</p>';
      }
   ?>

   </div>

</section>