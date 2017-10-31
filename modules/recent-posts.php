<?php

class Pickle_Divi_Builder_Module_Recent_Posts extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Recent Posts', 'pickle-divi' );
		$this->slug       = 'et_pb_recent_posts';
		//$this->fb_support = true; // CHECK THIS //

		$this->whitelisted_fields = array(
			'post_type',
			//'taxonomy',
			'number_of_posts',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'post_type' => array('post'),
			'number_of_posts'   => array(5),
		);

		// EIDT THIS //
		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Posts', 'pickle-divi'),
				),
			),
		);

		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = array();
	}

	function get_fields() {
		$fields = array(
			//'taxonomy',
			
			'post_type' => array(
				'label'            => esc_html__('Post Type', 'pickle-divi'),
				'renderer'         => 'pickle_divi_builder_include_post_types_option',
				//'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Select the post type that you would like to include.', 'pickle-divi' ),
/*
				'computed_affects' => array(
					'__project_terms',
					'__projects',
				),
*/
				//'taxonomy_name'    => 'project_category',
				'toggle_slug'      => 'main_content',
			),


			'number_of_posts' => array(
 				'label'           => esc_html__('Number of Posts', 'pickle-divi'),
 				'type'            => 'range',
 				//'option_category' => 'configuration',
 				'toggle_slug'     => 'main_content',
 				//'sub_toggle'      => 'ul',
 				//'priority'        => 90,
 				'default'         => 5,
 				'range_settings'  => array(
 					'min'  => '0',
 					'max'  => '100',
 					'step' => '1',
 				),
 			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'pickle-divi' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'pickle-divi' ),
				'toggle_slug' => 'admin_label',
			),
			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'pickle-divi' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'pickle-divi' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'classes',
				'option_class'    => 'et_pb_custom_css_regular',
			),
		);

		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id = $this->shortcode_atts['module_id'];
		$module_class = $this->shortcode_atts['module_class'];
		$number_of_posts = $this->shortcode_atts['number_of_posts'];
		$post_type = $this->shortcode_atts['post_type'];

		$module_class = ET_Builder_Element::add_module_order_class($module_class, $function_name);

		$content='';
		$post_ids=get_posts(array(
			'posts_per_page' => $number_of_posts,
			'post_type' => $post_type,
			'fields' => 'ids',
		));
		
		if (count($post_ids)) :
		
			$content.='<ul class="recent-posts-list">';
			
				foreach ($post_ids as $post_id) :
					$excerpt=pickle_divi_excerpt_by_id($post_id, 40, '', '<a href="'.get_permalink($post_id).'">...more &raquo;</a>');
				
					if (has_post_thumbnail($post_id)) :
						$thumbnail=get_the_post_thumbnail($post_id, 'medium');
					else :
						$thumbnail='';
					endif;
				
					
				
					$content.='<li id="post-'.$post_id.'" class="recent-post-single">';
						$content.='<div class="thumbnail">'.$thumbnail.'</div>';
						$content.='<h3 class="title"><a href="'.get_permalink($post_id).'">'.get_the_title($post_id).'</a></h3>';
						
						if ($excerpt)
							$content.='<div class="excerpt">'.$excerpt.'</div>';
							
					$content.='</li>';
					
				endforeach;
				
			$content.='</ul>';
			
		endif;

		$output = sprintf(
			'<div%2$s class="et_pb_recent_posts%3$s">
				<div class="et_pb_recent_posts_inner">
					%1$s
				</div>
			</div> <!-- .et_pb_text -->',
			$content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}
}

new Pickle_Divi_Builder_Module_Recent_Posts;
?>