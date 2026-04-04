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
		<?php $paper_posts = get_post_meta( get_the_ID(), 'rr_sp_select2_paper',true ); 
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'rr_sp_paper_list',		
			'orderby' => 'date',
			'order' => 'ASC',
			'include' => $paper_posts
		);		
		$paper_posts = get_posts( $args );
		if( isset( $paper_posts ) && !empty( $paper_posts ) && is_array( $paper_posts ) ) {
		?>	
		<table border="0" dir="ltr">
			<tbody>
			<?php
			$count = 1;
				foreach(  $paper_posts as  $paper_post ) {								
					$paper_id = $paper_post->ID;
					$paper_title = $paper_post->post_title;
					// Paper listing post not a single issue content just use htmt.
					the_single_issue_content_html( $paper_id, $paper_title, $count);
			$count++; } ?>
			</tbody>
		</table>
		<?php } ?>
		
	</div>
	</div><!-- .entry-content -->	
</article><!-- #post-## -->
