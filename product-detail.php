<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bazar</title>
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
      <section class="grid-container product-detail-container">
        <?php
          if (!isset($productId)) {
            $productId = $_REQUEST['id'];
          }

          if ($productId == null)  header("Location:index.php");

          function toPrice($number) {
            return "$".number_format($number, 2,'.', ',');
          }

          $db = mysqli_connect("localhost", "root", "");
          mysqli_select_db($db, "bazar");  
          
          $products = mysqli_query($db, "select * from products where product_id='".$productId."';");

          while($product = mysqli_fetch_array($products)) {
            $title = $product['title'];
            $description = $product['description'];
            $status = $product['status'];
            $price = $product['price'];
            $stock = $product['stock'];

            if ($imageQuery = mysqli_query($db, "select image from images where product_id='".$productId."' limit 1;")) {
              $data = mysqli_fetch_array($imageQuery);
              $image = $data['image'];
            }
          }
        ?>  

        <div class="product-detail__gallery">
          <?php 
            echo "<img src='./assets/productsImages/$image' alt='Imagen de $title' />";
          ?>
        </div>

        <div class="product-detail__data">
          <?php 
            echo "
            <h2 class='product-detail__title'>".$title."</h2>
            <p class='product-detail__price'>".toPrice($price)."</p>
            <p class='product-detail__status'>".$status."</p>
            <p class='product-detail__stock'>".$stock." Disponible(s)</p>
            <p class='product-detail__description'>".$description."</p>
            ";
          ?>

          <form class="form--hidden-button" action="./endpoint-add-to-bag.php" method="POST">
            <?php 
              echo "<input type='hidden' name='productId' value='".$productId."'>";
            ?>
            <input class="button--form" type="submit" value="Agregar a la bolsa">

            <?php
              if(isset($errorMessage)){
                echo "<p class='error'>$errorMessage</p>";
              }
            ?>
          </form>
        </div>

      </section>
    </main>
    <footer class="footer">
      <p>Bazar®</p>
    </footer>
  </body>
</html>
