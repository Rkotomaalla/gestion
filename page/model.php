<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaires</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>FruitDrinks</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="#">Our Juices</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>
    <!-- code PHP -->
    <!-- ============================================================================== -->
        <?php 
             include("../inc/function.php");
            $page=$_GET ["page"];
        ?>
    <!-- ============================================================================== -->
    <!-- Navbar verticale -->
    <div>
    <nav class="navbar">
        <div>
        <ul>
            <li><a href="model.php?page=rubrique.php">Insertion Rubrique</a></li>
        </ul>
        </div>
        <div>
        <ul>
            <li><a href="model.php?page=charge.php">Insertion Charge</a></li>
        </ul>
        </div>
        <div>
        <ul>
            <li><a href="model.php?page=revient.php">Recherche coupe de revient</a></li>
        </ul>
        </div>
    </nav>
    </div>
    <!-- include formulaire -->
     <?php include($page) ?>
</body>
</html>
