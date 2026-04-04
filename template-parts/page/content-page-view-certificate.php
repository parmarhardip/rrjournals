<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * 
 */
$error_html = '';
if( isset( $_GET['response'] ) && !empty( $_GET['response'] ) ) {
	if( $_GET['code'] == 0 ) {
		$error_html = '<tr><td colspan="2"><div class="error">Please try again.</div></td></tr>';
	}else if( $_GET['code'] == 1 ) {
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
		<!--<h4>To varify the Certificate of Publication Please enter Certificate Number</h4>
		<form id="view-certificate" name="view-certificate" action="<?php //echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
			<table>			
				<tr>
					<th>Enter Certificate Reference Number :</th>
					<td><input name="certificate_number" type="text" required></td>
				</tr>
				<tr>
					<td colspan="2">
						<?php//  wp_nonce_field('valid_certificate', 'valid_certificate_nonce_field'); ?>
						<?php //$nonce = wp_create_nonce( 'valid_certificate' ); ?>
						<input type="hidden" name="_wpnonce" value="<?php echo $nonce;?>">
						<input type="hidden" name="action" value="get_certificate_by_number">
						<input type="hidden" name="post_id" value="<?php echo esc_attr(get_the_ID()); ?>">
						<input type="hidden" name="data" value="foobarid">
						<input type="submit" value="Submit">
						<input type="reset" value="Clear">
					</td>
				</tr>
				<?php //echo $error_html; ?>
			</table>
			
		</form>-->
	</div>
	</div><!-- .entry-content -->	
</article><!-- #post-## -->