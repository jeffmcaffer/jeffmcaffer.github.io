<?php get_header(); ?>

<div id="content">

	<?php if (have_posts()) : ?>
	
		<div class="post">
			<h1 class="title">Search Results for &ldquo;<?php the_search_query(); ?>&rdquo;</h1>
			<div class="entry">&nbsp;</div>
		</div>

		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2 class="title"><span><?php the_author(); ?> on <?php the_time('M jS, Y') ?></span><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<div class="entry">
					<?php the_excerpt(); ?>
				</div>
				<div class="meta">
					<p class="links">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">Read Full Post &#187;</a>
						<?php edit_post_link(); ?>
					</p>
				</div>
			</div>
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php previous_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php next_posts_link('Next Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<div class="post">
			<h2 class="title">Search Results for &ldquo;<?php the_search_query(); ?>&rdquo;</h2>
			<div class="entry">
				<p>No posts found. <br/>Please use the sidebar to do a different search or browsing through the archives.</p>				
			</div>
		</div>

	<?php endif; ?>

</div>
<!-- end content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>