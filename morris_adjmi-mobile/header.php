<?php $z = get_post_type(); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<meta property="og:image" content="<?php echo $thumb[0]; ?>" />
<meta itemprop="image" content="<?php echo $thumb[0]; ?>" />
<link rel="image_src" href="<?php echo $thumb[0]; ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/image/favicon.ico" type="image/x-icon"/>

<title><?php
  if (is_front_page()) {
    echo get_bloginfo('name');
    if (get_bloginfo('description')!="") { echo " | ".get_bloginfo('description'); }
  } else {
    wp_title ( ' | ', true,'right' );
    echo get_bloginfo('name');
  } ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- CSS -->
<link type="text/css" rel="stylesheet" href="http://fast.fonts.net/cssapi/d6dbc5e2-7b60-40d7-ad0f-ed0d40e1e4f2.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<!-- JAVASCRIPT -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/script.js"></script>
<?php if ($z == "project") { ?><script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/jquery.touchSwipe.min.js"></script><?php } ?>

<?php
    /*
     *  Add this to support sites with sites with threaded comments enabled.
     */
    if ( is_singular() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    wp_head();

    wp_get_archives('type=monthly&format=link');
?>

</head>
<body>
<?php
/*** ANNOUNCEMENTS? ***/
$announcement= array();
$args = array(
  'post_type' => 'announcement',
  'posts_per_page' => 1
);
$ann = new WP_Query($args);
if($ann->have_posts()) :
?>
<div id="wrapper_announcements">
  <div id="container_announcements">
    <div>
      <div>
<?php while($ann->have_posts()) : $ann->the_post(); ?>
      <?php the_content(); ?>
<?php endwhile; ?>
      </div>
    </div>
  </div>
</div>
<?php 
endif;
wp_reset_query();
?>
<div id="wrapper_header">
  <div id="container_header">

    <h1><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>

    <!-- navigation -->
      <div id="nav"<?php if(is_page_template("homepage-template.php")) { echo ' class="home"'; }?>>
        <nav>
<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'menu_class' => 'nav', 'theme_location' => 'primary-menu' ) ); ?>
        </nav>
        <div class="clear"></div>
      </div><!-- #nav -->

    <div class="clear"></div>
  </div><!-- container_header -->
</div><!-- wrapper_header -->