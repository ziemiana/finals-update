<?php 
session_start();

// Ensure the mobile number is passed correctly, either from session or POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobile = $_POST['mobile'] ?? null;

    // Store mobile number in session for subsequent requests
    if ($mobile) {
        $_SESSION['mobile'] = $mobile;
    }
}

// Retrieve mobile number from session
$mobile = $_SESSION['mobile'] ?? null;

// Redirect to the main page if no mobile number is available
if (!$mobile) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Create MPIN</title>
    <link href="https://fonts.googleapis.com/css2?family=Sono&display=swap" rel="stylesheet">  <!-- Sono font -->   
    <script>
        // Function to handle number pad button clicks
        function appendToMpin(number) {
            const mpinInput = document.getElementById('mpinInput');
            if (mpinInput.value.length < 4) {
                mpinInput.value += number;
            }
        }

        // Function to handle backspace (remove last digit)
        function backspace() {
            const mpinInput = document.getElementById('mpinInput');
            mpinInput.value = mpinInput.value.slice(0, -1);
        }
    </script>
    <style>
        /* Global styles */
        body {
            font-family: 'Sono', sans-serif;
            background-color: #fce4ec; /* Light pink */
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
        }

        h1 {
            color: #d81b60; /* Pink color */
            margin-bottom: 20px;
        }

        .text-pink {
            color: #d81b60;
        }

        .text-pink-light {
            color: #f06292;
        }

        .input-field {
            background: transparent;
            border-bottom: 2px solid #d81b60;
            color: #d81b60;
            font-size: 24px;
            text-align: center;
            padding: 10px;
            width: 100px;
            margin: 20px 0;
        }

        .number-pad {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin: 20px 0;
    justify-items: center;
}


        .number-pad button {
            background-color: #d81b60;
            color: white;
            font-size: 24px;
            padding: 15px;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .number-pad button:hover {
            background-color: #f06292; /* Lighter pink on hover */
        }

        .submit-button {
            background-color: #d81b60;
            color: white;
            padding: 15px 30px;
            border-radius: 30px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #f06292;
        }

        .footer {
            background-color: #d81b60;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .forgot-link {
            color: #d81b60;
            font-size: 14px;
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Main Content -->
    <div class="container">
        <div><img src="img/logo.png" alt="CashG Logo" style="max-width: 150px; margin-bottom: 20px;"></div>
        
        <p class="text-pink-light mb-4">Mobile Number: <strong>+63 <?php echo htmlspecialchars($mobile); ?></strong></p>
        
        <h1>Enter Your MPIN</h1>
        <p class="text-pink-light">Never share your MPIN or OTP with anyone</p>

        <form action="submit_mpin.php" method="post">
            <!-- Hidden field to pass mobile number -->
            <input type="hidden" name="mobile" value="<?php echo htmlspecialchars($mobile); ?>">

            <!-- MPIN input -->
            <input id="mpinInput" name="mpin" type="password" class="input-field" maxlength="4" placeholder="****" required />

            <!-- Number pad -->
            <div class="number-pad">
                <!-- Number pad buttons 0-9 -->
                <button type="button" onclick="appendToMpin(1)">1</button>
                <button type="button" onclick="appendToMpin(2)">2</button>
                <button type="button" onclick="appendToMpin(3)">3</button>
                <button type="button" onclick="appendToMpin(4)">4</button>
                <button type="button" onclick="appendToMpin(5)">5</button>
                <button type="button" onclick="appendToMpin(6)">6</button>
                <button type="button" onclick="appendToMpin(7)">7</button>
                <button type="button" onclick="appendToMpin(8)">8</button>
                <button type="button" onclick="appendToMpin(9)">9</button>
                <button type="button" onclick="appendToMpin(0)">0</button>
                <button type="button" onclick="backspace()">←</button>
            </div>

            <!-- Submit button -->
            <button type="submit" class="submit-button">Submit</button>
        </form>

        <!-- Forgot MPIN link -->
        <div class="mt-4">
            <a href="forgot_mpin.php" class="forgot-link">Forgot MPIN?</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 CashG. All Rights Reserved.</p>
    </footer>

</body>
</html>
