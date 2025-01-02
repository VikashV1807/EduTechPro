<?php

include 'D:\xampp\htdocs\EduFinal\design\db_conection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

   
    $query = "SELECT * FROM users WHERE username = '$username' AND role = '$role'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

       
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id']; 

            
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: student_dashboard.php");
            }
        } else {
            echo "<p style='color:red; text-align:center;'>Invalid password.</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>Invalid username or role.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <div class="logo">
          <h1>EduTechPro</h1>
        </div>
        
        <div class="cta-buttons">
            <button onclick="location.href='register.php'">Register</button>
            <button onclick="location.href='login.php'">Login</button>
          </div>
    </header>
    <div class="regcontainer">
        <h2>Login</h2>
        <form method="POST">
        <select name="role" required>
                <option value="admin">Admin</option>
                <option value="student">Student</option>
            </select>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <button type="submit">Login</button>
            <a href="register.php">Don't have an account? Register here.</a>
        </form>
    </div>
   
</body>

</html>
