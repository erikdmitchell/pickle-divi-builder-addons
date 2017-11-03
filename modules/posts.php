<?php

class Pickle_Divi_Builder_Module_Posts extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Posts', 'pickle-divi' );
		$this->slug       = 'et_pb_posts';
		//$this->fb_support = true; // CHECK THIS //

		$this->whitelisted_fields = array(
			'section_title',
			'post_type',
			'in_term',
			'taxonomy_name',
			'taxonomy_type',
			'number_of_posts',
			'show_excerpt',
			'excerpt_length',
			'show_thumbnail',
			'show_date',
			'date_format',
			'show_more_link',
			'more_text',
			'order',
			'order_by',
			'meta_key',
			'show_custom_meta_query',	
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'post_type' => array('post'),
			'taxonomy_type' => array('category'),
			'number_of_posts'   => array(5),
			'show_excerpt' => array('on'),
			'excerpt_length' => array(30),
			'show_thumbnail' => array('on'),
			'show_date' => array('off'),
			'date_format' => array('M j, Y'),
			'show_more_link' => array('on'),
			'more_text' => array('...more &raquo;'),
			'order' => array('DESC'),
			'order_by' => array('date'),	
			'meta_key' => array(''),	
			'show_custom_meta_query' => array('off'),
			'custom_meta_query' => array(''),				
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
			'section_title' => array(
				'label'            => esc_html__( 'Section Title', 'pickle-divi' ),
				'type'             => 'text',
				'description'      => esc_html__( 'This will appear above the posts. If left empty, nothing will appear.', 'pickle-divi' ),
				'toggle_slug'      => 'elements',
			),			
			'post_type' => array(
				'label'            => esc_html__('Post Type', 'pickle-divi'),
				'type' => 'select',
				'options' => pickle_divi_builder_include_post_types_option(),
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
				'type' => 'select',
				'options' => pickle_divi_builder_get_taxonomies(),
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
 				'default'         => 5,
 				'range_settings'  => array(
 					'min'  => '-1',
 					'max'  => '100',
 					'step' => '1',
 				),
 			),
			'show_excerpt' => array(
				'label'             => esc_html__('Show Excerpt', 'pickle-divi'),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'pickle-divi' ),
					'off' => esc_html__( 'No', 'pickle-divi' ),
				),
				'default' => 'on',
				'affects' => array(
					'excerpt_length',
				),				
				'toggle_slug'       => 'elements',
				'description'       => esc_html__('Here you can choose whether or not display to display the excerpt/post content', 'pickle-divi'),
			),  			
			'excerpt_length' => array(
 				'label'           => esc_html__('Excerpt Length', 'pickle-divi'),
 				'type'            => 'range',
 				'option_category' => 'configuration',
 				'depends_show_if'  => 'on',
 				'description'      => esc_html__('The number of words in the posts excerpt.', 'pickle-divi'),
 				'toggle_slug'     => 'elements',
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
			'show_more_link' => array(
				'label'             => esc_html__('Show More Link', 'pickle-divi'),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'pickle-divi' ),
					'off' => esc_html__( 'No', 'pickle-divi' ),
				),
				'default' => 'on',
				'affects' => array(
					'more_text',
				),				
				'toggle_slug'       => 'elements',
				'description'       => esc_html__('Here you can choose whether or not display to display the more link', 'pickle-divi'),
			), 						
			'more_text' => array(
				'label'             => esc_html__('More Text', 'pickle-divi'),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'toggle_slug'       => 'elements',
				'depends_show_if'  => 'on',
				'description'       => esc_html__('Here you can define the text for the more link. Default is "...more &raquo;"', 'pickle-divi'),
			),
			'order' => array(
				'label'             => esc_html__('Order', 'pickle-divi'),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'ASC'  => esc_html__( 'ASC', 'pickle-divi' ),
					'DESC' => esc_html__( 'DESC', 'pickle-divi' ),
				),
				'default' => 'DESC',			
				'toggle_slug'       => 'elements',
				'description'       => esc_html__('Here you can change the order of the posts', 'pickle-divi'),
			),  
			'order_by' => array(
				'label'             => esc_html__('Order By', 'pickle-divi'),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'none'  => esc_html__( 'None', 'pickle-divi' ),
					'ID' => esc_html__('ID', 'pickle-divi'),
					'author' => esc_html__('Author', 'pickle-divi'),
					'title' => esc_html__('Title', 'pickle-divi'),
					'date' => esc_html__('Date', 'pickle-divi'),
					'modified' => esc_html__('Last Modified', 'pickle-divi'),
					'parent' => esc_html__('Parent ID', 'pickle-divi'),
					'rand' => esc_html__('Random', 'pickle-divi'),
					'comment_count' => esc_html__('Number of Comments', 'pickle-divi'),
					'menu_order' => esc_html__('Page Order', 'pickle-divi'),
					'meta_value' => esc_html__('Meta Value', 'pickle-divi'),
					'meta_value_num' => esc_html__('Numeric Meta Value', 'pickle-divi'),
				),
				'default' => 'date',	
				'affects' => array(
					'meta_key',
				),							
				'toggle_slug'       => 'elements',
				'description'       => esc_html__('Here you can change how to order the posts', 'pickle-divi'),
			),  
			'meta_key' => array(
				'label'            => esc_html__( 'Meta Key', 'pickle-divi' ),
				'type'             => 'text',
				'description'      => esc_html__( 'The key to order the posts by (meta value).', 'pickle-divi' ),
				'toggle_slug'      => 'elements',
				'depends_show_if_not'  => array(
					'none',
					'ID',
					'author',
					'title',
					'date',
					'modified',
					'parent',
					'rand',
					'comment_count',
					'menu_order',
				),
			),
			'show_custom_meta_query' => array(
				'label'             => esc_html__('Add Custom Meta Query', 'pickle-divi'),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'pickle-divi' ),
					'off' => esc_html__( 'No', 'pickle-divi' ),
				),
				'default' => 'off',
				'affects' => array(
					'custom_meta_query',
				),				
				'toggle_slug'       => 'elements',
				'description'       => esc_html__('Here you can choose whether or not to add a custom meta query', 'pickle-divi'),
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
		$args=wp_parse_args($args, $defaults);
		$args=apply_filters('pickle_divi_posts_module_get_post_ids_args', $args, $this);

		$post_ids=get_posts($args);

		return $post_ids;		
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$content='';
		
		$module_id = $this->shortcode_atts['module_id'];
		$module_class = $this->shortcode_atts['module_class'];
		$section_title = $this->shortcode_atts['section_title'];
		$number_of_posts = $this->shortcode_atts['number_of_posts'];
		$post_type = $this->shortcode_atts['post_type'];
		$in_term = $this->shortcode_atts['in_term'];
		$taxonomy_type = $this->shortcode_atts['taxonomy_type'];
		$taxonomy_name = $this->shortcode_atts['taxonomy_name'];
		$show_excerpt = $this->shortcode_atts['show_excerpt'];
		$excerpt_length = $this->shortcode_atts['excerpt_length'];
		$show_thumbnail = $this->shortcode_atts['show_thumbnail'];
		$show_date = $this->shortcode_atts['show_date'];
		$date_format = $this->shortcode_atts['date_format'];		
		$show_more_link = $this->shortcode_atts['show_more_link'];
		$more_text = $this->shortcode_atts['more_text'];	
		$order = $this->shortcode_atts['order'];
		$order_by = $this->shortcode_atts['order_by'];
		$meta_key = $this->shortcode_atts['meta_key'];
		$show_custom_meta_query = $this->shortcode_atts['show_custom_meta_query'];
					
		$module_class = ET_Builder_Element::add_module_order_class($module_class, $function_name);
		
		$post_id_args=array(
			'posts_per_page' => $number_of_posts,
			'post_type' => $post_type,
			'order' => $order,
			'orderby' => $order_by,
			'meta_key' => $meta_key,
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
		
		if ($show_custom_meta_query==='on') :
			$post_id_args=apply_filters('pickle_divi_posts_module_custom_meta_query', $post_id_args, $this->shortcode_atts);
		endif;

		$post_ids=$this->get_post_ids($post_id_args);
		
		if (count($post_ids)) :
		
			if (!empty($section_title))
				$content.='<h3 class="posts-section-title">'.$section_title.'</h3>';
		
			$content.='<ul class="recent-posts-list">';
			
				foreach ($post_ids as $post_id) :
					if ($show_more_link==='on') :
						$more='<a href="'.get_permalink($post_id).'">'.$more_text.'</a>';
					else :
						$more='';
					endif;
				
					$excerpt=apply_filters('pickle_divi_posts_module_excerpt', pickle_divi_excerpt_by_id($post_id, $excerpt_length, '', $more), $post_id, $excerpt_length, $more, $this);
				
					if (has_post_thumbnail($post_id)) :
						$thumbnail=get_the_post_thumbnail($post_id, 'medium');
					else :
						$thumbnail='';
					endif;
				
					$content.='<li id="post-'.$post_id.'" class="recent-post-single">';
						
						if ($show_thumbnail==='on')
							$content.='<div class="thumbnail">'.$thumbnail.'</div>';
							
						$content.='<h3 class="title"><a href="'.get_permalink($post_id).'">'.get_the_title($post_id).'</a></h3>';
						
						if ($show_date==='on')
							$content.='<div class="date">'.apply_filters('pickle_divi_posts_module_date', get_the_date($date_format, $post_id), $post_id, $date_format).'</div>';						
						
						if ($show_excerpt==='on' && $excerpt)
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