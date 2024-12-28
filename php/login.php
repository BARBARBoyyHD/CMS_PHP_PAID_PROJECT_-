<?php
  include("../config/db.php");  // Make sure this file contains the correct mysqli connection setup

  // Debugging: Check the request method
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit;
    }

    // Prepare the SQL statement using mysqli
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);  // "s" for string

    if ($stmt->execute()) {
        $result = $stmt->get_result();  // Get the result of the query
        $user = $result->fetch_assoc();  // Fetch the user record

        if ($user && password_verify($password, $user['password'])) {
            // Start a session and store user info
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to a dashboard or home page
            header("Location: ../php/userpage.php");
            exit;
        } 
    } else {
        echo "Error: " . $stmt->error;  // Display any errors from the query execution
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" image="image/x-icon" href="../assets/favicon.ico">
  <title>Login Page</title>
</head>
<body>
  <?php include("../layout/login.html")?>
</body>
</html>
