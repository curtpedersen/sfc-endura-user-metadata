<?php

add_action('rest_api_init', 'endura_register_metadata_endpoint');

function endura_register_metadata_endpoint() {
    register_rest_route('endura/v1', '/save-user-metadata', [
        'methods' => 'POST',
        'callback' => 'endura_save_user_metadata',
        'permission_callback' => function() {
            return is_user_logged_in();
        }
    ]);
}

function endura_save_user_metadata(WP_REST_Request $request) {
    $user_id = get_current_user_id();
    $metadata = $request->get_json_params();

    if (empty($metadata) || !is_array($metadata)) {
        return new WP_REST_Response(['message' => 'Invalid metadata provided'], 400);
    }

    foreach ($metadata as $key => $value) {
        update_user_meta($user_id, sanitize_key($key), sanitize_text_field($value));
    }

    return new WP_REST_Response(['message' => 'Metadata saved successfully'], 200);
}