<?php

class Customers_Module extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__('Customers', 'boomi');
		$this->slug = 'et_pb_customers_grid';

		$this->whitelisted_fields = array(
			'post_type',
			'post_ids',
			'columns',
			'admin_label',
			'module_id',
			'module_class',
		);
		
		$this->fields_defaults = array(
			'columns' => array(3),
		);		
		
		$this->advanced_options = array(
			'border' => array(),
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
			'post_ids' => array(
				'label'             => esc_html__('Post IDs', 'boomi'),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Enter the post IDs. For multiple IDs separate them by a comma (,)', 'boomi' ),
			),	
			'columns' => array(
				'label'    => esc_html__( 'Columns', 'boomi' ),
				'type'            => 'range',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '6',
					'step' => '1',
				),
				'default' => 3,
				'description' => esc_html__( 'Number of columns in grid.', 'boomi' ),	
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
		$post_type = $this->shortcode_atts['post_type'];
		$post_ids = $this->shortcode_atts['post_ids'];
		$columns = $this->shortcode_atts['columns'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		
		$post_ids=get_posts(array(
			'posts_per_page' => -1,
			'post_type' => $post_type,
			'include' => explode(',', $post_ids),
			'fields' => 'ids',
		));
		
		$html='';
		
		foreach ($post_ids as $post_id) :
			$hover_excerpt = get_field('customer_hover_excerpt', $post_id);
			$classes=boomi_cms_post_terms_to_classes($post_id, array('application_type', 'application', 'industry'));

			if ($logo_image=get_field('customer_logo', $post_id)) :
				$thumb_url = '<img class="client-logo" src="' . $logo_image['sizes']['medium'] . '" />';
			else :
				$thumb_url = '<img src="/wp-content/uploads/2016/09/white_box.jpg" />';
			endif;

			$html.='<div class="more_solution_box customer '.$classes.' cols-'.$columns.'">';
				$html.='<div class="more_solution_overlay">';
					$html.='<div class="overlay_inner">'.$hover_excerpt.'</div>';
				$html.='</div>';
				$html.='<div class="more_img_box">'.$thumb_url.'</div>';
				$html.='<a class="arrow-link" href="' . get_the_permalink($post_id) . '"><img src="/wp-content/uploads/2016/09/yellow_go.png"></a>';
			$html.='</div>';		
		endforeach;

		// create output //
		$output = sprintf(
			'<div%3$s class="%1$s%4$s">
				%2$s
			</div>',
			'customers-grid',
			$html,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s ', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}

}

new Customers_Module();
?>