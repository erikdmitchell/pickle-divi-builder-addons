<?php	
	
function _pickle_divi_clear_local_storage () {
	?>
	<script>
		for(var prop in localStorage)localStorage.removeItem(prop);	
	</script>
	<?php
}
add_action('admin_enqueue_scripts', '_pickle_divi_clear_local_storage', 9999);

function pickle_divi_builder_include_post_types_option($args=array()) {
	$output='';
	/*
		args = Array ( [label] => Post Type [renderer] => boomi_et_builder_include_post_types_option [description] => Select the post type that you would like to include. [toggle_slug] => main_content [shortcode_default] => post [name] => post_type [_order_number] => 0 ) 
		*/
	$defaults=array();
	$args=wp_parse_args($args, $defaults);
	$post_types=get_post_types(array('public' => true), 'objects');

	$output.='<select name="pickle_divi_pb_include_post_types">';
		foreach ($post_types as $post_type) :
			$output.='<option value="'.$post_type->name.'">'.$post_type->label.'</option>';
		endforeach;
	$output.='</select>';

	$output='<div id="pickle_divi_pb_include_post_types">'.$output.'</div>';

	return apply_filters('pickle_divi_pb_include_post_types', $output);	
}

function pickle_divi_excerpt_by_id($post, $length = 10, $tags = '<a><em><strong>', $extra = ' . . .') {
	if(is_int($post)) {
		// get the post object of the passed ID
		$post = get_post($post);
	} elseif(!is_object($post)) {
		return false;
	}
 
	if(has_excerpt($post->ID)) {
		$the_excerpt = $post->post_excerpt;
		return apply_filters('the_content', $the_excerpt);
	} else {
		$the_excerpt = $post->post_content;
	}
 
	$the_excerpt = strip_shortcodes(strip_tags($the_excerpt), $tags);
	$the_excerpt = preg_split('/\b/', $the_excerpt, $length * 2+1);
	$excerpt_waste = array_pop($the_excerpt);
	$the_excerpt = implode($the_excerpt);
	
	if (empty($the_excerpt))
		return false;
	
	$the_excerpt .= $extra;
 
	return apply_filters('the_content', $the_excerpt);
}
?>