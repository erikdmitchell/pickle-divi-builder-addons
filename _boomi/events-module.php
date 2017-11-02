<?php

class BoomiEvents extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__('Events', 'boomi');
		$this->slug = 'et_pb_boomi_events';

		$this->whitelisted_fields = array(
			'post_type',
			'posts_number',
			'meta_date',
			'show_thumbnail',
			'show_content',
			'show_date',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'post_type'         => array( 'events' ),
			'posts_number'      => array( 2, 'add_default_setting' ),
			'meta_date'         => array( 'M j, Y', 'add_default_setting' ),
			'show_thumbnail'    => array( 'on' ),
			'show_content'      => array( 'on' ),
			'show_date'         => array( 'on' ),
		);

		$this->custom_css_options = array(
			'title' => array(
				'label'    => esc_html__( 'Title', 'boomi' ),
				'selector' => '.et_pb_post h2',
			),
			'featured_image' => array(
				'label'    => esc_html__( 'Featured Image', 'boomi' ),
				'selector' => '.et_pb_image_container',
			),
		);
	}

	function get_fields() {		
		$fields = array(
			'post_type' => array(
				'label'            => esc_html__( 'Post Type', 'boomi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options' 		   => boomi_et_builder_post_types_option(),
				'description'      => esc_html__( 'Choose which post type you would like to use.', 'boomi' ),
			),		
			'posts_number' => array(
				'label'             => esc_html__( 'Posts Number', 'boomi' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Choose how many posts you would like to display per page.', 'boomi' ),
			),
			'meta_date' => array(
				'label'             => esc_html__( 'Meta Date Format', 'boomi' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'If you would like to adjust the date format, input the appropriate PHP date format here.', 'boomi' ),
			),
			'show_thumbnail' => array(
				'label'             => esc_html__( 'Show Featured Image', 'boomi' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'boomi' ),
					'off' => esc_html__( 'No', 'boomi' ),
				),
				'description'        => esc_html__( 'This will turn thumbnails on and off.', 'boomi' ),
			),
			'show_content' => array(
				'label'             => esc_html__( 'Content', 'boomi' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on' => esc_html__( 'Yes', 'boomi' ),
					'off'  => esc_html__( 'No', 'boomi' ),
				),
				'affects'           => array(
					'#et_pb_show_more',
				),
				'description'        => esc_html__( 'Showing the full content will not truncate your posts on the index page. Showing the excerpt will only display your excerpt text.', 'boomi' ),
			),
			'show_date' => array(
				'label'             => esc_html__( 'Show Date', 'boomi' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'boomi' ),
					'off' => esc_html__( 'No', 'boomi' ),
				),
				'description'        => esc_html__( 'Turn the date on or off.', 'boomi' ),
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
		$module_id= $this->shortcode_atts['module_id'];
		$module_class= $this->shortcode_atts['module_class'];
		$post_type= $this->shortcode_atts['post_type'];
		$posts_number= $this->shortcode_atts['posts_number'];
		$meta_date= $this->shortcode_atts['meta_date'];
		$show_thumbnail= $this->shortcode_atts['show_thumbnail'];
		$show_content= $this->shortcode_atts['show_content'];
		$show_date= $this->shortcode_atts['show_date'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		
		$html = '';
		$value = '';
		$args=array(
			'posts_per_page' => (int) $posts_number,
			'post_status' => 'publish',
			'post_type' => $post_type,
			'meta_key' => 'start_date',
			'orderby' => 'meta_value',
			'order'	=> 'ASC',
			'meta_query' => array(
				array(
					'key' => 'start_date',
					'compare' => '>=',
					'value' => date('Y-m-d'),
					'type' => 'DATE',
				),
			),
		);
		$posts=get_posts($args);
		
		if (empty($posts))
			return false;
			
		$html.='<div class="resource_Parent_div">';			
			
			foreach ($posts as $post) :
				if (has_post_thumbnail($post->ID) && $show_thumbnail==='on') {
					$thumb_url = get_the_post_thumbnail($post->ID, 'thumbnail');
				} else {
					$thumb_url = '';
				}

				$html .= '<div class="resource_section rs-events">';
					$html .= '<div class="resource_img_box">';
						$html .= '<a href="'. get_permalink($post->ID) . '">' . $thumb_url . '</a>';
					$html .= '</div>';
					
					$html .= '<a href="'. get_permalink($post->ID) .'"><h5>'. get_the_title($post->ID) . '</h5></a>';
					
					if ($show_date==='on') :
						$html .= '<p class="post-meta">';
							$html.='<span class="published">'.date($meta_date, strtotime(get_field('start_date', $post->ID))).'</span>';
						$html.='</p>';
					endif;
					
					if ($show_content==='on') :
						$html .= '<a href="'. get_permalink($post->ID) .'"><p class="excerpt">'.get_field('excerpt', $post->ID).'</p></a>';
					endif;
				$html .= '</div>';
			endforeach;
		
		$html .= '</div>';
		
			
		return $html;
	}
	
}

new BoomiEvents;
?>