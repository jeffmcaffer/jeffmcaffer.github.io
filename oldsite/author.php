<?php get_header();?>
<div id="content">
	<?php
	global $wp_query;
	$curauth = $wp_query->get_queried_object();
?>
<div class="post">
<h2>About: <?php echo $curauth->nickname; ?></h2>
<dl>
<dt>Full Name</dt>
<dd><?php echo $curauth->first_name. ' ' . $curauth->last_name ;?></dd>
<dt>Details</dt>
<dd><?php echo $curauth->description; ?></dd>
</dl>

			<h2>Posts by <?php echo $curauth->nickname; ?>:</h2>
			<ul class="authorposts">
			<!-- The Loop -->
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<li>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a>
			</li>
			<?php endwhile; else: ?>
			<p><?php _e('No posts by this author.'); ?></p>

			<?php endif; ?>
			<!-- End Loop -->			
		</ul>
		<div class="navigation">
			<div class="alignleft"><?php previous_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php next_posts_link('Next Entries &raquo;') ?></div>
		</div>
	</div>
</div>
  <?php get_sidebar();?>
  <?php get_footer();?>
