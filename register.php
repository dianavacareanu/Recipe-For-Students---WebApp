<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="styles.css">

</head>
<html>
<body>
    <header>
    <h1> Log in to your account  </h1>
        <nav>
        <ul class="nav-menu">
                    <li ><a href="homepage.html" class="nav-menu__link">Home</a></li>
                    <li ><a href="15MinRecipes.html" class="nav-menu__link">15 Minutes Recipes</a></li>
                    <li><a href="threeIngredients.html" class="nav-menu__link">3 Ingredients</a></li>
                    <li><a href="submit.php" class="nav-menu__link">Submit Recipe</a></li>
                    <li><a href="index.php" class="nav-menu__link">Kitchen Utensils List</a></li>
                    <li><a href="login.php" class="nav-menu__link">LogIn</a></li>
                    <li><a href="register.php" class="nav-menu__link">Register</a></li>
             </ul>
        </nav>
    </header>

    <main>
    <div class="register-container">
        <h2>Register</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="submit" value="Register">
        </form>
        <?php
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
            $check_username_query = "SELECT * FROM login WHERE username='$username'";
            $check_username_result = $conn->query($check_username_query);

            if ($check_username_result->num_rows > 0) {
                // Username is already taken
                echo "<p style='color: red; text-align: center;'>Username '$username' is already taken. Please choose a different username.</p>";
            } else {
                // Insert new user into the database
                $insert_user_query = "INSERT INTO login (username, password) VALUES ('$username', '$password')";
                if ($conn->query($insert_user_query) === TRUE) {
                    echo "<p style='color: green; text-align: center;'>Registration successful. You can now <a href='login.php'>login</a>.</p>";
                } else {
                    echo "<p style='color: red; text-align: center;'>Error: " . $insert_user_query . "<br>" . $conn->error . "</p>";
                }
            }

            // Close connection
            $conn->close();
        }
        ?>
    </div>
    </main>
</body>
</html>
