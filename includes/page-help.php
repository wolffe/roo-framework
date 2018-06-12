<?php
function roo_help_page() {
    ?>
	<div id="poststuff">
		<div class="postbox">
            <h2>Help and Advanced Usage</h2>
            <div class="inside">
                <p><b>roo!</b> Framework is a full-featured, compact and quick to set up framework for creating link directories, business directories, classified ad listings, jobs, article directories, recipe lists and more. Packaged as a plugin for WordPress, <b>roo!</b> Framework allows users to add their items to your directory based on multiple criteria.</p>
                <p><b>roo!</b> Framework uses a powerful review system and it is based on pure WordPress custom post types and taxonomies, using native WordPress comments.</p>

                <h4>Installation</h4>
                <p>
                    1. Upload the <b>roo-framework</b> folder to your <code>/wp-content/plugins/</code> directory<br>
                    2. Activate the plugin via the Plugins menu in WordPress<br>
                    3. Create and publish a new page and add this shortcode: <code>[roo]</code><br>
                    4. A new <b>roo!</b> Items menu will appear in WordPress with items, categories, types, settings and general help<br>
                    5. Create the desired categories and adjust the framework settings<br>
                    6. See usage examples below
                </p>

                <h4>Basic Usage</h4>
                <p>
                    &middot; Add the <code>[roo]</code> shortcode in any post/page to display the framework<br>
                    &middot; Add the <code>[roo page="add"]</code> shortcode to display only the <b>Add Item</b> page<br>
                    &middot; Add the <code>[roo page="summary"]</code> shortcode to display a quick summary (latest items with optional Google Maps)<br>
                    &middot; Add the <code>[roo page="search"]</code> shortcode to display a search form<br>
                    &middot; Add the <code>[roo category="My Category"]</code> shortcode to display a certain category<br>
                    &middot; Add the <code>[roo item="My First Item"]</code> shortcode to display a certain item
                </p>

                <h4>Featured/Highlighted Items</h4>
                <p>Edit the item and add a flavour (like a post tag), for example "highlight". Then create a ".highlight" class in your stylesheet and add the desired style (background, border, text style).</p>

                <h4>Advanced Usage</h4>
                <p>Items can be added both by administrator via the back-end form and by users via the front-end form. Filling in all text fields and textareas will make sure your items get maximum visibility. Keep your title simple and keywords rich. From the <b>roo!</b> Items section you can modify or delete your existing items.</p>
                <p>Whenever an item is pending, a bubble notification will show you how many items are waiting for publishing.</p>
                <p>You can view or edit the item before approving it, or simply delete it if it does not fit your site’s theme or is simply spammy.</p>
                <p>You can add an unlimited number of categories and subcategories and set their desired order.</p>
                <p>You can add an unlimited number of types and subtypes. Some example item types would be buy or sell for a classified ads board, or part-time, full-time or freelance for a job board.</p>

                <h4>Item Template</h4>
                <p>In order to view the full item in a post/page, you need to create a custom post type template in your theme's folder. In order to accomplish this, you need to duplicate the single.php file, rename it as single-roo.php and replace the loop with this line:</p>
                <p><code>&lt;?php if(function_exists('roo_single')) roo_single(); ?&gt;</code></p>

                <h4>Category Template</h4>
                <p>In order to view the items category, you need to create a custom post type template in your theme's folder. In order to accomplish this, you need to duplicate the category.php (or archive.php) file, rename it as taxonomy-roo_category.php and add this line inside the loop:</p>
                <p><code>&lt;?php if (function_exists('roo_category')) roo_category(); ?&gt;</code></p>

                <h4>Sample Templates</h4>
                <p>The examples below are taken straight from my theme.</p>
                <p><textarea class="large-text" rows="12">&lt;?php get_header(); ?&gt;

&lt;div id=&quot;page_wrap&quot;&gt;
    &lt;div id=&quot;page&quot; class=&quot;is_page&quot;&gt;
        &lt;?php if (function_exists('roo_single')) roo_single(); ?&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;?php get_sidebar(); ?&gt;
&lt;?php get_footer(); ?&gt;</textarea></p>
                <p><textarea class="large-text" rows="12">&lt;?php get_header(); ?&gt;

&lt;div id=&quot;page_wrap&quot;&gt;
    &lt;div id=&quot;page&quot; class=&quot;is_page&quot;&gt;
        &lt;?php if (have_posts()) : while (have_posts()) : the_post(); ?&gt;
            &lt;?php if (function_exists('roo_category')) roo_category(); ?&gt;
        &lt;?php endwhile; endif; ?&gt;
    &lt;/div&gt;
&lt;/div&gt;

&lt;?php get_sidebar(); ?&gt;
&lt;?php get_footer(); ?&gt;</textarea></p>
			</div>
		</div>
	</div>
<?php }
