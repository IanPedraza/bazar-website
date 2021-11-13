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
            <li><a href="./new.php">Nuevo</a></li>
            <li><a href="./account.php" >Mis Productos</a></li>
            <li><a href="./sales.php">Historial de Ventas</a></li>
            <li><a href="./statistics.php" class="selected">Estadísticas</a></li>
            <li><a href="./endpoint-logout.php">Salir</a></li>
          </ul>
        </div>
      </section>
    </header>
    <main>
      <div class="short-container">
      <?php 
        if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
          session_start();
        }
  
        if (!isset($_SESSION['userId'])) {
          header('Location:login.php');
        }  

            include "./libchart/classes/libchart.php";

            $chart = new VerticalBarChart(600, 370);
            $dataset = getDataSet();

            $chart->setDataSet($dataset);
            $chart->setTitle("Cantidad de ventas por producto");
            $chart->render("./generated/chart.png");

            function getDataSet() {
                
                $userId = $_SESSION['userId'];
        
                $db = mysqli_connect("localhost", "root", "");
                mysqli_select_db($db, "bazar");

                $sales = mysqli_query($db, "select distinct product_id from sales where seller_id='".$userId."';");

                $dataset = new XYDataSet();

                while($sale = mysqli_fetch_array($sales)) {
                    $productID = $sale['product_id'];

                    $products = mysqli_query($db, "select title from products where product_id='".$productID."' limit 1;");
                    $product = mysqli_fetch_array($products);
                    $title = $product['title'];
                    $quantity = 0;
                    $quantity_products = mysqli_query($db, "select quantity from sales where product_id='".$productID."';");
                    while($quantity_product = mysqli_fetch_array($quantity_products)){
                        $quantity += $quantity_product['quantity'];
                    }
                    
                    $dataset->addPoint(new Point($title,$quantity));
                }

                mysqli_free_result($sales);
                mysqli_close($db);

                return $dataset;
            }
        ?>

    <section class="chart-container">
      <img src="./generated/chart.png" alt="Gráfica del número de ventas">
    </section>
      </div>
    </main>
    <footer class="footer">
      <p>Bazar®</p>
    </footer>
  </body>
</html>