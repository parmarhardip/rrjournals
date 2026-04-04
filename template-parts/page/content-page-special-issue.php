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
	<div class="entry-content special-content-post">
	<div class="board-form">		
		
		<?php //issue_content_html(get_the_time( 'Y' ),get_the_time( 'm' )); ?>
		<table border="0" dir="ltr" style="width: 100%;">
		<tbody>
			<tr>
				<td colspan="3">
					<hr class="hr">
				</td>
			</tr>
			<tr valign="top" id="<?php echo "post-".get_the_ID(); ?>">
				<td id="ar_row_ind" align="right"><?php echo $post_count; ?></td>				
				<td width="98%" valign="middle">
					<h2 class="citation_title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo get_the_title(); ?></a></h2>
					<div class="special_content"><?php the_content(); ?></div>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	</div><!-- .entry-content -->	
</article><!-- #post-## -->

