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
        <a href="home.php" class="logo">art heritage</a>

        <nav class="navbar">
            <ul>
                <li><a href="home.php">каталог</a></li>
                <li><a href="contact.php">Фидбэк</a></li>
                <li><a href="orders.php">заказы</a></li>
                <li><a href="#">Аккаунт +</a>
                    <ul>
                        <li><a href="login.php">Вход</a></li>
                        <li><a href="register.php">Регистрация</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <a href="wishlist.php"><i class="fas fa-heart"></i></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
        </div>

        <div class="account-box">
            <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">выйти</a>
        </div>
    </div>
</header>