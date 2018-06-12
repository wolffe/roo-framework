<?php
/*
Plugin Name: roo! Framework
Version: 5.3.0
Plugin URI: https://getbutterfly.com/wordpress-plugins/roo-framework/
Description: <strong>roo!</strong> Framework is a full-featured, compact and quick to set up framework for creating link directories, business directories, classified ad listings, jobs, article directories, recipe lists and more. Packaged as a plugin for WordPress, <strong>roo!</strong> Framework allows users to add their items to your directory based on multiple criteria.
Author: Ciprian Popescu
Author URI: https://getbutterfly.com/

Copyright 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017 Ciprian Popescu (email: getbutterfly@gmail.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

define('ROO_PLUGIN_URL', WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));
define('ROO_PLUGIN_PATH', WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)));
define('ROO_VERSION', '5.3.0');

// plugin initialization
function roo_loaded() {
	load_plugin_textdomain('roo', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'roo_loaded');

// settings menu
function roo_wp_menu() {
    add_submenu_page('edit.php?post_type=roo', 'roo! Settings', 'roo! Settings', 'manage_options', 'roo_admin_page', 'roo_admin_page');
}

include ROO_PLUGIN_PATH . '/includes/functions.php';
include ROO_PLUGIN_PATH . '/includes/registration.php';

include ROO_PLUGIN_PATH . '/includes/page-dashboard.php';
include ROO_PLUGIN_PATH . '/includes/page-help.php';
include ROO_PLUGIN_PATH . '/includes/page-settings.php';
include ROO_PLUGIN_PATH . '/includes/page-display-directory.php';
include ROO_PLUGIN_PATH . '/_rate.php';

function roo_styles() {
	wp_enqueue_style('pure', ROO_PLUGIN_URL . '/css/pure.css');	
	wp_enqueue_style('roo-styles', ROO_PLUGIN_URL . '/css/style.css');	
}







if (!wp_next_scheduled('roo_delete_items_hook')) {
	wp_schedule_event(time(), 'daily', 'roo_delete_items_hook');
}
//wp_clear_scheduled_hook('roo_delete_items_hook');
add_action('roo_delete_items_hook', 'roo_delete_items');

function roo_delete_items() {
	global $wpdb;

    $options = get_option('roo');

    $query = "SELECT * FROM `" . $wpdb->prefix . "posts` WHERE `post_type` = '" . $options['slug_link'] . "' AND (DATEDIFF(NOW(), `post_date`) > '" . $option['expiration'] . "')";
	$ids = $wpdb->get_results($query);

	if ($ids) {
		foreach ($ids as $id) {
			if ($id->ID == '') {
				continue;
			}
			wp_delete_post($id->ID, false);
		}
	}
}







// Roo activation
$roo_ext_options = get_option('roo');

register_activation_hook(__FILE__, 'roo_init');

// Roo actions
add_action('init', 'create_roo_item'); // registration
add_action('init', 'create_roo_taxonomies', 0); // registration

add_action('admin_init', 'roo_link_admin'); // meta box for Roo details

add_action('admin_menu', 'roo_wp_menu'); // settings menu
add_action('save_post', 'add_roo_item_fields', 10, 2);

add_action('manage_roo_posts_custom_column', 'roo_attachment_column', 5, 2);

add_action('wp_print_styles', 'roo_styles');

if ($roo_ext_options['emailthem'] == 'Yes')
	add_action('draft_to_publish_roo ', 'roo_authorNotification');

// Roo filters
add_filter('manage_roo_posts_columns', 'roo_columns');
add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
add_filter('pre_get_posts' , 'roo_change_order');

// Roo shortcodes
add_shortcode('roo', 'roo_main');

$roo_showcomments = $roo_ext_options['showcomments'];
if ($roo_showcomments == 'Show comments')
	add_filter('the_posts', 'roo_open_comments');

if ($roo_showcomments == 'Hide comments')
	add_filter('the_posts', 'roo_close_comments');


function roo_init() {
	global $wpdb;

	add_option('roo_slug_link', 'item');
	add_option('roo_slug_category', 'section');

	add_option('roo_approval', 'Require item approval (keep as draft)');
	add_option('roo_custom_phone', 'Show phone field');
	add_option('roo_custom_fax', 'Show fax field');
	add_option('roo_custom_hours', 'Show open-hours field');
	add_option('roo_emailme', 'Yes');
	add_option('roo_emailthem', 'Yes');
	add_option('roo_catsperrow', 2);
	add_option('roo_show_numbers', 'Yes');
	add_option('roo_target', '_blank');
	add_option('roo_nofollow', 'No');
	add_option('roo_roomail_title_template_approval', 'Your item has been approved!');
	add_option('roo_roomail_title_template_submission', 'Your item has been submitted!');
	add_option('roo_roomail_intro_template', '');
	add_option('roo_roomail_footer_template', '');

	add_option('roo_showsummarymaps', 'Show Google Maps on summary page');

	add_option('roo_showdirections', 'Show directions form');
	add_option('roo_showcomments', 'Show comments');
	add_option('roo_enable_rating', 'Enable rating');
	add_option('roo_track_hitsin', 'Yes');
	add_option('roo_showgallery', 'Show gallery');
	add_option('roo_showaddress', 'Show address line');
	add_option('roo_showmap', 'Show Google map');
	add_option('roo_showcontact', 'Hide contact form');
	add_option('roo_showurl', 'Show URL');

	add_option('roo_vote5', 0);

	add_option('roo_special_flavour', 'roo-featured');

	// reCAPTCHA options
	add_option('roo_captcha_display', 0);
	add_option('roo_rc_public', '');
	add_option('roo_rc_private', '');

	add_option('roo_showthumb', '');

	// 4.4.2.2
	add_option('roo_allow_images', 1);

    // 4.5.2
	add_option('roo_order', 'desc');
	add_option('roo_orderby', 'date');
	add_option('roo_rc_theme', 'red');

    // 4.5.3
    add_option('roo_excluded_categories', '');

    // 5.0 // framework
    add_option('roo_category_content', 0);
}

// general plugin functions	
function roo_link_admin() {
	add_meta_box('roo_link_meta_box', 'Roo Item Details', 'display_roo_item_meta_box', 'roo', 'normal', 'high');
}

function roo_authorNotification($post_id) {
	global $wpdb;

    $options = get_option('roo');

    $roo_email = get_post_meta($post_id, '_roo_email', true);

	if ($roo_email != '') {
		$roo_submitter = get_post_meta($post_id, '_roo_submitter', true);
		$roo_url = get_post_meta($post_id, '_roo_url', true);

		$message = '';

		$roo_roomail_title_template_approval = $options['roomail_title_template_approval'];
		$roo_roomail_intro_template = $options['roomail_intro_template'];
		$roo_roomail_footer_template = $options['roomail_footer_template'];

		$message .= '<p>' . $roo_roomail_intro_template . '</p>';
		$message .= '<p>' . $roo_url . '<br><small>' . $roo_submitter . '</small></p>';
		$message .= '<p>' . $roo_roomail_footer_template . '</p>';

		wp_mail($roo_email, $roo_roomail_title_template_approval, $message);
	}
}

function display_roo_item_meta_box($roo_item) {
	$roo_url 		   = esc_html(get_post_meta($roo_item->ID, '_roo_url', true));
	$roo_submitter     = esc_html(get_post_meta($roo_item->ID, '_roo_submitter', true));
	$roo_email 	       = esc_html(get_post_meta($roo_item->ID, '_roo_email', true));
	$roo_phone 	       = esc_html(get_post_meta($roo_item->ID, '_roo_phone', true));
	$roo_fax 		   = esc_html(get_post_meta($roo_item->ID, '_roo_fax', true));
	$roo_hours 	       = esc_html(get_post_meta($roo_item->ID, '_roo_hours', true));
	$roo_address       = esc_html(get_post_meta($roo_item->ID, '_roo_address', true));
	$roo_city          = esc_html(get_post_meta($roo_item->ID, '_roo_city', true));
	$roo_country       = esc_html(get_post_meta($roo_item->ID, '_roo_country', true));
	$roo_price         = esc_html(get_post_meta($roo_item->ID, '_roo_price', true));
	?>
	<p>
        <input type="url" class="regular-text" name="roo_url" value="<?php echo $roo_url; ?>" placeholder="URL">
        <br><small><a href="<?php echo $roo_url; ?>" rel="external nofollow" target="_blank">Click to visit link</a>
    </p>
	<p>
		<input type="text" class="text" name="roo_submitter" value="<?php echo $roo_submitter; ?>" placeholder="Submitter/Contact Name">
		<input type="email" name="roo_email" value="<?php echo $roo_email; ?>" placeholder="Email">
	</p>
	<p>
		<input type="text" name="roo_address" value="<?php echo $roo_address; ?>" placeholder="Address">
		<input type="text" name="roo_city" value="<?php echo $roo_city; ?>" placeholder="City/County">
		<input type="text" name="roo_country" value="<?php echo $roo_country; ?>" placeholder="Country">
	</p>
	<p>
		<input type="text" name="roo_phone" value="<?php echo $roo_phone; ?>" placeholder="Phone">
		<input type="text" name="roo_fax" value="<?php echo $roo_fax; ?>" placeholder="Fax">
		<input type="text" name="roo_hours" value="<?php echo $roo_hours; ?>" placeholder="Open-hours">
	</p>
	<p>
		<input type="number" name="roo_price" value="<?php echo $roo_price; ?>" placeholder="Price">
	</p>
<?php }

function add_roo_item_fields() {
	global $post;
	// check autosave
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post;

	$roo_id = get_the_ID();

	if(isset($_POST['roo_url']))
		update_post_meta($roo_id, '_roo_url', $_POST['roo_url']);
	if(isset($_POST['roo_submitter']))
		update_post_meta($roo_id, '_roo_submitter', $_POST['roo_submitter']);
	if(isset($_POST['roo_email']))
		update_post_meta($roo_id, '_roo_email', $_POST['roo_email']);
	if(isset($_POST['roo_phone']))
		update_post_meta($roo_id, '_roo_phone', $_POST['roo_phone']);
	if(isset($_POST['roo_fax']))
		update_post_meta($roo_id, '_roo_fax', $_POST['roo_fax']);
	if(isset($_POST['roo_hours']))
		update_post_meta($roo_id, '_roo_hours', $_POST['roo_hours']);
	if(isset($_POST['roo_address']))
		update_post_meta($roo_id, '_roo_address', $_POST['roo_address']);
	if(isset($_POST['roo_city']))
		update_post_meta($roo_id, '_roo_city', $_POST['roo_city']);
	if(isset($_POST['roo_country']))
		update_post_meta($roo_id, '_roo_country', $_POST['roo_country']);
	if(isset($_POST['roo_price']))
		update_post_meta($roo_id, '_roo_price', $_POST['roo_price']);
}

// custom management columns
function roo_columns($defaults) {
    $defaults['roo_category'] = 'Roo Category';
    $defaults['wps_post_attachments'] = __('Attachments');
    $defaults['post_views'] = __('Pageviews');
    return $defaults;
}
function roo_attachment_column($column_name, $post_id){
	if($column_name === 'roo_category') {
		$taxonomy = $column_name;
		$post_type = get_post_type($post_id);
		$terms = get_the_terms($post_id, $taxonomy);

		if(!empty($terms)) {
			foreach($terms as $term)
				$post_terms[] = "<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " . esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
			echo join(', ', $post_terms);
		}
		else
			echo '<em>Unassigned</em>';
	}
	if($column_name === 'wps_post_attachments') {
		$attachments = get_children(array('post_parent' => $post_id));
		$count = count($attachments);
		if($count != 0)
			echo $count . ' attachments';
		else
			echo 'No attachments';
    }
	if($column_name === 'post_views') {
		echo (getRooViews(get_the_ID()) > 0) ? getRooViews(get_the_ID()) : '0';
	}
}



// Main directory function
// Displays item submission form and category table
function roo_main($atts) {
    $options = get_option('roo');

	extract(shortcode_atts(array(
		'page' => '',
		'category' => '',
		'item' => '',
		'exclude' => '',
	), $atts));

	// ADD NEW ITEM
	if($page == 'add') {
		$category_args = array(
			'show_count' 	=> 1,
			'hide_empty' 	=> 0,
			'hierarchical' 	=> 1,
			'name' 			=> 'roo_category[]',
			'id' 			=> 'roo_category',
			'taxonomy' 		=> 'roo_category',
			'hide_if_empty' => false,
			'echo' 			=> 0
		);
		$type_args = array(
			'show_count' 	=> 1,
			'hide_empty' 	=> 0,
			'hierarchical' 	=> 1,
			'name' 			=> 'roo_type[]',
			'id' 			=> 'roo_type',
			'taxonomy' 		=> 'roo_type',
			'hide_if_empty' => true,
			'echo' 			=> 0
		);

		// Get a key from https://www.google.com/recaptcha/admin/create
		// reCAPTCHA settings
		$publickey = $options['rc_public'];
		$privatekey = $options['rc_private'];
		$resp = null;

		if('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) &&  $_POST['action'] == 'new_post') {
			$roo_submitter 	= $_POST['roo_submitter'];
			$roo_email 		= $_POST['roo_email'];
			$roo_url 		= $_POST['roo_url'];
			$roo_title 		= $_POST['roo_title'];
			$roo_address 	= $_POST['roo_address'];
			$roo_city 		= $_POST['roo_city'];
			$roo_country 	= $_POST['roo_country'];
			$roo_phone 		= $_POST['roo_phone'];
			$roo_fax 		= $_POST['roo_fax'];
			$roo_hours 		= $_POST['roo_hours'];
			$roo_price 		= $_POST['roo_price'];

			// multiple categories
			$roo_category        = '';
			foreach($_POST['roo_category'] as $roo_selectedCategory)
				$roo_category   .= $roo_selectedCategory . ',';
			$roo_category        = rtrim($roo_category, ',');
			$roo_category        = explode(',', $roo_category);

			$roo_type            = '';
			foreach($_POST['roo_type'] as $roo_selectedType)
				$roo_type       .= $roo_selectedType . ',';
			$roo_type            = rtrim($roo_type, ',');
			$roo_type            = explode(',', $roo_type);

			$roo_description 	= $_POST['roo_description'];

			$roo_approval = $options['approval'];
            $roo_status = 'publish';
			if($roo_approval == 'Require item approval (keep as draft)')
				$roo_status = 'draft';
			if($roo_approval == 'Do not require item approval (set as published)')
				$roo_status = 'publish';

			// ADD THE FORM INPUT TO $new_post ARRAY
			$new_post = array(
				'post_title' 	=> $roo_title,
				'post_name' 	=> sanitize_title($roo_title),
				'post_content' 	=> $roo_description,
				'post_status' 	=> $roo_status, // Choose: publish, preview, future, draft, etc.
				'post_type' 	=> 'roo'
			);

			// email functions
			$roo_emailthem = $options['emailthem'];
			$roo_emailme = $options['emailme'];

			$roo_roomail_title_template_submission = $options['roomail_title_template_submission'];
			$roo_roomail_title_template_approval = $options['roomail_title_template_approval'];

			$roo_roomail_intro_template = $options['roomail_intro_template'];
			$roo_roomail_footer_template = $options['roomail_footer_template'];

			$message = '';
			$message .= '<p>' . $roo_roomail_intro_template . '</p>';
			$message .= '<p>' . $roo_roomail_footer_template . '</p>';

			if($options['captcha_display'] == 2) {
				if($_POST['recaptcha_response_field']) {
					require_once(ROO_PLUGIN_PATH . '/recaptchalib.php');
					$resp = recaptcha_check_answer($privatekey, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
					if($resp->is_valid) {
						// SAVE THE POST
						$pid = wp_insert_post($new_post);
						wp_set_post_terms($pid, $roo_category, 'roo_category');
                        wp_set_post_terms($pid, $roo_type, 'roo_type');

						// ADD OUR CUSTOM FIELDS 
						add_post_meta($pid, '_roo_submitter', $roo_submitter, true); 
						add_post_meta($pid, '_roo_email', $roo_email, true); 
						add_post_meta($pid, '_roo_url', $roo_url, true); 
						add_post_meta($pid, '_roo_address', $roo_address, true); 
						add_post_meta($pid, '_roo_city', $roo_city, true); 
						add_post_meta($pid, '_roo_country', $roo_country, true); 
						add_post_meta($pid, '_roo_phone', $roo_phone, true); 
						add_post_meta($pid, '_roo_fax', $roo_fax, true); 
						add_post_meta($pid, '_roo_hours', $roo_hours, true); 
						add_post_meta($pid, '_roo_price', $roo_price, true); 

						if($_FILES) {
							$files = $_FILES['roo_attachment'];
							foreach($files['name'] as $key => $value) {
								if($files['name'][$key]) {
									$file = array(
										'name' 		=> $files['name'][$key],
										'type' 		=> $files['type'][$key],
										'tmp_name' 	=> $files['tmp_name'][$key],
										'error' 	=> $files['error'][$key],
										'size' 		=> $files['size'][$key]
									);
									$_FILES = array('upload_attachment' => $file);

									foreach($_FILES as $file => $array) {
										$newupload = roo_insert_attachment($file, $pid);
									}
								}
							}
						}

						// REDIRECT TO THE NEW POST ON SAVE
						// $link = get_permalink($pid);
						// wp_redirect($link);

						do_action('wp_insert_post', 'wp_insert_post');

						// send email to submitter
						if($roo_emailthem == 'Yes') {
							if($roo_approval == 'Do not require item approval (set as published)')
								wp_mail($roo_email, $roo_roomail_title_template_approval, $message);
							else
								wp_mail($roo_email, $roo_roomail_title_template_submission, $roo_roomail_title_template_submission);
						}

						// send email to administrator
						if($roo_emailme == 'Yes')
							wp_mail(get_bloginfo('admin_email'), 'New Submission', 'A new item has been submitted!');

						echo '<p>' . __('Item submitted successfully!', 'roo') . '</p>';
					}
					else
						echo '<p>' . __('Wrong verification code!', 'roo') . '</p>';
				}
			}
			else { // if reCAPTCHA is not required
				// SAVE THE POST
				$pid = wp_insert_post($new_post);
				wp_set_post_terms($pid, $roo_category, 'roo_category');
                wp_set_post_terms($pid, $roo_type, 'roo_type');

				// ADD OUR CUSTOM FIELDS 
				add_post_meta($pid, '_roo_submitter', $roo_submitter, true); 
				add_post_meta($pid, '_roo_email', $roo_email, true); 
				add_post_meta($pid, '_roo_url', $roo_url, true); 
				add_post_meta($pid, '_roo_address', $roo_address, true); 
				add_post_meta($pid, '_roo_city', $roo_city, true); 
				add_post_meta($pid, '_roo_country', $roo_country, true); 
				add_post_meta($pid, '_roo_phone', $roo_phone, true); 
				add_post_meta($pid, '_roo_fax', $roo_fax, true); 
				add_post_meta($pid, '_roo_hours', $roo_hours, true); 
				add_post_meta($pid, '_roo_price', $roo_price, true); 

				if($_FILES) {
					$files = $_FILES['roo_attachment'];
					foreach($files['name'] as $key => $value) {
						if($files['name'][$key]) {
							$file = array(
								'name' 		=> $files['name'][$key],
								'type' 		=> $files['type'][$key],
								'tmp_name' 	=> $files['tmp_name'][$key],
								'error' 	=> $files['error'][$key],
								'size' 		=> $files['size'][$key]
							);
							$_FILES = array('upload_attachment' => $file);

							foreach($_FILES as $file => $array) {
								$newupload = roo_insert_attachment($file, $pid);
							}
						}
					}
				}

				// REDIRECT TO THE NEW POST ON SAVE
				// $link = get_permalink($pid);
				// wp_redirect($link);

				do_action('wp_insert_post', 'wp_insert_post');

				// send email to submitter
				if($roo_emailthem == 'Yes') {
					if($roo_approval == 'Do not require item approval (set as published)')
						wp_mail($roo_email, $roo_roomail_title_template_approval, $message);
					else
						wp_mail($roo_email, $roo_roomail_title_template_submission, $roo_roomail_title_template_submission);
				}

				// send email to administrator
				if($roo_emailme == 'Yes')
					wp_mail(get_bloginfo('admin_email'), 'New Submission', 'A new item has been submitted!');

				echo '<p>' . __('Item submitted successfully!', 'roo') . '</p>';
			}
		}

        $roo_rc_theme = $options['rc_theme'];

        $display = '<script>var RecaptchaOptions = { theme : "' . $roo_rc_theme . '" };</script>
			<form id="roo_add_item" name="roo_add_item" method="post" action="#anchor" enctype="multipart/form-data" class="pure-form">
                <fieldset class="pure-group">
				    <input type="text" name="roo_title" placeholder="' . __('Title/Name', 'roo') . '" class="pure-u-2-3">
				    <input type="url" name="roo_url" placeholder="' . __('URL (including http://)', 'roo') . '" class="pure-u-2-3">
				    <input type="text" name="roo_submitter" placeholder="' . __('Your name (first and last name)', 'roo') . '" class="pure-u-2-3">
					<input type="email" name="roo_email" placeholder="' . __('Your email (private)', 'roo') . '" class="pure-u-2-3">
				</fieldset>';

				$roo_showaddress = $options['showaddress'];
				if($roo_showaddress == 'Show address line')
				$display .= '
                <fieldset class="pure-group">
				    <input type="text" name="roo_address" placeholder="' . __('Address', 'roo') . '" class="pure-u-2-3">
				    <input type="text" name="roo_city" placeholder="' . __('City/County', 'roo') . '" class="pure-u-2-3">
				    <input type="text" name="roo_country" placeholder="' . __('Country', 'roo') . '" class="pure-u-2-3">
                </fieldset>';

				$roo_custom_phone = $options['custom_phone'];
				$roo_custom_fax = $options['custom_fax'];
				$roo_custom_hours = $options['custom_hours'];
				$roo_custom_price = $options['custom_price'];

				$display .= '<fieldset class="pure-group">';
                    if($roo_custom_phone == 'Show phone field')
                        $display .= '<input type="text" name="roo_phone" placeholder="' . __('Phone', 'roo') . '" class="pure-u-2-3">';
                    if($roo_custom_fax == 'Show fax field')
                        $display .= '<input type="text" name="roo_fax" placeholder="' . __('Fax', 'roo') . '" class="pure-u-2-3">';
                    if($roo_custom_hours == 'Show open-hours field')
                        $display .= '<input type="text" name="roo_hours" placeholder="' . __('Open hours', 'roo') . '" class="pure-u-2-3">';
                    if($roo_custom_price == 1)
                        $display .= '<input type="text" name="roo_price" placeholder="' . __('Price', 'roo') . '" class="pure-u-2-3">';
				$display .= '</fieldset>';

				$display .= '<fieldset class="pure-group">';
                    $roo_allow_multiple_tax = $options['allow_multiple_tax'];
                    $roo_multiple_categories = wp_dropdown_categories($category_args);
                    $roo_multiple_types = wp_dropdown_categories($type_args);
                    if($roo_allow_multiple_tax == 1)
                        $roo_multiple_categories = str_replace('id=', ' class="pure-u-2-3" multiple size="8" id=', $roo_multiple_categories);

                    $display .= $roo_multiple_categories;
                    $display .= $roo_multiple_types;

                    if($options['allow_images'] == 1) {
                        $display .= '
                        <input type="file" id="roo_attachment" name="roo_attachment[]" class="pure-u-2-3" multiple>
                        <small>' . __('Maximum images:', 'roo') . ' ' . ini_get('max_file_uploads') . ' | ' . __('Maximum filesize:', 'roo') . ' ' . ini_get('upload_max_filesize').'</small>';
                    }
				$display .= '</fieldset>';

				$display .= '<fieldset class="pure-group"><textarea name="roo_description" rows="12" class="pure-u-2-3" placeholder="' . __('Description', 'roo') . '"></textarea></fieldset>';

				if($options['captcha_display'] == 2) {
					if(!function_exists('_recaptcha_qsencode'))
						require_once(ROO_PLUGIN_PATH . '/recaptchalib.php');
					$publickey = $options['rc_public'];
					$display .= recaptcha_get_html($publickey);
				}

				$display .= '<input id="submit" name="submit" type="submit" value="' . __('Add', 'roo') . '" class="pure-button pure-button-primary pure-button-xlarge">
				<input type="hidden" name="action" value="new_post">
			</form>';

		return $display;
	}

	// SHOW SEARCH BAR
	if($page == 'search') {
		$display = '';
		$display .= '
			<form role="search" method="get" id="roosearchform" action="">
				<div>
					<input type="text" name="s" id="s" placeholder="' . __('Search...', 'roo') . '"> 
					<input type="submit" id="searchsubmit" value="' . __('Search', 'roo') . '">
					<input type="hidden" name="post_type" value="roo">
				</div>
			</form>
		';

		return $display;
	}

	// SHOW SUMMARY
	if($page == 'summary') {
		$display = '';

		query_posts(array(
			'post_status' => 'publish',
			'post_type' => array('roo'),
			'posts_per_page' => 1,
		));
		if(have_posts()) : while(have_posts()) : the_post();
			$roo_id = get_the_ID();
			$roo_address 	= esc_html(get_post_meta($roo_id, '_roo_address', true));
			$roo_city 		= esc_html(get_post_meta($roo_id, '_roo_city', true));
			$roo_country 	= esc_html(get_post_meta($roo_id, '_roo_country', true));

			$display .= '<div>';
				if($options['showsummarymaps'] == 'Show Google Maps on summary page')
					$display .= roo_maps('0', '0', 'map', '14', '', '300', 'TERRAIN', $roo_address . ', ' . $roo_city . ', ' . $roo_country, 'yes', ROO_PLUGIN_URL . '/images/icon-marker.png', 'no', '');
				$display .= '<div><a href="' . get_permalink() . '" rel="external"><b>' . get_the_title() . '</b> | ' . get_the_date(get_option('date_format')) . '</a><br>' . $roo_address . ', ' . $roo_city . ', ' . $roo_country . '<br><small>' . get_the_excerpt() . '</small></div>';
			$display .= '</div>';
		endwhile;
		endif;
		wp_reset_query();

		$display .= '<hr>';

		query_posts(array(
			'post_status' => 'publish',
			'post_type' => array('roo'),
			'offset' => 1,
			'posts_per_page' => 4,
		));
		if(have_posts()) : while(have_posts()) : the_post();
			$roo_id = get_the_ID();
			$roo_address 	= esc_html(get_post_meta($roo_id, '_roo_address', true));
			$roo_city 		= esc_html(get_post_meta($roo_id, '_roo_city', true));
			$roo_country 	= esc_html(get_post_meta($roo_id, '_roo_country', true));

			$display .= '<div>';
				$display .= '<div><a href="' . get_permalink() . '" rel="external"><b>' . get_the_title() . '</b></a> | ' . get_the_date(get_option('date_format')) . '</div>';
				if($options['showaddress'] == 'Show address line')
					$display .= '<div><small>' . $roo_address . ', ' . $roo_city . ', ' . $roo_country . '</small></div>';
			$display .= '</div>';
		endwhile;
		endif;
		wp_reset_query();

		$display .= '<hr>';

		$display .= '
			<form role="search" method="get" id="roosearchform" action="" class="pure-form">
				<div>
					<input type="text" name="s" id="s" placeholder="' . __('Search...', 'roo') . '"> 
					<input type="submit" id="searchsubmit" value="' . __('Search', 'roo') . '">
					<input type="hidden" name="post_type" value="roo">
				</div>
			</form>';

		return $display;
	}

	// SHOW SELECTED CATEGORY
	if($category != '') {
		$display = '';
		$display .= '<h2>' . $category . '</h2>';

		$catId = get_cat_ID($category);

		query_posts(array(
			'post_status' => 'publish',
			'post_type' => array('roo'),
			'roo_category' => $category,
		));
		if(have_posts()) : while(have_posts()) : the_post();
			$roo_id = get_the_ID();
			$roo_address 	= esc_html(get_post_meta($roo_id, '_roo_address', true));
			$roo_city 		= esc_html(get_post_meta($roo_id, '_roo_city', true));
			$roo_country 	= esc_html(get_post_meta($roo_id, '_roo_country', true));
			$roo_url 		= esc_html(get_post_meta($roo_id, '_roo_url', true));
			$roo_flavour 	= get_the_term_list($roo_id, 'flavour', '', ', ', '');
			$roo_category 	= get_the_term_list($roo_id, 'roo_category', '', ', ', '');
			$roo_views       = getRooViews($roo_id);


			$roo_special_flavour = '';
			if(strip_tags($roo_flavour) == $options['special_flavour'])
				$roo_special_flavour = strip_tags($roo_flavour);

			$display .= '<div class="' . $roo_special_flavour . '">';
				// hide title as it appears inside the archive page
				$display .= '<h2 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
				$display .= '<p><small>';
					$display .= '<a href="' . $roo_url . '" rel="external">' . $roo_url . '</a> | ';
					$display .= $roo_views . ' | ';
					$display .= '<b>' . $roo_category . '</b>';
				$display .= '</small></p>';
				$display .= get_the_excerpt();
			$display .= '</div>';

		endwhile;
		endif;
		wp_reset_query();

		return $display;
	}

	// SHOW SELECTED item
	if($item != '') {
		$display = '';
		$display .= '<h2>' . $item . '</h2>';

		query_posts(array(
			'name' => sanitize_title($item),
			'post_status' => 'publish',
			'post_type' => 'roo',
		));
		if(have_posts()) : while(have_posts()) : the_post();
			$roo_id = get_the_ID();
			$roo_address 	= esc_html(get_post_meta($roo_id, '_roo_address', true));
			$roo_city 		= esc_html(get_post_meta($roo_id, '_roo_city', true));
			$roo_country 	= esc_html(get_post_meta($roo_id, '_roo_country', true));

			$roo_category = get_the_term_list($roo_id, 'roo_category', '', ', ', '');
			$roo_views = getRooViews($roo_id);

			$display .= '<div>';
				$display .= '<p><small>';
					$display .= '<a href="' . get_permalink() . '"><strong>' . get_the_title() . '</strong></a> | ';
					if($options['showsaddress'] == 'Show address line')
						$display .= '<b>' . $roo_city . '</b> | ';
					$display .= $roo_views . ' | ' . get_the_date(get_option('date_format')) . '</small><br>';

					$display .= $roo_category . '<br>';
				$display .= '</p>';
				$display .= '<p>';
					$display .= nl2br(get_the_content()) . ' <a href="' . get_permalink() . '">&raquo;</a>';
				$display .= '</p>';
			$display .= '</div>';
		endwhile;
		endif;
		wp_reset_query();

		return $display;
	}

	// SHOW CATEGORIES // MAIN DIRECTORY SHORTCODE
	if($page == '') {
		$division = $options['catsperrow'];

        $roo_excluded_categories = $options['excluded_categories'];
        if(!empty($roo_excluded_categories))
            $exclude .= ',' . $roo_excluded_categories;

        if($options['show_numbers'] == 'No')
			$roo_show_count = 0;
		else
			$roo_show_count = 1;

        $get_cats = wp_list_categories('echo=0&title_li=&show_count=' . $roo_show_count . '&hide_empty=0&exclude=' . $exclude . '&hierarchical=false&taxonomy=roo_category&orderby=name');

		$cat_array = explode('</li>', $get_cats);

		$display = '';
		$display .= '<style scoped>.roo-categories { -moz-column-count: ' . $division . '; -webkit-column-count: ' . $division . '; column-count: ' . $division . '; }</style>';

		$display .= '<div class="roo-container">';
            $display .= '<ul class="roo-categories">';
                foreach($cat_array as $category) {
                    $display .= $category . '</li>';
                }
            $display .= '</ul>';
		$display .= '</div>';

		return $display;
	}
}



// BEGIN WIDGETS
class roostats_widget extends WP_Widget {
	function __construct() {
		parent::__construct(false, $name = 'roo! Statistics', array('description' => 'A summary of your framework activity'));
	}
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
        if(isset($instance['message']))
            $message = $instance['message'];

		$args = array(
			'post_type' => 'roo',
			'post_status' => 'publish',
			'showposts' => -1,
			'ignore_sticky_posts'=> 1
		);
		$published_roo_items = count(get_posts($args));
		$args = array(
			'post_type' => 'roo',
			'post_status' => 'draft',
			'showposts' => -1,
			'ignore_sticky_posts'=> 1
		);
		$draft_roo_items = count(get_posts($args));

		echo $before_widget;

		if($title)
			echo $before_title.$title.$after_title;
		else
			echo $before_title.__('Framework Statistics', 'roo').$after_title;
		?>
		<ul>
			<li><?php echo $published_roo_items . __(' items', 'roo'); ?></li>
			<li><?php echo $draft_roo_items . __(' pending items', 'roo'); ?></li>
			<li><?php echo count(get_terms('roo_category')) . __(' categories', 'roo'); ?></li>
		</ul>
		<?php echo $after_widget;?>
	<?php
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance) {
		$title = esc_attr($instance['title']);
		?>
		<p>
			This widget will show an unordered list of items, featured items and categories.
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>">
			<br><small>If a title is not supplied, a default, localized one will be displayed.</small>
		</p>
		<?php
	}
}

class roohits_widget extends WP_Widget {
    function __construct() {
        parent::__construct(false, $name = 'roo! Most Visited', array('description' => 'A list of your most visited items'));
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        if (isset($instance['message']))
            $message = $instance['message'];

        echo $before_widget;

        if ($title)
            echo $before_title.$title.$after_title;
        else
            echo $before_title.__('Most Visited Items', 'roo').$after_title;

        query_posts(array(
            'post_status' => 'publish',
            'post_type' => array('roo'),
            'meta_key' => '_post_views_count',
            'posts_per_page' => 5,
            'orderby' => 'meta_value_num',
            'meta_query' => array(
                array(
                    'key' => '_post_views_count',
                    'type' => 'numeric'
                )
            )
        ));
        echo '<ul>';
			if(have_posts()) : while(have_posts()) : the_post();
				$roo_views = getRooViews(get_the_ID());
				echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a> <small>(' . $roo_views . ')</small></li>';
			endwhile; endif;
		echo '</ul>';

		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance) {
		$title = esc_attr($instance['title']);
		?>
		<p>
			This widget will show an unordered list of most visited items, based on their activity.
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>">
			<br><small>If a title is not supplied, a default, localized one will be displayed.</small>
		</p>
		<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("roostats_widget");'));
add_action('widgets_init', create_function('', 'return register_widget("roohits_widget");'));
// END WIDGETS

add_action('admin_menu', 'roo_add_user_menu_bubble');

function roo_add_user_menu_bubble() {
    global $menu, $submenu;

    $args = array(
        'post_type' => 'roo',
        'post_status' => 'draft',
        'showposts' => -1,
        'ignore_sticky_posts'=> 1
    );
    $draft_roo_items = count(get_posts($args));

    if ($draft_roo_items) {
        foreach ($menu as $key => $value) {
            if ($menu[$key][2] == 'edit.php?post_type=roo') {
                $menu[$key][0] .= ' <span class="update-plugins count-' . $draft_roo_items . '"><span class="plugin-count">' . $draft_roo_items . '</span></span>';
                return;
            }
        }

        foreach ($submenu as $key => $value) {
            if ($submenu[$key][2] == 'edit.php?post_type=roo') {
                $submenu[$key][0] .= ' <span class="update-plugins count-' . $draft_roo_items . '"><span class="plugin-count">' . $draft_roo_items . '</span></span>';
                return;
            }
        }
    }
}

/*
 * Open comments for specific post type
 */
function roo_open_comments($posts, $post_type = 'roo') {
    if(!is_single()) {
        return $posts;
    }

    if ((string) get_post_type($posts[0]->ID) === 'roo') {
        $posts[0]->comment_status = 'open';
        $posts[0]->ping_status = 'open';
        wp_update_post($posts[0]);
    }

    return $posts;
}

/*
 * Close comments for specific post type
 */
function roo_close_comments($posts, $post_type = 'roo') {
    if (!is_single()) {
        return $posts;
    }

    if ((string) get_post_type($posts[0]->ID) === 'roo') {
        $posts[0]->comment_status = 'closed';
        $posts[0]->ping_status = 'closed';
        wp_update_post($posts[0]);
    }

    return $posts;
}
