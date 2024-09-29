<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruit Drinks</title>
</head>

<style>
    /* General Styles */
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color:  black;
    color: #333;
}

/* Header Styles */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0px 4%;
    background-color: black;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.logo h1 {
    font-family: 'Brush Script MT', cursive;
    color: #f76c5e;
    margin: 0; 
    font-size: 28px;
}

nav ul {
    list-style: none;
    display: flex;
    gap: 20px;
}

nav ul li {
    display: inline-block;
}

nav ul li a {
    text-decoration: none;
    color: white;
    font-size: 14px;
    font-weight: bold;
    transition: color 0.3s ease;
}

nav ul li a:hover {
    color: #f76c5e;
}

.hero {
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 0;
    background: black;
    position: relative;
}

.content {
    max-width: 600px;
}

.content h1 {
    font-family: 'Brush Script MT', cursive;
    font-size: 60px;
    color: white;
    margin: 0;
}

.content h2 {
    font-family: 'Roboto', sans-serif;
    font-size: 30px;
    color: #f76c5e;
    margin: 0;
}

.content p {
    font-size: 18px;
    line-height: 1.6;
    margin-top: 20px;
    color: white;
}

.btn {
    display: inline-block;
    padding: 15px 30px;
    background-color: #f76c5e;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 20px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #ff8567;
}

/* Image Container Styles */
.image-container img {
    max-width: 1000px;
    width: 100%;
    height: auto;
    border: none;
}

/* Responsive Styles */
@media (max-width: 600px) {
    .hero {
        flex-direction: column;
        text-align: center;
    }

    .image-container {
        margin-top: 80px;
    }
}
</style>

<body>
    <header>
        <div class="logo">
            <h1>FruitDrinks</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Our Juices</a></li>
                <li><a href="#">About Us</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="content">
            <h2>Freshly Made</h2>
            <h1>Fruit Drinks</h1>
            <p>Enjoy the refreshing taste of freshly blended fruits with our delicious fruit drinks. Made from high-quality ingredients, our juices are nutritious and the perfect way to stay energized and hydrated throughout the day.</p>
            <a href="model.php?page=rubrique.php" class="btn">Order Now</a>
        </div>
        <div class="image-container">
            <img src="fruit.jpg" alt="Fruit Drinks">
        </div>
    </section>
</body>
</html>
