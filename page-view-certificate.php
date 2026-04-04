<?php
/*
Template Name: View Certificate form page
*/
get_header();
?>
	<div id="primary" class="content-area fullwidth">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/page/content', 'page-view-certificate' ); ?>

			<?php endwhile; // end of the loop. ?>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>

