<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Additional Forms</title>
</head>
<body>
    <h1>Additional Forms</h1>
    <form action="second_page_process.php" method="post">
        <!-- Add more forms as needed -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
