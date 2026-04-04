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
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<div class="board-box">
	<?php
	$jrms = rr_get_field( 'journal_reviewers_members' );
	if( isset( $jrms ) && !empty( $jrms ) && is_array( $jrms ) ) {
		echo "<ol>";
		foreach ( $jrms as $jrm ) {
			echo "<li><span>" . $jrm['rr_jr_name'] . "</span><p>(".$jrm['rr_jr_designation'] .")</p>";
			echo "<blockquote>". $jrm['rr_jr_area_of_interest'] . "</blockquote></li>";
		}
		echo "</ol>";
	}
	?>
	</div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
