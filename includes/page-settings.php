<?php
add_action('admin_init', 'roo_options_init');

// Init plugin options to white list our options
function roo_options_init(){
    register_setting('roo_options', 'roo');
}

function roo_admin_page() {
	global $wpdb;

	echo '<div class="wrap">
		<h2><b>roo!</b> Framework Settings</h2>';
		?>
        <script>
        jQuery(document).ready(function($){
            $('.nav-tab').css('cursor', 'pointer');

            $('.roo-tabs div').click(function(){
                if($(this).hasClass('selected') === false) {
                    $('.roo-tabs div').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active');
                }
                var selectionId = $(this).attr('id');
                $('.content').fadeOut('fast', function(){
                    $('div .page').css('display', 'none');
                    $('.page#' + selectionId).css('display', 'block');
                    $('.content').fadeIn('fast');
                });
            });
        });
        </script>

		<h2 class="nav-tab-wrapper">
            <div class="roo-tabs">
                <div id="tab1" class="nav-tab nav-tab-active">Dashboard</div>
                <div id="tab2" class="nav-tab">Settings</div>
                <div id="tab3" class="nav-tab">Detail Display</div>
                <div id="tab4" class="nav-tab">Category Display</div>
                <div id="tab5" class="nav-tab">Email</div>
                <div id="tab6" class="nav-tab">Summary</div>
                <div id="tab7" class="nav-tab">Help</div>
            </div>
		</h2>

        <form method="post" action="options.php">
            <?php settings_fields('roo_options'); ?>
            <?php $options = get_option('roo'); ?>
            <div class="content">
                <div class="page" id="tab1" style="display: block;">
                    <?php roo_dashboard_page(); ?>
                </div>
                <div class="page" id="tab7" style="display: none;">
                    <?php roo_help_page(); ?>
                </div>
                <div class="page" id="tab4" style="display: none;">
                    <div id="poststuff">
                        <div class="postbox">
                            <h2>Category/Archive Listing Settings</h2>
                            <div class="inside">
                                <p>
                                    <select name="roo[category_content]" id="roo_category_content">
                                        <option value="1"<?php if($options['category_content'] == 1) echo ' selected'; ?>>Show content on category listing</option>
                                        <option value="0"<?php if($options['category_content'] == 0) echo ' selected'; ?>>Hide content on category listing</option>
                                    </select> <label for="roo_category_content">theme</label>
                                    <br><small>Show or hide item content on the category/archive template.</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page" id="tab2" style="display: none;">
                    <div id="poststuff">
                        <div class="postbox">
                            <h2>Framework Configuration (Purpose/Destination)</h2>
                            <div class="inside">
                                <p><small>Some WordPress configurations require you need to deactivate/reactivate the plugin if you change the slugs.</small></p>
                                <p>
                                    <input type="text" name="roo[slug_link]" id="roo_slug_link" value="<?php echo $options['slug_link']; ?>" class="regular-text"> <label for="roo_slug_link">Item slug</label>
                                    <br><small>Use a relevant word for your item type (e.g. <b>link</b>, <b>ad</b>, <b>job</b>, <b>article</b> or <b>recipe</b>).</small>
                                    <br><small style="color: #cc0000;">You need to regenerate (resave) the permalinks.</small>
                                </p>
                                <p>
                                    <input type="text" name="roo[slug_category]" id="roo_slug_category" value="<?php echo $options['slug_category']; ?>" class="regular-text"> <label for="roo_slug_category">Category slug</label>
                                    <br><small>Use a relevant word for your category (e.g. <b>section</b>, <b>group</b> or <b>topic</b>). Remember that <b>category</b> is reserved by WordPress.</small>
                                    <br><small style="color: #cc0000;">You need to regenerate (resave) the permalinks.</small>
                                </p>
                                <p>
                                    <input type="text" name="roo[slug_type]" id="roo_slug_type" value="<?php echo $options['slug_type']; ?>" class="regular-text"> <label for="roo_slug_type">Type slug</label>
                                    <br><small>Use a relevant word for your type (e.g. <b>type</b>).</small>
                                    <br><small style="color: #cc0000;">You need to regenerate (resave) the permalinks.</small>
                                </p>
                                <p>
                                    <input type="number" name="roo[expiration]" id="roo_expiration" value="<?php echo $options['expiration']; ?>"> <label for="roo_expiration">Item expiration (days)</label>
                                    <br><small>How many days until items expire and are deleted from database. Use for <b>jobs</b> or <b>ads</b>.</small>
                                </p>
                            </div>
                        </div>

                        <div class="postbox">
                            <h2>Display Settings</h2>
                            <div class="inside">
                                <p>
                                    <input type="number" min="1" max="10" name="roo[catsperrow]" id="roo_catsperrow" value="<?php echo $options['catsperrow']; ?>"> <label for="roo_catsperrow">Categories per row <em>(recommended: 2)</em></label>
                                      <br><small>Set this to <b>2</b> if you have a narrow layout or to <b>3</b> if you have a wide layout (or a full page/no sidebar layout).</small>
                               </p>
                               <p>
                                    <input type="text" name="roo[excluded_categories]" id="roo_excluded_categories" value="<?php echo $options['excluded_categories']; ?>"> <label for="roo_excluded_categories">Categories to exclude (use comma-separated IDs or leave blank to deactivate)</label>
                                    <br><small>This is a global option and it will exclude categories from <b>all</b> shortcodes (example: 2,3,175,218).</small>
                               </p>
                               <p>
                                    <select name="roo[show_numbers]" id="roo_show_numbers">
                                        <option value="Yes"<?php if($options['show_numbers'] == 'Yes') echo ' selected'; ?>>Show category count</option>
                                        <option value="No"<?php if($options['show_numbers'] == 'No') echo ' selected'; ?>>Hide category count</option>
                                    </select> 
                                    <select name="roo[target]" id="roo_target">
                                        <option value="_blank"<?php if($options['target'] == '_blank') echo ' selected'; ?>>Open links in new tab</option>
                                        <option value="_self"<?php if($options['target'] == '_self') echo ' selected'; ?>>Open links in parent tab</option>
                                    </select> 
                                    <select name="roo[nofollow]" id="roo_nofollow">
                                        <option value="Yes"<?php if($options['nofollow'] == 'Yes') echo ' selected'; ?>>nofollow links</option>
                                        <option value="No"<?php if($options['nofollow'] == 'No') echo ' selected'; ?>>follow links</option>
                                    </select>
                                </p>
                                <p>
                                    <select name="roo[custom_phone]" id="roo_custom_phone">
                                        <option value="Show phone field"<?php if($options['custom_phone'] == 'Show phone field') echo ' selected'; ?>>Show phone field</option>
                                        <option value="Hide phone field"<?php if($options['custom_phone'] == 'Hide phone field') echo ' selected'; ?>>Hide phone field</option>
                                    </select> 
                                    <select name="roo[custom_fax]" id="roo_custom_fax">';
                                        <option value="Show fax field"<?php if($options['custom_fax'] == 'Show fax field') echo ' selected'; ?>>Show fax field</option>
                                        <option value="Hide fax field"<?php if($options['custom_fax'] == 'Hide fax field') echo ' selected'; ?>>Hide fax field</option>
                                    </select> 
                                    <select name="roo[custom_hours]" id="roo_custom_hours">';
                                        <option value="Show open-hours field"<?php if($options['custom_hours'] == 'Show open-hours field') echo ' selected'; ?>>Show open-hours field</option>
                                        <option value="Hide open-hours field"<?php if($options['custom_hours'] == 'Hide open-hours field') echo ' selected'; ?>>Hide open-hours field</option>
                                    </select> 
                                    <select name="roo[custom_price]" id="roo_custom_price">';
                                        <option value="1"<?php if($options['custom_hours'] == 1) echo ' selected'; ?>>Show price field</option>
                                        <option value="0"<?php if($options['custom_hours'] == 0) echo ' selected'; ?>>Hide price field</option>
                                    </select>
                                    <br><small>Toggling any of these options will also affect the submission form.</small>
                                </p>
                                <p>
                                    <input type="text" name="roo[currency]" id="roo_currency" value="<?php echo $options['currency']; ?>" class="small-text"> <label for="roo_currency">Currency (optional)</label>
                                    <br><small>Use a currency code if you require prices within your framework.</small>
                                </p>
                            </div>
                        </div>

                        <div class="postbox">
                            <h2>Item Submission Settings</h2>
                            <div class="inside">
                                <p>
                                    <select name="roo[allow_multiple_tax]" id="roo_allow_multiple_tax" title="Allow or disallow submission of items in multiple categories">
                                    <option value="1"<?php if($options['allow_multiple_tax'] == 1) echo ' selected'; ?>>Allow multiple item categories</option>
                                    <option value="0"<?php if($options['allow_multiple_tax'] == 0) echo ' selected'; ?>>Do not allow multiple item categories</option>
                                    </select> 
                                    <select name="roo[allow_images]" id="roo_allow_images">
                                        <option value="1"<?php if($options['allow_images'] == 1) echo ' selected'; ?>>Show image upload form</option>
                                        <option value="0"<?php if($options['allow_images'] == 0) echo ' selected'; ?>>Hide image upload form</option>
                                    </select>
                                </p>
                                <p>
                                    <select name="roo[approval]" id="roo_approval">';
                                        <option value="Require item approval (keep as draft)"<?php if($options['approval'] == 'Require item approval (keep as draft)') echo ' selected'; ?>>Require item approval (keep as draft)</option>
                                        <option value="Do not require item approval (publish immediately)"<?php if($options['approval'] == 'Do not require item approval (publish immediately)') echo ' selected'; ?>>Do not require item approval (publish immediately)</option>
                                    </select>
                                </p>
                            </div>
                        </div>
                        <div class="postbox">
                            <h2>Notification Settings</h2>
                            <div class="inside">
                                <p>
                                    <select name="roo[emailme]" id="roo_emailme">
                                        <option value="No"<?php if($options['emailme'] == 'No') echo ' selected'; ?>>Do not notify administrator on item submission</option>
                                        <option value="Yes"<?php if($options['emailme'] == 'Yes') echo ' selected'; ?>>Notify administrator on item submission</option>
                                    </select> 
                                    <select name="roo[emailthem]" id="roo_emailthem">
                                        <option value="No"<?php if($options['emailthem'] == 'No') echo ' selected'; ?>>Do not notify item author on state change</option>
                                        <option value="Yes"<?php if($options['emailthem'] == 'Yes') echo ' selected'; ?>>Notify item author on state change</option>
                                    </select>
                                </p>
                            </div>
                        </div>
                        <div class="postbox">
                            <h2>reCAPTCHA&trade; Settings</h2>
                            <div class="inside">
                                <p>
                                    <select name="roo[captcha_display]">
                                        <option value="2"<?php if($options['captcha_display'] == 2) echo ' selected'; ?>>Display reCAPTCHA&trade; verification (recommended)</option>
                                        <option value="0"<?php if($options['captcha_display'] == 0) echo ' selected'; ?>>Hide reCAPTCHA&trade; verification</option>
                                    </select> <label>using</label> 
                                    <select name="roo[rc_theme]">
                                        <option value="<?php echo $options['rc_theme']; ?>" selected><?php echo $options['rc_theme']; ?></option>
                                        <optgroup label="reCAPTCHA&trade; themes">
                                            <option value="red">red</option>
                                            <option value="white">white</option>
                                            <option value="blackglass">blackglass</option>
                                            <option value="clean">clean</option>
                                        </optgroup>
                                    </select> <label for="roo_rc_theme">theme</label>
                                    <br><small>Show or hide reCAPTCHA&trade; verification (you need a free API key). See themes <a href="https://developers.google.com/recaptcha/docs/customization">here</a>. Default is <b>red</b>.</small>
                                </p>
                                <p>
                                    <input name="roo[rc_public]" id="roo_rc_public" type="text" size="48" value="<?php echo $options['rc_public']; ?>"> <label for="roo_rc_public">reCAPTCHA&trade; Public Key</label><br>
                                    <input name="roo[rc_private]" id="roo_rc_private" type="text" size="48" value="<?php echo $options['rc_private']; ?>"> <label for="roo_rc_private">reCAPTCHA&trade; Private Key</label>
                                    <br><small>Get a key from <a href="https://www.google.com/recaptcha/admin/create" target="_blank" rel="external">https://www.google.com/recaptcha/admin/create</a>.</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page" id="tab5" style="display: none;">
                    <div id="poststuff">
                        <div class="postbox">
                            <h2>Email Options</h2>
                            <div class="inside">
                                <p>
                                    <input type="text" name="roo[roomail_title_template_approval]" id="roo_roomail_title_template_approval" value="<?php echo $options['roomail_title_template_approval']; ?>" class="regular-text"> <label for="roo_roomail_title_template_approval">The title of the email sent to link submitter upon approval.</label>
                                    <br><small>Keep it small to avoid email client spam filters.</small>
                                </p>
                                <p>
                                    <input type="text" name="roo[roomail_title_template_submission]" id="roo_roomail_title_template_submission" value="<?php echo $options['roomail_title_template_submission']; ?>" class="regular-text"> <label for="roo_roomail_title_template_submission">The title of the email sent to item submitter upon submission.</label>
                                    <br><small>Keep it small to avoid email client spam filters.</small>
                                </p>
                                <p>
                                    <label for="roo_roomail_intro_template">Email body</label>
                                    <br><small>The body of the email sent to link submitter upon approval.</small>
                                    <br><textarea class="large-text" name="roo[roomail_intro_template]" id="roo_roomail_intro_template" rows="8"><?php echo $options['roomail_intro_template']; ?></textarea>
                                </p>
                                <p>
                                    <label for="roo[roomail_footer_template]">Email footer</label>
                                    <br><small>The footer of the email sent to link submitter upon approval.</small>
                                    <br><textarea class="large-text" name="roo[roomail_footer_template]" id="roo_roomail_footer_template" rows="8"><?php echo $options['roomail_footer_template']; ?></textarea>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page" id="tab6" style="display: none;">
                    <div id="poststuff">
                        <div class="postbox">
                            <h2>Summary Section Options</h2>
                            <div class="inside">
                                <p>
                                    <select name="roo[showsummarymaps]" id="roo_showsummarymaps">
                                        <option value="Show Google Maps on summary page"<?php if($options['showsummarymaps'] == 'Show Google Maps on summary page') echo ' selected'; ?>>Show Google Maps on summary page</option>
                                        <option value="Hide Google Maps on summary page"<?php if($options['showsummarymaps'] == 'Hide Google Maps on summary page') echo ' selected'; ?>>Hide Google Maps on summary page</option>
                                    </select> <label for="roo_showsummarymaps">Summary Google Maps</label> 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page" id="tab3" style="display: none;">
                    <div id="poststuff">
                        <div class="postbox">
                            <h2>Item Detail Options</h2>
                            <div class="inside">
                                <p>
                                    <label>Sort links </label>
                                    <select name="roo[order]">
                                        <option value="<?php echo $options['order']; ?>" selected><?php echo $options['order']; ?></option>
                                        <option value="asc">asc</option>
                                        <option value="desc">desc</option>
                                    </select>
                                    <label> by </label>
                                    <select name="roo[orderby]">
                                        <option value="<?php echo $options['orderby']; ?>" selected><?php echo $options['orderby']; ?></option>
                                        <option value="title">title</option>
                                        <option value="date">date</option>
                                    </select>
                                    <label> in category view</label>
                                </p>
                                <p>
                                    <label for="roo_showurl"><abbr title="Uniform Resource Locator">URL</abbr> address options:</label> 
                                    <select name="roo[showurl]" id="roo_showurl">
                                        <option value="Show URL"<?php if($options['showurl'] == 'Show URL') echo ' selected'; ?>>Show URL</option>
                                        <option value="Hide URL"<?php if($options['showurl'] == 'Hide URL') echo ' selected'; ?>>Hide URL</option>
                                    </select>
                                    <br><small>This option will show/hide the <abbr title="Uniform Resource Locator">URL</abbr> address both from category page and from listing page.</small>
                                </p>
                                <p>
                                    <select name="roo[showthumb]" id="roo_showthumb">
                                        <option value="thumbalizr.com"<?php if($options['showthumb'] == 'thumbalizr.com') echo ' selected'; ?>>thumbalizr</option>
                                        <option value="picoshot.com"<?php if($options['showthumb'] == 'picoshot.com') echo ' selected'; ?>>picoshot</option>
                                        <option value="bitpixels.com"<?php if($options['showthumb'] == 'bitpixels.com') echo ' selected'; ?>>bitpixels</option>
                                        <option value="pagepeeker.com"<?php if($options['showthumb'] == 'pagepeeker.com') echo ' selected'; ?>>pagepeeker</option>
                                        <option value="shrinktheweb.com"<?php if($options['showthumb'] == 'shrinktheweb.com') echo ' selected'; ?>>shrinktheweb</option>
                                        <option value="thumbshots.com"<?php if($options['showthumb'] == 'thumbshots.com') echo ' selected'; ?>>thumbshots</option>
                                        <option value="webshrinker.com"<?php if($options['showthumb'] == 'webshrinker.com') echo ' selected'; ?>>webshrinker</option>
                                        <option value="webthumbnail.org"<?php if($options['showthumb'] == 'webthumbnail.org') echo ' selected'; ?>>webthumbnail</option>
                                        <option value="immediatenet.com"<?php if($options['showthumb'] == 'immediatenet.com') echo ' selected'; ?>>immediatenet</option>
                                        <option value=""<?php if($options['showthumb'] == '') echo ' selected'; ?>>No thumbnail (default)</option>
                                    </select> <label for="roo_showthumb">Thumbshot generator provider<label>
                                </p>
                                <p>
                                    <select name="roo[showgallery]" id="roo_showgallery">
                                        <option value="Show gallery"<?php if($options['showgallery'] == 'Show gallery') echo ' selected'; ?>>Show attachments gallery</option>
                                        <option value="Hide gallery"<?php if($options['showgallery'] == 'Hide gallery') echo ' selected'; ?>>Hide attachments gallery</option>
                                    </select> 
                                    <select name="roo[track_hitsin]" id="roo_track_hitsin">
                                        <option value="Yes"<?php if($options['track_hitsin'] == 'Yes') echo ' selected'; ?>>Track and display pageviews</option>
                                        <option value="No"<?php if($options['track_hitsin'] == 'No') echo ' selected'; ?>>Do not track pageviews</option>
                                    </select>
                                </p>
                                <p>
                                    <label for="roo_showmap">Address/localization options:</label> 
                                    <select name="roo[showmap]" id="roo_showmap">
                                        <option value="Show Google map"<?php if($options['showmap'] == 'Show Google map') echo ' selected'; ?>>Show Google map</option>
                                        <option value="Hide Google map"<?php if($options['showmap'] == 'Hide Google map') echo ' selected'; ?>>Hide Google map</option>
                                    </select> 
                                    <select name="roo[showdirections]" id="roo_showdirections">
                                        <option value="Show directions form"<?php if($options['showdirections'] == 'Show directions form') echo ' selected'; ?>>Show directions form</option>
                                        <option value="Hide directions form"<?php if($options['showdirections'] == 'Hide directions form') echo ' selected'; ?>>Hide directions form</option>
                                    </select> 
                                    <select name="roo[showaddress]" id="roo_showaddress">
                                        <option value="Show address line"<?php if($options['showaddress'] == 'Show address line') echo ' selected'; ?>>Show address line</option>
                                        <option value="Hide address line"<?php if($options['showaddress'] == 'Hide address line') echo ' selected'; ?>>Hide address line</option>
                                    </select> 
                                </p>
                                <p>
                                    <select name="roo[showcomments]" id="roo_showcomments">
                                        <option value="Show comments"<?php if($options['showcomments'] == 'Show comments') echo ' selected'; ?>>Show comments (WordPress default)</option>
                                        <option value="Hide comments"<?php if($options['showcomments'] == 'Hide comments') echo ' selected'; ?>>Hide comments (WordPress default)</option>
                                    </select> 
                                    <select name="roo[enable_rating]" id="roo_enable_rating">
                                        <option value="Enable rating"<?php if($options['enable_rating'] == 'Enable rating') echo ' selected'; ?>>Enable star rating</option>
                                        <option value="Disable rating"<?php if($options['enable_rating'] == 'Disable rating') echo ' selected'; ?>>Disable star rating</option>
                                    </select> 
                                    <select name="roo[vote5]" id="roo_vote5">
                                        <option value="1"<?php if($options['vote5'] == 1) echo ' selected'; ?>>Enable vote5 (if present)</option>
                                        <option value="0"<?php if($options['vote5'] == 0) echo ' selected'; ?>>Disable vote5 (if present)</option>
                                    </select> 
                                    <?php
                                    if(function_exists('getvote5'))
                                        echo '<label>vote5 plugin is <b>available</b>.<label>';
                                    else
                                        echo '<label><b>vote5</b> plugin is <b>not available</b>. <a href="" rel="external nofollow" target="_blank">Get it here</a>.</label>';
                                    ?>
                                </p>
                                <p>
                                    <label for="roo_showcontact">Contact options:</label> 
                                    <select name="roo[showcontact]" id="roo_showcontact">
                                        <option value="Show contact form"<?php if($options['showcontact'] == 'Show contact form') echo ' selected'; ?>>Show contact form</option>
                                        <option value="Hide contact form"<?php if($options['showcontact'] == 'Hide contact form') echo ' selected'; ?>>Hide contact form</option>
                                    </select>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <p>
				    <input type="submit" name="Submit" value="Save Changes" class="button button-primary">
                </p>
            </div>
		</form>
	</div>
<?php } ?>
