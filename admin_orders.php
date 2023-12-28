<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:login.php');
};

if(isset($_POST['update_order'])){
    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_id'") or die('query failed');
    $message[] = 'payment status has been updated!';
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php @include 'admin_header.php'; ?>

<section class="placed-orders">

    <h1 class="title">размещенные заказы</h1>

    <div class="box-container">

        <?php

        $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
        if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
                ?>
                <div class="box">
                    <p> id пользователя : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
                    <p> время размещения : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                    <p> имя : <span><?php echo $fetch_orders['name']; ?></span> </p>
                    <p> телефон : <span><?php echo $fetch_orders['number']; ?></span> </p>
                    <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                    <p> адрес : <span><?php echo $fetch_orders['address']; ?></span> </p>
                    <p> всего картин : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                    <p> общий итог : <span><?php echo $fetch_orders['total_price']; ?> ₽</span> </p>
                    <p> метод оплаты : <span><?php echo $fetch_orders['method']; ?></span> </p>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                        <select name="update_payment">
                            <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
                            <option value="в ожидании">в ожидании</option>
                            <option value="completed">завершён</option>
                        </select>
                        <input type="submit" name="update_order" value="обновить" class="option-btn">
                        <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">удалить</a>
                    </form>
                </div>
                <?php
            }
        }else{
            echo '<p class="empty">нет заказов!</p>';
        }
        ?>
    </div>

</section>





<script src="js/admin_script.js"></script>

</body>
</html>