<?php
/**
 * Legacy ACF PHP export reference for the initial Strangeday post types.
 *
 * Source of truth now lives in:
 * wp-content/plugins/strangeday-core/includes/post-types.php
 */

add_action(
	'init',
	function() {
		register_post_type(
			'music',
			array(
				'labels'           => array(
					'name'          => 'Music',
					'singular_name' => 'Music',
					'menu_name'     => 'Music',
					'all_items'     => 'All Music',
					'add_new_item'  => 'Add New Music',
					'edit_item'     => 'Edit Music',
					'view_item'     => 'View Music',
					'search_items'  => 'Search Music',
					'archives'      => 'Music Archive',
				),
				'public'           => true,
				'show_in_rest'     => true,
				'menu_icon'        => 'dashicons-format-audio',
				'supports'         => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
				'has_archive'      => 'music',
				'rewrite'          => array(
					'slug'       => 'music',
					'with_front' => false,
					'feeds'      => false,
					'pages'      => true,
				),
				'delete_with_user' => false,
			)
		);

		register_post_type(
			'photo',
			array(
				'labels'           => array(
					'name'          => 'Photos',
					'singular_name' => 'Photo',
					'menu_name'     => 'Photos',
					'all_items'     => 'All Photos',
					'add_new_item'  => 'Add New Photo',
					'edit_item'     => 'Edit Photo',
					'view_item'     => 'View Photo',
					'search_items'  => 'Search Photos',
					'archives'      => 'Photo Archive',
				),
				'public'           => true,
				'show_in_rest'     => true,
				'menu_icon'        => 'dashicons-format-image',
				'supports'         => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
				'has_archive'      => 'photos',
				'rewrite'          => array(
					'slug'       => 'photo',
					'with_front' => false,
					'feeds'      => false,
					'pages'      => true,
				),
				'delete_with_user' => false,
			)
		);

		register_post_type(
			'recipe',
			array(
				'labels'           => array(
					'name'          => 'Recipes',
					'singular_name' => 'Recipe',
					'menu_name'     => 'Recipes',
					'all_items'     => 'All Recipes',
					'add_new_item'  => 'Add New Recipe',
					'edit_item'     => 'Edit Recipe',
					'view_item'     => 'View Recipe',
					'search_items'  => 'Search Recipes',
					'archives'      => 'Recipe Archive',
				),
				'public'           => true,
				'show_in_rest'     => true,
				'menu_icon'        => 'dashicons-carrot',
				'supports'         => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
				'has_archive'      => 'recipes',
				'rewrite'          => array(
					'slug'       => 'recipe',
					'with_front' => false,
					'feeds'      => false,
					'pages'      => true,
				),
				'delete_with_user' => false,
			)
		);
	}
);
