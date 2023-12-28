<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
};

if(isset($_POST['order'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name'];
            $cart_total += $cart_item['price'];
        }
    }

    $total_products = implode(', ',$cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if($cart_total == 0){
        $message[] = 'ваша корзина пуста!';
    }elseif(mysqli_num_rows($order_query) > 0){
        $message[] = 'заказ уже размещён!';
    }else{
        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'закан размещён успешно!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php @include 'header.php'; ?>

<section class="display-order">

    <h3 class="title">Оформление заказа</h3>

    <?php
    $grand_total = 0;
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($select_cart) > 0){
        while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $grand_total += $fetch_cart['price'];
            ?>
            <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo $fetch_cart['price'].' ₽'?>)</span> </p>
            <?php
        }
    }else{
        echo '<p class="empty">Ваша корзина пуста</p>';
    }
    ?>
    <div class="grand-total">общая стоимость: <span><?php echo $grand_total; ?> ₽</span></div>
</section>

<section class="checkout">

    <form action="" method="POST">

        <div class="flex">
            <div class="inputBox">
                <span>Ваше имя :</span>
                <input type="text" name="name" placeholder="">
            </div>
            <div class="inputBox">
                <span>Ваш телефон :</span>
                <input type="number" name="number" min="0" placeholder="">
            </div>
            <div class="inputBox">
                <span>Ваш email :</span>
                <input type="email" name="email" placeholder="">
            </div>
            <div class="inputBox">
                <span>Метод оплаты :</span>
                <select name="method">
                    <option value="cash on delivery">оплата при получении</option>
                    <option value="credit card">mastercard/visa/mir</option>
                    <option value="paypal">paypal</option>
                    <option value="paytm">qiwi</option>
                </select>
            </div>
            <div class="inputBox">
                <span>адрес :</span>
                <input type="text" name="flat" placeholder="">
            </div>
            <div class="inputBox">
                <span>страна :</span>
                <input type="text" name="country" placeholder="">
            </div>
            <div class="inputBox">
                <span>город :</span>
                <input type="text" name="city" placeholder="">
            </div>
            <div class="inputBox">
                <span>пин-код :</span>
                <input type="number" min="0" name="pin_code" placeholder="">
            </div>
        </div>

        <input type="submit" name="order" value="Заказать сейчас" class="btn">

    </form>

</section>



<script src="js/script.js"></script>

</body>
</html>