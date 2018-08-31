<!DOCTYPE HTML>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=1100">
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/image/favicon.ico" type="image/x-icon"/>

<meta property="og:image" content="<?php echo $thumb[0]; ?>" />
<meta itemprop="image" content="<?php echo $thumb[0]; ?>" />
<link rel="image_src" href="<?php echo $thumb[0]; ?>" />
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
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>?v=4" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/override.css?v=2" />

<?php
if (isset($_REQUEST["fontdemo"]) && $_REQUEST["fontdemo"] == "1")
{
?>
<script type="text/javascript" src="//use.typekit.net/qdm0eyd.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/altfont.css?v=1" />
<?php
}

    /*
     *  Add this to support sites with sites with threaded comments enabled.
     */
    if ( is_singular() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    wp_head();

    wp_get_archives('type=monthly&format=link');

/*** ANNOUNCEMENTS? ***/
$announcement= array();
$args = array(
  'post_type' => 'announcement',
  'posts_per_page' => 1
);
$ann = new WP_Query($args);
if($ann->have_posts()) :
  while($ann->have_posts()) : $ann->the_post();
    $announcement[] = get_the_content();
  endwhile;
endif;
wp_reset_query();
?>

</head>
<body<?php if(is_front_page() && sizeof($announcement)) { echo ' class="announcementVis"'; } ?>>
<?php if(is_front_page() && sizeof($announcement)) { ?>
<!-- ANNOUNCEMENT -->
<div id="wrapper_announcement">
  <div id="container_announcement" class="full_width">
    <div>
      <div>
<?php foreach($announcement as $announcementTxt) { ?>
        <p><?php echo $announcementTxt; ?></p>
<?php } ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<!-- HEADER -->
<div id="wrapper_header"<?php if (is_front_page()) { echo ' class="home"'; } ?>>
  <div id="container_header" class="full_width">
    <h1<?php if(is_page_template("homepage-template.php")) { echo ' class="home"'; }?>>
      <img src="<?php bloginfo('template_directory'); ?>/image/ma-logo.png" alt="Morris Adjmi" />
      <a href="<?php echo get_option('home'); ?>"><span><?php bloginfo('name'); ?></span></a></h1>

    <div id="header_left">

      <!-- navigation -->
      <div id="nav"<?php if(is_page_template("homepage-template.php")) { echo ' class="home"'; }?> class="five_col">
        <nav>
<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'menu_class' => 'nav', 'theme_location' => 'primary-menu' ) ); ?>
        </nav>
        <div class="clear"></div>
      </div><!-- #nav -->
<?php
if(!is_search() && !is_tag()  && !is_404() ) :
/** Subnav
If not a top level page, get ID of parent page. **/
$z = get_post_type();
$a = get_post_ancestors($post->ID);
if($a) { $pid = $a[0]; } else
       { $pid = $post->ID; }

$mypages = get_pages( array( 'child_of' => $pid, 'sort_column' => 'post_date', 'sort_order' => 'asc' ) );
if($mypages) { ?>

      <!-- subnavigation -->
      <div class="subnav five_col">
        <ul>
<?php foreach( $mypages as $page ) {
  //$content = $page->post_content; ?>
<li id="subnav-<?php echo $page->post_name; ?>"><a href="<?php echo get_page_link( $page->ID ); ?>"<?php if($page->ID == $post->ID) { echo ' class="current_page"'; }?>><?php echo $page->post_title; ?></a></li>
<?php } /* foreach */ ?>
        </ul>
        <div class="clear"></div>
      </div><!-- .subnav -->
<?php } ?>

<?php
/** Year archive
If it's a post page, display the year archive in the subnav *
if($z=="post") { ?>

      <!-- subnavigation -->
      <div class="subnav five_col">
        <ul>
<?php wp_get_archives('type=yearly'); ?>
        </ul>
        <div class="clear"></div>
      </div><!-- .subnav -->

<?php } */ ?>

<?php
/** Project archive
If it's a project page, display the project categories in the subnav **/
 if ( is_page_template("project-template.php")||$z=="project" ) {
   $thisid = get_the_ID(); ?>
      <!-- subnavigation -->
      <div class="subnav five_col">
        <ul>
<?php
$id = get_queried_object()->ID;
$terms = wp_get_post_terms( $id , "project_category");

if($terms[0]->slug) {
      $slug = $terms[0]->slug;
} else if (get_queried_object()->slug) {
      $slug = get_queried_object()->slug;
}

/* get the category list and generate the nav */
$categories = get_categories( 'taxonomy=project_category' );
foreach ($categories as $cat) {

  $active = $slug==$cat->slug;
 ?>
          <li id="subnav-<?php echo $cat->slug; ?>"><a href="/project_category/<?php echo $cat->slug; ?>"<?php if($active) { echo ' class="current_page"'; } ?>><?php echo $cat->name; ?></a>
            <ul class="project_dropdown three_col">
<?php /* generate the sub-subnav list of projects */
  $args = array('posts_per_page'=>999,'post_type' => 'project','project_category' => $cat->slug);
  $project_query = new WP_Query($args);
  if($project_query->have_posts()) : while ( $project_query->have_posts() ) : $project_query->the_post(); if(!get_field('hidden')) { ?>
              <li<?php if($id==$thisid) { echo ' class="current_page"'; } ?>><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></li>
<?php }
  endwhile;
  endif; ?>
            </ul>
          </li>
<?php } ?>
        </ul>
        <div class="clear"></div>
      </div><!-- .subnav -->

<?php }

endif; /* !is_search() */
?>

    </div><!-- #header_left -->
    <div class="clear"></div>
  </div><!-- #container_header -->
</div><!-- #wrapper_header -->
