<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bazar | Checkout</title>
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

      $db = mysqli_connect("localhost", "root", "");
      mysqli_select_db($db, "bazar");  
      
      if (!isset($_SESSION['bagId'])) {
        header('Location:index.php');
      }

      $bagId = $_SESSION['bagId'];
    ?>
    <header class="header">
      <div class="grid-container header-main-container">
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
      </div>
    </header>
    <main>
      <section class="grid-container">
        <?php 
          function toPrice($number) {
            return "$".number_format($number, 2,'.', ',');
          }

          $total = 0;
          $items = mysqli_query($db, "select * from products_orders where order_id='".$bagId."'");

          while($item = mysqli_fetch_array($items)) { 
            $itemBagId = $item['id'];
            $productId = $item['product_id'];

            if ($data = mysqli_query($db, "select * from products where product_id='".$productId."'")) {
              $product = mysqli_fetch_array($data);
              $price = $product['price'];
              $total += $price;
            }

          }
        ?>

        <form action="./endpoint-checkout.php" method="POST"class="checkout-container">
          <div>
            <h2>Datos de envío</h2>

            <?php
              if(isset($errorCheckout)){
                echo "<p class='error'>$errorCheckout</p>";
              }
            ?>

            <label for="client_name">
              Nombre completo:
              <input type="text" name="client_name" autocomplete="name" required />
            </label>

            <label for="address">
              Dirección de entrega:
              <input type="text" name="address" autocomplete="street-address" required />
            </label>

            <label for="zip_code">
              Código postal:
              <input type="number" name="zip_code" autocomplete="postal-code" required />
            </label>

            <label for="state">
              Estado:
              <input type="text" name="state" required />
            </label>

            <label for="phone">
              Teléfono:
              <input type="tel" name="phone" autocomplete="tel" required />
            </label>

            <label for="email">
              Correo eléctronico:
              <input type="email" name="email" autocomplete="email" required />
            </label>

          </div>

          <div class='checkout__total-container'>
            <?php 
              echo "<p class='bag__total'><b>Total: </b>".toPrice($total)."</p>";
            ?>

            <input class="button--form" type="submit" value="Confirmar orden">
          </div>
        </form>
        
      </section>
    </main>
    <footer class="footer">
      <p>Bazar®</p>
    </footer>
  </body>
</html>
