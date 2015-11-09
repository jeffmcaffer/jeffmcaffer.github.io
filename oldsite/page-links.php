<?php
/*
Template Name: Links
*/
?>
<?php get_header(); ?>
  <div id="content">
		<div class="post">
      <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
      <div class="entry">
        <ul>
          <?php get_links_list('name'); ?>
        </ul>
      </div>
  </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
