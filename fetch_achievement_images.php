<?php
include('config.php');
$id = intval($_GET['id']);
$query = "SELECT image_path FROM achievement_images WHERE achievement_id = $id";
$result = mysqli_query($conn, $query);
$images = [];

while ($row = mysqli_fetch_assoc($result)) {
  $images[] = $row['image_path'];
}

echo json_encode($images);
?>
