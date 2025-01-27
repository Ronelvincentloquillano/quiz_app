<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'] ?? 'Anonymous'; 
    $answers = $_POST['answer'] ?? [];
    $score = 0;
    $total_questions = count($answers);

    foreach ($answers as $question_id => $selected_option) {
        $stmt = $conn->prepare("SELECT correct_option FROM questions WHERE id = :id");
        $stmt->bindParam(':id', $question_id, PDO::PARAM_INT);
        $stmt->execute();
        $correct_option = $stmt->fetchColumn();

        if (strtolower($selected_option) === strtolower($correct_option)) {
            $score++;
        }
    }

    $percentage = ($score / $total_questions) * 100;

    
    try {
        $insert = $conn->prepare(
            "INSERT INTO results (user_name, score, total_questions, percentage) 
            VALUES (:user_name, :score, :total_questions, :percentage)"
        );
        $insert->bindParam(':user_name', $user_name);
        $insert->bindParam(':score', $score);
        $insert->bindParam(':total_questions', $total_questions);
        $insert->bindParam(':percentage', $percentage);
        $insert->execute();

        echo "<h1>Quiz Results</h1>";
        echo "<p>Thank you, <strong>" . htmlspecialchars($user_name) . "</strong>!</p>";
        echo "<p>Total Questions: $total_questions</p>";
        echo "<p>Your Score: $score</p>";
        echo "<p>Percentage: " . number_format($percentage, 2) . "%</p>";
        echo "<p>Your results have been saved.</p>";
    } catch (Exception $e) {
        die("Error saving results: " . $e->getMessage());
    }
} else {
    echo "Invalid request.";
}
?>
