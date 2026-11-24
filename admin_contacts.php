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

      if(isset($_POST['send_reply'])){
      $msg_id = $_POST['message_id'];
      $reply = mysqli_real_escape_string($conn, $_POST['reply']);

      mysqli_query($conn, "UPDATE contact SET reply='$reply' WHERE id='$msg_id'");

      header('location:admin_contacts.php');
      exit();
      }
?>

<?php include 'admin_header.php'; ?>
<link rel="stylesheet" href="css/admin_style.css">


<!-- delete messages -->
<?php
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM message WHERE id = '$delete_id'");
   header('location:admin_contacts.php');
   exit();
}
?>

<!-- show messages -->
<section class="messages">

   <h1 class="title">Messages</h1>

   <div class="box-container">

   <?php
      $select_messages = mysqli_query($conn, "SELECT * FROM contact");

      if(mysqli_num_rows($select_messages) > 0){
         while($fetch_messages = mysqli_fetch_assoc($select_messages)){
   ?>

   
   <div class="box">
      <p>Name : <span><?php echo $fetch_messages['name']; ?></span></p>
      <p>Email : <span><?php echo $fetch_messages['email']; ?></span></p>
      <p>Message : <span><?php echo $fetch_messages['message']; ?></span></p>

      <!-- 🔥 SHOW EXISTING REPLY -->
      <p>Reply : 
         <span>
            <?php echo $fetch_messages['reply'] ? $fetch_messages['reply'] : 'No reply yet'; ?>
         </span>
      </p>

      <!-- 🔥 REPLY FORM -->
      <form action="" method="post">
         <input type="hidden" name="message_id" value="<?php echo $fetch_messages['id']; ?>">

         <textarea name="reply" placeholder="Write reply..." required></textarea>

         <input type="submit" name="send_reply" value="Send Reply" class="option-btn">
      </form>
      <a href="admin_contacts.php?delete=<?php echo $fetch_messages['id']; ?>" class="delete-btn">Delete</a>
   </div>
   

   <?php
         }
      }else{
         echo '<p class="empty">No messages found!</p>';
      }
   ?>
   </div>
</section>

