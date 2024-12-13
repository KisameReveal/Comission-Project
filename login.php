<?php
session_start();  // Start the session
include('db.php');  // Include the database connection file

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];  // Get the username from the form
    $password = $_POST['password'];  // Get the password from the form

    // Query the database to get the user record by username
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Check if user exists and password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Store user info in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] == 'HR') {
            header('Location: hr_home.php');  // Redirect HR to HR dashboard
            exit();
        } else {
            header('Location: applicant_home.php');  // Redirect Applicant to Applicant dashboard
            exit();
        }
    } else {
        echo "Invalid credentials!";
    }
}
?>

<!-- Login form -->
<form method="POST">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
