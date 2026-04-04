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
		<?php do_shortcode('[board_member_form]'); ?>
	</div>
	</div><!-- .entry-content -->	
</article><!-- #post-## -->

<script>

jQuery(document).ajaxStart(jQuery.blockUI).ajaxStop(jQuery.unblockUI);
jQuery(document).ready(function(){
	
	jQuery("#ebm_form_id").validate({
		debug: true,
		ignore: [],
		rules: {
			ebm_name_pre:{
				required:true,
			},
			ebm_first_name:{
				required:true,
			},
			ebm_last_name:{
				required:true,
			},
			ebm_contact_no:{
				required:true,
			},
			ebm_email:{
				required:true,
				email: true
			},
			ebm_designation:{
				required:true,
			},
			ebm_institute_name_address:{
				required:true,
			},
			ebm_residential_address:{
				required:true,
			},
			ebm_degree_qualification:{
				required:true,
			},
			ebm_subjectArea:{
				required:true,
			},
			ebm_google_scholar_profile:{
				required:true,
			},
			ebm_research_gate_url:{
				required:true,
			},
			ebm_orcid_id:{
				required:true,
			},
			ebm_ssrn_id:{
				required:true,
			},	
			ebm_file: {
				required: true,			
			},
			captcha1: {
				required: true,			
			}
		},	  
		submitHandler: function (form) { 
			var ebm_name_pre = jQuery('#ebm_name_pre').val();
			var ebm_first_name = jQuery('#ebm_first_name').val();
			var ebm_last_name = jQuery('#ebm_last_name').val();
			var ebm_contact_no = jQuery('#ebm_contact_no').val();
			var ebm_email = jQuery('#ebm_email').val();
			var ebm_designation = jQuery('#ebm_designation').val();
			var ebm_institute_name_address = jQuery('#ebm_institute_name_address').val();
			var ebm_residential_address = jQuery('#ebm_residential_address').val();
			var ebm_degree_qualification = jQuery('#ebm_degree_qualification').val();
			var ebm_subjectArea = jQuery('#ebm_subjectArea').val();
			var ebm_institute_url = jQuery('#ebm_institute_url').val();
			var ebm_personal_blog = jQuery('#ebm_personal_blog').val();
			var ebm_google_scholar_profile = jQuery('#ebm_google_scholar_profile').val();
			var ebm_research_gate_url = jQuery('#ebm_research_gate_url').val();
			var ebm_orcid_id = jQuery('#ebm_orcid_id').val();
			var ebm_ssrn_id = jQuery('#ebm_ssrn_id').val();
			var captcha1 = jQuery('#captcha1').val();
				
			var formData = new FormData();
			formData.append("action", "ebm_form_ajax_request");
			formData.append("ebm_name_pre", ebm_name_pre);
			formData.append("ebm_first_name",ebm_first_name);
			formData.append("ebm_last_name",ebm_last_name);
			formData.append("ebm_contact_no",ebm_contact_no);
			formData.append("ebm_email",ebm_email);
			formData.append("ebm_designation",ebm_designation);
			formData.append("ebm_institute_name_address",ebm_institute_name_address);
			formData.append("ebm_residential_address",ebm_residential_address);
			formData.append("ebm_degree_qualification",ebm_degree_qualification);
			formData.append("ebm_subjectArea",ebm_subjectArea);
			formData.append("ebm_institute_url",ebm_institute_url);
			formData.append("ebm_personal_blog",ebm_personal_blog);
			formData.append("ebm_google_scholar_profile",ebm_google_scholar_profile);
			formData.append("ebm_research_gate_url",ebm_research_gate_url);
			formData.append("ebm_orcid_id",ebm_orcid_id);
			formData.append("ebm_ssrn_id",ebm_ssrn_id);
			formData.append("captcha1", captcha1);			
			formData.append('file', jQuery('#ebm_file')[0].files[0]);
				jQuery.ajax({
					type: 'POST',
					dataType: 'json',
					url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
					data : formData,
					processData: false,  // tell jQuery not to process the data
					contentType: false, 
					success: function(data){
						jQuery('.ebm_response').html(data.message);
						if( data.success == true ) {						
							jQuery('.ebm_response').show().addClass('success').removeClass('error').delay(5000).fadeOut();											
							jQuery('#ebm_form_id').trigger("reset");	
						} else {
							jQuery('img#img').attr('src',data.recaptchaimage);
							jQuery('.ebm_response').show().addClass('error').removeClass('success').delay(5000).fadeOut();	
						}					
						
					}
				});						
		}
	});
});
</script>