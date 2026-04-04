<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * 
 */
?>
<?php
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$args = array(
    'post_type'=>'books-download',
    'post_status'=>'publish',
    'posts_per_page'=>5,
    'paged' => $paged,
    'orderby' => 'menu_order title',
    'order'   => 'DESC',
    //'fields' => 'ids',
    'update_post_term_cache' => false
);
$book_query = new WP_Query($args);

?>
<style>
        .hr-dev-book-list table {
            border-collapse: collapse;
        }
        .hr-dev-book-list  table,.hr-dev-book-list th,.hr-dev-book-list td {
            border: 1px solid black;
        }
        .hr-dev-book-list th, .hr-dev-book-list td {
            padding: 10px;
        }
        .hr-dev-book-list th {
            text-align: center;
			/*text-transform: uppercase;*/
			padding: 5px 10px;
			background-color: #003250;
			color: #fff;
        }
        .hr-dev-book-list .download-btn {
            border-radius: 15px 15px;
            width: auto;
			min-width:80px;
            line-height: 22px;
            background-color: #003366;
            color: white;
            border-color: #003366;
            cursor: pointer;
        }
        .hr-dev-book-list .download-btn:hover {
            border-width: 2px;
            border-style: outset;
            border-color: #aaa;
        }
		
		.hr-dev-book-list a.cfs-hyperlink {
			text-rendering: auto;
			border-radius: 15px 15px;
			width: auto;
			min-width:80px;
			line-height: 22px;
			background-color: #003366;
			color: white;
			border-color: #003366;
			cursor: pointer;
			letter-spacing: normal;
			word-spacing: normal;
			text-indent: 0px;
			text-shadow: none;
			display: inline-block;
			text-align: center;
			align-items: flex-start;
			box-sizing: border-box;
			margin: 0em;
			font: 400 13.3333px Arial;
			padding: 5px 6px;
			border-width: 2px;
			border-style: outset;
			text-decoration: none;
			text-transform: capitalize;
		}
		.hr-dev-book-list a.cfs-hyperlink:hover {
			border-width: 2px;
			border-style: outset;
			border-color: #aaa;
		}
		
		.hr-dev-book-list .pagination-wrap ul.pagination {
			list-style: none;
			padding: 0;
		}

		.hr-dev-book-list .pagination-wrap ul.pagination li {
			display: inline-block;
		}
    </style>
<?php if ( $book_query->have_posts() ) : ?>
    
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div> 
	<div class="entry-content">
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
		<div class="hr-dev-book-list">
			<table>
				<tr>
					<th><?php esc_html_e('Cover Page','rrjounrals'); ?></th>
					<th><?php esc_html_e('Title of the Book','rrjounrals'); ?></th>
					<th><?php esc_html_e("Author(s)",'rrjounrals'); ?></th>
					<th><?php esc_html_e('ISBN No','rrjounrals'); ?></th>
					<th><?php esc_html_e('Access','rrjounrals'); ?></th>
				</tr>
				<?php while ( $book_query->have_posts() ) : $book_query->the_post(); ?>
				<?php
					$hrbd_choose_btn = rr_get_field('hrbd_choose_button');
					$book_image_url = rr_get_field( 'hrbd_cover_page_image' );
					$title_of_the_book = rr_get_field( 'hrbd_title_of_the_book' );
					$authors_name = rr_get_field( 'hrbd_authors_name' );
					$isbn_number = rr_get_field( 'hrbd_isbn_number' );
				?>
				<tr>
					<td><img src="<?php echo esc_url($book_image_url); ?>"  width="100" height="150"/></td>
					<td><?php echo esc_html($title_of_the_book); ?></td>
					<td><?php echo esc_html($authors_name); ?></td>
					<td><?php echo esc_html($isbn_number); ?></td>
					<?php if( isset($hrbd_choose_btn) && !empty($hrbd_choose_btn) && in_array('Download',$hrbd_choose_btn) ) {	?>
						<td>
						<form action="<?php echo rr_get_field( 'hrbd_download' ); ?>" method="post" target="_blank">
						<button type="submit" class="download-btn" vlaue=""><?php esc_html_e('Download','rrjounrls'); ?></button>
						</form>
						</td>
					<?php } else { ?>
						<td><?php echo rr_get_field( 'hrbd_buy_now' ); ?></td>
					<?php } ?>
				</tr>
				<?php endwhile; // end of the loop. ?>
				<!-- pagination here -->
				
				
			</table>
			<?php
				$big = 999999999; // need an unlikely integer
				$paginate_links =  paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '/paged=%#%',  // if using pretty permalink
					'current' => max( 1, $paged ),
					'total' => $book_query->max_num_pages,
					'type'  => 'array',
					) 
				);

					if( is_array( $paginate_links ) ) {
						$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
						echo '<div class="pagination-wrap"><ul class="pagination">';
						foreach ( $paginate_links as $paginate_link ) {
								echo "<li>$paginate_link</li>";
						}
					   echo '</ul></div>';
						}
				?>
				<?php wp_reset_postdata(); ?>
		</div>
	</div><!-- .entry-content -->	
</article><!-- #post-## -->
<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>