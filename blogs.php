<?php
// blogs.php
include 'config.php'; // connect to DB

$blogs = $conn->query("SELECT * FROM blogs ORDER BY date DESC");
?>
<?php require_once('inc/header.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blogs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
          
    .nav {
  background-color: rgba(15, 15, 15, 0.95);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;

}

.nav li a {
  color: #ccc;
}.mt-100 {
  margin-top: 60px;
}
.btn-view {
  background-color:white; /* Bootstrap blue */
  color: white;
  border: none;
  transition: all 0.3s ease;
}

.btn-view:hover {
  background-color: white;
  color: #007bff;
  border: 1px solid #007bff;
}

    </style>
</head>
<body>
<nav id="nav-wrap">
            <a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show navigation</a>
            <a class="mobile-btn" href="#" title="Hide navigation">Hide navigation</a>

            <ul id="nav" class="nav">
            <li class="current"><a href="index.php">Home</a></li>
                <li><a class="smoothscroll" href="#about">About</a></li>
                <li><a href="uploads/22761A0506_Resume.pdf" target="_blank">Resume</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="internships.php">Internships</a></li>
                <li><a href="achievements.php">Achievements</a></li>
                <li><a href="certificates.php">Certificates</a></li>
                <li><a href="blogs.php">Blogs</a></li>
            </ul>
        </nav>
<div class="container py-5">
    <h1 class="mb-4 text-center mt-100">Our Blogs</h1>
    <div class="row">
        <?php while ($row = $blogs->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?php echo $row['img']; ?>" class="card-img-top" alt="Blog Image" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <small class="text-muted"><?php echo date("F j, Y", strtotime($row['date'])); ?></small>
                        <p class="card-text mt-2"><?php echo substr($row['intro'], 0, 100); ?>...</p>
                        <a href="view_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-view btn-sm">View More</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php require_once('inc/footer1.php') ?>
</body>
</html>
