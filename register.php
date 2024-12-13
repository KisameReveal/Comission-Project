<?php
include('db.php');  // Include the database connection file

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];  // Get the username from the form
    $password = $_POST['password'];  // Get the password from the form

    // Validate username and password
    if (!empty($username) && !empty($password)) {
        // Hash the password before saving
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Hash the password

        // Set default role to 'Applicant' or change if you want to allow HR registration
        $role = 'Applicant';

        // Prepare the SQL statement to insert the new user into the database
        $stmt = $pdo->prepare("INSERT INTO Users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashedPassword, $role]);

        // Redirect the user to the login page after successful registration
        header('Location: login.php');
        exit();
    } else {
        echo "Please fill in all fields.";
    }
}
?>

<!-- Registration form -->
<form method="POST">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>
