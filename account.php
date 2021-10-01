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
      media="(min-width: 720px)"
    />
  </head>
  <body>
    <?php 
      session_start();

      if (!isset($_SESSION['userId'])) {
        header('Location:login.php');
      }
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
              <a href="./account.php"
                ><span class="icon material-icons-outlined">
                  account_circle
                </span></a
              >
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
            <li><a href="#">Mis Productos</a></li>
            <li><a href="#">Historial de Ventas</a></li>
            <li><a href="#">Estadísticas</a></li>
            <li><a href="./endpoint-logout.php">Salir</a></li>
          </ul>
        </div>
      </section>
    </header>
    <main>
      <section class="grid-container short-container">
        <?php echo "<p>Welcome ".$_SESSION['userId']." 🥳</p>"; ?>  
      </section>
    </main>
    <footer class="footer">
      <p>Bazar®</p>
    </footer>
  </body>
</html>
