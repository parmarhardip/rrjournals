<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>	
<div style="clear:both"> </div>
<div id="footer"> 
	<div class="copy_right">
		<p>© 2015-16 Copyright <a href="index.php"> RRIJM</a></p>
		<p class="sociel-icon"> <a href="https://www.facebook.com/Research-Review-Journals-1659280160993581/?skip_nax_wizard=true" target="_blank" style="text-decoration:none;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fb_icon.png" height="30" width="30"> </a>
		<a href="http://www.linkedin.com" target="_blank" style="text-decoration:none;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/link-incon.png" height="30" width="30"> </a>		
		<a href="https://twitter.com/RRJournals" target="_blank" style="text-decoration:none;"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/tw-icon.png" height="30" width="30"> </a>
		</p>	
		<!--<div align="center" style="padding-bottom: 10px;"><img src="http://simplehitcounter.com/hit.php?uid=2360915&f=16777215&b=0" border="0" height="18" width="83" alt="web counter"><br></div>-->
		<div class="page-counter">
		<?php echo do_shortcode('[hit_count]'); ?>	
		</div>
	</div>
	<div class="foot_nav">
		<a href="<?php echo site_url(); ?>">Home</a> | 
		<a href="<?php echo site_url('/faqs/'); ?>">FAQs</a> | 
		<a href="<?php echo site_url('/plagiarism-policy/'); ?>">Plagiarism Policy</a> | 
		<a href="<?php echo site_url('/open-access-policy/'); ?>">Open Access Policy</a> |
		<a href="<?php echo site_url('/disclaimer-policy/'); ?>">Disclaimer Policy </a> |
		<a href="<?php echo site_url('/privacy-policy/'); ?>">Privacy Policy </a> |
		<a href="<?php echo site_url('/site-map/'); ?>">Site map</a> |
		<a href="<?php echo site_url('/contact-us/'); ?>">Contact Us </a> |
	</div>
	
	<div class="foot-text">	
	<a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/in/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-nd/2.5/in/88x31.png" /></a><br>This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/in/">Creative Commons Attribution-NonCommercial-NoDerivs 2.5 India License.</a>
	</div>
</div>
</div>
<?php wp_footer(); ?>
</div><!-- #content -->
<script>
jQuery(document).ready(function(){
	jQuery('a.cite_Btn').click(function(){
		jQuery(this).next().show();
	});
	jQuery('.cite_model span.close').click(function(){
		jQuery('.cite_model').hide();
	});
});
</script>
</body>
</html>
