
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category'] ?? '';
    $skill = $_POST['skill'] ?? '';

    

        $stmt = $conn->prepare("INSERT INTO skills (category, skill) VALUES (?, ?)");
        $stmt->bind_param("ss", $category, $skill);

        if ($stmt->execute()) {
            header("Location: ../?page=skills"); // redirect back to skills
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } 

?>
