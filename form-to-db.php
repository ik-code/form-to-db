<?php
/**
 * Plugin name: IK Form to DB
 * Plugin URI: https://sitepro4web.com/
 * Description: Form to DB
 * Version: 1.0.0
 * Author: Ihor Khaletskyi
 * Author URI: https://sitepro4web.com/
 * Licence: GPL2
 * Text Domain: ik-form-to-db
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
Copyright 2005-2015 Automattic, Inc.
*/

defined( 'ABSPATH' ) or die( 'Hey, you can\t access this file!' );

define( 'IK_FORM_TO_DB_PATH', plugin_dir_path( __FILE__ ) );
define( 'IK_FORM_TO_DB_URL', plugin_dir_url( __FILE__ ) );

require IK_FORM_TO_DB_PATH . 'vendor/autoload.php';

use App\FormToDB;

$plugin = new FormToDB();

register_activation_hook( __FILE__, [ $plugin, 'tb_create' ] );

$plugin->save_to_tb();

add_shortcode( 'form-to-db', 'shortcode_method' );
function shortcode_method( $atts, $content = null ) {
    ?>
    <form role="form" action="<?php echo IK_FORM_TO_DB_URL; ?>src/process/"
          method="post"
          style="display: flex; flex-direction: column;">
        <input type="text" name="name" placeholder="Your Name*"
               required="required"><br>
        <input type="email" name="email"
               placeholder="Your Email*" required="required"><br>
        <input type="text"
    name="phone"
    placeholder="+38(xxx)xxx-xx-xx"
    pattern="\+38\s?[\(]\d{3}[\)]\d{3}[\-]\d{2}[\-]\d{2}"
               required="required"><br>
        <input type="hidden" name="_wpnonce"
               value="<?php echo wp_create_nonce( 'form_to_db_nonce' ); ?>">
        <input type="hidden" name="redirect_to"
               value="<?php echo the_permalink(); ?>">
        <input type="submit" name="save" value="Save">
    </form>
	<?php
}

add_action( 'admin_menu', 'form_to_db_plugin_menu' );
function form_to_db_plugin_menu() {
	add_menu_page( 'Form to DB Plugin Page',
	               'Contact List',
	               'manage_options',
	               'contact-list',
	               'contact_list_display' );
}

function contact_list_display() {
  ?>
  <h2>Contact list from table wp_tb_form_to_db</h2>
    <table border="1">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Date</th>
    </tr>
	<?php
	global $wpdb;
	$tb_name = $wpdb->prefix . "tb_form_to_db";
	$items = $wpdb->get_results ( "SELECT * FROM $tb_name" );
	if(!empty($items)){
	foreach ( $items as $item )   {
		?>
        <tr>
            <td><?php echo $item->user_name;?></td>
            <td><?php echo $item->email;?></td>
            <td><?php echo $item->phone;?></td>
            <td><?php echo $item->date;?></td>
        </tr>
	<?php }
	}
}

