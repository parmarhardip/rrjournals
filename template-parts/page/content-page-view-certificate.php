<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * 
 */
$error_html = '';
if( isset( $_GET['response'] ) && !empty( $_GET['response'] ) ) {
	$code = isset( $_GET['code'] ) ? absint( $_GET['code'] ) : 0;
	if( 0 === $code ) {
		$error_html = '<tr><td colspan="2"><div class="error">Please try again.</div></td></tr>';
	}else if( 1 === $code ) {
		$error_html = '<tr><td colspan="2"><div class="error">Please enter valid certificate number.</div></td></tr>';
	}
}

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
	</div>
	</div><!-- .entry-content -->	
</article><!-- #post-## -->