<?php

/**** ADD SUPPORT FOR CUSTOM MENUS ****/
add_action( 'init', 'register_my_menu' );
function register_my_menu() {
    register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
    register_nav_menu( 'mobile-menu', __( 'Mobile Menu' ) );
}

/**** ENABLE POST THUMBNAILS ****/
add_theme_support('post-thumbnails');
set_post_thumbnail_size(85, 85,true);
add_image_size('Homepage Gallery Mobile',480,263,true);
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


/**** REGISTER PEOPLE POST TYPE ****/
add_action('init', 'people_register');
 
function people_register() {
 
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
		'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail')
	  ); 
 
	register_post_type( 'people' , $args );
	flush_rewrite_rules();
}

/**** REGISTER PROJECT POST TYPE ****/
add_action('init', 'project_register');
 
function project_register() {
 
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
		'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail'),
		'taxonomies' => array('post_tag')
	  ); 
 
	register_post_type( 'project' , $args );
	flush_rewrite_rules();
}

// Add category taxonomy
add_action( 'init', 'create_project_categories', 0 );
function create_project_categories() {
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
}

/**** SHORTCODES ****/
/* removes stray <p> and <br /> tags */
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 12);

/* Map */
function map_func( $atts ) {
  
  $msg = '
    <div class="map_container seven_col">
      <a href="https://www.google.com/maps/preview#!q=45+W+20th+St%2C+New+York%2C+NY+10011&data=!1m4!1m3!1d19319!2d-73.9939339!3d40.739994!4m15!2m14!1m13!1s0x89c259a3d1318599%3A0xe218fd9db8b1529a!3m8!1m3!1d12091!2d-73.988028!3d40.74342!3m2!1i1024!2i768!4f13.1!4m2!3d40.739112!4d-73.989272" target="_blank">
      <img src="'.get_bloginfo('template_directory').'/image/map.png" /></a>
    </div>';
  
  return $msg;
}

// register shortcodes
function register_shortcodes(){
  add_shortcode( 'map', 'map_func' );
}

add_action( 'init', 'register_shortcodes');

?>