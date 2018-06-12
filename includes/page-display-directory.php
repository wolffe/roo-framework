<?php
// Main display function
function roo_category() {
    global $wp_query;

    $options = get_option('roo');

    $roo_id = $wp_query->post->ID;
    $roo_category = get_the_term_list($roo_id, 'roo_category', '', ', ', '');
    $roo_flavour = get_the_term_list($roo_id, 'flavour', '', ', ', '');
    $roo_date = get_the_time(get_option('date_format'));
    $roo_views = getRooViews($roo_id);

    $roo_target = $options['target'];
    $roo_nofollow = $options['nofollow'];

    $roo_url 		  = esc_html(get_post_meta($roo_id, '_roo_url', true));
    $roo_submitter    = esc_html(get_post_meta($roo_id, '_roo_submitter', true));
    $roo_email        = esc_html(get_post_meta($roo_id, '_roo_email', true));
    $roo_phone        = esc_html(get_post_meta($roo_id, '_roo_phone', true));
    $roo_fax          = esc_html(get_post_meta($roo_id, '_roo_fax', true));
    $roo_hours        = esc_html(get_post_meta($roo_id, '_roo_hours', true));
    $roo_price        = esc_html(get_post_meta($roo_id, '_roo_price', true));
    $roo_address      = esc_html(get_post_meta($roo_id, '_roo_address', true));
    $roo_city         = esc_html(get_post_meta($roo_id, '_roo_city', true));
    $roo_country      = esc_html(get_post_meta($roo_id, '_roo_country', true));

    $output = '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';

	$output .= '<p><small>';
		if($options['showurl'] == 'Show URL')
			$output .= $roo_submitter . ' | <a href="' . $roo_url . '"' . $roo_target . $roo_nofollow . '>' . $roo_url . '</a><br>';
		if($options['track_hitsin'] == 'Yes')
			$output .= $roo_views.' | ';
		$output .= $roo_category.' | ';

		$output .= $roo_date.' | ';
		$output .= get_comments_number($roo_id) . ' ' . __('review(s)', 'roo');

		$output .= '</small>';

    	if($options['showaddress'] == 'Show address line')
            $output .= '<br><small>' . (!empty($roo_address) ? $roo_address . ', ' : '') . (!empty($roo_city) ? $roo_city . ', ' : '') . (!empty($roo_country) ? $roo_country : '') . '</small>';
	$output .= '</p>';

	if($options['showthumb'] == 'thumbalizr.com')
		$output .= '<img src="https://api.thumbalizr.com/?url=' . $roo_url . '&width=120" width="120" class="roo-thumb">';
	if($options['showthumb'] == 'picoshot.com')
		$output .= '<img src="http://www.picoshot.com/t.php?picurl=' . $roo_url . '" width="120" class="roo-thumb">';
	if($options['showthumb'] == 'bitpixels.com')
		$output .= '<img src="http://img.bitpixels.com/getthumbnail?code=11271&url=' . $roo_url . '" width="120" class="roo-thumb">';
	if($options['showthumb'] == 'pagepeeker.com')
		$output .= '<img src="http://free.pagepeeker.com/v2/thumbs.php?size=x&url=' . $roo_url . '" width="120" class="roo-thumb">';
	if($options['showthumb'] == 'shrinktheweb.com')
		$output .= '<img src="http://images.shrinktheweb.com/xino.php?stwembed=1&stwu=adb83&stwinside=1&stwsize=sm&stwurl=' . $roo_url . '" width="120" class="roo-thumb">';
	if($options['showthumb'] == 'thumbshots.com')
		$output .= '<img src="http://images.thumbshots.com/image.aspx?cid=gKhuywsJD6o%3d&v=1&w=120&url=' . $roo_url . '" width="120" class="roo-thumb">';
	if($options['showthumb'] == 'webshrinker.com')
		$output .= '<img src="https://api.webshrinker.com/thumbnails/v1/show/key:51a823b9cb9a2/size:small/url:' . $roo_url . '" width="120" class="roo-thumb">';
	if($options['showthumb'] == 'webthumbnail.org')
		$output .= '<img src="https://api.webthumbnail.org?width=120&height=90&format=jpg&screen=1024&url=' . $roo_url . '" width="120" class="roo-thumb">';
	if($options['showthumb'] == 'immediatenet.com')
		$output .= '<img src="http://immediatenet.com/t/m?Size=1024x768&URL=' . $roo_url . '" width="120" class="roo-thumb">';
	if($options['showthumb'] == '')
		$output .= '';

    if($options['category_content'] == 1)
    	$output .= wpautop(get_the_content());

    $output .= '<div class="clearfix"></div>';

    echo $output;
}

