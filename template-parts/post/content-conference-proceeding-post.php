<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( is_sticky() && is_home() ) :
		echo twentyseventeen_get_svg( array( 'icon' => 'thumb-tack' ) );
	endif;
	?>
	
	
	<div class="entry-content">
		
		<header class="entry-header">
			<?php
			if ( 'post' === get_post_type() ) {
				echo '<div class="entry-meta">';
					if ( is_single() ) {
						twentyseventeen_posted_on();
					} else {
						echo twentyseventeen_time_link();
						twentyseventeen_edit_link();
					};
				echo '</div><!-- .entry-meta -->';
			};

			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} elseif ( is_front_page() && is_home() ) {
				the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
			?>
		</header><!-- .entry-header -->
		<?php 
			$icp_atricle_number        = rr_get_field( 'icp_atricle_number' );
    		$icp_year_and_month        = rr_get_field( 'icp_year_and_month' );
    		$icp_page_number           = rr_get_field( 'icp_page_number' );
    		$ice_published_online      = rr_get_field( 'ice_published_online' );
    		$icp_doi                   = rr_get_field( 'icp_doi' );
    		$icp_authors_names_loop    = rr_get_field( 'icp_authors_names' );
    		$icp_abstract_content      = rr_get_field( 'icp_abstract_content' );
    		$ice_keywords              = rr_get_field( 'ice_keywords' );
    		$ice_pdf_upload            = rr_get_field( 'ice_pdf_upload' );
    		$ice_google_drive_pdf_link = rr_get_field( 'ice_google_drive_pdf_link' );
    		$ice_paper_category        = rr_get_field( 'ice_paper_category' );
    		$ice_subject               = rr_get_field( 'ice_subject' );
    		$file_id                   = rr_get_field( 'ice_pdf_upload', get_the_ID() );
    		$fileSize                  = get_file_size( $file_id );
    		$postcat                   = get_article_category( $issue_id );	
			

			?>
		<div class="article-post-content">	
			<table cellpadding="0" cellspacing="2" width="98%" dir="ltr">
			<tbody>
				
				<tr>
					<td colspan="2" style="padding: 7px 5px 0 5px">
						<span id="ar_row_ind">						
						<?php 
							if( isset( $icp_year_and_month ) && !empty( $icp_year_and_month ) ) { 
								echo $icp_year_and_month; 
							} 
							if( isset( $ice_published_online ) && !empty( $ice_published_online ) ) { ?>							
								<span id="sp_ar_pages"> <?php echo '  |  Published Online: '. $ice_published_online; ?> </span>
							<?php } 
							if( isset( $icp_atricle_number ) && !empty( $icp_atricle_number ) ) { ?>
							<span id="sp_ar_pages"> <?php echo '  |  Page: '. $icp_page_number; ?> </span>
						<?php } ?>
						<?php if ( isset( $ice_google_drive_pdf_link ) && ! empty( $ice_google_drive_pdf_link ) ) { ?>
							<span class="spdf">
								<a href="<?php echo esc_url( $ice_google_drive_pdf_link ); ?>" target="_blank" class="pdf">PDF</a>
							</span>
						<?php } else if ( isset( $ice_pdf_upload ) && ! empty( $ice_pdf_upload ) ) { ?>
							<span class="spdf">
								<a href="<?php echo $ice_pdf_upload; ?>" target="_blank" download class="pdf">&nbsp;&nbsp;  PDF ( <?php echo $fileSize; ?> )</a>
							</span>
						<?php } ?>
					</td>
				</tr>
				<?php if( isset( $icp_doi ) && !empty( $icp_doi ) ) { ?>
				<tr>
					<td colspan="2" style="padding: 1px 5px 5px 5px">DOI: <span dir="ltr" id="ar_doi"><a href="<?php echo $icp_doi; ?>"><?php echo $icp_doi; ?></a></span></td>
				</tr>
				<?php } ?>
				<?php if( isset( $icp_authors_names_loop ) && !empty( $icp_authors_names_loop ) ) { ?>
				<tr>
					<td colspan="2" style="padding: 8px 5px 0px 5px" class="arial"><b>Author(s)</b></td>
				</tr>	
				<tr>
					<td colspan="2" style="padding: 1px 5px 1px 5px">
					<?php 
					$icp_loop = 1;
					$numItems = count($icp_authors_names_loop);
						foreach ( $icp_authors_names_loop as $icp_authors_names ) {
							?>
							<a href="#"><?php echo $icp_authors_names['icp_author_name']; ?></a>						
							<?php if( !empty( $icp_authors_names['icp_author_email'] ) ) { ?>
								<a href="mailto:<?php echo $icp_authors_names['icp_author_email']; ?>" title="Email to Corresponding Author"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/mail.gif" border="0"></a>
							<?php } ?>
							<sup><a href="#au1"><?php echo $icp_loop; ?></a></sup><?php  if( $numItems != $icp_loop ) { echo '; ';} ?>  
						<?php $icp_loop++;} ?>						
					</td>
				</tr>
				<tr>	
					<td colspan="2" style="padding: 1px 5px 1px 5px">
				<?php 
					$icp_author_loop = 1;
					foreach ( $icp_authors_names_loop as $icp_authors_names ) { 
					
					?>
					<?php if( !empty( $icp_authors_names['ice_author_about'] ) ) { ?>
					
						<p style="margin: 0;"><sup id="au1"><?php echo $icp_author_loop; ?></sup><?php echo $icp_authors_names['ice_author_about']; ?></p>
						
					<?php } 
					$icp_author_loop++;
					} 
				} 
				?>
					</td>
				</tr>	
				<?php if( isset( $icp_abstract_content ) && !empty( $icp_abstract_content ) ) { ?>
				<tr>
					<td colspan="2" style="padding: 23px 5px 0 5px" class="arial"><b>Abstract</b></td>
				</tr>
				<tr>
					<td colspan="2" id="abs_en" class="article_abstract"><?php echo $icp_abstract_content; ?></td>
				</tr>
				<?php } ?>
				<?php if( isset( $ice_keywords ) && !empty( $ice_keywords ) ) { ?>
				<tr>
					<td colspan="2" style="padding: 15px 5px 0 5px" class="arial"><b>Keywords</b></td>
				</tr>
				<tr>
					<td colspan="2" style="padding: 1px 5px"><?php echo $ice_keywords; ?></td>
				</tr>
				<?php } ?>				
				<tr>
					<td colspan="3" style="padding: 15px 5px 0 5px">
						<div class="arial bold"><b>Statistics</b></div>
						<div>Article View: <?php echo hr_articke_PostViews( get_the_ID() ); ?></div>						
					</td>
				</tr>
			</tbody>
		</table>
		
		<?php
		/* translators: %s: Name of current post */
		wp_link_pages( array(
			'before'      => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		) );
		?>
		<?php
		if ( is_single() ) {
			twentyseventeen_entry_footer();
		}
		?>
		</div>
	</div><!-- .entry-content -->

	

</article><!-- #post-## -->
