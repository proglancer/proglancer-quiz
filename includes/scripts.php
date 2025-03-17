<?php
// Enqueue styles and scripts
function proglancer_quiz_enqueue_scripts() {
    wp_enqueue_style('proglancer-quiz-style', PROGLANCER_QUIZ_URL . 'css/style.css'); // Create css/style.css file in your plugin folder
}