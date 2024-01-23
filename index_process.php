<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);

    // Save user input to a text file with commas as separators
    $file = fopen("user_data.txt", "a");
    fwrite($file, "$name,");
    fclose($file);

    // Redirect to the next page
    header("Location: second_page.php");
    exit;
} else {
    // Redirect to index.php if accessed directly
    header("Location: index.php");
    exit;
}
?>
