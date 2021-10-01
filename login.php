<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bazar | Iniciar Sesión</title>
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
      if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
      }

      if(isset($_SESSION['userId'])) {
        header('Location:./account.php');
      }
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
      <section class="grid-container short-container">

        <form action="./endpoint-login.php" method="post">
          <h2>Iniciar Sesión</h2>

          <?php          
            if(isset($errorRegistro)){
              echo "<p class='error'>$errorRegistro</p>";
            }
          ?>

          <label for="user">
            Usuario:
            <input type="text" name="user" required />
          </label>

          <?php
            if(isset($errorUser)){
              echo "<p class='error'>$errorUser</p>";
            }
          ?>

          <label for="password">
            Contraseña:
            <input type="password" name="password" required />
          </label>
         
          <?php
            if(isset($errorPassword)){
              echo "<p class='error'>$errorPassword</p>";
            }
          ?>

          <input class="button--form" type="submit" value="Ingresar" />

          <a class="button-text" href="./register.php">Registrarse</a>

        </form>

      </section>
    </main>
    <footer class="footer">
      <p>Bazar®</p>
    </footer>
  </body>
</html>
