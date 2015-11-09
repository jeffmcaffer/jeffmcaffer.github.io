<?php 
/*
Template Name: Sidebarless Page
*/
?>

<?php get_header(); ?>

	<div id="content-nosidebar">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<div class="entry">
					<?php the_content('Continue Reading &#187;'); ?>
					<?php wp_link_pages(); ?>											
					<?php $sub_pages = wp_list_pages( 'sort_column=menu_order&depth=1&title_li=&echo=0&child_of=' . $id );?>
				<!--
					<?php trackback_rdf(); ?>
				-->
				</div>
				<div class="meta">
				</div>
			</div>
		<?php endwhile; ?>		
	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>		

	<?php endif; ?>

	</div>
	
<?php get_footer(); ?>
