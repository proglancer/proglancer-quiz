<?php
// Shortcode to display the quiz
function proglancer_quiz_shortcode() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'proglancer_quizzes';
    $questions = $wpdb->get_results("SELECT * FROM $table_name ORDER BY RAND()"); // Randomize question order
    if (!$questions) {
        return '<p>No questions available.</p>';
    }
    ob_start(); // Start output buffering
    ?>
    <div class="proglancer-quiz">
        <form id="proglancer-quiz-form">
            <?php foreach ($questions as $question) : ?>
                <div class="question">
                    <h3><?php echo esc_html($question->question); ?></h3>
                    <label>
                        <input type="radio" name="question_<?php echo $question->id; ?>" value="1" required>
                        <?php echo esc_html($question->option1); ?>
                    </label><br>
                    <label>
                        <input type="radio" name="question_<?php echo $question->id; ?>" value="2" required>
                        <?php echo esc_html($question->option2); ?>
                    </label><br>
                    <label>
                        <input type="radio" name="question_<?php echo $question->id; ?>" value="3" required>
                        <?php echo esc_html($question->option3); ?>
                    </label><br>
                    <input type='hidden' name='correct_<?php echo $question->id; ?>' value='<?php echo $question->correct_answer;?>'>
                </div>
            <?php endforeach; ?>
            <button type="button" onclick="submitQuiz()">Submit Quiz</button>
            <div id="quiz-results"></div>
        </form>
    </div>
    <script>
        function submitQuiz() {
            let score = 0;
            let totalQuestions = document.querySelectorAll('.question').length;
            let resultsDiv = document.getElementById('quiz-results');
            let form = document.getElementById('proglancer-quiz-form');
            let questions = form.querySelectorAll('.question');
            questions.forEach(question => {
                let correctAnswer = question.querySelector('input[name^="correct_"]').value;
                let selectedAnswer = question.querySelector('input[name^="question_"]:checked');
                if (selectedAnswer && parseInt(selectedAnswer.value) === parseInt(correctAnswer)) {
                    score++;
                }
            });
            resultsDiv.innerHTML = `<p>Your score: ${score} out of ${totalQuestions}</p>`;
        }
    </script>
    <?php
    return ob_get_clean(); // Return the buffered output
}