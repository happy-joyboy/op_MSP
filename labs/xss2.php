<?php

include("db_connection.php");

// Insert a comment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $username = $_POST['username'];
    $comment = $_POST['comment'];

    // Vulnerable SQL query (no prepared statement, direct insertion of user input)
    $stmt = "INSERT INTO comments (username, comment) VALUES ('$username', '$comment')";

    if (mysqli_query($connXss, $stmt)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt . "<br>" . mysqli_error($connXss);
    }
}
// get all comments
$sql = "SELECT * FROM comments ORDER BY created_at DESC";
$result = mysqli_query($connXss, $sql);

//delete all commnets
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $reset_query = "DELETE FROM comments";
    if (mysqli_query($connXss, $reset_query)) {
        echo "<p style='color:red;'>All comments have been deleted.</p>";
    } else {
        echo "Error: " . mysqli_error($connXss);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles22.css">
    <title>Stored XSS and SQL Injection Demo</title>
</head>
<body>
<h1>Leave a Comment</h1>
    <div class="contact" id="contact">
    <form action="xss2.php" method="POST">
        <div>
            <label for="username">Name:</label>
            <input type="text"  name="username" required><br><br>
        </div>
        <label for="comment">Comment:</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>
        
        <input type="submit" value="Submit Comment" class="btn">
    </form>

    <!-- Reset Button to Clear the Database -->
    <form action="xss2.php" method="POST">
        <input type="submit" name="reset" value="Reset Comments" class="btn">
    </form>
    </div>
    <h2>Recent Comments:</h2>
    <div class="reflection">
        <?php
        // Display all stored comments without sanitization to demonstrate XSS
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Displaying comments directly without sanitization for XSS demo
                echo "<div class='comment'>";
                echo "<p><strong>" . $row['username'] . ":</strong> " . $row['comment'] . "</p>"; // No htmlspecialchars to allow XSS
                echo "</div>";
            }
        } else {
            echo "<p>No comments yet.</p>";
        }
        ?>
    </div>

    
    <?php
    // Close connection
    mysqli_close($connXss);
    ?>
</body>
</html>