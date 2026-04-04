		<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.blockUI.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->

<script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<div id="container">
		<div class="main-header">
		  <div id="banner"> <?php get_template_part( 'template-parts/header/header', 'image' ); ?> </div>	  
		  <div id="bannerb">		
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description site-sub-title"><?php echo $description; ?></p>
			<?php endif; 
			$ugc_id = get_theme_mod( 'rrjournals_text_ugc_id' ); 
			if ( $ugc_id || is_customize_preview() ) : ?>
				<p class="site-ugc_id site-sub-title"><?php echo $ugc_id; ?></p>
			<?php endif; 
			$impact_id = get_theme_mod( 'rrjournals_text_impact_id' ); 
			if ( $impact_id || is_customize_preview() ) : ?>
				<p class="site-impact_id site-sub-title"><?php echo $impact_id; ?></p>
			<?php endif; ?>		
			<div class="header-search-form">
				<form action="/" method="get">			
					<input type="text" name="s" placeholder="Search..." required id="search" value="<?php the_search_query(); ?>" />
					<button type="submit" class="search-submit"><span class="screen-reader-text">Search</span></button>			
				</form>
			  </div>
		  </div>
		</div> <!-- main header -->
		<div class="header-navigation">
		  <nav>
			  <ul class="nav">
				<li><a href="<?php echo site_url(); ?>">Home</a></li>
				<li><a href="javascript:void(0);">About</a>
					<ul>
						<li><a href="<?php echo site_url('/why-rrijm/'); ?>"  title="Why RRIJM?">Why RRIJM?</a></li>
						<li><a href="<?php echo site_url('/editorial-board/'); ?>" title="Editorial Board">Editorial Board</a></li>
						<li><a href="<?php echo site_url('/journal-reviewers/'); ?>" title="Journal Reviewers">Journal Reviewers</a></li>
						<li><a href="<?php echo site_url('/editorial-policy/'); ?>" title="Editorial Policy">Editorial Policy</a></li>
						<li><a href="<?php echo site_url('/peer-review-process/'); ?>" title="Peer Review Process">Peer Review Process</a></li>
						<li><a href="<?php echo site_url('/publication-ethics-practices/'); ?>" title="Publication Ethics & Practices">Publication Ethics & Practices</a></li>
						<li><a href="<?php echo site_url('/join-as-an-editorial-board-member/'); ?>" title="Join as Editorial Board Member">Join as Editorial Board Member</a></li>
						<li><a href="<?php echo site_url('/publication-policy/'); ?>" title="Publication Policy">Publication Policy</a></li>	
					</ul>
				</li>
				<li><a href="<?php echo site_url('/current-issue/'); ?>">Current Issue</a>
				<li><a href="javascript:void(0);">Archives</a>
					<ul>
						<li ><a class="with_arrow" href="<?php echo site_url('/past-issue/'); ?>" title="Past Issue">Past Issue</a>
							<ul class="gradient_menu gradient108">
								<?php 
									$volumn_arr = get_list_years();
									
									if( isset( $volumn_arr ) && ! empty($volumn_arr) ) {
										foreach( $volumn_arr as $volumn_key => $volumn_value ) {
											echo sprintf('<li class=""><a href="%s" title="">%s</a></li>',site_url('/past-issue/'.$volumn_key),$volumn_value);
										} 
									}
									?>

							</ul>
						</li>
						<li><a href="<?php echo site_url('/spcial-issue/'); ?>"  title="Special Issue">Special Issue</a>
							
						</li>
						<li class="last_item"><a class="with_arrow" href="javascript:void(0);" title="Conference Proceeding">Conference Proceeding </a>
							<ul class="gradient_menu gradient108">
								<?php get_taxonomy_term(); ?>
							</ul>										
						</li>
					</ul>
				</li>	
				<li><a href="<?php echo esc_url( site_url('/indexing/') ); ?>">Indexing</a></li>
				<li><a href="<?php echo esc_url( site_url('/submit-paper/') ); ?>">Submit paper</a></li>
				<li><a href="javascript:void(0);">Author Guide</a>
					<ul>
						<li><a href="<?php echo site_url('/author-instructions/'); ?>" title="Author Instruction">Author Instruction</a></li>			
						<li><a href="<?php echo site_url('/faqs/'); ?>" title="FAQs">FAQs</a></li>			
						<li><a href="<?php echo site_url('/topics-covered/'); ?>" title="Topics Covered">Topics Covered</a></li>	
					</ul>
				</li>	  
				<li><a href="<?php echo site_url('/contact-us/'); ?>">Contact</a></li>    
			  </ul>
			</nav>
			</div> <!-- end header-navigation -->
	  </div>
	  
		<div id="container">
