<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2 class="title"><span>on <?php the_time('M jS, Y') ?></span><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<div class="entry">
					<?php the_content('Continue Reading &#187;'); ?>
					<?php wp_link_pages(); ?>
          <p class="post-tags">
            <?php if (function_exists('the_tags')) the_tags('Tags: ', ', ', '<br/>'); ?>
          </p>
				</div>
				<div class="meta">
					<p class="links">
						<span class="comments"><?php comments_popup_link(__('No responses yet'), __('One response so far'), __('% responses so far')); ?></span>
						<span class="user"><?php the_author_posts_link(); ?></span>
						<span class="category"><?php the_category(',')?></span> 
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

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>		

	<?php endif; ?>

	</div>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
