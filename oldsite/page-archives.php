<?php
/*
Template Name: Archives
*/
?>
<?php get_header();?>
	<div id="content">
      <div class="post">
        <h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>        
        <div class="entry">
          <h2>Recent 20 Posts</h2>
          <ul>
            <?php wp_get_archives('type=postbypost&limit=20'); ?>
          </ul>
          <h2>by Category</h2>
          <ul>
            <?php wp_list_cats('optioncount=1');?>
          </ul>
          <h2>by Month</h2>
          <ul>
            <?php wp_get_archives('type=monthly&show_post_count=true'); ?>
          </ul>
        </div>
        <p class="comments"></p>	          
      </div>      
	</div>
  <?php get_sidebar();?>
  <?php get_footer();?>