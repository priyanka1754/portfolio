<?php
// view_blog.php
include 'config.php';

if (!isset($_GET['id'])) {
    echo "No blog selected.";
    exit;
}

$id = $_GET['id'];
$blog = $conn->query("SELECT * FROM blogs WHERE id = $id")->fetch_assoc();

if (!$blog) {
    echo "Blog not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $blog['title']; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container py-5">
    <a href="blogs.php" class="btn btn-secondary mb-4">← Back to Blogs</a>
    <div class="card shadow-sm">
    <img src="<?php echo $blog['img']; ?>" alt="Blog Image" class="img-fluid rounded mb-3" style="max-height: 400px; object-fit: cover; width: 100%;">
        <div class="card-body">
            <h2 class="card-title"><?php echo $blog['title']; ?></h2>
            <p class="text-muted"><?php echo date("F j, Y", strtotime($blog['date'])); ?></p>
            <p><strong>Intro:</strong> <?php echo $blog['intro']; ?></p>
            <hr>
            <div><?php echo html_entity_decode($blog['description']); ?></div>
            <?php if (!empty($blog['reference_links'])): ?>
                <hr>
                <p><strong>References:</strong></p>
                <ul>
                    <?php
                    $links = explode("\n", $blog['reference_links']);
                    foreach ($links as $link) {
                        echo "<li><a href='" . trim($link) . "' target='_blank'>" . trim($link) . "</a></li>";
                    }
                    ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
