<?php

include('D:\xampp\htdocs\EduFinal\design\db_conection.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role']; 

    $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
        header("Location: login.php?message=Registration successful, please login.");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <div class="logo">
          <h1>EduTechPro</h1>
        </div>
        
        </nav>
        <div class="cta-buttons">
            <button onclick="location.href='register.php'">Register</button>
            <button onclick="location.href='login.php'">Login</button>
          </div>
    </header>
    <div class="regcontainer">
        <h2>Register</h2>
        <form method="POST">
        <select name="role" required>
           <option value="student">Student</option>
           <option value="admin">Admin</option>
        </select>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit">Register</button>
        </form>
    </div>
    
</body>
</html>
