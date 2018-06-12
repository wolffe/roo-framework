<?php
function create_roo_item() {
    $options = get_option('roo');

    $labels = array(
        'name'                  => _x( 'roo! Items', 'Post Type General Name', 'roo' ),
        'singular_name'         => _x( 'roo! Item', 'Post Type Singular Name', 'roo' ),
        'menu_name'             => __( 'roo! Items', 'roo' ),
        'name_admin_bar'        => __( 'roo! Item', 'roo' ),
        'archives'              => __( 'Item Archives', 'roo' ),
        'parent_item_colon'     => __( 'Parent Item:', 'roo' ),
        'all_items'             => __( 'All Items', 'roo' ),
        'add_new_item'          => __( 'Add New Item', 'roo' ),
        'add_new'               => __( 'Add New', 'roo' ),
        'new_item'              => __( 'New Item', 'roo' ),
        'edit_item'             => __( 'Edit Item', 'roo' ),
        'update_item'           => __( 'Update Item', 'roo' ),
        'view_item'             => __( 'View Item', 'roo' ),
        'search_items'          => __( 'Search Item', 'roo' ),
        'not_found'             => __( 'Not found', 'roo' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'roo' ),
        'featured_image'        => __( 'Featured Image', 'roo' ),
        'set_featured_image'    => __( 'Set featured image', 'roo' ),
        'remove_featured_image' => __( 'Remove featured image', 'roo' ),
        'use_featured_image'    => __( 'Use as featured image', 'roo' ),
        'insert_into_item'      => __( 'Insert into item', 'roo' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'roo' ),
        'items_list'            => __( 'Items list', 'roo' ),
        'items_list_navigation' => __( 'Items list navigation', 'roo' ),
        'filter_items_list'     => __( 'Filter items list', 'roo' ),
	);
    $rewrite = array(
        'slug'                  => $options['slug_link'],
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'roo! Item', 'roo' ),
        'description'           => __( 'roo! Framework Item', 'roo' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'custom-fields', ),
        'taxonomies'            => array( 'roo_category', 'roo_type', 'flavour' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
		'menu_icon'             => 'dashicons-star-filled',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,		
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
    );
    register_post_type( 'roo', $args );
}

// create new taxonomies
function create_roo_taxonomies() {
    $options = get_option('roo');

    //
	$labels = array(
		'name'                       => _x( 'roo! Sections', 'Taxonomy General Name', 'roo' ),
		'singular_name'              => _x( 'roo! Section', 'Taxonomy Singular Name', 'roo' ),
		'menu_name'                  => __( 'roo! Sections', 'roo' ),
		'all_items'                  => __( 'All Sections', 'roo' ),
		'parent_item'                => __( 'Parent Section', 'roo' ),
		'parent_item_colon'          => __( 'Parent Section:', 'roo' ),
		'new_item_name'              => __( 'New Section Name', 'roo' ),
		'add_new_item'               => __( 'Add New Section', 'roo' ),
		'edit_item'                  => __( 'Edit Section', 'roo' ),
		'update_item'                => __( 'Update Section', 'roo' ),
		'view_item'                  => __( 'View Section', 'roo' ),
		'separate_items_with_commas' => __( 'Separate sections with commas', 'roo' ),
		'add_or_remove_items'        => __( 'Add or remove sections ', 'roo' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'roo' ),
		'popular_items'              => __( 'Popular Sections', 'roo' ),
		'search_items'               => __( 'Search Sections', 'roo' ),
		'not_found'                  => __( 'Not Found', 'roo' ),
		'no_terms'                   => __( 'No sections', 'roo' ),
		'items_list'                 => __( 'Sections list', 'roo' ),
		'items_list_navigation'      => __( 'Sections list navigation', 'roo' ),
	);
	$rewrite = array(
		'slug'                       => $options['slug_category'],
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'roo_category', array( 'roo' ), $args );



    //
    $labels = array(
		'name'                       => _x( 'roo! Types', 'Taxonomy General Name', 'roo' ),
		'singular_name'              => _x( 'roo! Type', 'Taxonomy Singular Name', 'roo' ),
		'menu_name'                  => __( 'roo! Types', 'roo' ),
		'all_items'                  => __( 'All Types', 'roo' ),
		'parent_item'                => __( 'Parent Type', 'roo' ),
		'parent_item_colon'          => __( 'Parent Type:', 'roo' ),
		'new_item_name'              => __( 'New Type Name', 'roo' ),
		'add_new_item'               => __( 'Add New Type', 'roo' ),
		'edit_item'                  => __( 'Edit Type', 'roo' ),
		'update_item'                => __( 'Update Type', 'roo' ),
		'view_item'                  => __( 'View Type', 'roo' ),
		'separate_items_with_commas' => __( 'Separate types with commas', 'roo' ),
		'add_or_remove_items'        => __( 'Add or remove types ', 'roo' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'roo' ),
		'popular_items'              => __( 'Popular Types', 'roo' ),
		'search_items'               => __( 'Search Types', 'roo' ),
		'not_found'                  => __( 'Not Found', 'roo' ),
		'no_terms'                   => __( 'No types', 'roo' ),
		'items_list'                 => __( 'Types list', 'roo' ),
		'items_list_navigation'      => __( 'Types list navigation', 'roo' ),
	);
	$rewrite = array(
		'slug'                       => $options['slug_type'],
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'roo_type', array( 'roo' ), $args );
    
    

	//
	$labels = array(
		'name'                       => _x( 'roo! Flavours', 'Taxonomy General Name', 'roo' ),
		'singular_name'              => _x( 'roo! Flavour', 'Taxonomy Singular Name', 'roo' ),
		'menu_name'                  => __( 'roo! Flavours', 'roo' ),
		'all_items'                  => __( 'All Flavours', 'roo' ),
		'parent_item'                => __( 'Parent Flavour', 'roo' ),
		'parent_item_colon'          => __( 'Parent Flavour:', 'roo' ),
		'new_item_name'              => __( 'New Flavour Name', 'roo' ),
		'add_new_item'               => __( 'Add New Flavour', 'roo' ),
		'edit_item'                  => __( 'Edit Flavour', 'roo' ),
		'update_item'                => __( 'Update Flavour', 'roo' ),
		'view_item'                  => __( 'View Flavour', 'roo' ),
		'separate_items_with_commas' => __( 'Separate flavours with commas', 'roo' ),
		'add_or_remove_items'        => __( 'Add or remove flavours', 'roo' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'roo' ),
		'popular_items'              => __( 'Popular Flavours', 'roo' ),
		'search_items'               => __( 'Search Flavours', 'roo' ),
		'not_found'                  => __( 'Not Found', 'roo' ),
		'no_terms'                   => __( 'No flavours', 'roo' ),
		'items_list'                 => __( 'Flavours list', 'roo' ),
		'items_list_navigation'      => __( 'Flavours list navigation', 'roo' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => false,
	);
	register_taxonomy( 'flavour', array( 'roo' ), $args );
}
?>
