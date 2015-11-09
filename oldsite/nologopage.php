<?php
/*
Template Name: No Logo Page
*/
?>

<?php get_header(); ?>

	<div id="content-nosidebar">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<div class="entry">
					<?php the_content('Continue Reading &#187;'); ?>
					<?php wp_link_pages(); ?>											
					<?php $sub_pages = wp_list_pages( 'sort_column=menu_order&depth=1&title_li=&echo=0&child_of=' . $id );?>
			</div>
		<?php endwhile; ?>		
	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>		

	<?php endif; ?>

	</div>

<?php get_footer(); ?>
