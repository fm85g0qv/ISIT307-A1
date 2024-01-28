<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user answers from the form
    $userAnswers = $_POST['userAnswers'] ?? [];

    // Initialize counters
    $correctAnswersCount = $incorrectAnswersCount = 0;

    // Check user answers against correct answers and update the counts
    foreach ($_SESSION['questions'] as $question) {
        $userAnswer = strtolower($userAnswers[$question['number']] ?? '');
        $correctAnswersCount += ($userAnswer === $question['boolean']);
        $incorrectAnswersCount += ($userAnswer !== $question['boolean']);
    }

    // Update the session counts
    $_SESSION['correctAnswersCount'] = $correctAnswersCount;
    $_SESSION['incorrectAnswersCount'] = $incorrectAnswersCount;

    // Update the session score
    $score = ($correctAnswersCount * 4) - ($incorrectAnswersCount * 2);
    $_SESSION['score'] = $score;

    // Redirect to the score.php page
    header('Location: score.php');
    exit();
}

// Read questions from the text file and select 3 random questions
$fileContents = file_get_contents('countries_quiz.txt');
$lines = explode("\n", $fileContents);

$questions = [];
foreach ($lines as $line) {
    if (!empty($line)) {
        $data = explode('|', $line);
        $questions[] = [
            'number' => trim($data[0]),
            'trivia' => trim($data[1]),
            'boolean' => trim($data[2]),
        ];
    }
}

// Randomly select 3 questions
$selectedQuestionsData = array_intersect_key($questions, array_flip(array_rand(array_column($questions, 'number'), 3)));

// Save selected questions in the session
$_SESSION['questions'] = $selectedQuestionsData;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countries Quiz</title>
</head>
<body>
    <h1>Countries Quiz</h1>

    <form method="post" action="">
        <?php foreach ($selectedQuestionsData as $question): ?>
            <div>
                <?php echo $question['trivia'] . "<br>"; ?>
                <label>
                    <input type="radio" name="userAnswers[<?php echo $question['number']; ?>]" value="true"> True
                </label>
                <label>
                    <input type="radio" name="userAnswers[<?php echo $question['number']; ?>]" value="false"> False
                </label>
            </div>
            <br>
        <?php endforeach; ?>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
