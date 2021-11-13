<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bazar | Nuevo</title>
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
            <li><a href="./new.php" class="selected">Nuevo</a></li>
            <li><a href="./account.php">Mis Productos</a></li>
            <li><a href="./sales.php">Historial de Ventas</a></li>
            <li><a href="./statistics.php">Estadísticas</a></li>
            <li><a href="./endpoint-logout.php">Salir</a></li>
          </ul>
        </div>
      </section>
    </header>
    <main>
      <section class="grid-container">
        <form action="./endpoint-add-product.php" method="POST" enctype="multipart/form-data">
          <h2>Agregar nuevo producto</h2>

          <?php
            if(isset($errorRigisteringProduct)){
              echo "<p class='error'>$errorRigisteringProduct</p>";
            }
          ?>

          <label for="title">
            Titulo:
            <input type="text" name="title" required />
          </label>

          <label for="description">
            Descripción:
            <input type="text" name="description" required />
          </label>

          <label for="status">
            Status:
            <select name="status" id="status" required>
              <option value="nuevo">Nuevo</option>
              <option value="usado">Usado</option>
            </select>
          </label>

          <label for="price">
            Precio:
            <input type="number" name="price" required />
          </label>

          <label for="stock">
            Cantidad disponible:
            <input type="number" name="stock" required />
          </label>

          <label for="photos[]">
            Fotos del producto:
            <input type="file" name="photos[]" accept="image/png, image/jpeg, image/webp" multiple required />
          </label>

          <input class="button--form" type="submit" value="Agregar Producto">
        </form>
      </section>
    </main>
    <footer class="footer">
      <p>Bazar®</p>
    </footer>
  </body>
</html>
