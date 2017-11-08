<?php	
	
/**
 * _pickle_divi_clear_local_storage function.
 * 
 * @access private
 * @return void
 */
function _pickle_divi_clear_local_storage () {
	?>
	<script>
		for(var prop in localStorage)localStorage.removeItem(prop);	
	</script>
	<?php
}
add_action('admin_enqueue_scripts', '_pickle_divi_clear_local_storage', 9999);

/**
 * pickle_divi_builder_include_post_types_option function.
 * 
 * @access public
 * @return void
 */
function pickle_divi_builder_include_post_types_option() {
	$output=array();
	$post_types=get_post_types(array('public' => true), 'objects');

	foreach ($post_types as $post_type) :
		$output[$post_type->name]=$post_type->label;
	endforeach;

	return apply_filters('pickle_divi_pb_include_post_types', $output);	
}

/**
 * pickle_divi_builder_get_taxonomies function.
 * 
 * @access public
 * @return void
 */
function pickle_divi_builder_get_taxonomies() {
	$output=array();
	$taxonomies=get_taxonomies(array('public' => true), 'objects');

	foreach ($taxonomies as $taxonomy) :
		$output[$taxonomy->name]=$taxonomy->label;
	endforeach;

	return apply_filters('pickle_divi_builder_get_taxonomies', $output);	
}

/**
 * pickle_divi_excerpt_by_id function.
 * 
 * @access public
 * @param mixed $post
 * @param int $length (default: 10)
 * @param string $tags (default: '<a><em><strong>')
 * @param string $extra (default: ' . . .')
 * @return void
 */
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