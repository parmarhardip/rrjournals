<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); 

global $wp_query;
$page_num = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$count = $wp_query->post_count;
if ( is_day() ) :
    $day         = get_the_time( 'd' );
    $monthnum    = get_the_time( 'm' );
    $year        = get_the_time( 'Y' );
    $archive_url = '/' . $year . '/' . $monthnum . '/' . $day;
	$page_action = 'day';
elseif ( is_month() ) :
    $monthnum    = get_the_time( 'm' );
    $year        = get_the_time( 'Y' );
    $archive_url = '/' . $year . '/' . $monthnum;
	$page_action = 'month';
	
	$page_title = !empty( $monthnum ) ? 'Special Issue ('.get_the_time( 'F' ).', '.$year.')' : 'Special Issue';
elseif ( is_year() ) :
    $year        = get_the_time( 'Y' );
    $archive_url = '/' . $year;
	$page_action = 'spacial-issue';
	$volume_arr = get_list_years();
	$page_title = !empty( $year ) ? 'Special Issue (Year-'.$year.')' : 'Special Issue';
else :
	$page_action = 'year';   
	$page_title = 'Special Issues';
endif;

if ( 1 !== $page_num && 0 !== $page_num ) {
    $dat_page_url = site_url() . $archive_url . '/page/' . $page_num;
    $data_url     = $archive_url . '/page/' . $page_num;
} else {
    $data_url     = $archive_url;
}

?>

	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div> 
	
	<div id="primary" class="content-area fullwidth">
	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<h1 class="page-title"><?php echo esc_html('Archives: '. $page_title); ?></h1>
			
		</header><!-- .page-header -->
		<?php endif; ?>
		<main id="main" class="site-main" role="main">
			<?php 
			switch( $page_action ) {
				case 'year':
					global $wpdb;
					$results = $wpdb->get_results( "SELECT YEAR(post_date) AS year FROM {$wpdb->prefix}posts WHERE post_type = 'rr_special_issue' AND post_status = 'publish' GROUP BY year ASC", OBJECT );
					if( isset( $results ) && ! empty( $results ) ) {						
						echo "<table><tr>";
						$int =1;
						foreach( $results as $re_key => $result ) {			
							if( $int %4 == 0 ) {
								echo "</tr>";
							}
							echo sprintf('<td class="volumn-btn"><a href="%s" title="">%s</a></td>',$result->year,$result->year);
							$int++;
						} 
						echo "</tr></table>";
					}					
					break;				
				case 'spacial-issue':
						if ( have_posts() ) : 
							/* Start the Loop */
							$count = get_post_count_by_page($page_num);
							while ( have_posts() ) : the_post();
								
								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								set_query_var( 'post_count', absint( $count ) );
								get_template_part( 'template-parts/page/content', 'page-special-issue' );
								$count++;
							endwhile;

							the_posts_pagination( array(
								'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
								'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
							) );

						else :

							get_template_part( 'template-parts/page/content', 'issue-none' );

						endif;
					break;
					
			} 
			 ?>


		</main><!-- #main -->
	</div><!-- #primary -->


<?php get_footer();
