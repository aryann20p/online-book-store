<?php
    include 'config.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    echo "Current User ID: " . $user_id; //temporary fix//
    if(!isset($user_id)){
    header('location:login.php');
    }

if(isset($_POST['place_order'])){

   $name = mysqli_real_escape_string($conn,$_POST['name']);
   $number = mysqli_real_escape_string($conn,$_POST['number']);
   $email = mysqli_real_escape_string($conn,$_POST['email']);
   $address = mysqli_real_escape_string($conn,$_POST['address']);

   $cart_query = mysqli_query($conn,"SELECT * FROM cart WHERE user_id='$user_id'");

   $total_price = 0;
   $products = [];

   while($cart_item = mysqli_fetch_assoc($cart_query)){
      $products[] = $cart_item['name'].' ('.$cart_item['quantity'].')';
      $total_price += $cart_item['price'] * $cart_item['quantity'];
   }

   $total_products = implode(', ', $products);

   mysqli_query($conn,"INSERT INTO orders(user_id,name,number,email,address,total_products,total_price,placed_on)
   VALUES('$user_id','$name','$number','$email','$address','$total_products','$total_price',NOW())") or die('Query Failed');

   mysqli_query($conn,"DELETE FROM cart WHERE user_id='$user_id'");

//    echo "<script>alert('Order Placed Successfully'); 
//    window.location='home.php';</script>";
        $message[] = ' Order placed sucessfully !';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>

    <link rel="stylesheet" href="css/checkout.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<?php include 'header.php'; ?>
<!-- <script src="js/script.js"></script> -->

    <section class="checkout">
        <h1 class="title">Checkout</h1>

    <div class="checkout-container">
<!-- BILLING FORM -->
        <form method="post" class="billing-form">
            <h2>Billing Details</h2>
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="number" placeholder="Phone Number" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <textarea name="address" placeholder="Full Address" required></textarea>
            <button type="submit" name="place_order">Place Order</button>

            <label>Payment Method</label>
                <select name="method" class="box" required>
                    <option value="COD">Cash on Delivery</option>
                </select>
        </form>

<!-- ORDER SUMMARY -->

        <div class="order-summary">
            <h2>Your Order</h2>

        <?php
            $grand_total = 0;
            $cart_query = mysqli_query($conn,"SELECT * FROM cart WHERE user_id='$user_id'");
            if(mysqli_num_rows($cart_query) > 0){
            while($cart = mysqli_fetch_assoc($cart_query)){
            $sub_total = $cart['price'] * $cart['quantity'];
            $grand_total += $sub_total;
        ?>

        <div class="item">
            <span><?php echo $cart['name']; ?> (<?php echo $cart['quantity']; ?>)</span>
            <span>$<?php echo $sub_total; ?></span>
        </div>

        <?php
            }
            }else{
            echo "<p>Your cart is empty</p>";
            }
        ?>

        <div class="total">
            Total: $<?php echo $grand_total; ?>
        </div>

        </div>
     </div>
    </section>

    <script>
        let userBtn = document.querySelector('#user-btn');
        let userBox = document.querySelector('.user-box');

        userBtn.onclick = () =>{
        userBox.classList.toggle('active');
        }
    </script>

<?php include 'footer.php'; ?>

</body>
</html>