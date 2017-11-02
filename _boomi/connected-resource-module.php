<?php

class Boomi_Connected_resource_Module extends ET_Builder_Module {
	
	function init() {
		$this->name = esc_html__('Connected Resource', 'boomi');
		$this->slug = 'et_pb_connected_resource';

		$this->whitelisted_fields = array(
			'title',
			'title_color',
			'image',
			'url',
			'type',
			'description',
			'admin_label',
			'module_id',
			'module_class',
		);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Title Text', 'boomi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__('This defines the title text for the resource.', 'boomi' ),
			),
			'title_color' => array(
				'label'             => esc_html__( 'Title Color', 'boomi' ),
				'type'              => 'color',
				'custom_color'      => true,
			),
			'image' => array(
				'label'              => esc_html__('Image URL', 'boomi'),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'boomi' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'boomi' ),
				'update_text'        => esc_attr__( 'Set As Image', 'boomi' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder' ),
			),	
			'type' => array(
				'label'             => esc_html__('Type', 'boomi'),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Enter the resource type.', 'boomi' ),
			),
			'url' => array(
				'label'           => esc_html__( 'Link URL', 'boomi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Enter the URL of the resource.', 'boomi' ),
			),
			'description' => array(
				'label'             => esc_html__('Description', 'boomi'),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Enter a brief description. This will display instead of the title unless left blank.', 'boomi' ),
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
		$title_color = $this->shortcode_atts['title_color'];
		$image = $this->shortcode_atts['image'];
		$url = $this->shortcode_atts['url'];
		$type = $this->shortcode_atts['type'];
		$description = $this->shortcode_atts['description'];		

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		// title color //
		if ( '' !== $title_color ) {			
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .resource_title a',
				'declaration' => sprintf(
					'%1$s',
					( '' !== $title_color ? sprintf( 'color: %1$s!important', esc_html( $title_color ) ) : '' )
				),
			) );
			
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .resource-thumbnail',
				'declaration' => sprintf(
					'%1$s',
					( '' !== $title_color ? sprintf( 'background-color: %1$s', esc_html( $title_color ) ) : '' )
				),
			) );			
		}

		// create output //
		$output = sprintf(
			'<div%1$s class="boomi-connected-resource%2$s">

				<a href="%3$s">
					<div class="resource-thumbnail" style="background-image: url(%4$s)">
						<div class="resource-type-wrapper">
							<!-- <span class="resource-type-icon %6$s"></span> -->
							<!-- <span class="resource-type-name">%5$s</span> -->
						</div>
					</div>
				</a>
				
				<div class="resource-content">
					<div class="resource_title">
						<a href="%3$s">%7$s</a>
					</div>
					<div class="link-icon">
						<a href="%3$s"></a>
					</div>
				</div>

			</div>',
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s ', esc_attr( $module_class ) ) : '' ),
			$url,
			($image!==''? $image : ''),
			$type,
			strtolower($type),
			($description!==''? $description : $title)
		);

		return $output;
	}

}

new Boomi_Connected_resource_Module();

?>