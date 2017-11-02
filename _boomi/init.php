<?php

/**
 * boomi_cms_divi_child_theme_setup function.
 * 
 * @access public
 * @return void
 */
function boomi_cms_divi_child_theme_setup() {
	if (class_exists('ET_Builder_Module')) :
    	include_once(BOOMI_CMS_PATH.'et-custom-modules/customers-module.php');
    	include_once(BOOMI_CMS_PATH.'et-custom-modules/icon-list-module.php');
    	include_once(BOOMI_CMS_PATH.'et-custom-modules/icon-hover-list-module.php');
	    include_once(BOOMI_CMS_PATH.'et-custom-modules/process-list-module.php');
		include_once(BOOMI_CMS_PATH.'et-custom-modules/blog-posts-module.php');
		include_once(BOOMI_CMS_PATH.'et-custom-modules/connected-resource-module.php');	
		include_once(BOOMI_CMS_PATH.'et-custom-modules/events-module.php');	
		include_once(BOOMI_CMS_PATH.'et-custom-modules/marketo-form-module.php');
		include_once(BOOMI_CMS_PATH.'et-custom-modules/ouibounce-module.php');
		include_once(BOOMI_CMS_PATH.'et-custom-modules/visual-menu-module.php');
		include_once(BOOMI_CMS_PATH.'et-custom-modules/featured-resources.php');
		include_once(BOOMI_CMS_PATH.'et-custom-modules/icon-box-module.php');
		include_once(BOOMI_CMS_PATH.'et-custom-modules/icon-box-group-module.php');		    
	endif;
}
add_action('et_builder_ready', 'boomi_cms_divi_child_theme_setup');

/**
 * boomi_cms_divi_modules_scripts_styles function.
 * 
 * @access public
 * @return void
 */
function boomi_cms_divi_modules_scripts_styles() {
	wp_register_script('ouibounce-script', BOOMI_CMS_URL.'et-custom-modules/js/ouibounce.min.js', array('jquery'), '0.0.12', true);	
	wp_register_script('boomi-cms-visual-menu-module', BOOMI_CMS_URL.'et-custom-modules/js/visual-menu.js', array('jquery'), '0.1.0', true);
	wp_register_script('boomi-cms-marketo-form-module', BOOMI_CMS_URL.'et-custom-modules/js/marketo-form.js', array('jquery'), '0.2.0', true);
	wp_register_script('boomi-cms-icon-hover-list-module', BOOMI_CMS_URL.'et-custom-modules/js/icon-hover-list.js', array('jquery'), '0.1.0', true);
	wp_register_script('boomi-cms-ouibounce-module', BOOMI_CMS_URL.'et-custom-modules/js/ouibounce-module.js', array('ouibounce-script'), '0.1.0', true);	
		
	wp_enqueue_style('boomi-cms-modules-style', BOOMI_CMS_URL.'et-custom-modules/css/modules.css', '', BOOMI_CMS_VERSION);
}
add_action('wp_enqueue_scripts', 'boomi_cms_divi_modules_scripts_styles');

/**
 * boomi_cms_admin_divi_modules_scripts_styles function.
 * 
 * @access public
 * @return void
 */
function boomi_cms_admin_divi_modules_scripts_styles() {
	wp_enqueue_style('boomi-cms-modules-style', BOOMI_CMS_URL.'et-custom-modules/css/admin.css', '', '1.0.0');
}
add_action('admin_enqueue_scripts', 'boomi_cms_admin_divi_modules_scripts_styles');

function _boomi_cms_clear_local_storage () {
	?>
	<script>
		for(var prop in localStorage)localStorage.removeItem(prop);	
	</script>
	<?php
}
add_action( 'admin_enqueue_scripts', '_boomi_cms_clear_local_storage', 9999);

function boomi_et_builder_post_types_option($args=array()) {
	$defaults=array();
	$args=wp_parse_args($args, $defaults);
	$post_types=get_post_types($args, 'objects');
	$post_types_output=array();
	
	foreach ($post_types as $post_type) {
		$post_types_output[$post_type->name]=esc_html($post_type->label);
	}
	
	return $post_types_output;	
}
function boomi_et_builder_taxonomy_option($args=array()) {
	$defaults=array(
		'taxonomy' => 'resource_category',
		'hide_empty' => false,
	);
	$args=wp_parse_args($args, $defaults);
	$terms=get_terms($args);
	$terms_output=array();
	
	foreach ($terms as $term) {
		$terms_output[$term->term_id]=esc_html($term->name);
	}
	
	return $terms_output;	
}

function boomi_et_builder_modals_option($args=array()) {
	$output=array();
	$defaults=array();
	$args=wp_parse_args($args, $defaults);
	// $args is essentially useless
	
	$posts=get_posts(array(
		'posts_per_page' => -1,
		'post_type' => 'ouibounce_modals',
	));
	
	foreach ($posts as $post) :
		$output[$post->ID]=esc_html($post->post_title);
	endforeach;
	
	return $output;	
}
?>