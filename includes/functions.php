<?php
/*
 *
 * functions.php for roo! Framework
 * version 1.3
 *
 */

/*
 * Google Maps
 * Usage: roo_maps(0, 0, 'map', 8, 560, 250, 'TERRAIN', $myrow['address'], 'yes', 'images/icon-marker.png', 'no', '');
 */
if(!function_exists('roo_maps')) {
	function roo_maps($lat, $lon, $id, $z, $w, $h, $maptype, $address, $marker, $markerimage, $traffic) {
		/*
		'lat' 			=> 0,
		'lon' 			=> 0,
		'id' 			=> 'map',
		'z' 			=> 8,
		'w' 			=> 400,
		'h' 			=> 300,
		'maptype' 		=> 'TERRAIN',
		'address' 		=> '',
		'marker' 		=> '',
		'markerimage' 	=> '',
		'traffic' 		=> 'no'
		*/

		$returnme = '<div id="' . $id . '" style="width: 100%; height: ' . $h . 'px;"></div>
		<script src="https://maps.googleapis.com/maps/api/js"></script>
		<script>
		var latlng = new google.maps.LatLng(' . $lat . ', ' . $lon . ');
		var myOptions = { zoom: ' . $z . ', center: latlng, mapTypeId: google.maps.MapTypeId.' . $maptype . ', streetViewControl: true };
        var ' . $id . ' = new google.maps.Map(document.getElementById("' . $id . '"), myOptions);';

		//traffic
		if($traffic == 'yes')
            $returnme .= 'var trafficLayer = new google.maps.TrafficLayer(); trafficLayer.setMap(' . $id . ');';

		//address
		if($address != '') {
            $returnme .= 'var geocoder_' . $id . ' = new google.maps.Geocoder(); var address = "' . $address . '";
            geocoder_' . $id . '.geocode({ \'address\': address}, function(results, status) {
				if(status == google.maps.GeocoderStatus.OK) {
					' . $id . '.setCenter(results[0].geometry.location);';

					if($marker != '') {
						//add custom image
						if($markerimage != '')
                            $returnme .= 'var image = "' . $markerimage . '";';

                        $returnme .= 'var marker = new google.maps.Marker({
                            map: ' . $id . ', ';
							if($markerimage != '')
								$returnme .= 'icon: image,';
							$returnme .= '
								position: ' . $id . '.getCenter()
				        });';
				    }
				$returnme .= '}
            });';
        }

		// marker: show if address is not specified
		if($marker != '' && $address == '') {
            // add custom image
			if($markerimage != '')
				$returnme .= 'var image = "' . $markerimage . '";';

            $returnme .= 'var marker = new google.maps.Marker({
				map: ' . $id . ', ';
				if($markerimage != '')
					$returnme .= 'icon: image,';

				$returnme .= 'position: ' . $id . '.getCenter()
            });';
        }

		$returnme .= '</script>';

		return $returnme;
	}
}

/*
 * shorten a string based on words
 */
if(!function_exists('roo_wordlimit')) {
	function roo_wordlimit($string, $length = 50, $ellipsis = '...') {
		$words = explode(' ', $string);
		if(count($words) > $length)
			return implode(' ', array_slice($words, 0, $length)) . $ellipsis;
		else
			return $string;
	}
}

/*
 * functions to set/get pageviews
 */
if(!function_exists('setRooViews')) {
	function setRooViews($postID) {
		$count_key = '_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count == ''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		} else {
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
}
if(!function_exists('getRooViews')) {
	function getRooViews($postID){
		$count_key = '_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count == ''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return 'No pageviews';
		}
		return $count . ' pageviews';
	}
}

/*
 * function to capture a user's IP address
 */
if(!function_exists('roo_get_my_ip')) {
	function roo_get_my_ip() {
		if(!empty($_SERVER['HTTP_CLIENT_IP']))
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip = $_SERVER['REMOTE_ADDR'];
		return $ip;
	}
}

/*
 * function to insert attachment
 */
if(!function_exists('roo_insert_attachment')) {
	function roo_insert_attachment($file_handler, $post_id, $setthumb = 'false') {
		// check to make sure its a successful upload
		if($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

		require_once(ABSPATH . 'wp-admin' . '/includes/image.php');
		require_once(ABSPATH . 'wp-admin' . '/includes/file.php');
		require_once(ABSPATH . 'wp-admin' . '/includes/media.php');

		$attach_id = media_handle_upload($file_handler, $post_id);

		if($setthumb) update_post_meta($post_id, '_thumbnail_id', $attach_id);
		return $attach_id;
	}
}

/*
 * function to display a simple contact form
 */
if(!function_exists('roo_contact_form')) {
	function roo_contact_form($email) {
		$display = '';

		if(isset($_POST['roo_submit_message'])) {
			$rf_pp_name = $_POST['rf_pp_name'];
			$rf_pp_email = $_POST['rf_pp_email'];
			$rf_pp_message = $_POST['rf_pp_message'];
			$rf_pp_subject = __('Web Contact Form | New Message', 'roo');

			$rf_pp_message = '
			<p>
				<strong>' . __('Name', 'roo') . ':</strong> '.$rf_pp_name.'<br>
				<strong>' . __('Email', 'roo') . ':</strong> '.$rf_pp_email.'<br>
				<strong>' . __('Message', 'roo') . ':</strong> '.$rf_pp_message.'
			</p>
			<p><small>' . $_SERVER['HTTP_REFERER'] . ' | ' . roo_get_my_ip() . ' | ' . $_SERVER['HTTP_USER_AGENT'] . ' | ' . $_SERVER['SERVER_SOFTWARE'] . '</small></p>';

			$headers = '';
			$headers .= 'From: ' . $rf_pp_name . ' <' . $rf_pp_email . '>' . "\r\n";
			$headers .= "Reply-To: " . $rf_pp_email . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			$mail = wp_mail($email, $rf_pp_subject, $rf_pp_message, $headers);

			if($mail)
				$display .= '<p>' . __('Thank you. Your message has been sent.', 'roo') . '</p>';
			else
				$display .= '<p>' . __('There was an error with your message. Please try again.', 'roo') . '</p>';
		}

		$display .= '<h4>' . __('Quick Contact/Application', 'roo') . '</h4>
			<form method="post" action="#" class="pure-form">
				<p>
					<input type="text" name="rf_pp_name" placeholder="' . __('Name', 'roo') . '..." class="pure-input-1-3" required>
					<input type="email" name="rf_pp_email" placeholder="' . __('Email', 'roo') . '..." class="pure-input-1-3" required>
				</p>
				<p><textarea name="rf_pp_message" rows="5" placeholder="' . __('Message', 'roo') . '..." class="pure-input-2-3" required></textarea></p>
				<p>
					<input type="submit" name="roo_submit_message" value="' . __('Send message', 'roo') . '" class="pure-button">
					<input name="spammy" type="hidden" id="spammy" class="spammy">
				</p>
			</form>';

		return $display;
	}
}

function roo_change_order($query) {
    $options = get_option('roo');

    if($query->is_archive && $query->is_tax('roo_category')) {
        $query->set('order', $options['order']);
        $query->set('orderby', $options['orderby']);
	}
    return $query;
}
?>
