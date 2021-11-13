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
    <link rel="stylesheet" href="./styles/card-image_detail.css">
  </head>
  <body>
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
          <div class="view-image">
          <?php 
              $imageQuery = mysqli_query($db, "select image from images where product_id='".$productId."';");
              while($picture = mysqli_fetch_array($imageQuery)) {
                $image = $picture['image'];
                echo "
                <form class='image-detail' id='image-$image' action='./endpoint-delete-image.php' method='POST'>
                  <img src='./assets/productsImages/$image' alt='Imagen de $title' class='image'/>
                  <input type='hidden' name='nameImage' value='".$image."' required/>
                  <input class='button--icon--destructive' type='submit' value='X'>
                </form>
                ";
              }
              ?>
          </div>
        </div>

        <div>
          <?php 
            echo "
            <form action='./endpoint-edit-product.php' method='POST' enctype='multipart/form-data'>
              <h2>Editar producto</h2>
              <label for='title'>
              Titulo:
              <input type='text' name='title' value='".$title."' required/>
              </label>

              <label for='description'>
              Descripción:
              <input type='text' name='description' value='".$description."' required />
              </label>
              ";

              if($status == 'Nuevo' || $status == 'nuevo'){
                echo "
                <label for='status'>
                  Status:
                  <select name='status' id='status' required>
                    <option value='nuevo' selected>".$status."</option>
                    <option value='usado'>Usado</option>
                  </select>
                </label>
                ";
              }else{
                echo "
                <label for='status'>
                  Status:
                  <select name='status' id='status' required>
                    <option value='nuevo'>Nuevo</option>
                    <option value='usado' selected>".$status."</option>
                  </select>
                </label>
                ";
              }

              echo "
              <label for='price'>
                Precio:
                <input type='number' name='price' value='".$price."' required />
              </label>

              <label for='stock'>
              Cantidad disponible:
              <input type='number' name='stock' value='".$stock."' required />
              </label>

              <label for='photos[]'>
              Fotos del producto:
              <input type='file' name='photos[]' accept='image/png, image/jpeg, image/webp' multiple/>
              </label>

              <input type='hidden' name='productId' value='".$productId."'>

              <input class='button--form' type='submit' value='Guardar'>
            </form>
            ";
          ?>

          <form action="./endpoint-delete-product.php" method="POST">
            <?php 
              echo "<input type='hidden' name='productId' value='".$productId."'>";
            ?>

            <input class="button--form-destructive" type="submit" value="Eliminar">

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
