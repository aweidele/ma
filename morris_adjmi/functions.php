<?php

/*
add_filter('option_template', 'dontchoose');
add_filter('template', 'dontchoose');
add_filter('option_template', 'dontchoose');
add_filter('option_stylesheet', 'dontchoose');


function dontchoose($theme) {
	$theme = 'twentythirteen';
	return $theme;
}
*/

/**** ENQUEUE SCRIPTS ****/
function ma_enqueue_scripts() {
	wp_dequeue_script( 'comment-reply' );
	wp_enqueue_script(
		'Main Script',
		get_template_directory_uri().'/script.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);/*
	wp_enqueue_script(
		'Touchswipe',
		get_template_directory_uri().'/jquery.touchSwipe.min.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);*/
	
	//bloginfo('template_directory');/jquery.touchSwipe.min.js
}
add_action( 'wp_enqueue_scripts', 'ma_enqueue_scripts' );


/**** ADD SUPPORT FOR CUSTOM MENUS ****/
add_action( 'init', 'register_my_menu' );
function register_my_menu() {
    register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
    register_nav_menu( 'mobile-menu', __( 'Mobile Menu' ) );
}

/**** ENABLE POST THUMBNAILS ****/
add_theme_support('post-thumbnails');
set_post_thumbnail_size(85, 85,true);
add_image_size('news-main',580,999999);
add_image_size('Homepage Gallery',1460,999999);
add_image_size('Homepage Gallery Mobile',480,263,true);
add_image_size('Page Featured Image',480,999999);
add_image_size('Staff Photo',200,200,true);
add_image_size('Project Photo',1180,999999,true);
add_image_size('Project Related',280,205,true);
add_image_size('Project Slider',999999,360);

add_image_size('Mobile Grid View',106,106,true);
add_image_size('Mobile Portfolio View',480,999999);

/**** ENABLE SIDEBAR SUPPORT ****/
if ( function_exists('register_sidebar') )
register_sidebar();

if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'Footer Left',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<h4>',
'after_title' => '</h4>',
));
register_sidebar(array('name'=>'Footer Right',
'before_widget' => '',
'after_widget' =>  ''
));
register_sidebar(array('name'=>'Mobile Footer',
'before_widget' => '',
'after_widget' =>  ''
));

/**** RENAME/REORDER ADMIN MENU ****/

function custom_menu_order($menu_ord) {  
  if (!$menu_ord) return true;  
          
  return array(  
    'index.php', // Dashboard  
    'separator1', // First separator
    'edit.php?post_type=page', // Pages  
    'edit.php?post_type=people', // People 
    'edit.php?post_type=project', // Project  
    'edit.php', // Posts  
    'upload.php', // Media  
    'edit.php?post_type=announcement', // Project 
    'link-manager.php', // Links  
    'separator2', // Second separator  
    'themes.php', // Appearance  
    'plugins.php', // Plugins  
    'users.php', // Users  
    'tools.php', // Tools  
    'options-general.php', // Settings  
    'separator-last', // Last separator  
        );  
    }  
add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order  
add_filter('menu_order', 'custom_menu_order');

function edit_admin_menus() {  
  global $menu;
  global $submenu;   

  $menu[5][0] = 'News'; // Change Posts to Recipes 
  $submenu['edit.php'][5][0] = 'All News';  
  $submenu['edit.php'][10][0] = 'Add News Post';
}  
add_action( 'admin_menu', 'edit_admin_menus' );  

/**** ADD CUSTOM STYLES TO WYSIWYG EDITOR ****/
add_filter('tiny_mce_before_init', 'add_custom_classes');
function add_custom_classes($arr_options) {
	$arr_options['theme_advanced_styles'] = "Intro Text=intro";
	$arr_options['theme_advanced_buttons2_add_before'] = "styleselect";
	return $arr_options;
}

add_action('init', 'post_type_register');
 
