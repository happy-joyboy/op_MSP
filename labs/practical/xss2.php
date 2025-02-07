<?php

include("../backend/db_connection.php");

// Insert a comment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $username = $_POST['username'];
    $comment = $_POST['comment'];

    // Vulnerable SQL query (direct insertion of user input)
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
    <link rel="stylesheet" href="../styles/styles22.css">
    <title>Stored XSS and SQL Injection Demo</title>
    <style>
        .divider{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .test{
            margin: 2rem;
            width: auto;
        }
    </style>
</head>
<body>
<h1>Leave a Comment</h1>
    <div class="contact" id="contact">
        <form action="xss2.php" method="POST">
            <div class="input-box">
                <label for="username">Name:</label>
                <input type="text"  name="username" required><br><br>
            </div>
            <label for="comment">Comment:</label><br>
            <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>
            
            <input type="submit" value="Submit Comment" class="btn">
        </form>
    </div>
    <div class="divider">
            <!-- Reset Button to Clear the Database -->
            <form action="xss2.php" method="POST" class="test">
                <input type="submit" name="reset" value="Reset Comments" class="btn">
            </form>
            <div class="next test">
                <a href="xss3.html" class="btn"> Next Challenge</a>
            </div>
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