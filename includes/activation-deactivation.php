<?php
// Activation hook
function proglancer_quiz_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'proglancer_quizzes';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        question text NOT NULL,
        option1 text NOT NULL,
        option2 text NOT NULL,
        option3 text NOT NULL,
        correct_answer tinyint(1) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Deactivation hook
function proglancer_quiz_deactivate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'proglancer_quizzes';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
}