<?php
/**
 * Functies voor de thema
 */

/**
 * Run op setup
 */
function studio418_setup() {

	/* pagina titel */
	add_theme_support( 'title-tag' );
	/* post thumbnails */
	add_theme_support( 'post-thumbnails' );
	/* brand logo */
	add_theme_support( 'custom-logo', array(
		'height'      => 40,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true
		) );
	/* custom header */
	add_theme_support( 'custom-header', array(
		'width' => 2600,
		'height' => 650,
		'default-image' => get_template_directory_uri() . '/images/header.jpg',
		'uploads' => true
	) );
	/* Register default header(s) */
	register_default_headers(array(
		'default-header' => array(
			'url' => get_template_directory_uri() . '/images/header.jpg',
			'thumbnail_url' => get_template_directory_uri() . '/images/header.jpg',
			'description' => __('Default header')
		)
	));

}

add_action( 'after_setup_theme', 'studio418_setup' );


/**
 * Voeg CSS en JS toe aan thema
*/
function studio418_scripts() {

	/* CSS */
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.5.0' );
	wp_enqueue_style( 'studio418', get_template_directory_uri() . '/style.css', array(), filemtime( get_template_directory() . '/style.css ' ) );

	/* JS */
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.5.0', 1 );

}

add_action( 'wp_enqueue_scripts', 'studio418_scripts' );

