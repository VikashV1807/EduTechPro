<?php
session_start();
include 'D:\xampp\htdocs\EduFinal\design\db_conection.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}


if (isset($_POST['add_course'])) {
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $category_id = isset($_POST['category_id']) ? mysqli_real_escape_string($conn, $_POST['category_id']) : '';
    $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';
    $link = isset($_POST['link']) ? mysqli_real_escape_string($conn, $_POST['link']) : '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target_dir = "images/";
        $target_file = $target_dir . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $query = "INSERT INTO courses (name, category_id, description, image, link) 
                      VALUES ('$name', '$category_id', '$description', '$image', '$link')";
            mysqli_query($conn, $query);
        } else {
            echo "Error: Unable to upload the file.";
        }
    } else {
        echo "Error: File upload issue or no file selected.";
    }
}

if (isset($_POST['add_category'])) {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $query = "INSERT INTO categories (name) VALUES ('$category_name')";
    mysqli_query($conn, $query);
}


$courses_query = "SELECT courses.*, categories.name AS category_name 
                  FROM courses 
                  JOIN categories ON courses.category_id = categories.id";
$courses = mysqli_query($conn, $courses_query);


$categories_query = "SELECT * FROM categories";
$categories = mysqli_query($conn, $categories_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
  <header>
        <div class="logo">
          <h1>EduTechPro</h1>
        </div>
        <div class="cta-buttons">
            <button onclick="location.href='logout.php'">Logout</button>
          </div>
    </header>
        <h1>Admin Dashboard</h1>
   

    <div class="container">
        <h2>Add New Course</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Course Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
                <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?php echo $category['id']; ?>">
                        <?php echo $category['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            
            <label for="link">Course Link:</label>
            <input type="text" id="link" name="link" required>
            
            <label for="image">Course Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            
            <button type="submit" name="add_course">Add Course</button>
        </form>

        <h2>Add New Category</h2>
        <form method="POST">
            <label for="category_name">Category Name:</label>
            <input type="text" id="category_name" name="category_name" required>
            <button type="submit" name="add_category">Add Category</button>
        </form>

        <h2>All Courses</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Course Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Link</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($course = mysqli_fetch_assoc($courses)) : ?>
                        <tr>
                            <td>
                                <img src="uploads/<?php echo $course['image']; ?>" alt="<?php echo $course['name']; ?>" style="width: 100px; height: auto;">
                            </td>
                            <td><?php echo $course['name']; ?></td>
                            <td><?php echo $course['category_name']; ?></td>
                            <td><?php echo substr($course['description'], 0, 50) . '...'; ?></td>
                            <td><a href="<?php echo $course['link']; ?>" target="_blank">View Course</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <h2>All Categories</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Category Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php mysqli_data_seek($categories, 0);  ?>
                    <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                        <tr>
                            <td><?php echo $category['name']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer>
    <div class="container">
      <p>&copy; 2025 EduTechPro. All Rights Reserved.</p>
    </div>
  </footer>
</body>
</html>




 