<?php
    session_start();
    include("../backend/db_connection.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles22.css">
    <title>Find id</title>
    <style>
        p {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
            color: yellow;
        }
    </style>
</head>
<body>
    <header>
        <img src="../assets/images/Picture1.jpg" alt="msp" id="logo">
    </header>
    <div class="contact" id="contact">
        <h2 class="heading">Welcome to HQ</h2>
        <h3 class="typing-text">We are <br><span></span></h3>
        
        
        <!-- Login form -->
        <form action="#" method="post">
            <div class="input-box">
                <input type="text" name="username" placeholder="kirishima" required>
            </div>
            <input type="submit" name="login" value="Search" class="btn"> 
        </form>
    </div>
    <div>
    <?php
    if (isset($_POST['login'])) {
        $user = $_POST['username'];

        // Vulnerable SQL query 
        $sql = "SELECT id FROM userdata WHERE username='$user'";

        // Execute the query
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<p>User ID: " . $row['id'] . "</p>";
        } else {
            echo "<p>User ID: -1</p>";
        }
    }
?>
    </div>
</body>

</html>

<?php
    // if (isset($_POST['login'])) {
    //     $user = $_POST['username'];
    //     $pass = $_POST['password'];

    //     // Use prepared statements to prevent SQL injection
    //     $stmt = $conn->prepare("SELECT id FROM userdata WHERE username=? AND password=?");
    //     $stmt->bind_param("ss", $user, $pass);
    //     $stmt->execute();
    //     $stmt->store_result();

    //     if ($stmt->num_rows > 0) {
    //         $stmt->bind_result($id);
    //         $stmt->fetch();
    //         echo "<p>User ID: $id</p>";
    //     } else {
    //         echo "<p>User ID: -1</p>";
    //     }

    //     $stmt->close();
    // }
?> 