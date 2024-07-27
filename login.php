<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <?php
    // Start session
    session_start();

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve username and password from the form
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Database connection parameters
        $servername = "localhost"; // MySQL server address (usually localhost)
        $db_username = "root"; // MySQL username
        $db_password = ""; // MySQL password
        $database = "login"; // MySQL database name

        // Create connection
        $conn = new mysqli($servername, $db_username, $db_password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to check if the username and password exist in the database
        $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows == 1) {
            // Set session variable
            $_SESSION['username'] = $username;
        } else {
            // Display an error message if login fails
            echo "<p style='color: red; text-align: center;'>Invalid username or password. Please try again.</p>";
        }

        // Close connection
        $conn->close();
    }
    ?>

    <header>
        <div class="nav-title">
            <h1> Log in to your account  </h1>
        </div>
        <nav>
        <ul class="nav-menu">
                    <li ><a href="homepage.html" class="nav-menu__link">Home</a></li>
                    <li ><a href="15MinRecipes.html" class="nav-menu__link">15 Minutes Recipes</a></li>
                    <li><a href="threeIngredients.html" class="nav-menu__link">3 Ingredients</a></li>
                    <li><a href="submit.php" class="nav-menu__link">Submit Recipe</a></li>
                    <li><a href="index.php" class="nav-menu__link">Kitchen Utensils List</a></li>
                    <li><a href="login.php" class="nav-menu__link">LogIn</a></li>
                    <li><a href="register.php" class="nav-menu__link">Register</a></li>
            
                <?php
                if(isset($_SESSION['username'])) {
                    echo "<li class='nav-menu__item'><span class='user-greeting'>Hello, " . $_SESSION['username'] . "!</span></li>";
                    echo "<li class='nav-menu__item'><a href='logout.php' class='nav-menu__link'>Logout</a></li>";
                } else {
                    echo "<li class='nav-menu__item'><a href='login.php'>LogIn</a></li>";
                    echo "<li class='nav-menu__item'><a href='register.php'>Register</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="login-container">
            <h2>Login</h2>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="submit" value="Login">
            </form>
            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </main>
</body>
</html>
