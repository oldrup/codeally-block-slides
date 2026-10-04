<?php
/**
 * Plugin Name:       Codeally Block Slides
 * Plugin URI:        https://github.com/oldrup/codeally-block-slides
 * Description:       Registers a slides post type with deck taxonomy and keyboard navigation for block-based presentations.
 * Version:           0.1.2
 * Requires at least: 6.9
 * Tested up to:      7.1
 * Requires PHP:      8.2
 * Author:            Codeally
 * Author URI:        https://codeally.dk/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       codeally-block-slides
 * Tags:              slides, presentation, gutenberg, custom-post-type, keyboard-navigation
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class handling Slide CPT, Taxonomy, and Pattern registration.
 */
final class Codeally_Block_Slides {

	/**
	 * Register 'slide' CPT and 'slide_deck' Taxonomy.
	 */
	public static function register_cpt_and_tax(): void {
		$cpt_labels = array(
			'name'               => _x( 'Slides', 'post type general name', 'codeally-block-slides' ),
			'singular_name'      => _x( 'Slide', 'post type singular name', 'codeally-block-slides' ),
			'menu_name'          => _x( 'Slides', 'admin menu', 'codeally-block-slides' ),
			'name_admin_bar'     => _x( 'Slide', 'add new on admin bar', 'codeally-block-slides' ),
			'add_new'            => __( 'Add New', 'codeally-block-slides' ),
			'add_new_item'       => __( 'Add New Slide', 'codeally-block-slides' ),
			'new_item'           => __( 'New Slide', 'codeally-block-slides' ),
			'edit_item'          => __( 'Edit Slide', 'codeally-block-slides' ),
			'view_item'          => __( 'View Slide', 'codeally-block-slides' ),
			'all_items'          => __( 'All Slides', 'codeally-block-slides' ),
			'search_items'       => __( 'Search Slides', 'codeally-block-slides' ),
			'not_found'          => __( 'No slides found.', 'codeally-block-slides' ),
			'not_found_in_trash' => __( 'No slides found in Trash.', 'codeally-block-slides' ),
		);

		$cpt_args = array(
			'labels'             => $cpt_labels,
			'description'        => __( 'A single slide rendered full viewport with pagination.', 'codeally-block-slides' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_admin_bar'  => true,
			'show_in_nav_menus'  => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'slide', 'with_front' => false ),
			'capability_type'    => 'page',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'menu_icon'          => 'dashicons-slides',
			'show_in_rest'       => true,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
		);

		register_post_type( 'slide', $cpt_args );

		$tax_labels = array(
			'name'              => _x( 'Slide Decks', 'taxonomy general name', 'codeally-block-slides' ),
			'singular_name'     => _x( 'Slide Deck', 'taxonomy singular name', 'codeally-block-slides' ),
			'search_items'      => __( 'Search Slide Decks', 'codeally-block-slides' ),
			'all_items'         => __( 'All Slide Decks', 'codeally-block-slides' ),
			'parent_item'       => __( 'Parent Slide Deck', 'codeally-block-slides' ),
			'parent_item_colon' => __( 'Parent Slide Deck:', 'codeally-block-slides' ),
			'edit_item'         => __( 'Edit Slide Deck', 'codeally-block-slides' ),
			'update_item'       => __( 'Update Slide Deck', 'codeally-block-slides' ),
			'add_new_item'      => __( 'Add New Slide Deck', 'codeally-block-slides' ),
			'new_item_name'     => __( 'New Slide Deck Name', 'codeally-block-slides' ),
			'menu_name'         => __( 'Slide Decks', 'codeally-block-slides' ),
		);

		$tax_args = array(
			'hierarchical'      => true,
			'labels'            => $tax_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'deck' ),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'slide_deck', array( 'slide' ), $tax_args );
	}

	/**
	 * Dynamically register all Block Patterns located in assets/patterns/*.json.
	 */
	public static function register_patterns(): void {
		$patterns_dir = plugin_dir_path( __FILE__ ) . 'assets/patterns/';

		if ( ! is_dir( $patterns_dir ) ) {
			return;
		}

		$json_files = glob( $patterns_dir . '*.json' );
		if ( empty( $json_files ) ) {
			return;
		}

		register_block_pattern_category(
			'codeally',
			array(
				'label' => __( 'Codeally', 'codeally-block-slides' ),
			)
		);

		foreach ( $json_files as $file_path ) {
			$file_content = file_get_contents( $file_path );
			if ( false === $file_content ) {
				continue;
			}

			$pattern_data = json_decode( $file_content, true );
			if ( ! is_array( $pattern_data ) || empty( $pattern_data['content'] ) ) {
				continue;
			}

			$slug_base    = pathinfo( $file_path, PATHINFO_FILENAME );
			$pattern_slug = 'codeally-block-slides/' . sanitize_key( $slug_base );

			register_block_pattern(
				$pattern_slug,
				array(
					'title'       => ! empty( $pattern_data['title'] ) ? $pattern_data['title'] : ucwords( str_replace( array( '-', '_' ), ' ', $slug_base ) ),
					'description' => __( 'Slide layout pattern.', 'codeally-block-slides' ),
					'categories'  => array( 'codeally' ),
					'content'     => $pattern_data['content'],
				)
			);
		}
	}
}

add_action( 'init', static function (): void {
	Codeally_Block_Slides::register_cpt_and_tax();
	Codeally_Block_Slides::register_patterns();
} );

/**
 * Enqueue Pattern Stylesheet for both Frontend and Block Editor.
 */
add_action( 'enqueue_block_assets', static function (): void {
	if ( is_admin() ) {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return;
		}
		$screen = get_current_screen();
		if ( ! $screen || 'slide' !== $screen->post_type ) {
			return;
		}
	} elseif ( ! is_singular( 'slide' ) ) {
		return;
	}

	wp_enqueue_style(
		'cdly-slides-style',
		plugin_dir_url( __FILE__ ) . 'assets/css/block-slide.css',
		array(),
		'0.1.2'
	);
} );

/**
 * Enqueue Frontend Keyboard Navigation Script.
 */
add_action( 'wp_enqueue_scripts', static function (): void {
	if ( ! is_singular( 'slide' ) ) {
		return;
	}

	wp_enqueue_script(
		'cdly-slides-navigation',
		plugin_dir_url( __FILE__ ) . 'assets/js/slides.js',
		array(),
		'1.0.0',
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
} );

/**
 * Activation Hook: Flush Rewrite Rules safely without re-triggering init.
 */
register_activation_hook( __FILE__, static function (): void {
	Codeally_Block_Slides::register_cpt_and_tax();
	flush_rewrite_rules();
} );

/**
 * Deactivation Hook: Flush Rewrite Rules.
 */
register_deactivation_hook( __FILE__, static function (): void {
	flush_rewrite_rules();
} );