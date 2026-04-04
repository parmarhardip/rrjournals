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
	<div class="entry-content">
	<div class="board-form">
		<?php the_content(); ?>
		<?php //issue_content_html(get_the_time( 'Y' ),get_the_time( 'm' )); ?>
		<table border="0" dir="ltr">
		<tbody>
			<?php			
			the_single_issue_content_html( get_the_ID(),get_the_title(), $post_count);
			?>		
		</tbody>
	</table>
	</div>
	</div><!-- .entry-content -->	
</article><!-- #post-## -->

