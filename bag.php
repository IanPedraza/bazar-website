<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bazar | Bolsa de compra</title>
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
        $_SESSION['bagId'] = uniqid();
        $bagId = $_SESSION['bagId'];
    
        $query = "insert into orders(order_id, client_name, address, zip_code, state, phone_number, email) values('".$bagId."', '', '', '', '', '', '');";
        mysqli_query($db, $query);
      }

      $bagId = $_SESSION['bagId'];
    ?>
    <header class="header">
      <div class="grid-container header-main-container">
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
      </div>
    </header>
    <main>
      <section class="grid-container bag-container">
        <div>
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
                $title = $product['title'];
                $price = $product['price'];
                $total += $price;

                if ($imageQuery = mysqli_query($db, "select image from images where product_id='".$productId."' limit 1;")) {
                  $dataImage = mysqli_fetch_array($imageQuery);
                  $image = $dataImage['image'];
                }

                echo "
                <article class='bag-item-container'>
                  <img src='./assets/productsImages/$image' alt='Imagen de $title' />
                  <div class='bag-item__data-container'>
                    <h2 class='bag-item__title'>".$title."</h2>
                    <p class='bag-item__price'>".toPrice($price)."</p>
                    <form class='form--hidden-button' action='./endpoint-delete-from-bag.php' action='POST'>
                      <input type='hidden' name='itemBagId' value='".$itemBagId."'>
                      <input class='button--text button--bag' type='submit' value='Eliminar'>
                    </form>
                  </div>
                </article>
                ";
              }

            }

            if ($total == 0) {
              echo "
              <div class='empty-bag'>
                <p>No hay articulos en tu bolsa</p>
              </div>
              ";
            }
          ?>
        </div>
        <div class='bag__total-container'>
          <?php 
            echo "<p class='bag__total'><b>Total: </b>".toPrice($total)."</p>";
            
            if ($total > 0) {
              echo "
                <a href='./checkout.php' class='button'>
                  Proceder al pago
                </a>
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
