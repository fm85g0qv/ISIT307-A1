<?php

session_start();

$questions = file('countries_quiz.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if (!isset($_SESSION['score'])) {
  $_SESSION['score'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $answers = $_POST['answer'];

  foreach ($answers as $i => $answer) {
    $parts = explode(',', $questions[$i]);
    $correct = $parts[1];

    if ($answer == $correct) {
      $_SESSION['score']++;
    } else {
      $_SESSION['score']--;
    }
  }

  header('Location: score.php');
  exit;

}

// Randomly pick 3 questions
$random_indices = array_rand($questions, 3);
$random_questions = array_intersect_key($questions, array_flip($random_indices));

?>

<!DOCTYPE html>
<html>
<head>
  <title>Countries Quiz</title>
</head>
<body>

  <h1>Countries Quiz</h1>

  <form method="post">

    <?php foreach ($random_questions as $i => $question): ?>
      <?php
        $parts = explode(',', $question);
        $questionText = $parts[0];
      ?>
      <div>
        <p><?php echo ($i + 1) . '. ' . $questionText; ?></p>
        <input type="radio" name="answer[<?php echo $i; ?>]" value="1"> True
        <input type="radio" name="answer[<?php echo $i; ?>]" value="0"> False
      </div>
    <?php endforeach; ?>

    <br>

    <input type="submit" value="Submit Answers">

  </form>

</body>
</html>
