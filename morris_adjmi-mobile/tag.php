<?php get_header(); ?>

<div id="wrapper_content">
  <div id="container_content">
    <h2 class="search_results">Search results for “<?php single_tag_title(); ?>” </h2>
  
<?php $term_id = get_query_var('tag_id');

$args = array('post_type' => 'project' , 'tag_id' => $term_id);
$project_query = new WP_Query($args);
if($project_query->have_posts()) : while ( $project_query->have_posts() ) : $project_query->the_post(); ?>

    <div class="result">
      <a href="<?php echo the_permalink(); ?>">
      <p class="thumbnail"><?php echo get_the_post_thumbnail(); ?></p>
      <h3><?php the_title(); ?></h3>
      <div class="clear"></div>
      </a>
    </div>

<?php
endwhile;
endif;
?>
  </div><!-- #container_content -->
</div><!-- #wrapper_content -->
<?php get_footer(); ?>