<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Twenty Seventeen
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $class Classes for the body element.
 * @return array
 */
function twentyseventeen_body_classes( $class ) {

	$classes = array();

	// Add class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options
	if ( is_customize_preview() ) {
		$classes[] = 'twentyseventeen-customizer';
	}

	// Add class on front page
	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
		$classes[] = 'twentyseventeen-front-page';
	}

	// Add class if no custom header or featured images
	$header_image = get_header_image();
	if ( '' == $header_image && ( ! has_post_thumbnail( $post->ID ) || is_home() ) ) {
		$classes[] = 'no-header-image';
	}

	// Add class if footer image has been added
	$footer_image = get_theme_mod( 'twentyseventeen_footer_image' );
	if ( isset( $footer_image ) ) {
		$classes[] = 'twentyseventeen-footer-image';
	}

	// Add class if sidebar is used
	if ( is_active_sidebar( 'sidebar-1' ) && ! twentyseventeen_is_frontpage() ) {
		$classes[] = 'has-sidebar';
	}

	// Add class if top header content is added
	$twentyseventeen_header_top_text_1 = get_theme_mod( 'twentyseventeen_header_top_text_1' );
	$twentyseventeen_header_top_text_2 = get_theme_mod( 'twentyseventeen_header_top_text_2' );
	if ( '' !== $twentyseventeen_header_top_text_1 || '' !== $twentyseventeen_header_top_text_2 ) {
		$classes[] = 'has-top-content';
	}

	$classes = array_map( 'esc_attr', $classes );

	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_merge( $classes, $class );
	}

	return $classes;
}
add_filter( 'body_class', 'twentyseventeen_body_classes' );

/*
 * Count our number of active panels
 * Primarily used to see if we have any panels active, duh.
 */
function twentyseventeen_panel_count() {
	$panels = array( '1', '2', '3', '4' );
	$panel_count = 0;

	foreach ( $panels as $panel ) {
		if ( get_theme_mod( 'twentyseventeen_panel' . $panel ) ) {
			$panel_count++;
		}
	}

	return $panel_count;
}

/**
 * Checks to see if we're on the homepage or not.
 */
function twentyseventeen_is_frontpage() {
	if ( is_front_page() && ! is_home() ) :
		return true;
	else :
		return false;
	endif;
}
