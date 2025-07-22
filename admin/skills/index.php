<?php
ob_start();
// Database connection (update if needed)
$conn = new mysqli("localhost", "root", "", "db_portfolio"); // Replace with your DB details
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST["category"] ?? '';
    $name = trim($_POST["skill"] ?? '');

    if (!empty($category) && !empty($name)) {
        $stmt = $conn->prepare("INSERT INTO skills (category, name) VALUES (?, ?)");
        $stmt->bind_param("ss", $category, $name);
        $stmt->execute();
        $stmt->close();

        // Redirect to clear form data on refresh
        echo "<script>location.href='?page=skills';</script>";
        exit;
    }
}
?>

<!-- HTML START -->
<h2>Skills</h2>
<h3>Skills Management</h3>

<?php
$categories = ["Frontend", "Backend", "Database", "Problem Solving", "Soft Skills"];

foreach ($categories as $cat) {
    echo "<div style='margin-bottom: 20px;'>
            <strong>{$cat}:</strong>
            <form method='POST' style='margin-top: 5px;'>
                <input type='hidden' name='category' value='{$cat}'>
                <input type='text' name='skill' placeholder='Enter new skill' required>
                <button type='submit'>Submit</button>
            </form>";

    // Display existing skills
    $result = $conn->query("SELECT name FROM skills WHERE category = '$cat'");
    if ($result && $result->num_rows > 0) {
        echo "<ul style='margin-top: 5px;'>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row["name"]) . "</li>";
        }
        echo "</ul>";
    }

    echo "</div>";
}
ob_end_flush();
?>

<!-- HTML END -->

