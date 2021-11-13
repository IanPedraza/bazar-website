<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bazar | Registro</title>
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
        <form action="./endpoint-register.php" method="post">
          <h2>Registro</h2>

          <label for="name">
            Nombre:
            <input type="text" name="name" autocomplete="name" required />
          </label>

          <label for="phone_number">
            Numero de telefono:
            <input type="tel" name="phone_number" autocomplete="tel" required />
          </label>
          
          <label for="city">
            Ciudad:
            <input type="text" name="city" autocomplete="street-address" required />
          </label>
          
          <label for="state">
            Estado:
            <input type="text" name="state" required />
          </label>

          <label for="email">
            Correo electrónico :
            <input type="email" name="email" autocomplete="email" required />
          </label>

          <?php
            if(isset($existenciaError)){
              echo "<p class='error'>$existenciaError</p>";
            }
          ?>

          <label for="password">
            Password:
            <input type="password" name="password"  autocomplete="new-password" required />
          </label>
          
          <label for="password_confirm">
            Confirmación de Password:
            <input type="password" name="password_confirm" required />
          </label>

          <?php
            if(isset($incorrectPassword)){
              echo "<p class='error'>$incorrectPassword</p>";
            }
          ?>
          
          <input class="button--form" type="submit" value="Registrarse">
        </form>
      </section>
    </main>
    <footer class="footer">
      <p>Bazar®</p>
    </footer>
  </body>
</html>
