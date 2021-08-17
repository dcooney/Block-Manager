<?php
/**
 * Custom API route.
 *
 * @since 1.0
 */
add_action( 'rest_api_init', function () {
	$my_namespace = 'gbm';
	$my_endpoint  = '/blocks_reset';
	register_rest_route(
		$my_namespace,
		$my_endpoint,
		array(
			'methods'             => 'POST',
			'callback'            => 'block_manager_blocks_reset',
			'permission_callback' => function () {
				return Gutenberg_Block_Manager::has_access();
			},
		)
	);
});

/**
 * Reset the Blocks.
 *
 * @param WP_REST_Request $request The content of the HTTP request.
 * @return json
 * @since 1.2.2
 */
function block_manager_blocks_reset( WP_REST_Request $request ) {

	if ( is_user_logged_in() && current_user_can( apply_filters( 'block_manager_user_role', 'activate_plugins' ) ) ) {

		error_reporting( E_ALL | E_STRICT );

		delete_option( BLOCK_MANAGER_OPTION );

		$response = array(
			'success' => true,
			'msg'     => __( 'Blocks reset successfully.', 'block-manager' ),
		);

		wp_send_json( $response ); // Send response as JSON.
	}
}
