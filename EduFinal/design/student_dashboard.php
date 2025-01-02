<?php
session_start();
include 'D:\xampp\htdocs\EduFinal\design\db_conection.php';


if ($_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; 


$courses_query = "SELECT * FROM courses";
$courses = mysqli_query($conn, $courses_query);


if (isset($_POST['bookmark'])) {
    $course_id = intval($_POST['course_id']); 
    $check_query = "SELECT * FROM bookmarks WHERE user_id = $user_id AND course_id = $course_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
    
        $bookmark_query = "INSERT INTO bookmarks (user_id, course_id) VALUES ($user_id, $course_id)";
        mysqli_query($conn, $bookmark_query);
    }
}


$bookmarks_query = "SELECT courses.* 
                    FROM bookmarks 
                    JOIN courses ON bookmarks.course_id = courses.id 
                    WHERE bookmarks.user_id = $user_id";
$bookmarks = mysqli_query($conn, $bookmarks_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="student.css">
    
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
    <div class="container">
        

       
        <h2>All Courses</h2>
        <div class="course-section">
            <?php while ($course = mysqli_fetch_assoc($courses)) : ?>
                <div class="course-card">
                <div class="img"><img src="images/<?php echo $course['image']; ?>" alt="<?php echo $course['name']; ?>"></div>    
                
                    <strong><?php echo $course['name']; ?></strong>
                    <p><?php echo substr($course['description'], 0, 50) . '...'; ?></p>
                    <a href="<?php echo $course['link']; ?>" target="_blank">Link to Course</a>
                    <form method="POST" style="margin-top: 10px;">
                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                        <button type="submit" name="bookmark">Bookmark</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>

      
        <h2>Your Bookmarked Courses</h2>
        <div class="course-section">
            <?php while ($bookmark = mysqli_fetch_assoc($bookmarks)) : ?>
                <div class="course-card">
                <div class="img"><img src="images/<?php echo $bookmark['image']; ?>" alt="<?php echo $bookmark['name']; ?>"></div>    
                
                    <strong><?php echo $bookmark['name']; ?></strong>
                    <p><?php echo substr($bookmark['description'], 0, 50) . '...'; ?></p>
                    <a href="course_details.php?course_id=<?php echo $bookmark['id']; ?>">View Details</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <footer>
    <div class="container">
      <p>&copy; 2025 EduTechPro. All Rights Reserved.</p>
    </div>
  </footer>
</body>
</html>
