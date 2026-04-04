<?php
/**
 * Displays content for front page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'twentyseventeen-panel ' ); ?> >	
  <div id="sidebar">
	<?php get_sidebar(); ?>
  </div>    
  <div id="content">
    <?php the_content(); ?>
  </div>	
</article><!-- #post-## -->