function post_type_register() {

/**** REGISTER PEOPLE POST TYPE ****/
	$labels = array(
		'name' => _x('People', 'post type general name'),
		'singular_name' => _x('Person', 'post type singular name'),
		'add_new' => _x('Add New Person', 'portfolio item'),
		'add_new_item' => __('Add New Person'),
		'edit_item' => __('Edit People'),
		'new_item' => __('New Person'),
		'view_item' => __('View Person'),
		'search_items' => __('Search People'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		//'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array('title','editor','thumbnail')
	  ); 
 
	register_post_type( 'people' , $args );


/**** REGISTER PROJECT POST TYPE ****/
	$labels = array(
		'name' => _x('Projects', 'post type general name'),
		'singular_name' => _x('Project', 'post type singular name'),
		'add_new' => _x('Add New Project', 'portfolio item'),
		'add_new_item' => __('Add New Project'),
		'edit_item' => __('Edit Project'),
		'new_item' => __('New Project'),
		'view_item' => __('View Project'),
		'search_items' => __('Search Projects'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		//'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 21,
		'supports' => array('title','editor','thumbnail'),
		'taxonomies' => array('post_tag')
	  ); 
 
	register_post_type( 'project' , $args );


/**** REGISTER ANNOUNCEMENTS POST TYPE ****/
	$labels = array(
		'name' => _x('Announcements', 'post type general name'),
		'singular_name' => _x('Announcement', 'post type singular name'),
		'add_new' => _x('Add New Announcement', 'portfolio item'),
		'add_new_item' => __('Add New Announcement'),
		'edit_item' => __('Edit Announcement'),
		'new_item' => __('New Announcement'),
		'view_item' => __('View Announcement'),
		'search_items' => __('Search Announcements'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		//'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 21,
		'supports' => array('title','editor','thumbnail'),
		'taxonomies' => array('post_tag')
	  ); 
 
	register_post_type( 'announcement' , $args );


/**** REGISTER TAXONOMIES ****/
    register_taxonomy(
        'project_category',
        'project',
        array(
            'labels' => array(
                'name'              => _x( 'Project Categories' , 'taxonomy general name' ),
                'singular_name'     => _x( 'Project Category' , 'taxonomy singular name'),
                'add_new_item' => 'Add Project Category',
                'new_item_name' => "New Project Category"
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'support' => array('tags')
        )
    );

    register_taxonomy(
        'people_category',
        'people',
        array(
            'labels' => array(
                'name'              => _x( 'People Categories' , 'taxonomy general name' ),
                'singular_name'     => _x( 'People Category' , 'taxonomy singular name'),
                'add_new_item' => 'Add People Category',
                'new_item_name' => "New People Category"
            ),
            'show_ui' => true,
            'show_admin_column' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'support' => array('tags')
        )
    );

	flush_rewrite_rules();
}

//add_action('init', 'demo_add_default_boxes');

/*
// custom columns
add_filter("manage_edit-project_columns", "project_columns");
add_action("manage_posts_custom_column", "project_custom_columns",10,2);

function project_columns($columns){
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Title",
        "taxonomies" => "Project Category",
        "tags" => "Tags",
        "date" => "Date"
    );
    return $columns;
}

function project_custom_columns($column,$id) {
    global $wpdb;
        switch ($column) {
        case 'project-type':
            echo "<pre>"; print_r($wpdb); echo "</pre>";
            $types = $wpdb->get_results("SELECT name FROM $wpdb->posts LEFT OUTER JOIN $wpdb->term_relationships ON ID = object_id LEFT OUTER JOIN $wpdb->terms ON term_taxonomy_id = term_id WHERE ID = {$id}");
            foreach($types as $loopId => $type) {
                echo $type->name.', ';
            }
            break;
        case 'slug':
            $text = basename(get_post_permalink($id));
            echo $text;
            break;
        default:
            break;
        } // end switch
}
*/


/**** RESTYLE SEARCH WIDGET ****/
function style_search_form($form) {
    $form = '
  <div class="search">
    <form method="get" id="searchform" action="' . get_option('home') . '/" >
      <label for="s" class="screen_reader_hidden">Search:</label>
      <div>';

    if (is_search()) {
        $form .='<input type="text" value="' . attribute_escape(apply_filters('the_search_query', get_search_query())) . '" name="s" id="s" />';
    } else {
        $form .='<input type="text" value="Search" name="s" id="s"  onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;"/>';
    }

    $form .= '
      </div>
    </form>
  </div><!-- search -->';


    return $form;
}
add_filter('get_search_form', 'style_search_form');

/**** SOCIAL MEDIA WIDGET ****/
    class EM_Social_Widget extends WP_Widget {  
    function EM_Social_Widget() {  
            parent::WP_Widget(false, 'Social');  
        }  

    function form($instance) {  
            // outputs the options form on admin
            $title = esc_attr($instance['title']); 
            $twitter = esc_attr($instance['twitter']); 
            $instagram = esc_attr($instance['instagram']);  
            $linkedin = esc_attr($instance['linkedin']); 
            $facebook = esc_attr($instance['facebook']); 
            $tumblr = esc_attr($instance['tumblr']);   
?>  
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('TITLE:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('twitter:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo $twitter; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('instagram:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo $instagram; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('linkedin:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('label'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo $linkedin; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('facebook:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo $facebook; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('tumblr'); ?>"><?php _e('tumblr:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('tumblr'); ?>" type="text" value="<?php echo $tumblr; ?>" /></label></p>
<?php  
        }  

    function update($new_instance, $old_instance) {  
            // processes widget options to be saved  
            return $new_instance;  
        }  

    function widget($args, $instance) {  
            // outputs the content of the widget  
            $args['title'] = $instance['title'];
            $args['twitter'] = $instance['twitter'];  
            $args['instagram'] = $instance['instagram'];  
            $args['linkedin'] = $instance['linkedin'];
            $args['facebook'] = $instance['facebook']; 
            $args['tumblr'] = $instance['tumblr']; 
            social_output($args); 
        }  
    }  
    register_widget('EM_Social_Widget');  

function social_output($args) {
?>

<!-- SOCIAL MEDIA WIDGET -->
<div class="social">
<?php if ($args['title']) { ?>  <h4><?php echo $args['title'] ?></h4><?php } ?>
  <ul>
<?php if ($args['facebook']) { ?>    <li class="facebook"><a href="<?php echo $args['facebook']; ?>" class="facebook" target="_blank">Facebook</a></li><?php } echo "\n"; ?>
<?php if ($args['twitter'])  { ?>    <li class="twitter"><a href="<?php echo $args['twitter']; ?>" class="twitter" target="_blank">Twitter</a></li><?php echo "\n"; } ?>
<?php if ($args['instagram'])   { ?>    <li class="instagram"><a href="<?php echo $args['instagram']; ?>" class="instagram" target="_blank">Instagram</a></li><?php } echo "\n"; ?>
<?php if ($args['linkedin']) { ?>    <li class="linkedin"><a href="<?php echo $args['linkedin']; ?>" class="linkedin" target="_blank">LinkedIn</a></li><?php } echo "\n"; ?>
<?php if ($args['tumblr']) { ?>    <li class="tumblr"><a href="<?php echo $args['tumblr']; ?>" class="tumblr" target="_blank">LinkedIn</a></li><?php } echo "\n"; ?>
  </ul>
</div>
<!-- end SOCIAL MEDIA WIDGET -->

<?php
}

/**** THEME SETTINGS ****/
function setup_theme_admin_menus() {  
  add_menu_page('MA Theme Settings', 'MA Settings', 'manage_options', 'ma_settings', 'ma_settings_settings', '', 28.5);
}

function ma_settings_settings() {
  
  // Check if user is allowed to make these changes
  if (!current_user_can('manage_options')) {  
    wp_die('You do not have sufficient permissions to access this page.');  
  } 
  
  // Include theme_settings.php
  require(get_template_directory()."/theme_settings.php");
}

add_action("admin_menu", "setup_theme_admin_menus");



/**** SHORTCODES ****/
/* removes stray <p> and <br /> tags */
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);

/* Map */
function map_func( $atts ) {
  
  $msg = '
    <div class="map_container seven_col">
     <iframe width="100%" height="460" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps?t=m&amp;q=45+W+20th+St,+New+York,+NY+10011&amp;ie=UTF8&amp;hq=&amp;hnear=45+W+20th+St,+New+York,+10011&amp;ll=40.739096,-73.989272&amp;spn=0.011706,0.023217&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe><p style="text-align: right"><a href="https://www.google.com/maps?t=m&amp;q=45+W+20th+St,+New+York,+NY+10011&amp;ie=UTF8&amp;hq=&amp;hnear=45+W+20th+St,+New+York,+10011&amp;ll=40.739096,-73.989272&amp;spn=0.011706,0.023217&amp;z=15&amp;iwloc=A&amp" target="_blank">View Larger Map</a></p>
    </div>';
  
  return $msg;
}

// register shortcodes
function register_shortcodes(){
  add_shortcode( 'map', 'map_func' );
}

add_action( 'init', 'register_shortcodes');

/**** Yoast Sitemap adjustments ****/
add_filter( 'wpseo_sitemap_entry', ma_filter_sitemap, 10, 3 );
function ma_filter_sitemap($url, $postType, $p)
{
	if( $p->post_type == "project" )
	{
		if( get_field('hidden', $p->ID) )
		{
			//
			// Don't display hidden
			//
			return array();
		}
	}
	return $url;
}
?>