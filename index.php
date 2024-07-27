<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
<header>
        <h1>Student Recipe Ideas</h1>
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
<div class="sale">
        <h1>Kitchen Utensils Shop</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Price</th>
            </tr>
    
<?php
// Database connection parameters
$servername = "localhost";  // MySQL server address (usually localhost)
$username = "root";         // MySQL username
$password = "";             // MySQL password (if any)
$database = "ustensile"; // MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select data
$sql = "SELECT id, type, price FROM ustensila";

// Execute query
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data of each row
    
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["type"] . "</td><td>" . $row["price"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
  </table>
    </div>

<?php 
$servername = "localhost";  // MySQL server address (usually localhost)
$username = "root";         // MySQL username
$password = "";             // MySQL password (if any)
$database = "recipes"; 
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM recipe";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row in a table format
    echo "<table class='recipe-table-page1'>";
    echo "<tr><th>Title</th><th>Description</th><th>Ingredients</th><th>Instructions</th><th>Email</th><th>Date</th><th>Country</th><th>City</th><th>Action</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["title"] . "</td>";
        echo "<td>" . $row["description"] . "</td>";
        echo "<td>" . $row["ingredients"] . "</td>";
        echo "<td>" . $row["instructions"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["date"] . "</td>";
        echo "<td>" . $row["country"] . "</td>";
        echo "<td>" . $row["city"] . "</td>";
        echo "<td><form method='post'><input type='hidden' name='recipe_title' value='" . $row["title"] . "'><input type='hidden' name='recipe_description' value='" . $row["description"] . "'><input type='hidden' name='recipe_ingredients' value='" . $row["ingredients"] . "'><input type='hidden' name='recipe_instructions' value='" . $row["instructions"] . "'><button type='submit' name='delete_recipe'>Delete</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Handle recipe deletion
if (isset($_POST["delete_recipe"])) {
    $recipe_title = $_POST["recipe_title"];
    $recipe_description = $_POST["recipe_description"];
    $recipe_ingredients = $_POST["recipe_ingredients"];
    $recipe_instructions = $_POST["recipe_instructions"];
    
    // Construct the delete query
    $delete_sql = "DELETE FROM recipe WHERE title = ? AND description = ? AND ingredients = ? AND instructions = ?";
    
    // Prepare the delete statement
    $stmt = $conn->prepare($delete_sql);
    
    // Bind parameters
    $stmt->bind_param("ssss", $recipe_title, $recipe_description, $recipe_ingredients, $recipe_instructions);
    
    // Execute the delete statement
    if ($stmt->execute()) {
        echo "<p>Recipe deleted successfully!</p>";
        // Refresh the page to reflect changes
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "<p>Error deleting recipe: " . $stmt->error . "</p>";
    }
    
    // Close the statement
    $stmt->close();
}
?>

</body>
</main>
</html>

