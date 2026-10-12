<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

class CL_Restaurant_Core_Demo_User_Import {

	public $user_migration = [];

	public function __construct() {
		$this->import_users();
		$this->import_usermeta();
		$this->update_authors_in_post_and_postmeta();
	}


	public function import_users() {
		global $wpdb;

		$existing_users     = [];
		$existing_users_obj = get_users( [ 'number' => - 1, 'fields' => [ 'ID', 'user_login' ] ] );
		foreach ( $existing_users_obj as $existing_user ) {
			$existing_users[ $existing_user->user_login ] = $existing_user->ID;
		}

		$user_data = file_get_contents( CL_RESTAURANT_CORE_BASE_DIR . 'demo-users/users.json' );
		$user_data = json_decode( $user_data, true );

		$_user_migration = [];
		foreach ( $user_data as $user_value ) {
			if ( array_key_exists( $user_value['user_login'], $existing_users ) ) {
				//continue;
				require_once( ABSPATH . 'wp-admin/includes/user.php' );
				wp_delete_user( $existing_users[$user_value['user_login']] );
			}

			$old_id = $user_value['ID'];
			unset( $user_value['ID'] );
			if ( $wpdb->insert( $wpdb->users, $user_value ) ) {
				//$this->user_migration[ $old_id ] = $wpdb->insert_id;
				$_user_migration[ $old_id ] = $wpdb->insert_id;
			}
		}

		update_option( 'cl_restaurant_users', $_user_migration );
	}

	public function import_usermeta() {
		global $wpdb;

		$user_meta_data = file_get_contents( CL_RESTAURANT_CORE_BASE_DIR . 'demo-users/usermeta.json' );
		$user_meta_data = json_decode( $user_meta_data, true );

		$_cl_restaurant_users = get_option( 'cl_restaurant_users' );
		foreach ( $user_meta_data as $user_meta_value ) {
			if ( ! array_key_exists( $user_meta_value['user_id'], $_cl_restaurant_users ) ) {
				continue;
			}

			$user_meta_value['user_id']    = $_cl_restaurant_users[ $user_meta_value['user_id'] ];
			$user_meta_value['meta_value'] = maybe_unserialize( $user_meta_value['meta_value'] );

			// run update
			update_user_meta( $user_meta_value['user_id'], $user_meta_value['meta_key'], $user_meta_value['meta_value'] );
		}
	}

	public function update_authors_in_post_and_postmeta() {
		$_cl_restaurant_users = get_option( 'cl_restaurant_users' );

		//Update Listing author : Listing_id => user_id
		$existing_post_authors = [
			// Sami Rogers
			192 => 3,
			182 => 3,
			145 => 3,
			// Alina Fraser
			283 => 4,
			256 => 4,
			232 => 4,
			201 => 4,
			174 => 4,
			// Corey Burke
			274 => 5,
			239 => 5,
			154 => 5,
			// Kian Bailey
			265 => 6, 
			211 => 6, 
			102 => 6, 
			// Eva Martin
			248 => 7,
			218 => 7,
			163 => 7,
			136 => 7,
		];

		foreach ( $existing_post_authors as $post_id => $user_id ) {
			if ( ! array_key_exists( $user_id, $_cl_restaurant_users ) ) {
				continue;
			}
			@wp_update_post( [ 'ID' => $post_id, 'post_author' => $_cl_restaurant_users[ $user_id ] ] );
			update_post_meta( $post_id, '_rtcl_manager_id', $_cl_restaurant_users[ $user_id ] );
		}
	}

	public static function export_users() {
		global $wpdb;
		$users_id = [ 3, 4, 5, 6, 7 ];

		$users_id_sql = implode( ',', $users_id );

		// user table -- IDs are hardcoded integers, safe from SQL injection
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
		$users = $wpdb->get_results( "SELECT * FROM {$wpdb->users} WHERE ID IN ({$users_id_sql})", ARRAY_A );

		// usermeta table
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
		$usermetas = $wpdb->get_results( "SELECT * FROM {$wpdb->usermeta} WHERE user_id IN ({$users_id_sql})", ARRAY_A );


		// json
		$json1 = json_encode( $users );
		$json2 = json_encode( $usermetas );
		file_put_contents( CL_RESTAURANT_CORE_BASE_DIR . 'demo-users/users.json', $json1 );
		file_put_contents( CL_RESTAURANT_CORE_BASE_DIR . 'demo-users/usermeta.json', $json2 );
	}

}