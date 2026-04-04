<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * 
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div> 
	<div class="entry-content">
	<header class="entry-header">
		<?php $current_month_year = date('F - Y'); ?>
		<?php the_title( '<h1 class="entry-title">', ' ('.$current_month_year . ')</h1>' ); ?>
	</header><!-- .entry-header -->
	<div class="board-form">
		<?php the_content(); ?>
		<?php issue_content_html(date('Y'),date('m')); ?>
	</div>
	</div><!-- .entry-content -->	
</article><!-- #post-## -->
