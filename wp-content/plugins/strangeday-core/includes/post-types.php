<?php
/**
 * Strangeday post type registration.
 *
 * @package StrangedayCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns the Strangeday post type configuration.
 *
 * @return array<string, array<string, mixed>>
 */
function strangeday_core_get_post_types() {
	return array(
		'photo'  => array(
			'plural'      => __( 'Photos', 'strangeday-core' ),
			'singular'    => __( 'Photo', 'strangeday-core' ),
			'menu_icon'   => 'dashicons-format-image',
			'archive_slug'=> 'photos',
			'single_slug' => 'photo',
		),
		'music'  => array(
			'plural'      => __( 'Music', 'strangeday-core' ),
			'singular'    => __( 'Music', 'strangeday-core' ),
			'menu_icon'   => 'dashicons-format-audio',
			'archive_slug'=> 'music',
			'single_slug' => 'music',
		),
		'recipe' => array(
			'plural'      => __( 'Recipes', 'strangeday-core' ),
			'singular'    => __( 'Recipe', 'strangeday-core' ),
			'menu_icon'   => 'dashicons-carrot',
			'archive_slug'=> 'recipes',
			'single_slug' => 'recipe',
		),
	);
}

/**
 * Registers Strangeday custom post types.
 *
 * @return void
 */
function strangeday_core_register_post_types() {
	foreach ( strangeday_core_get_post_types() as $post_type => $config ) {
		register_post_type(
			$post_type,
			array(
				'labels'              => strangeday_core_get_post_type_labels( $config['plural'], $config['singular'] ),
				'public'              => true,
				'hierarchical'        => false,
				'show_in_rest'        => true,
				'menu_icon'           => $config['menu_icon'],
				'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
				'has_archive'         => $config['archive_slug'],
				'rewrite'             => array(
					'slug'       => $config['single_slug'],
					'with_front' => false,
					'feeds'      => false,
					'pages'      => true,
				),
				'delete_with_user'    => false,
				'exclude_from_search' => false,
				'show_in_nav_menus'   => true,
			)
		);
	}
}

add_action( 'init', 'strangeday_core_register_post_types', 5 );

/**
 * Builds a minimal but complete label set for a custom post type.
 *
 * @param string $plural   Plural label.
 * @param string $singular Singular label.
 * @return array<string, string>
 */
function strangeday_core_get_post_type_labels( $plural, $singular ) {
	return array(
		'name'               => $plural,
		'singular_name'      => $singular,
		'menu_name'          => $plural,
		'all_items'          => sprintf( __( 'All %s', 'strangeday-core' ), $plural ),
		'add_new'            => sprintf( __( 'Add New %s', 'strangeday-core' ), $singular ),
		'add_new_item'       => sprintf( __( 'Add New %s', 'strangeday-core' ), $singular ),
		'edit_item'          => sprintf( __( 'Edit %s', 'strangeday-core' ), $singular ),
		'new_item'           => sprintf( __( 'New %s', 'strangeday-core' ), $singular ),
		'view_item'          => sprintf( __( 'View %s', 'strangeday-core' ), $singular ),
		'view_items'         => sprintf( __( 'View %s', 'strangeday-core' ), $plural ),
		'search_items'       => sprintf( __( 'Search %s', 'strangeday-core' ), $plural ),
		'not_found'          => sprintf( __( 'No %s found', 'strangeday-core' ), strtolower( $plural ) ),
		'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'strangeday-core' ), strtolower( $plural ) ),
		'archives'           => sprintf( __( '%s Archive', 'strangeday-core' ), $singular ),
		'attributes'         => sprintf( __( '%s Attributes', 'strangeday-core' ), $singular ),
	);
}

/**
 * Toggles the matching ACF UI post type definitions.
 *
 * @param bool $activate True to activate the ACF UI definitions, false to deactivate them.
 * @return void
 */
function strangeday_core_sync_acf_post_types( $activate ) {
	if ( ! post_type_exists( 'acf-post-type' ) ) {
		return;
	}

	$target_status = $activate ? 'publish' : 'acf-disabled';

	foreach ( strangeday_core_get_acf_post_type_posts() as $post ) {
		if ( $post->post_status === $target_status ) {
			continue;
		}

		wp_update_post(
			array(
				'ID'          => $post->ID,
				'post_status' => $target_status,
			)
		);
	}
}

/**
 * Returns the ACF internal post type posts that map to Strangeday content types.
 *
 * @return WP_Post[]
 */
function strangeday_core_get_acf_post_type_posts() {
	$posts  = get_posts(
		array(
			'post_type'      => 'acf-post-type',
			'post_status'    => array( 'publish', 'acf-disabled' ),
			'posts_per_page' => -1,
		)
	);
	$slugs  = array_keys( strangeday_core_get_post_types() );
	$target = array();

	foreach ( $posts as $post ) {
		$definition = maybe_unserialize( $post->post_content );

		if ( ! is_array( $definition ) || empty( $definition['post_type'] ) ) {
			continue;
		}

		if ( in_array( $definition['post_type'], $slugs, true ) ) {
			$target[] = $post;
		}
	}

	return $target;
}
