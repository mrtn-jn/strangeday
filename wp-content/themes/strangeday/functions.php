<?php
/**
 * strangeday functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since strangeday 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'strangeday_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since strangeday 1.0
	 *
	 * @return void
	 */
	function strangeday_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'strangeday_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'strangeday_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since strangeday 1.0
	 *
	 * @return void
	 */
	function strangeday_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'strangeday_editor_style' );

// Enqueues the theme stylesheet on the front.
if ( ! function_exists( 'strangeday_enqueue_styles' ) ) :
	/**
	 * Enqueues the theme stylesheet on the front.
	 *
	 * @since strangeday 1.0
	 *
	 * @return void
	 */
	function strangeday_enqueue_styles() {
		$suffix = SCRIPT_DEBUG ? '' : '.min';
		$src    = 'style' . $suffix . '.css';

		wp_enqueue_style(
			'strangeday-style',
			get_parent_theme_file_uri( $src ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
		wp_style_add_data(
			'strangeday-style',
			'path',
			get_parent_theme_file_path( $src )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'strangeday_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'strangeday_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since strangeday 1.0
	 *
	 * @return void
	 */
	function strangeday_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'strangeday' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'strangeday_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'strangeday_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since strangeday 1.0
	 *
	 * @return void
	 */
	function strangeday_pattern_categories() {

		register_block_pattern_category(
			'strangeday_page',
			array(
				'label'       => __( 'Pages', 'strangeday' ),
				'description' => __( 'A collection of full page layouts.', 'strangeday' ),
			)
		);

		register_block_pattern_category(
			'strangeday_post-format',
			array(
				'label'       => __( 'Post formats', 'strangeday' ),
				'description' => __( 'A collection of post format patterns.', 'strangeday' ),
			)
		);
	}
endif;
add_action( 'init', 'strangeday_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'strangeday_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since strangeday 1.0
	 *
	 * @return void
	 */
	function strangeday_register_block_bindings() {
		register_block_bindings_source(
			'strangeday/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'strangeday' ),
				'get_value_callback' => 'strangeday_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'strangeday_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'strangeday_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since strangeday 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function strangeday_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;
