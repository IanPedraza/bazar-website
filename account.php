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
        <input class="search-bar" type="text" placeholder="Buscar" />
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
            <li><a href="./account.php" class="selected">Mis Productos</a></li>
            <li><a href="#">Historial de Ventas</a></li>
            <li><a href="#">Estadísticas</a></li>
            <li><a href="./endpoint-logout.php">Salir</a></li>
          </ul>
        </div>
      </section>
    </header>
    <main>
      <section class="grid-container products-container">
        <?php
          $products = mysqli_query($db, "select product_id, title, stock from products where seller_id='".$userId."' AND isDeleted=0;");

          while($product = mysqli_fetch_array($products)) {
            $productId = $product['product_id'];
            $title = $product['title'];
            $stock = $product['stock'];

            if ($imageQuery = mysqli_query($db, "select image from images where product_id='".$productId."' limit 1;")) {
              $data = mysqli_fetch_array($imageQuery);
              $image = $data['image'];

              echo "
                <article class='product-item'>
                  <a href='./product-detail_edit.php?id=".$productId."'>
                    <img src='./assets/productsImages/$image' alt='Imagen de $title' />
                    <h3>$title</h3>
                    <p>".$stock." disponibles</p>
                  </a>
                </article>
              ";
            }
          }
        ?>  
      </section>
    </main>
    <footer class="footer">
      <p>Bazar®</p>
    </footer>
  </body>
</html>
