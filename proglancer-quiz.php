<?php
/**
 * Plugin Name: Proglancer Quiz
 * Description: A simple quiz plugin with CRUD operations.
 * Version: 1.0.0
 * Author: Proglancer
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin paths
define('PROGLANCER_QUIZ_PATH', plugin_dir_path(__FILE__));
define('PROGLANCER_QUIZ_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once PROGLANCER_QUIZ_PATH . 'includes/activation-deactivation.php';
require_once PROGLANCER_QUIZ_PATH . 'includes/admin-page.php';
require_once PROGLANCER_QUIZ_PATH . 'includes/shortcode.php';
require_once PROGLANCER_QUIZ_PATH . 'includes/scripts.php';

// Activation and Deactivation Hooks
register_activation_hook(__FILE__, 'proglancer_quiz_activate');
register_deactivation_hook(__FILE__, 'proglancer_quiz_deactivate');

// Add Admin Menu
add_action('admin_menu', 'proglancer_quiz_admin_menu');

// Register Shortcode
add_shortcode('proglancer_quiz', 'proglancer_quiz_shortcode');

// Enqueue Styles and Scripts
add_action('wp_enqueue_scripts', 'proglancer_quiz_enqueue_scripts');
