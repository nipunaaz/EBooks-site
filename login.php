<?php
session_start();

// Database connection
$host = "localhost";
$dbname = "ebook_library";
$dbuser = "root";         // change this to your DB user
$dbpass = "";             // change this to your DB password

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // Fetch user from DB
  $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $hashed_password)) {
      $_SESSION['user_id'] = $id;
      $_SESSION['username'] = $username;
      header("Location: dashboard.php");
      exit();
    } else {
      $error = "Invalid username or password.";
    }
  } else {
    $error = "Invalid username or password.";
  }

  $stmt->close();
}

$conn->close();
?>
