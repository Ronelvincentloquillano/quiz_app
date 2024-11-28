<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Quiz App</title>
</head>
<body>
    <h1>Quiz App</h1>
    <form action="submit_quiz.php" method="POST">
        <div class="user-info">
            <label for="user_name">Enter your name:</label>
            <input type="text" id="user_name" name="user_name" required>
        </div>
        <?php
        include 'retrieve_questions.php';

        foreach ($questions as $index => $question) {
            echo "<div class='question'>";
            echo "<p><strong>" . ($index + 1) . ". " . htmlspecialchars($question['question']) . "</strong></p>";
            echo "<div class='options'>";
            foreach (['a', 'b', 'c', 'd'] as $option) {
                echo "<label>";
                echo "<input type='radio' name='answer[{$question['id']}]' value='{$option}' required> ";
                echo htmlspecialchars($question["option_" . $option]);
                echo "</label>";
            }
            echo "</div>";
            echo "</div>";
        }
        ?>
        <button type="submit">Submit Quiz</button>
    </form>
</body>
</html>
