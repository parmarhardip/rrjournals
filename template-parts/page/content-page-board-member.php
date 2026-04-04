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
		<h3>Editor-in-Chief</h3>
		<?php
		$eics = rr_get_field( 'editor_in_chief' );
		if( isset( $eics ) && !empty( $eics ) && is_array( $eics ) ) {
			echo "<ul>";
			foreach ( $eics as $eic ) {
				echo "<li>". $eic['eic_name'] . "</li>";		
			}
			echo "</ul>";
		}
		?>
		</div>
		<div class="board-box">
		<h3>Editorial Board Members </h3>
		<?php
		$ebms = rr_get_field( 'editorial_board_members' );
		if( isset( $ebms ) && !empty( $ebms ) && is_array( $ebms ) ) {
			echo "<ol>";
			foreach ( $ebms as $ebm ) {
				echo "<li>";
				$ebm_name = $ebm['ebm_name'];
				$ebm_email = $ebm['ebm_email'];
				$ebm_education_degree = $ebm['ebm_education_degree'];
				$ebm_affiliation_institute = $ebm['ebm_affiliation_institute'];
				$ebm_role = $ebm['ebm_role'];
				$ebm_web_profiles = $ebm['ebm_web_profiles'];
				
				?>
				<table class="rrBlueTable">
					<tbody>
					<?php if( isset( $ebm_name ) && !empty( $ebm_name ) ) { ?>
						<tr>
							<td>Name:</td>
							<td><?php esc_html_e($ebm_name); ?></td>
						</tr>
					<?php } ?>
					<?php if( isset( $ebm_email ) && !empty( $ebm_email ) ) { ?>
						<tr>
							<td>Email:</td>
							<td><?php esc_html_e($ebm_email); ?></td>
						</tr>
					<?php } ?>
					<?php if( isset( $ebm_education_degree ) && !empty( $ebm_education_degree ) ) { ?>
						<tr>
							<td>Education / Degree</td>
							<td><?php esc_html_e($ebm_education_degree); ?></td>
						</tr>
					<?php } ?>
					<?php if( isset( $ebm_affiliation_institute ) && !empty( $ebm_affiliation_institute ) ) { ?>
						<tr>
							<td>Affiliation / Institute</td>
							<td><?php esc_html_e($ebm_affiliation_institute); ?></td>
						</tr>
					<?php } ?>
					<?php if( isset( $ebm_role ) && !empty( $ebm_role ) ) { ?>
						<tr>
							<td>Role</td>
							<td><?php esc_html_e($ebm_role); ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<div class="rr_row">
				<?php
				
				if( isset( $ebm_web_profiles[0] ) && !empty( $ebm_web_profiles[0] ) ) {
					
					$ebm_wp_institute_profile = $ebm_web_profiles[0]['ebm_wp_institute_profile'];
					$ebm_wp_personal_web_blog = $ebm_web_profiles[0]['ebm_wp_personal_web_blog'];
					$ebm_wp_google_scholar = $ebm_web_profiles[0]['ebm_wp_google_scholar'];
					$ebm_wp_research_gate = $ebm_web_profiles[0]['ebm_wp_research_gate'];
					$ebm_wp_ssrn_id = $ebm_web_profiles[0]['ebm_wp_ssrn_id'];
					$ebm_wp_orcid_id = $ebm_web_profiles[0]['ebm_wp_orchid_id'];
					
					if( isset( $ebm_wp_institute_profile['url'] ) && !empty( $ebm_wp_institute_profile['url'] ) ) { 
					?>
					  <div class="rr_column">

						<a href="<?php echo esc_url($ebm_wp_institute_profile['url']); ?>" target="<?php echo ('none' !== $ebm_wp_institute_profile['target']) ? esc_attr($ebm_wp_institute_profile['target']) : ''; ?>">
							<div id="rr_icon_box">
							  <img class="rr_icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/ebm_1.jpg"/>
							</div>
							<div id="rr_icon_text">
								<?php echo ( isset( $ebm_wp_institute_profile['text'] ) && !empty( $ebm_wp_institute_profile['text'] ) ) ? esc_html($ebm_wp_institute_profile['text']) : esc_html('Institute Profile'); ?>
							</div>						
						</a>
					  </div>
					<?php 
					}
					if( isset( $ebm_wp_personal_web_blog['url'] ) && !empty( $ebm_wp_personal_web_blog['url'] ) ) { 
					?>
					  <div class="rr_column">
						<a href="<?php echo esc_url($ebm_wp_personal_web_blog['url']); ?>" target="<?php echo ('none' !== $ebm_wp_personal_web_blog['target']) ? esc_attr($ebm_wp_personal_web_blog['target']) : ''; ?>">
							<div id="rr_icon_box">
								<img class="rr_icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/ebm_2.png"/>
							</div>
							<div id="rr_icon_text">
								<?php echo ( isset( $ebm_wp_personal_web_blog['text'] ) && !empty( $ebm_wp_personal_web_blog['text'] ) ) ? esc_html($ebm_wp_personal_web_blog['text']) : esc_html('Personal Web / Blog'); ?>
							</div>
						</a>
					  </div>
					<?php 
					} 
					if( isset( $ebm_wp_google_scholar['url'] ) && !empty( $ebm_wp_google_scholar['url'] ) ) { 
					?>
					  <div class="rr_column">
						<a href="<?php echo esc_url($ebm_wp_google_scholar['url']); ?>" target="<?php echo ('none' !== $ebm_wp_google_scholar['target']) ? esc_attr($ebm_wp_google_scholar['target']) : ''; ?>">
							<div id="rr_icon_box">
								<img class="rr_icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/ebm_3.png"/>
							</div>
							<div id="rr_icon_text">
								<?php echo ( isset( $ebm_wp_google_scholar['text'] ) && !empty( $ebm_wp_google_scholar['text'] ) ) ? esc_html($ebm_wp_google_scholar['text']) : esc_html('Google Scholar'); ?>
							</div>
						</a>
					  </div>
					<?php
					}
					if( isset( $ebm_wp_research_gate['url'] ) && !empty( $ebm_wp_research_gate['url'] ) ) { 
					?>
					  <div class="rr_column">
						<a href="<?php echo esc_url($ebm_wp_research_gate['url']); ?>" target="<?php echo ('none' !== $ebm_wp_research_gate['target']) ? esc_attr($ebm_wp_research_gate['target']) : ''; ?>">
							<div id="rr_icon_box">
								<img class="rr_icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/ebm_4.png"/>
							</div>
							<div id="rr_icon_text">
								<?php echo ( isset( $ebm_wp_research_gate['text'] ) && !empty( $ebm_wp_research_gate['text'] ) ) ? esc_html($ebm_wp_research_gate['text']) : esc_html('Research Gate'); ?>
							</div>
						</a>
					  </div>
					<?php
					} 
					if( isset( $ebm_wp_ssrn_id['url'] ) && !empty( $ebm_wp_ssrn_id['url'] ) ) { 
					?>
					  <div class="rr_column">
						<a href="<?php echo esc_url($ebm_wp_ssrn_id['url']); ?>" target="<?php echo ('none' !== $ebm_wp_ssrn_id['target']) ? esc_attr($ebm_wp_ssrn_id['target']) : ''; ?>">
							<div id="rr_icon_box">
								<img class="rr_icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/ebm_5.png"/>
							</div>
							<div id="rr_icon_text">
								<?php echo ( isset( $ebm_wp_ssrn_id['text'] ) && !empty( $ebm_wp_ssrn_id['text'] ) ) ? esc_html($ebm_wp_ssrn_id['text']) : esc_html('SSRN ID'); ?>
							</div>
						</a>
					  </div>
					<?php 
					}
					if( isset( $ebm_wp_orcid_id['url'] ) && !empty( $ebm_wp_orcid_id['url'] ) ) { 
					?>
					  <div class="rr_column">
						<a href="<?php echo esc_url($ebm_wp_orcid_id['url']); ?>" target="<?php echo ('none' !== $ebm_wp_orcid_id['target']) ? esc_attr($ebm_wp_orcid_id['target']) : ''; ?>">
							<div id="rr_icon_box">
								<img class="rr_icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/ebm_6.png"/>
							</div>
							<div id="rr_icon_text">
								<?php echo ( isset( $ebm_wp_orcid_id['text'] ) && !empty( $ebm_wp_orcid_id['text'] ) ) ? esc_html($ebm_wp_orcid_id['text']) : esc_html('ORCID ID'); ?>
							</div>
						</a>
					  </div>
					<?php 
					} 
				}
				?>
				</div>
				<?php
				echo "</li>";
			}
			echo "</ol>";
		}
		?>
		</div>
	</div><!-- .entry-content -->	
</article><!-- #post-## -->
