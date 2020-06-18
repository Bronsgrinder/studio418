<?php
/**
 * Plugin Name: Studio418 contactform
 * Description: Plugin that adds a contactform
 * Author: Patrick Willems
 * Version: 1.0.0
 */

/* Check if class already exist */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'studio418_contactform' ) ) {

	class studio418_contactform {

		public function __construct() {

			add_action( 'init', array(  $this, 'create_post_type' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'manage_s418_contactform_posts_custom_column', array($this, 'cpt_admin_colums_content' ), 10, 2 );
			/* De volgende 2 acties zijn nodig om zowel ingelogde gebruikers als niet ingelogde gebruikers te ondersteunen */
			add_action( 'admin_post_nopriv_studio418_contactform', array( $this, 'form_handler') );
			add_action( 'admin_post_studio418_contactform', array( $this, 'form_handler' ) );

			add_filter( 'manage_s418_contactform_posts_columns', array( $this, 'cpt_admin_colums_head' ) );
		}

		public function enqueue_scripts() {
			/* JS */
			wp_enqueue_script( 'studio418-contactform', plugins_url ('/js/contactform.js', __FILE__), array(), filemtime ( plugin_dir_path(  __FILE__ ) . 'js/contactform.js' ), 1 );
		}

		/*
		 * Register CPT s418_contactform
		 */
		public function create_post_type() {

			register_post_type( 's418_contactform', array(

				'labels' => array(
					'name' => 'Contact',
					'singular_name' => 'Contact'
				),
				'public' => false,
				'has_archive' => false,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'menu_position' => 25,
				'menu_icon' => 'dashicons-buddicons-pm',
				'supports' => array( 'title', 'editor', 'custom-fields' )
				)
			);

		}

		/*
		 * Controleer form input en sla deze op
		 */
		public function form_handler() {

			/*
			 * Check of redirect link is valid is zo niet redirect terug naar homepage
			 * Dit kan alleen gebeuren als
			 */
			$link = get_permalink( intval ( $_POST['redirect_id'] ) );
			if ( ! $link ) {
				wp_redirect(esc_url( home_url() ) );
				exit;
			}

			// Verify wp_nonce
			if ( ! isset( $_POST['wp_nonce'] ) || ! wp_verify_nonce(  sanitize_text_field( $_POST['wp_nonce'] ), 'submit_contactform') ) {
				wp_redirect( esc_url( ( add_query_arg( 'error', '1', $link ) ) ) );
				exit;
			}

			// Sanitize input
			$voornaam = sanitize_text_field( $_POST['voornaam'] );
			$achternaam = sanitize_text_field( $_POST['achternaam'] );
			$email = sanitize_email( $_POST['email'] );
			$bedrijfsnaam = sanitize_text_field( $_POST['bedrijfsnaam'] );
			$telefoon = sanitize_text_field( $_POST['telefoon'] );
			$bericht = sanitize_textarea_field( $_POST['bericht'] );

			// Check
			if( empty( $voornaam ) || empty( $achternaam ) || empty( $email ) || ! is_email( $email ) || empty( $bericht ) ) {

				wp_redirect( esc_url( ( add_query_arg( 'error', '1', $link ) ) ) );

			} else {

				// maak post
				$post = array(
					'post_author' => 1,
					'post_title' => $voornaam . ' ' . $achternaam,
					'post_content' => $bericht,
					'post_type' => 's418_contactform',
					'post_status' => 'publish',
					'meta_input' => array(
						'contact_email' => $email,
						'contact_bedrijfsnaam' => $bedrijfsnaam,
						'contact_telefoon' => $telefoon
					)
				);


				if( is_wp_error( wp_insert_post( $post, true ) ) ) {

					wp_redirect( esc_url( ( add_query_arg( 'error', '1', $link ) ) ) );

				} else {

					wp_redirect( esc_url( ( add_query_arg( 'error', '0', $link ) ) ) );
				}

			}

		}

		/**
		 * Maak de colums in admin panel
		 *
		 * @param $default
		 * @return array
		 */
		public function cpt_admin_colums_head( $default ) {

			unset( $default['date'] );
			$default[ 'title' ] = 'Naam';
			$default[ 'samenvatting' ] = 'Samenvatting';
			$default[ 'email' ] = 'Email';
			$default[ 'bedrijfsnaam' ] = 'Bedrijfsnaam';
			$default[ 'telefoon' ] = 'Telefoon';
			$default[ 'date' ] = 'Datum';

			return $default;
		}

		public function cpt_admin_colums_content( $column_name, $post_id ) {

			// Samenvatting van het bericht
			if( $column_name === 'samenvatting' ) {
				echo esc_html( get_the_excerpt( $post_id ) );
			}

			// Email
			if ( $column_name === 'email' ) {

				$email = get_post_meta( $post_id, 'contact_email', true );
				// Check email voor de zekerheid nog een keer
				if ( ! empty( $email ) && is_email( $email ) ){
					printf( '<a href="mailto:%s">%s</a>', $email, $email );
				}
			}

			// Bedrijfsnaam
			if( $column_name === 'bedrijfsnaam' ) {

				$bedrijfsnaam = get_post_meta( $post_id, 'contact_bedrijfsnaam', true);
				if( ! empty( $bedrijfsnaam ) ) {
					echo esc_html( $bedrijfsnaam );
				}
			}

			// Telefoon
			if( $column_name === 'telefoon' ) {

				$telefoon = get_post_meta( $post_id, 'contact_telefoon', true );
				if( ! empty( $telefoon ) ) {
					echo esc_html( $telefoon );
				}
			}
		}
	}
}

$contactform = new studio418_contactform();