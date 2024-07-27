<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Recipe - Student Recipe Ideas</title>
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
        <section id="submit-recipe-form">
            <h2>Submit Your Recipe</h2>
            <form class="recipe-form" action="#" method="post" onsubmit="return validateForm();">

                <label for="recipe-title" class="form-label">Recipe Title:</label>
                <input type="text" id="recipe-title" name="recipe-title" class="form-input" required>
                
                <label for="recipe-description" class="form-label">Recipe Description:</label>
                <textarea id="recipe-description" name="recipe-description" rows="4" class="form-input" required></textarea>
                
                <label for="ingredients" class="form-label">Ingredients:</label>
                <textarea id="ingredients" name="ingredients" rows="4" class="form-input" required></textarea>
                
                <label for="instructions" class="form-label">Instructions:</label>
                <textarea id="instructions" name="instructions" rows="4" class="form-input" required></textarea>

                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-input" required>
                <span id="emailValidity"></span>

                <label for="date" class="form-label">Date:</label>
                <input type="date" id="date" name="date" class="form-input" required>
                <span id="dateValidity"></span>

                <label for="country" class="form-label">Country:</label>
                <select id="country" name="country" class="form-input" onchange="populateCities();" required>
                    <option value="">Select Country</option>
                    <option value="ROMANIA">ROMANIA</option>
                </select>

                <label for="city" class="form-label">City:</label>
                <select id="city" name="city" class="form-input" required>
                    <option value="">Select City</option>
                    <!-- Cities will be populated dynamically based on the selected country -->
                </select>
                
                <input type="submit" value="Submit Recipe" class="form-submit">
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Student Recipe Ideas</p>
    </footer>
    <?php
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $title = $_POST["recipe-title"];
        $description = $_POST["recipe-description"];
        $ingredients = $_POST["ingredients"];
        $instructions = $_POST["instructions"];
        $email = $_POST["email"];
        $date = $_POST["date"];
        $country = $_POST["country"];
        $city = $_POST["city"];

        // Database connection parameters
        $servername = "localhost"; // Change this to your MySQL server address
        $username = "root"; // Change this to your MySQL username
        $password = ""; // Change this to your MySQL password
        $database = "recipes"; // Change this to your MySQL database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO recipe (title, description, ingredients, instructions, email, date, country, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $title, $description, $ingredients, $instructions, $email, $date, $country, $city);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "<p>Recipe submitted successfully!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>
    <script>
        // Function to validate email format
        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        // Function to validate date format 
        function validateDate(date) {
            return date.trim() !== '';
        }

        // Function to dynamically populate cities based on selected country
        function populateCities() {
            const country = document.getElementById("country").value;
            const citySelect = document.getElementById("city");
            citySelect.innerHTML = ''; // Clear previous options
            if (country === "ROMANIA") {
                const cities = ["Alba Iulia", "Arad", "Bacău", "Baia Mare", "Bistrița", "Botoșani",
                "Brașov", "Brăila", "București", "Cluj-Napoca", "Constanța", "Craiova",
                "Deva", "Drobeta-Turnu Severin", "Focșani", "Galați", "Giurgiu", "Iași",
                "Oradea", "Pitești", "Ploiești", "Râmnicu Vâlcea", "Reșița", "Sfântu Gheorghe",
                "Sibiu", "Slatina", "Slobozia", "Suceava", "Târgoviște", "Târgu Jiu",
                "Târgu Mureș", "Timișoara", "Tulcea", "Vaslui", "Zalău"];
                cities.forEach(city => {
                    const option = document.createElement("option");
                    option.text = city;
                    option.value = city;
                    citySelect.add(option);
                });
            } 
            // Add more conditions for other countries if needed
        }

        // Function to validate form fields
        function validateForm() {
            const email = document.getElementById("email").value;
            const date = document.getElementById("date").value;

            // Validate email
            const emailValid = validateEmail(email);
            document.getElementById("emailValidity").innerText = emailValid ? "✔️" : "❌";

            // Validate date
            const dateValid = validateDate(date);
            document.getElementById("dateValidity").innerText = dateValid ? "✔️" : "❌";
            return emailValid && dateValid;


        }
    </script>
    
</body>
</html>
