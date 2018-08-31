<?php 
if(have_posts()) : while(have_posts()) : the_post();


$page = get_permalink(49);
$id =  get_the_ID();
$redirect = $page."#".$id;

header("Location: ".$redirect);
echo $redirect;
endwhile;
endif;

?>