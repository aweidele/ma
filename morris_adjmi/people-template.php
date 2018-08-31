<?php
/*
Template Name: People

*/
?>
<?php
/**** GET CONTENT FOR PAGE ****/
if(have_posts()) : while ( have_posts() ) : the_post();
$content = get_field( "blurbs" );
shuffle($content);

$blurbpause = get_field( "blurb_pause" );
$blurbspeed = get_field( "blurb_fade_speed" );

endwhile;
endif;
wp_reset_query();

/**** GET THE PEOPLE LIST ****/
$people = array();
$peopleList = array();
$args = array('post_type' => 'people','posts_per_page' => 9999);
$taxonomy = 'people_category';
$pc = get_terms($taxonomy);
$peoplecat = array();
foreach($pc as $key => $cat) {
  $peoplecat['col-'.(floor($key / 2)+1)][] = $cat;
}

$tmp = array();
$people_query = new WP_Query($args);
if($people_query -> have_posts()) :
while( $people_query -> have_posts() ) : $people_query -> the_post();
  $id = get_the_ID();
  $name = get_the_title();
  $bio = get_the_content();
  $photo = get_the_post_thumbnail(get_the_ID(),'Staff Photo');
  $cv = get_field('cv');
  $related_projects = get_field('related_projects');
  $slug = $post->post_name;

  $cat = get_the_terms( $id, 'people_category' );
  
  foreach($cat as $c) {
    $peopleList[$c->slug][] = array(
      "name" => $name,
      "slug" => $slug
    );
  }
  $people[] = array(
      "id"                   => $id,
      "name"                 => $name,
      "bio"                  => $bio,
      "photo"                => $photo,
      "cv"                   => $cv,
      "related_projects"     => $related_projects,
      "slug"                 => $slug,
  );
endwhile;
endif;
wp_reset_query();
?>

<?php get_header(); ?>
<!-- CONTENT -->
<div class="people_top">
<div class="people_top_container full_width">
<!-- PEOPLE INTRO -->
<div id="people_intro" class="six_col">
  <div class="blurbs_carousel">
<?php 
  $first = true;
  foreach($content as $c) { ?>
    <p class="intro<?php if($first) { echo " active"; $first = false; } ?>"><?php echo $c["blurb"]; ?></p>
<?php } ?>
  </div>
</div><!-- #people_intro -->

<!-- PEOPLE LIST -->
<div id="people_list" class="full_width">
<?php foreach($peoplecat as $col => $catcol) { ?>
  <div class="<?php echo $col; ?>">
<?php foreach($catcol as $cat) { ?>
    <h3 class="listheader-<?php echo $cat->slug; ?>"><?php echo $cat->name; ?></h3>
    <ul class="list-<?php echo $cat->slug; ?>">
<?php foreach($peopleList[$cat->slug] as $p) { ?>
    <li><a href="#<?php echo $p['slug']; ?>"><?php echo $p['name']; ?></a></li>
<?php } ?>
    </ul>
<?php } ?>
  </div>
<?php } // foreach($peoplecat as $cat) ?>

</div><!-- #people_list -->
<div class="clear"></div>
</div><!-- .people_top_container -->
</div><!-- .people_top -->


<div id="wrapper_content" class="people">
  <div id="container_content" class="full_width">

<!-- PEOPLE BIOS -->
<?php foreach($people as $p) { ?>

<div class="people_bio_container" id="<?php echo $p['slug']; ?>">
  <div class="people_bio six_col">
    <h3><?php echo $p['name']; ?><?php if (is_user_logged_in()) { ?> <a href="<?php echo get_edit_post_link( $p['id'] ); ?>">[Edit]</a> <?php } ?></h3>
    <?php
    $p['bio'] = apply_filters('the_content', $p['bio']);
    $p['bio'] = str_replace(']]>', ']]&gt;', $p['bio']);
    echo $p['bio']; ?>
<?php if(is_array($p['related_projects']) > 0) { ?>
    <h4>Related Projects</h4>
    <ul>
<?php foreach($p['related_projects'] as $project) { ?>

      <li><?php if(!get_field('hidden',$project->ID)) { ?>
        <a href="<?php echo $project->guid; ?>"><?php echo $project->post_title; ?></a>
      <?php } else { ?>
        <span><?php echo $project->post_title; ?></span>
      <?php } ?></li>

<?php } ?>
    </ul>
<?php } ?>
  </div>
  <div class="people_right five_col">
    <div class="people_photo">
      <?php echo $p['photo']; ?>
    </div>
    <div class="people_cv">
      <?php echo $p['cv']; ?>
    </div>
  </div><!-- people right -->
  <div class="clear"></div>
</div><!-- .people_bio_container -->

<?php } ?>

<div class="back_to_top fixed hidden"><span class="full_width"><a href="#wrapper_header">Back to top</a></span></div>

  </div><!-- #container_content -->
</div><!-- #wrapper_content -->

<?php get_footer(); ?>