function roo_single() {
	global $wp_query;

    $options = get_option('roo');

    $roo_id = $wp_query->post->ID;
	$roo_category = get_the_term_list($roo_id, 'roo_category', '', ', ', '');
	$roo_flavour = get_the_term_list($roo_id, 'flavour', '', ', ', '');
	$roo_date = get_the_time(get_option('date_format'));
	$roo_views = getRooViews($roo_id);

	$roo_url 		  = esc_html(get_post_meta($roo_id, '_roo_url', true));
	$roo_submitter    = esc_html(get_post_meta($roo_id, '_roo_submitter', true));
	$roo_email        = esc_html(get_post_meta($roo_id, '_roo_email', true));
	$roo_phone        = esc_html(get_post_meta($roo_id, '_roo_phone', true));
	$roo_fax          = esc_html(get_post_meta($roo_id, '_roo_fax', true));
	$roo_hours        = esc_html(get_post_meta($roo_id, '_roo_hours', true));
	$roo_price        = esc_html(get_post_meta($roo_id, '_roo_price', true));
	$roo_address      = esc_html(get_post_meta($roo_id, '_roo_address', true));
	$roo_city         = esc_html(get_post_meta($roo_id, '_roo_city', true));
	$roo_country      = esc_html(get_post_meta($roo_id, '_roo_country', true));

	if($options['target'] == '_blank') $roo_target = ' target="_blank"';
	else $roo_target = '';

	if($options['nofollow'] == 'Yes') $roo_nofollow = ' rel="nofollow"';
	else $roo_nofollow = ' rel="external"';

	setRooViews($roo_id);

	$output = '<div class="roo">';

    $output .= '<h2>' . get_the_title() . '</h2>';

    $roo_currency = $options['currency'];
	if($options['custom_price'] == 1)
		$output .= '<p>' . $roo_currency . $roo_price . '</p>';

	$output .= '<p><small>';
		if($options['showurl'] == 'Show URL')
			$output .= $roo_submitter . ' | <a href="' . $roo_url . '"' . $roo_target . $roo_nofollow . '>' . $roo_url . '</a><br>';
		if($options['track_hitsin'] == 'Yes')
			$output .= $roo_views.' | ';
		$output .= $roo_category.' | ';

		$output .= $roo_date.' | ';
		$output .= get_comments_number($roo_id) . ' ' . __('review(s)', 'roo');

		$output .= '</small>';
	$output .= '</p>';

	$output .= '<p>';
        if($options['showthumb'] == 'thumbalizr.com')
            $output .= '<img src="https://api.thumbalizr.com/?url=' . $roo_url . '&width=120" width="120" class="roo-thumb">';
        if($options['showthumb'] == 'picoshot.com')
            $output .= '<img src="http://www.picoshot.com/t.php?picurl=' . $roo_url . '" width="120" class="roo-thumb">';
        if($options['showthumb'] == 'bitpixels.com')
            $output .= '<img src="http://img.bitpixels.com/getthumbnail?code=11271&url=' . $roo_url . '" width="120" class="roo-thumb">';
        if($options['showthumb'] == 'pagepeeker.com')
            $output .= '<img src="http://free.pagepeeker.com/v2/thumbs.php?size=x&url=' . $roo_url . '" width="120" class="roo-thumb">';
        if($options['showthumb'] == 'shrinktheweb.com')
            $output .= '<img src="http://images.shrinktheweb.com/xino.php?stwembed=1&stwu=adb83&stwinside=1&stwsize=sm&stwurl=' . $roo_url . '" width="120" class="roo-thumb">';
        if($options['showthumb'] == 'thumbshots.com')
            $output .= '<img src="http://images.thumbshots.com/image.aspx?cid=gKhuywsJD6o%3d&v=1&w=120&url=' . $roo_url . '" width="120" class="roo-thumb">';
        if($options['showthumb'] == 'webshrinker.com')
            $output .= '<img src="https://api.webshrinker.com/thumbnails/v1/show/key:51a823b9cb9a2/size:small/url:' . $roo_url . '" width="120" class="roo-thumb">';
        if($options['showthumb'] == 'webthumbnail.org')
            $output .= '<img src="https://api.webthumbnail.org?width=120&height=90&format=jpg&screen=1024&url=' . $roo_url . '" width="120" class="roo-thumb">';
        if($options['showthumb'] == 'immediatenet.com')
            $output .= '<img src="http://immediatenet.com/t/m?Size=1024x768&URL=' . $roo_url . '" width="120" class="roo-thumb">';
        if($options['showthumb'] == '')
            $output .= '';

		$output .= wpautop(get_the_content());
	$output .= '</p>';

	if($options['showmap'] == 'Show Google map') {
		$output .= roo_maps('0', '0', 'map', '15', '', '180', 'TERRAIN', $roo_address . ', ' . $roo_city . ', ' . $roo_country, 'yes', ROO_PLUGIN_URL.'/images/icon-marker.png', 'no', '');

		$output .= '<p>';
			if($options['showaddress'] == 'Show address line')
				$output .= (!empty($roo_address) ? $roo_address . ', ' : '') . (!empty($roo_city) ? $roo_city . ', ' : '') . (!empty($roo_country) ? $roo_country : '') . '<br>';

			if($options['custom_phone'] == 'Show phone field')
				if($roo_phone != '')
					$output .= '<small>' . __('Phone:', 'roo') . ' ' . $roo_phone . '</small> ';
			if($options['custom_fax'] == 'Show fax field')
				if($roo_fax != '')
					$output .= '<small>' . __('Fax:', 'roo') . ' ' . $roo_fax . '</small> ';
			if($options['custom_hours'] == 'Show open-hours field')
				if($roo_hours != '')
					$output .= '<small>' . __('Open hours:', 'roo') . ' ' . $roo_hours. '</small> ';
		$output .= '</p>';

		if($options['showdirections'] == 'Show directions form') {
			$output .= '<form action="http://maps.google.com/maps" method="get" target="_blank" class="pure-form">
							<p>
								<input type="hidden" name="daddr" value="' . $roo_address . ', ' . $roo_city . ', ' . $roo_country . '">
								<input type="text" name="saddr" placeholder="'.__('enter your location to get directions from Google Maps...', 'roo').'" class="pure-input-1-2"> 
								<input type="submit" value="' . __('Go', 'roo') . '" class="pure-button">
							</p>
						</form>';
		}
	}

	if($options['showgallery'] == 'Show gallery') {
		$args = array(
			'order'          => 'ASC',
			'orderby'        => 'menu_order',
			'post_type'      => 'attachment',
			'post_parent'    => $roo_id,
			'post_mime_type' => 'image',
			'post_status'    => null,
			'numberposts'    => -1,
		);
		$attachments = get_posts($args);
		if($attachments) {
			$output .= '<h4>' . __('Gallery', 'roo') . ' (' . count($attachments) . ')</h4>';
			$output .= '<p>';
				foreach($attachments as $attachment) {
					$output .= wp_get_attachment_link($attachment->ID, 'thumbnail', false, false, false);
					$output .= ' ';
				}
			$output .= '</p>';
			}
	}

	$roo_enable_rating = $options['enable_rating'];
	if($roo_enable_rating == 'Enable rating')
		$output .= html_output_rating('');

	if($options['vote5'] == 1)
		if(function_exists('getvote5')) $output .= getvote5('put');

	if($options['showcontact'] == 'Show contact form')
		$output .= roo_contact_form($roo_email);

	$output .= '</div>';

    echo $output;
}
?>
