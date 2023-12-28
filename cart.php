<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
};

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shopping cart</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php @include 'header.php'; ?>

<section class="shopping-cart">

    <h3 class="title">Корзина</h3>

    <div class="box-container">

        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                //$product_id = $fetch_cart['id'];
                //$select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id'") or die('query failed');
                //$fetch_product = mysqli_fetch_assoc($select_product)
                ?>
                <div  class="box">
                    <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
                    <a href="view_page.php?pid=<?php echo $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
                    <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="image">
                    <div class="name"><?php echo $fetch_cart['name']; ?></div>
                    <div class="price"><?php echo $fetch_cart['price']; ?> ₽</div>
                    <form action="" method="post">
                        <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="cart_id">
                    </form>
                </div>
                <?php
                $grand_total += $fetch_cart['price'];
            }
        }else{
            echo '<p class="empty">Ваша корзина пуста</p>';
        }
        ?>
    </div>

    <div class="cart-total">
        <p>общая стоимость : <span><?php echo $grand_total; ?> ₽</span></p>
        <a href="home.php" class="option-btn">вернуться в каталог</a>
        <a href="checkout.php" class="btn  <?php echo ($grand_total > 1)?'':'disabled' ?>">Оформить заказ</a>
    </div>

</section>





<script src="js/script.js"></script>

</body>
</html>