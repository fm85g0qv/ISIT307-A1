<?php
// Start a session to persist data across requests
session_start();

// Read questions from the file into an array
$questions = file('countries_quiz.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Initialize the score in the session if not already set
if (!isset($_SESSION['score'])) {
  $_SESSION['score'] = 0;
}

// Check if the form has been submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Retrieve user's answers from the form
  $answers = $_POST['answer'];

  // Iterate through each answer and update the score
  foreach ($answers as $i => $answer) {
    // Extract the correct answer from the corresponding question
    $parts = explode(',', $questions[$i]);
    $correct = $parts[1];

    // Update the score based on the correctness of the answer
    if ($answer == $correct) {
      $_SESSION['score']++;
    } else {
      $_SESSION['score']--;
    }
  }

  // Redirect to the score page after processing the answers
  header('Location: score.php');
  exit;
}

// Randomly pick 3 questions for the current quiz session
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
        // Extract the question text from the question-answer pair
        $parts = explode(',', $question);
        $questionText = $parts[0];
      ?>
      <div>
        <p><?php echo ($i + 1) . '. ' . $questionText; ?></p>
        <!-- Radio buttons for True and False answers -->
        <input type="radio" name="answer[<?php echo $i; ?>]" value="1"> True
        <input type="radio" name="answer[<?php echo $i; ?>]" value="0"> False
      </div>
    <?php endforeach; ?>

    <br>

    <!-- Submit button to submit the quiz answers -->
    <input type="submit" value="Submit Answers">

  </form>

</body>
</html>
