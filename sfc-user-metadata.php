<?php
/*
Plugin Name: SFC Endura User Metadata
Plugin URI: https://stayfitcentral.com
Description: Captures and manages user metadata for personalized workouts in Endura.
Version: 1.0
Author: Jefe de los Jefes
Author URI: https://stayfitcentral.com
Text Domain: sfc-endura-user-metadata
*/

// Include REST API endpoints
require_once plugin_dir_path(__FILE__) . 'includes/endpoints/rest-api.php';

add_action('wp_enqueue_scripts', 'endura_enqueue_metadata_scripts');

function endura_enqueue_metadata_scripts() {
    wp_enqueue_script(
        'endura-user-metadata',
        plugins_url('/assets/js/user-metadata.js', __FILE__),
        ['jquery'], 
        '1.0', 
        true
    );

    // Localize script to pass REST URL, nonce, and chatbot questions securely
    wp_localize_script('endura-user-metadata', 'enduraMetadata', [
        'apiUrl' => rest_url('endura/v1/save-user-metadata'),
        'nonce'  => wp_create_nonce('wp_rest'),
        'questions' => [
            'endura_first_name' => "What's your first name?",
            'endura_fitness_goal' => "Nice to meet you, [First Name]! What's your primary fitness goal right now? (strength, muscle gain, fat loss, endurance)",
            'endura_equipment' => "Great choice! What equipment do you have available? (barbell, dumbbells, kettlebell, bands, none)",
            'endura_experience_level' => "How would you describe your training experience? (beginner, intermediate, advanced)",
            'endura_workout_frequency' => "How many workouts per week would you like to aim for? (1-2, 3-4, 5+)",
            'endura_injuries_restrictions' => "Do you have any injuries or physical restrictions Endura should know about? If none, just type 'none'."
        ]
    ]);
}