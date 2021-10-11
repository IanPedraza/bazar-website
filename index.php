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
    <section class="grid-container products-container">
        <?php
          function toPrice($number) {
            return "$".number_format($number, 2,'.', ',');
          }

          $db = mysqli_connect("localhost", "root", "");
          mysqli_select_db($db, "bazar");  
          
          $products = mysqli_query($db, "select product_id, title, price from products where isDeleted=0 AND stock > 0;");

          while($product = mysqli_fetch_array($products)) {
            $productId = $product['product_id'];
            $title = $product['title'];
            $price = $product['price'];

            if ($imageQuery = mysqli_query($db, "select image from images where product_id='".$productId."' limit 1;")) {
              $data = mysqli_fetch_array($imageQuery);
              $image = $data['image'];

              echo "
                <article class='product-item'>
                  <a href='./product-detail.php?id=".$productId."'>
                    <img src='./assets/productsImages/$image' alt='Imagen de $title' />
                    <h3>$title</h3>
                    <p>".toPrice($price)."</p>
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
