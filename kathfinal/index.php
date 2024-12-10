<?php
// Include the connection file
include('database/connection.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobile = $_POST['mobile'] ?? null;  // Get the mobile number from the form input

    // Validate mobile number format (ensuring it is numeric and 10 digits long)
    if ($mobile) {
        if (!preg_match('/^\d{10}$/', $mobile)) {
            $error_message = "Please enter a valid mobile number (10 digits).";
        } else {
            // Sanitize input to prevent SQL injection
            $mobile = $conn->real_escape_string($mobile);

            // Prepare the SQL statement to prevent SQL injection
            $sql = "SELECT * FROM users WHERE num = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $mobile);  // Bind the mobile parameter (s for string)

            // Execute the query
            $stmt->execute();
            $result = $stmt->get_result();  // Get the result of the query

            // Check if a user with the given mobile number exists
            if ($result->num_rows > 0) {
                // If user exists, redirect to mpin.php and pass the mobile number
                header('Location: mpin.php?mobile=' . urlencode($mobile));
                exit();  // Stop further execution after the redirect
            } else {
                // If no user is found, display an error message
                $error_message = "Mobile number not registered. Please sign up.";
            }

            // Close the prepared statement
            $stmt->close();
        }
    } else {
        // If mobile number is not provided, display an error message
        $error_message = "Please enter your mobile number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div><img src="img/logo2.png" alt=""></div>
    <title>CashG </title>
    <link rel="stylesheet" href="gcash.css">  <!-- Include your stylesheet for styling -->

    <!-- Add JavaScript for client-side validation -->
    <script>
        function validateForm() {
            var mobile = document.getElementById('mobileInput').value;
            var errorMessage = document.getElementById('error-message');

            // Check if mobile number is empty
            if (mobile === "") {
                errorMessage.textContent = "Please enter your mobile number.";
                errorMessage.style.color = "red";
                return false;
            }

            // Validate mobile number format (10 digits)
            var mobilePattern = /^\d{10}$/;
            if (!mobilePattern.test(mobile)) {
                errorMessage.textContent = "Please enter a valid mobile number (10 digits).";
                errorMessage.style.color = "red";
                return false;
            }

            // If everything is valid, submit the form
            return true;
        }
    </script>
</head>
<body>
<style>
    body {
    background-color: #fce4ec; /* Light pink background */
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background-color: #fae4ea;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 100%;
    max-width: 400px;
    color: #e91e63; 
}

h1 {
    color: #e91e63; /* Pink color for heading */
    font-size: 2rem;
}

.error-message p {
    color: #e91e63; /* Pink color for error message */
    font-size: 1rem;
}

input {
    font-size: 1.25rem;
    padding: 8px;
    margin: 10px 0;
    border: 2px solid #e91e63;
    border-radius: 4px;
    width: 80%;
  
}
button {
    background-color: #e91e63; /* Pink background for button */
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-size: 1rem;
    width: 80%;
   
}

button:hover {
    background-color: #d81b60; /* Darker pink when hovered */
}

a {
    color: #e91e63; /* Pink color for the link */
    text-decoration: none;
    font-size: 1rem;
}

a:hover {
    text-decoration: underline;
}
</style>
    <div class="container">
        <h1 class="text-3xl font-bold mb-6">CashG</h1>

        <!-- Display error message if it exists -->
        <?php if (isset($error_message)): ?>
            <div class="error-message text-red-500">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>

        <!-- Form to input the mobile number -->
        <form action="mpin.php" method="post" onsubmit="return validateForm()"> <!-- Ensure this points to the current file -->
            <div class="flex items-center justify-center mb-4">
                <span class="text-2xl">+63</span>
                <input name="mobile" id="mobileInput" type="text" 
                       class="bg-transparent border-b-2 border-white text-2xl ml-2 outline-none" 
                       placeholder="Enter your mobile number" required />
            </div>
            
            <!-- Display error message from JavaScript -->
            <div id="error-message" class="text-red-500 mb-4"></div>

            <!-- Submit button to proceed to the next step -->
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-full hover:bg-blue-600">
                Next
            </button>
        </form>
        <br><br>

        <!-- Link to sign up page if the user does not have an account -->
        <div class="back-link mt-4">
            <a href="register.php" class="text-white">Create an Account</a>
        </div>
    </div>
</body>
</html>
