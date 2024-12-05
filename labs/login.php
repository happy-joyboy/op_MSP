<?php
    session_start();
    include("../backend/db_connection.php");

    // Check if already logged in
    if (isset($_SESSION['loggedInStatus'])) {
        header('Location: ../labs/dashboard.php');
        exit();
    }

    // Handle form submission
    if (isset($_POST['login'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // Vulnerable SQL query (prone to SQL injection)
        $sql = "SELECT * FROM userdata WHERE username='$user' AND password='$pass'";

        // Execute the query
        $result = mysqli_query($conn, $sql);

        // Check if any user is found
        if (mysqli_num_rows($result) > 0) {
            // Successful login, set session variable
            $_SESSION['loggedInStatus'] = true;
            header('Location: dashboard.php');
            exit();
        } else {
            // Failed login
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles22.css">
    <title>Login</title>
</head>
<body>
    <header>
        <img src="../assets/Picture1.jpg" alt="msp" id="logo">
    </header>
    <div class="contact" id="contact">
        <h2 class="heading">Welcome to Msp</h2>
        <h3 class="typing-text">We are <span></span></h3>
        
        <!-- Display error message if login fails -->
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <!-- Login form -->
        <form action="#" method="post">
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <input type="submit" name="login" value="Login" class="btn"> 
        </form>
    </div>
</body>
</html>