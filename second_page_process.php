<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $age = htmlspecialchars($_POST["age"]);

    // Append additional user input to the text file with commas as separators
    $file = fopen("user_data.txt", "a");
    fwrite($file, "$email,$age,");
    fclose($file);

    echo "<h1>Test Success</h1>";
} else {
    // Redirect to index.php if accessed directly
    header("Location: index.php");
    exit;
}
?>
