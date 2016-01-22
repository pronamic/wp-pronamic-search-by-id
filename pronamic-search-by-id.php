<?php
/*
Plugin Name: Pronamic Search by ID
Plugin URI: http://www.pronamic.eu/plugins/pronamic-search-by-id/
Description: Enables the user to search by post ID using the built-in search. Works for all kinds of posts (posts, pages, custom post types).

Version: 1.0.0
Requires at least: 3.0

Author: Pronamic
Author URI: http://www.pronamic.eu/

Text Domain: pronamic_search_by_id
Domain Path: /languages/

License: GPL

GitHub URI: https://github.com/pronamic/wp-pronamic-search-by-id
*/

function pronamic_search_by_id_where( $where ) {
	if ( is_search() ) {
		$s = filter_input( INPUT_GET, 's', FILTER_SANITIZE_STRING );

		if ( ! empty( $s ) ) {
			global $wpdb;

			if ( is_numeric( $s ) ) {
				$where .= ' OR ' . $wpdb->posts . '.ID = ' . $s;
			} elseif ( preg_match( '/^(\d+)(,\s*\d+)*\$/', $s ) ) { // string of post IDs
				$where .= ' OR ' . $wpdb->posts . '.ID in (' . $s . ')';
			}
		}
	}

	return $where;
}

add_filter( 'posts_where', 'pronamic_search_by_id_where' );
