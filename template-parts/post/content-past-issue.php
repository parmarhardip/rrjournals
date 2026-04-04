<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * 
 */

?>


<?php 

	//echo get_category_toggle_list();
	
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div> 
	<div class="entry-content">
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>		
	</header><!-- .entry-header -->
	<div class="board-form">
		<?php the_content(); ?>
		<?php issue_content_html(get_year(),get_month()); ?>
		<?php get_month_table( get_year() ); ?>
		
	</div>
	</div><!-- .entry-content -->	
</article><!-- #post-## -->
