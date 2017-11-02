<?php

class BoomiFeaturedResources extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__('Featured Resources', 'boomi');
		$this->slug = 'et_pb_featured_resources';

		$this->whitelisted_fields = array(
			'title',
			'post_type',
			'category',
			'posts_number',
			'show_thumbnail',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'post_Type' => array('resource'),
			'posts_number' => array(2, 'add_default_setting'),
		);

		$this->custom_css_options = array(
			'featured_image' => array(
				'label'    => esc_html__('Featured Image', 'boomi'),
				'selector' => '.et_pb_image_container',
			),
		);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Title Text', 'boomi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'This defines the title text for the section.', 'boomi' ),
			),
			'post_type' => array(
				'label'            => esc_html__( 'Post Type', 'boomi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options' 		   => boomi_et_builder_post_types_option(),
				'description'      => esc_html__( 'Choose which post type you would like to use.', 'boomi' ),
			),	
			'category' => array(
				'label'            => esc_html__( 'Category', 'boomi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options' 		   => boomi_et_builder_taxonomy_option(),
				'description'      => esc_html__( 'Choose which category you would like to use.', 'boomi' ),
			),
			'posts_number' => array(
				'label'             => esc_html__('Posts Number', 'boomi'),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Choose how much posts you would like to display per page.', 'boomi' ),
			),
			'show_thumbnail' => array(
				'label'             => esc_html__( 'Show Featured Image', 'boomi' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'        => esc_html__( 'This will turn thumbnails on and off.', 'boomi' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'boomi' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'boomi' ),
			),
			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'boomi' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'boomi' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id = $this->shortcode_atts['module_id'];
		$module_class = $this->shortcode_atts['module_class'];
		$title = $this->shortcode_atts['title'];
		$post_type = $this->shortcode_atts['post_type'];
		$category = $this->shortcode_atts['category'];		
		$posts_number = $this->shortcode_atts['posts_number'];
		$show_thumbnail = $this->shortcode_atts['show_thumbnail'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$args = array(
			'posts_per_page' => $posts_number,
			'post_status' => 'publish',
			'post_type' => $post_type,
			'tax_query' => array(
				array(
					'taxonomy' => 'resource_category',
					'field' => 'term_id',
					'terms' => $category,
				),
			),
		);
		$posts=get_posts($args);
		$html='';

		// if we have no posts //
		if (!count($posts))
			return;

		// build posts //
		foreach ($posts as $post) :
			$classes=get_post_class('et_pb_post', $post->ID);
			
			// thumbnail //
			if (has_post_thumbnail($post->ID)) :
				$thumb=get_the_post_thumbnail($post->ID, 'medium');
			else :
				$thumb='';
			endif;
			
			// link //
			if (get_field('resource_file', $post->ID)) :
				$link=get_field('resource_file', $post->ID);
			else :
				$link=get_field('external_url', $post->ID);
			endif;

			// excerpt //
			if ($post->post_excerpt!='') :
				$excerpt=$post->post_excerpt;
			else :
				$excerpt=$post->post_content;
			endif;

			$html.='<article id="post-'.$post->ID.'" class="'.implode(' ', $classes).'">';
				$html.='<div class="et_pb_image_container">';
					$html.='<a href="'.$link.'" class="entry-featured-image-url">';
						$html.=$thumb;
					$html.='</a>';
				$html.='</div> <!-- .et_pb_image_container -->';
				
				$html.='<h2 class="entry-title">';
					$html.='<a href="'.$link.'">'.$post->post_title.'</a>';
				$html.='</h2>';
				$html.='<div class="excerpt">'.$excerpt.'</div>';
			$html.='</article>';			
		endforeach;

		// create output //
		$output = sprintf(
			'<div class="boomi-featured-resources-shortcode et_pb_blog_grid_wrapper %6$s">
				<h4>%1$s</h4>
				<div%4$s class="%2$s%5$s">
					%3$s
				</div>
			</div>',
			$title,
			'et_pb_blog_grid',
			$html,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s ', esc_attr( $module_class ) ) : '' ),
			$this->slug
		);

		return $output;
	}

}

new BoomiFeaturedResources();

?>