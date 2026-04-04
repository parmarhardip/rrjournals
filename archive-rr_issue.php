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
	$issue_month_arr = get_month_table( $year );	
	$page_title = !empty( $issue_month_arr[$monthnum] ) ? $issue_month_arr[$monthnum]. '('.get_the_time( 'F' ).', '.$year.')' : 'Past Issue';
elseif ( is_year() ) :
    $year        = get_the_time( 'Y' );
    $archive_url = '/' . $year;
	$page_action = 'year';
	$volume_arr = get_list_years();
	$page_title = !empty( $volume_arr[$year] ) ? $volume_arr[$year]. '(Year-'.$year.')' : 'Past Issues Volume';
else :
	$page_action = 'volumn-list';   
	$page_title = 'Past Issues';
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
				case 'volumn-list':
					the_list_of_volumn();
					break;
				case 'year':
					the_issue_month_list( $year );
					break;
				case 'month':
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
								get_template_part( 'template-parts/page/content', 'page-past-issue' );
								$count++;
							endwhile;

							the_posts_pagination( array(
								'mid_size' => 3,
								'prev_text' => '<span class="screen-reader-text">' . __( '« prev', 'twentyseventeen' ) . '</span>',
								'next_text' => '<span class="screen-reader-text">' . __( 'next »', 'twentyseventeen' ) . '</span>' ,								
								'screen_reader_text' => ' ',
								
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
