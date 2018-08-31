<?php
/*
Template Name: Projects

*/
?>
<?php get_header(); ?>
<?php 

/*** DETERMINE WHICH VIEW TO SHOW ***/
$view = isset($_GET["view"]) ? $_GET["view"] : "grid"; 

/*** GET THE CONTENT ***/
$args = array('posts_per_page'=>999,'post_type' => 'project');

$project_query = new WP_Query($args);

$project = array();
$sort = array();

if($project_query->have_posts()) : while ( $project_query->have_posts() ) : $project_query->the_post();

  $title = get_the_title();
  $link  = get_permalink();
  $image = get_field('gallery_image');
  $short_blurb = get_field('short_blurb');
  $info = get_field('info');
  $grid_image = get_the_post_thumbnail($project_query->ID,'Mobile Grid View');
  $portfolio_image = get_the_post_thumbnail($project_query->ID,'Mobile Portfolio View');
  $category =  wp_get_post_terms( get_the_ID() , "project_category");
  $display = get_field('hidden');

  if(!$display[0]) {
  array_push($project,array(
  
    "title" => $title,
    "link" => $link,
    "image_grid" => $image["sizes"]["Mobile Grid View"],
    "grid_image" => $grid_image,
    "portfolio_image" => $portfolio_image,
    "short_blurb" => $short_blurb,
    "info" => $info,
    "category" => $category,
    "display" => $display,
    "mobile_name" => get_field('mobile_name')

  ));
  
  array_push($sort,$title);
  }

endwhile;
endif;

if(isset($_GET["sort"]) && $_GET["sort"] == "alpha") {
  array_multisort($sort,$project);
}

?>

<div id="projects_view">
  <ul>
    <li class="grid<?php if($view=="grid") { echo ' active'; } ?>"><a href="?view=grid">Grid</a></li>
    <li class="portfolio<?php if($view=="portfolio") { echo ' active'; } ?>"><a href="?view=portfolio">Portfolio</a></li>
    <li class="list<?php if($view=="list") { echo ' active'; } ?>"><a href="?view=list">List</a></li>
  </ul>
  <div class="clear"></div>
</div><!-- projects_view -->

<div id="project_content">
<?php switch ($view) {

/*** GRID VIEW ***/
  case "grid" :
  default :
?>
<div class="project_grid">
  <ul>
<?php foreach($project as $p) { ?>
    <li><a href="<?php echo $p["link"]; ?>"><?php echo $p["grid_image"]; ?></a></li>
<?php } ?>
  </ul>
</div><!-- .project_grid -->
<?php break;
  
/*** PORTFOLIO VIEW ***/
  case "portfolio" :
?>
<?php foreach($project as $p) { ?>
<div class="project_portfolio">
  <a href="<?php echo $p["link"]; ?>"><?php echo $p["portfolio_image"]; ?></a>
  <h2><a href="<?php echo $p["link"]; ?>"><?php echo $p["title"]; ?></a></h2>
  <p class="info"><?php echo $p["info"]; ?></p>

</div><!-- .project_portfolio -->
<?php } ?>
<?php break;
  
/*** PORTFOLIO VIEW ***/
  case "list" :
?>
<div class="project_portfolio">
  <table cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td class="name"><a href="?view=list&sort=alpha">Name</a></td>
      <td class="type"><a href="?view=list">Type</a></td>
    </tr>
<?php foreach($project as $p) { ?>
    <tr>
      <td class="name"><a href="<?php echo $p["link"]; ?>"><span><?php if($p["mobile_name"] != "") { echo $p["mobile_name"]; } else { echo $p["title"]; } ?></span></a></td>
      <td class="type"><?php echo $p["category"][0] ->name ; ?></td>
    </tr>
<?php } ?>
  </table>
</div><!-- .project_portfolio -->
<?php break;
} /* end switch */ ?>
</div><!-- #projects_view -->
<div class="clear"></div>


<?php get_footer(); ?>