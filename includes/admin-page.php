<?php
// Add admin menu
function proglancer_quiz_admin_menu() {
    add_menu_page(
        'Proglancer Quiz',
        'Proglancer Quiz',
        'manage_options',
        'proglancer-quiz',
        'proglancer_quiz_page'
    );
}

// Admin page content
function proglancer_quiz_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'proglancer_quizzes';
    if (isset($_POST['add_question'])) {
        $question = sanitize_text_field($_POST['question']);
        $option1 = sanitize_text_field($_POST['option1']);
        $option2 = sanitize_text_field($_POST['option2']);
        $option3 = sanitize_text_field($_POST['option3']);
        $correct_answer = intval($_POST['correct_answer']);
        $wpdb->insert(
            $table_name,
            array(
                'question' => $question,
                'option1' => $option1,
                'option2' => $option2,
                'option3' => $option3,
                'correct_answer' => $correct_answer,
            )
        );
        echo '<div class="notice notice-success is-dismissible"><p>Question added successfully.</p></div>';
    }
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);
        $wpdb->delete($table_name, array('id' => $id));
        echo '<div class="notice notice-success is-dismissible"><p>Question deleted successfully.</p></div>';
    }
    if (isset($_POST['edit_question'])) {
        $id = intval($_POST['edit_id']);
        $question = sanitize_text_field($_POST['edit_question']);
        $option1 = sanitize_text_field($_POST['edit_option1']);
        $option2 = sanitize_text_field($_POST['edit_option2']);
        $option3 = sanitize_text_field($_POST['edit_option3']);
        $correct_answer = intval($_POST['edit_correct_answer']);
        $wpdb->update(
            $table_name,
            array(
                'question' => $question,
                'option1' => $option1,
                'option2' => $option2,
                'option3' => $option3,
                'correct_answer' => $correct_answer,
            ),
            array('id' => $id)
        );
        echo '<div class="notice notice-success is-dismissible"><p>Question updated successfully.</p></div>';
    }
    $questions = $wpdb->get_results("SELECT * FROM $table_name");
    ?>
    <div class="wrap">
        <h1>Proglancer Quiz</h1>
        <h2>Add New Question</h2>
        <form method="post">
            <label for="question">Question:</label><br>
            <textarea name="question" id="question" rows="4" cols="50" required></textarea><br><br>
            <label for="option1">Option 1:</label><br>
            <input type="text" name="option1" id="option1" required><br><br>
            <label for="option2">Option 2:</label><br>
            <input type="text" name="option2" id="option2" required><br><br>
            <label for="option3">Option 3:</label><br>
            <input type="text" name="option3" id="option3" required><br><br>
            <label for="correct_answer">Correct Answer:</label><br>
            <select name="correct_answer" id="correct_answer" required>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
            </select><br><br>
            <input type="submit" name="add_question" value="Add Question">
        </form>
        <h2>Quiz Questions</h2>
        <table class="wp-list-table widefat striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Option 1</th>
                    <th>Option 2</th>
                    <th>Option 3</th>
                    <th>Correct Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($questions) : ?>
                    <?php foreach ($questions as $question) : ?>
                        <tr>
                            <td><?php echo $question->id; ?></td>
                            <td><?php echo esc_html($question->question); ?></td>
                            <td><?php echo esc_html($question->option1); ?></td>
                            <td><?php echo esc_html($question->option2); ?></td>
                            <td><?php echo esc_html($question->option3); ?></td>
                            <td>Option <?php echo $question->correct_answer; ?></td>
                            <td>
                                <a href="?page=proglancer-quiz&delete=<?php echo $question->id; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                                <button onclick="editQuestion(<?php echo $question->id; ?>, '<?php echo esc_js($question->question); ?>', '<?php echo esc_js($question->option1); ?>', '<?php echo esc_js($question->option2); ?>', '<?php echo esc_js($question->option3); ?>', <?php echo $question->correct_answer; ?>)">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="7">No questions found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div id="editModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border:1px solid #ccc;">
            <h2>Edit Question</h2>
            <form method="post">
                <input type="hidden" name="edit_id" id="edit_id">
                <label for="edit_question">Question:</label><br>
                <textarea name="edit_question" id="edit_question" rows="4" cols="50" required></textarea><br><br>
                <label for="edit_option1">Option 1:</label><br>
                <input type="text" name="edit_option1" id="edit_option1" required><br><br>
                <label for="edit_option2">Option 2:</label><br>
                <input type="text" name="edit_option2" id="edit_option2" required><br><br>
                <label for="edit_option3">Option 3:</label><br>
                <input type="text" name="edit_option3" id="edit_option3" required><br><br>
                <label for="edit_correct_answer">Correct Answer:</label><br>
                <select name="edit_correct_answer" id="edit_correct_answer" required>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                </select><br><br>
                <input type="submit" name="edit_question" value="Update Question">
                <button type="button" onclick="closeModal()">Cancel</button>
            </form>
        </div>
        <script>
            function editQuestion(id, question, option1, option2, option3, correctAnswer) {
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_question').value = question;
                document.getElementById('edit_option1').value = option1;
                document.getElementById('edit_option2').value = option2;
                document.getElementById('edit_option3').value = option3;
                document.getElementById('edit_correct_answer').value = correctAnswer;
                document.getElementById('editModal').style.display = 'block';
            }
            function closeModal() {
                document.getElementById('editModal').style.display = 'none';
            }
        </script>
    </div>
    <?php
}