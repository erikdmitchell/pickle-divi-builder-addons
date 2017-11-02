<?php

class Pickle_Divi_Builder_Module_Posts extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Posts', 'pickle-divi' );
		$this->slug       = 'et_pb_posts';
		//$this->fb_support = true; // CHECK THIS //

		$this->whitelisted_fields = array(
			'post_type',
			'in_term',
			'taxonomy_name',
			'taxonomy_type',
			'number_of_posts',
			'excerpt_length',
			'show_thumbnail',
			'show_date',
			'date_format',
			'more_text',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'post_type' => array('post'),
			'taxonomy_type' => array('category'),
			'number_of_posts'   => array(5),
			'excerpt_length' => array(30),
			'show_thumbnail' => array('on'),
			'show_date' => array('off'),
			'date_format' => array('M j, Y'),
			'more_text' => array('...more &raquo;'),
		);

		$this->options_toggles = array(
			'general'  => array(
				'toggles' => array(
					'elements' => esc_html__('Posts', 'pickle-divi'),
				),
			),
		);

		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = array();
	}

	function get_fields() {
		$fields = array(
			'post_type' => array(
				'label'            => esc_html__('Post Type', 'pickle-divi'),
				'renderer'         => 'pickle_divi_builder_include_post_types_option',
				'option_category'  => 'configuration',
				'description'      => esc_html__( 'Select the post type that you would like to include.', 'pickle-divi' ),
				'toggle_slug'      => 'elements',
			),
			'in_term' => array(
				'label'           => esc_html__('In specific category/taxonomy', 'pickle-divi'),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'No', 'pickle-divi' ),
					'on'  => esc_html__( 'Yes', 'pickle-divi' ),
				),
				'affects' => array(
					'taxonomy_type',
					'taxonomy_name',
				),
				'description'      => esc_html__( 'Here you can define whether the posts must be from a specific category/taxonomy', 'pickle-divi' ),
				'toggle_slug'      => 'elements',
			),
			'taxonomy_type' => array(
				'label'            => esc_html__('Taxonomy Type', 'pickle-divi'),
				//'type' => 'text',
				'renderer'         => 'pickle_divi_builder_get_taxonomies',
				'renderer_with_field' => true,
				'depends_show_if'  => 'on',
				'description'      => esc_html__( 'Select the taxonomy type that you would like to include.', 'pickle-divi' ),
				'toggle_slug'      => 'elements',
			),
			'taxonomy_name' => array(
				'label'            => esc_html__( 'Custom Taxonomy Name', 'pickle-divi' ),
				'type'             => 'text',
				'depends_show_if'  => 'on',
				'description'      => esc_html__( 'Type the taxonomy name to make the "In specific category/taxonomy" option work correctly', 'pickle-divi' ),
				'toggle_slug'      => 'elements',
			),			
			'number_of_posts' => array(
 				'label'           => esc_html__('Number of Posts', 'pickle-divi'),
 				'type'            => 'range',
 				'option_category' => 'configuration',
 				'toggle_slug'     => 'elements',
 				//'sub_toggle'      => 'ul',
 				//'priority'        => 90,
 				'default'         => 5,
 				'range_settings'  => array(
 					'min'  => '-1',
 					'max'  => '100',
 					'step' => '1',
 				),
 			),
			'excerpt_length' => array(
 				'label'           => esc_html__('Excerpt Length', 'pickle-divi'),
 				'type'            => 'range',
 				'option_category' => 'configuration',
 				'description'      => esc_html__('The number of words in the posts excerpt.', 'pickle-divi'),
 				'toggle_slug'     => 'elements',
 				//'sub_toggle'      => 'ul',
 				//'priority'        => 90,
 				'default'         => 30,
 				'range_settings'  => array(
 					'min'  => '0',
 					'max'  => '100',
 					'step' => '1',
 				),
 			),
			'show_thumbnail' => array(
				'label'             => esc_html__('Show Featured Image', 'pickle-divi'),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'pickle-divi' ),
					'off' => esc_html__( 'No', 'pickle-divi' ),
				),
				'default' => 'on',
				'toggle_slug'       => 'elements',
				'description'       => esc_html__('Here you can choose whether or not display the post featured image', 'pickle-divi'),
			), 	
			'show_date' => array(
				'label'             => esc_html__('Show Date', 'pickle-divi'),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'pickle-divi' ),
					'off' => esc_html__( 'No', 'pickle-divi' ),
				),
				'default' => 'off',
				'affects' => array(
					'date_format',
				),				
				'toggle_slug'       => 'elements',
				'description'       => esc_html__('Here you can choose whether or not display to display the date after the post title', 'pickle-divi'),
			), 
			'date_format' => array(
				'label'            => esc_html__( 'Date Format', 'pickle-divi' ),
				'type'             => 'text',
				'depends_show_if'  => 'on',
				'description'      => esc_html__('Here you can define the format for the date. Default is "M j, Y"', 'pickle-divi' ),
				'toggle_slug'      => 'elements',
			),			
			'more_text' => array(
				'label'             => esc_html__('More Text', 'pickle-divi'),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'toggle_slug'       => 'elements',
				'description'       => esc_html__('Here you can define the text for the more link. Default is "...more &raquo;"', 'pickle-divi'),
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
	
	function get_post_ids($args=array()) {
		$defaults=array(
			'posts_per_page' => 5,
			'post_type' => 'post',
			'fields' => 'ids',
		);

		$args = wp_parse_args($args, $defaults);

		$post_ids=get_posts($args);
		
		return $post_ids;		
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$content='';
		
		$module_id = $this->shortcode_atts['module_id'];
		$module_class = $this->shortcode_atts['module_class'];
		$number_of_posts = $this->shortcode_atts['number_of_posts'];
		$post_type = $this->shortcode_atts['post_type'];
		$in_term = $this->shortcode_atts['in_term'];
		$taxonomy_type = $this->shortcode_atts['taxonomy_type'];
		$taxonomy_name = $this->shortcode_atts['taxonomy_name'];		
		$excerpt_length = $this->shortcode_atts['excerpt_length'];
		$show_thumbnail = $this->shortcode_atts['show_thumbnail'];
		$more_text = $this->shortcode_atts['more_text'];		

		$module_class = ET_Builder_Element::add_module_order_class($module_class, $function_name);
		
		$post_id_args=array(
			'posts_per_page' => $number_of_posts,
			'post_type' => $post_type,	
		);

		if ($in_term==='on') :
			$post_id_args['tax_query']=array(
				array(
					'taxonomy' => $taxonomy_type,
					'field' => 'name',
					'terms' => $taxonomy_name
				)
			);			
		endif;

		$post_ids=$this->get_post_ids($post_id_args);
		
		if (count($post_ids)) :
		
			$content.='<ul class="recent-posts-list">';
			
				foreach ($post_ids as $post_id) :
				
					$excerpt=pickle_divi_excerpt_by_id($post_id, $excerpt_length, '', '<a href="'.get_permalink($post_id).'">'.$more_text.'</a>');
				
					if (has_post_thumbnail($post_id)) :
						$thumbnail=get_the_post_thumbnail($post_id, 'medium');
					else :
						$thumbnail='';
					endif;
				
					$content.='<li id="post-'.$post_id.'" class="recent-post-single">';
						
						if ($show_thumbnail==='on')
							$content.='<div class="thumbnail">'.$thumbnail.'</div>';
							
						$content.='<h3 class="title"><a href="'.get_permalink($post_id).'">'.get_the_title($post_id).'</a></h3>';
						
						if ($excerpt)
							$content.='<div class="excerpt">'.$excerpt.'</div>';
							
					$content.='</li>';
					
				endforeach;
				
			$content.='</ul>';
			
		endif;

		$output = sprintf(
			'<div%2$s class="et_pb_posts%3$s">
				<div class="et_pb_posts_inner">
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

new Pickle_Divi_Builder_Module_Posts;
?>