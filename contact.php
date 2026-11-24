<?php
   include 'config.php';
   session_start();
   $user_id = $_SESSION['user_id'];

// if(!isset($user_id)){
//    header('location:login.php');
// }

   if(isset($_POST['send'])){

      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $number = mysqli_real_escape_string($conn, $_POST['number']);
      $msg = mysqli_real_escape_string($conn, $_POST['message']);

//    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

//    if(mysqli_num_rows($select_message) > 0){
//       $message[] = 'message sent already!';
//    }else{
         mysqli_query($conn, "INSERT INTO `contact`(user_id, name, email, number, message) 
         VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
         // $message[] = 'message sent successfully!';
//    }
      echo"<script>
      alert('Message sent successfully!');
      </script>";
   }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
   <?php include 'header.php'; ?>
   <link rel="stylesheet" href="css/style.css">
   <div class="heading">
      <h3>contact us</h3>
   </div>

   <section class="contact">
      <form action="" method="post">
         <h3>say something!</h3>
         <input type="text" name="name" required placeholder="enter your name" class="box">
         <input type="email" name="email" required placeholder="enter your email" class="box">
         <input type="number" name="number" required placeholder="enter your number" class="box">
         <textarea name="message" class="box" placeholder="enter your message" id="" cols="30" rows="10"></textarea>
         <input type="submit" value="send message" name="send" class="btn">
      </form>
   </section>

   <section class="messages">
      <h1 class="title">Your Messages & Replies</h1>
      <div class="box-container">

      <?php
         $select_messages = mysqli_query($conn, "SELECT * FROM contact WHERE user_id='$user_id'");
         if(mysqli_num_rows($select_messages) > 0){
            while($fetch_message = mysqli_fetch_assoc($select_messages)){
      ?>

      <div class="box"> 
         <p>Your Message: 
            <span><?php echo $fetch_message['message']; ?></span>
         </p>
         <p>Admin Reply: 
            <span>
               <?php 
                  if(!empty($fetch_message['reply'])){
                  echo $fetch_message['reply'];
                  }else{
                  echo 'No reply yet';
                  }
               ?>
            </span>
         </p>
         </div>

      <?php
            }
         }else{
            echo '<p class="empty">No messages yet!</p>';
         }
      ?>
      </div>
   </section>

   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>
</html>