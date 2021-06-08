<?php


namespace App;


class FormToDB {

	public function tb_create() {
		global $wpdb;

		$tb_name = $wpdb->prefix . "tb_form_to_db";

		$query = "CREATE TABLE IF NOT EXISTS $tb_name(
            id int(10) NOT NULL AUTO_INCREMENT,
            user_name varchar (100) DEFAULT '',
            email varchar (100) NOT NULL UNIQUE ,
            phone varchar(20) DEFAULT '',
            date timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            )DEFAULT CHARACTER SET $wpdb->charset";


		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $query );
	}

	public function save_to_tb() {
		global $wpdb;

		$tb_name = $wpdb->prefix . "tb_form_to_db";

		$col_name  = isset( $_POST['name'] ) ? $_POST['name'] : '';
		$col_email = isset( $_POST['email'] ) ? $_POST['email'] : '';
		$col_phone = isset( $_POST['phone'] ) ? $_POST['phone'] : '';
		if ( isset( $_POST['save'] ) ) {
			$result = $wpdb->replace(
				$tb_name,
				[
					'user_name' => $col_name,
					'email'     => $col_email,
					'phone'     => $col_phone,
				],
				[
					'%s',
					'%s',
					'%s',
				]
			);
		}
	}

}