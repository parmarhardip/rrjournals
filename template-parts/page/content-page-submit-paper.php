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
	<div class="board-form">
		<?php the_content(); ?>		
		<?php do_shortcode('[submit_paper_form]'); ?>
	</div>
	</div><!-- .entry-content -->	
</article><!-- #post-## -->

<script>

jQuery(document).ajaxStart(jQuery.blockUI).ajaxStop(jQuery.unblockUI);
jQuery(document).ready(function(){
	
	jQuery("#rr_sp_form_id").validate({
		debug: true,
		ignore: [],
	  rules: {
		first_author_name: "required",
		first_author_designation: "required",
		name_of_corresponding_author: "required",
		email_of_corresponding_author: {
		  required: true,
		  email: true
		},		
		rrj_policy: {
			required:true,
		},
		contact_no: "required",
		rr_sp_file: {
			required: true,			
		},
		captcha1: {
			required: true,			
		}
	  },
	  
	  submitHandler: function (form) { 
			var article_type = jQuery('#article_type').val();
			var subject_area = jQuery('#subject_area').val();
			var title_of_the_paper = jQuery('#title_of_the_paper').val();
			var first_author_name = jQuery('#first_author_name').val();
			var first_author_designation = jQuery('#first_author_designation').val();
			var second_author_name = jQuery('#second_author_name').val();
			var second_author_designation = jQuery('#second_author_designation').val();
			var third_author_name = jQuery('#third_author_name').val();
			var third_author_designation = jQuery('#third_author_designation').val();
			var name_of_corresponding_author = jQuery('#name_of_corresponding_author').val();
			var email_of_corresponding_author = jQuery('#email_of_corresponding_author').val();
			var contact_no = jQuery('#contact_no').val();
			var city_name = jQuery('#city_name').val();
			var state_name = jQuery('#state_name').val();
			var country_name = jQuery('#country_name').val();
			var sp_submit_meta_nonce = jQuery('#sp_submit_meta_nonce').val();
			var captcha1 = jQuery('#captcha1').val();
			
			var formData = new FormData();
			formData.append("action", "rr_sp_form_ajax_request");
			formData.append("article_type", article_type);			
			formData.append("subject_area", subject_area);
			formData.append("title_of_the_paper", title_of_the_paper);
			formData.append("first_author_name", first_author_name);
			formData.append("first_author_designation", first_author_designation);
			formData.append("second_author_name", second_author_name);
			formData.append("second_author_designation", second_author_designation);
			formData.append("third_author_name", third_author_name);
			formData.append("third_author_designation", third_author_designation);
			formData.append("name_of_corresponding_author", name_of_corresponding_author);
			formData.append("email_of_corresponding_author", email_of_corresponding_author);
			formData.append("contact_no", contact_no);
			formData.append("city_name", city_name);
			formData.append("state_name", state_name);
			formData.append("country_name", country_name);
			formData.append("sp_submit_meta_nonce", sp_submit_meta_nonce);
			
			formData.append("captcha1", captcha1);			
			formData.append("rrj_policy", rrj_policy);			
			formData.append('rr_sp_file', jQuery('#rr_sp_file')[0].files[0]);
			//var ajax_form_data = $("#new_rr_sp_form_id").serialize();
			
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				data : formData,
			    processData: false,  // tell jQuery not to process the data
			    contentType: false, 
				success: function(data){
					jQuery('.rr_sp_response').html(data.message).delay(5000).fadeOut();
					if( data.success == true ) {						
						jQuery('.rr_sp_response').addClass('success');											
						jQuery('#rr_sp_form_id').trigger("reset");	
					} else {
						jQuery('.rr_sp_response').addClass('error');	
					}					
					
				}
			});						
		}
	});
});
</script>