 <?php
/**
 * The template for displaying all taxonomy posts
 * 
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); 

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
$term_metas = get_option("rr_cp_cate_{$term->term_id}_metas");
$custom_date_field 		  = !empty($term_metas['custom-date-field']) ? $term_metas['custom-date-field'] : '';
$institute_detail_field   = !empty($term_metas['institute-detail-field']) ? $term_metas['institute-detail-field'] : '';
$institute_down_url_field = !empty($term_metas['institute-download-url-field']) ? $term_metas['institute-download-url-field'] : '';
$institute_url_field 	  = !empty($term_metas['institute-url-field']) ? $term_metas['institute-url-field'] : '';
?>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/jquery.bxslider.css" rel="stylesheet" />

<div class="wrap">
	<div id="sidebar">
		<?php get_sidebar(); ?>
	</div> 	
	<div id="primary" class="content-area fullwidth">
		<main id="main" class="site-main" role="main">	
			<div class="top-cat-cp" style="margin-bottom: 15px;">
			<header class="entry-header" data-id="<?php echo esc_attr($term->term_id); ?>">
				<h1 class="entry-title"><?php echo esc_html($term->description); ?></h1>
			</header>
			<?php if( isset( $custom_date_field ) ) { ?>
				<div class="conf_tax"><strong><?php echo esc_html( $custom_date_field ); ?></strong></div>
			<?php } ?>
			<?php if( isset( $institute_detail_field ) ) { ?>
				<div class="conf_tax"><strong><?php echo esc_html( $institute_detail_field ); ?></strong></div>
			<?php } ?>
			<?php if( isset( $institute_down_url_field ) && isset( $institute_url_field ) ) { ?>
				<div class="conf_tax"><strong><a href="<?php echo esc_url($institute_url_field); ?>" target="_blank"><?php echo esc_html( $institute_down_url_field ); ?></a></strong></div>
			<?php } ?>
			</div>
			
			<?php $is_slider = false;
			$term = get_queried_object();?>
			
			<ul class="bxslider">
				<?php 
				for ( $slider_image = 1; $slider_image <=6; $slider_image++ ) { 
				
				$cp_cat_image_file = get_field('cp_cat_image'.$slider_image, $term);				
					if( !empty( $cp_cat_image_file ) ) {											
						?>
						<li><img src="<?php echo $cp_cat_image_file['url']; ?>" /></li>			  
						<?php
						$is_slider = true;
					} 
				 } ?>
			</ul>		
			
			<div class="entry-header cat-title">
				<?php echo '<h2 class="entry-title">'.$term->name.'</h2>';  ?>		
			</div><!-- .entry-header -->
					<?php						
			$page_num = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			$args = array(
				'post_type' => 'rr_cp_post',
				//'rr_cp_cat' => get_query_var( 'term' ),
				'orderby' => 'date',
				'order' => 'ASC',
				'paged'=>$page_num,
				'posts_per_page' => 15,
				'tax_query' => array(					
						array(
							'taxonomy' => 'rr_cp_cat',
							'field' => 'slug',
							'terms' => array( get_query_var( 'term' ) )
						),						
					)
			);
			
			$count = get_post_count_by_page($page_num);
			
				
			$query = new WP_Query( $args );
			
			/* Start the Loop */
			set_query_var( 'term_name', $term->name );
			while ( $query->have_posts() ) : $query->the_post();
				set_query_var( 'count', absint( $count ) );
				get_template_part( 'template-parts/post/content', 'conference-proceeding' );
				$count++;
			endwhile; // End of the loop.
			rr_custom_pagination($query);
			?>
			
		</main><!-- #main -->
	</div><!-- #primary -->	
</div><!-- .wrap -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.bxslider.js"></script>
<?php if( $is_slider ) { ?>
<script>
	jQuery(document).ready(function(){
		jQuery('.bxslider').bxSlider({
			auto: true,
			autoControls: true,
			stopAutoOnClick: true,
			pager: true,
			slideWidth: 300
		});
	});
</script>
<?php } get_footer();
