<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
	die;
}

/* Cleanup db */
$posts = get_posts( array('post_type' => 's418_contactform', 'posts_per_page' => -1) );
foreach ($posts as $post) {
	wp_delete_post( $post->ID, false );
}

unregister_post_type( 's418_contactform' );
flush_rewrite_rules();