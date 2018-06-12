<?php
function roo_dashboard_page() {
	$args = array(
		'post_type' => 'roo',
		'post_status' => 'publish',
		'showposts' => -1,
		'ignore_sticky_posts'=> 1
	);
	$published_roo_links = get_posts($args);
	$args = array(
		'post_type' => 'roo',
		'post_status' => 'draft',
		'showposts' => -1,
		'ignore_sticky_posts'=> 1
	);
	$draft_roo_links = get_posts($args);
    ?>

    <h2>Dashboard (Help and General Usage)</h2>
    <p><small>
        You are using <b>roo!</b> Framework version <b><?php echo ROO_VERSION; ?></b>.<br>
        You currently have <b><?php echo count($published_roo_links); ?></b> items (<b><?php echo count($draft_roo_links); ?></b> pending) in <b><?php echo count(get_terms('roo_category')); ?></b> categories.
    </small></p>
    <p>Thank you for using <b>roo!</b> Framework, full-featured, compact and quick to set up framework for creating link directories, business directories, classified ad listings, jobs, article directories, recipe lists and more. Packaged as a plugin for WordPress, roo! Framework allows users to add their items to your directory based on multiple criteria.</p>

    <h3>About</h3>
    <p>You can use the shortcode tag <code>[roo]</code> in any post or page. You can use the page and category shortcode parameters to display individual pages or categories. You can use the statistics widget to show your framework statistics, such as items, featured items, categories and more.</p>
    <p style="color: #cc0000;"><b>Don't forget to read the help section before using your framework!</b></p>

    <h4>Help with Shortcodes</h4>
    <p>
        Use <code>[roo page="add"]</code> - in any post or page to show the new item form.<br>
        Use <code>[roo page="search"]</code> - in any post or page to show the search form.<br>
        Use <code>[roo page="summary"]</code> - on your frontpage and display recent items with or without Google Maps and short statistics.<br>
        Use <code>[roo exclude="20,33"]</code> - to exclude certain categories.<br>
        Use <code>[roo category="My Category"]</code> -  to display a certain category.<br>
        Use <code>[roo item="My First Item"]</code> -  to display a certain item.
    </p>

    <h4>Frequently Asked Questions</h4>
    <p>Q: Permalinks are not working or items result in 404 errors.<br>A: Go to <b>Settings</b> &gt; <b>Permalinks</b> and click <b>Save Changes</b>.</p>

    <h4>Help and Support</h4>
    <p>Check the <a href="https://getbutterfly.com/wordpress-plugins/roo-framework/" rel="external">official web site</a> for news, updates and general help.</p>
<?php } ?>
