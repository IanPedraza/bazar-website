<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bazar | Cuenta</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
    />
    <link rel="stylesheet" href="./styles/main.css" />
    <link
      rel="stylesheet"
      href="./styles/tablet.css"
      media="(min-width: 500px)"
    />
    <link
      rel="stylesheet"
      href="./styles/desktop.css"
      media="(min-width: 850px)"
    />
  </head>
  <body>
    <?php 
      if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
      }

      if (!isset($_SESSION['userId'])) {
        header('Location:login.php');
      }

      $userId = $_SESSION['userId'];

      $db = mysqli_connect("localhost", "root", "");
      mysqli_select_db($db, "bazar");  
    ?>

    <header class="header">
      <section class="grid-container header-main-container">
        <a href="./index.php" class="header__logo">
          <img src="./assets/images/logo.png" alt="logo del bazar" />
        </a>
        <form action="./search-results.php" method="POST" class="search">
          <form action="" class="search">
          <input class="search-bar" type="text" name="textSearch" placeholder="Buscar" />
          <input type="submit" value="Buscar" class="search-button">
        </form>
        <nav>
          <ul>
            <li><a href="./about.php">Acerca de</a></li>
            <li>
              <a href="./bag.php"> 
                <span class="icon material-icons-outlined">
                  shopping_bag
                </span>
              </a>
            </li>
            <li>
              <a href="./login.php"> 
                <span class="icon material-icons-outlined">
                  account_circle
                </span>
              </a>
            </li>
          </ul>
        </nav>
        <a href="#" class="button--hamburger">
          <span class="icon material-icons-outlined"> menu </span>
        </a>
      </section>
      <section class="header-account-container">
        <div class="grid-container account-options">
          <ul>
            <li><a href="./new.php">Nuevo</a></li>
            <li><a href="./account.php">Mis Productos</a></li>
            <li><a href="./sales.php" class="selected">Historial de Ventas</a></li>
            <li><a href="./statistics.php">Estadísticas</a></li>
            <li><a href="./endpoint-logout.php">Salir</a></li>
          </ul>
        </div>
      </section>
    </header>
    <main>
      <section class="grid-container bag-container">
        <div>
            <?php
            function toPrice($number, $n) {
                $total = $number * $n;
                return "$".number_format($total, 2,'.', ',');
            }

            $total = 0;
            $sales = mysqli_query($db, "select * from sales where seller_id='".$userId."' ORDER BY date_sale DESC;");

            while($sale = mysqli_fetch_array($sales)) {
                $orderId = $sale['order_id'];
                $productId = $sale['product_id'];
                $quantity = $sale['quantity'];
                $date = $sale['date_sale'];

                if ($data = mysqli_query($db, "select * from products where product_id='".$productId."'")) {
                    $product = mysqli_fetch_array($data);
                    $title = $product['title'];
                    $price = $product['price'];
    
                    if ($imageQuery = mysqli_query($db, "select image from images where product_id='".$productId."' limit 1;")) {
                      $dataImage = mysqli_fetch_array($imageQuery);
                      $image = $dataImage['image'];
                    }
    
                    echo "
                    <article class='bag-item-container'>
                      <img src='./assets/productsImages/$image' alt='Imagen de $title' />
                      <div class='bag-item__data-container'>
                        <h2 class='bag-item__title'>".$title."</h2>
                        <div class='bag-item__data-detail'> 
                          <p class='bag-item__price'>Cantidad: ".$quantity."</p>
                          <p class='bag-item__price'>Total: ".toPrice($price, $quantity)."</p>
                        </div>
                        <p class='bag-item__detail'>Fecha: ".$date."</p>
                      </div>
                    </article>
                    ";
                  }
                
                $total +=1;
            }

            if ($total == 0) {
                echo "
                <div class='empty-bag'>
                  <p>No hay ventas</p>
                </div>
                ";
              }
            ?> 
        </div> 
      </section>
    </main>
    <footer class="footer">
      <p>Bazar®</p>
    </footer>
  </body>
</html>
