<?php
if(isset($message)){
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

    <div class="flex">

        <a href="admin_page.php" class="logo">Панель <span>админа</span></a>

        <nav class="navbar">
            <a href="admin_page.php">главная</a>
            <a href="admin_products.php">товары</a>
            <a href="admin_orders.php">заказы</a>
            <a href="admin_users.php">пользователи</a>
            <a href="admin_contacts.php">сообщения</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="account-box">
            <p>логин : <span><?php echo $_SESSION['admin_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">выйти</a>
            <div><a href="login.php">вход</a> | <a href="register.php">регистрация</a> </div>
        </div>

    </div>

</header>
