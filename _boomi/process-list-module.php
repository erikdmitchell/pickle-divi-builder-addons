<?php

class BoomiProcessList extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Process List', 'boomi' );
		$this->slug            = 'et_pb_process_list';
		$this->child_slug      = 'et_pb_process_list_item';
		$this->child_item_text = esc_html__( 'Item', 'boomi' );

		$this->whitelisted_fields = array(
			'admin_label',
			'module_id',
			'module_class',
		);

		//$this->main_css_element = '%%order_class%%.et_pb_tabs';
		//$this->custom_css_options = array();
	}

	function get_fields() {
		$fields = array(
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

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		
		$list_content=$this->shortcode_content;

		$output = sprintf(
			'<div%2$s class="et_pb_module et_pb_process_list%3$s">
				%1$s
			</div> <!-- .et_pb_process_list -->',
			$list_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}

}
new BoomiProcessList();

class BoomiProcessListItem extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__( 'Item', 'et_builder' );
		$this->slug = 'et_pb_process_list_item';
		$this->type = 'child';
		$this->child_title_var = 'admin_title';

		$this->whitelisted_fields = array(
			'icon_url',
			'icon_class',
			'icon_size',
			'icon_color',
			'title_text',
			'title_color',
			'content_new',
			'border_radius',
			'border_bottom_width',
			'admin_title',
			'module_id',
			'module_class',
		);

		$this->main_css_element = '%%order_class%% .process-list-item-wrap';

		$this->fields_defaults = array(
			'icon_size' => array( 80 ),
			'border_radius' => '10',
			'border_bottom_width' => '0',
		);
		
		$this->advanced_options = array(
			'border' => array()
		);		
	}

	function get_fields() {
		$fields = array(
			'icon_url' => array(
				'label'              => esc_html__( 'Icon URL', 'boomi' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an icon', 'boomi' ),
				'choose_text'        => esc_attr__( 'Choose an Icon', 'boomi' ),
				'update_text'        => esc_attr__( 'Set As Icon', 'boomi' ),
				'description'        => esc_html__( 'Upload your desired icon, or type in the URL to the image you would like to display.', 'boomi' ),
			),
			'icon_class' => array(
				'label'           => esc_html__( 'Icon Class', 'boomi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Instead of an icon image, you can use a specific class.', 'boomi' ),
			),
			'icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'boomi' ),
				'type'              => 'color',
				'custom_color'      => true,
			),
			'icon_size' => array(
				'label'           => esc_html__( 'Icon Size', 'boomi' ),
				'type'            => 'range',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'default'         => 60,
				'mobile_options'  => true, // prbably need to check this integration
			),			
			'title_text' => array(
				'label'           => esc_html__( 'Title Text', 'boomi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'This defines the HTML Title text for the icon text field.', 'boomi' ),
			),
			'title_color' => array(
				'label'             => esc_html__( 'Title Color', 'boomi' ),
				'type'              => 'color',
				'custom_color'      => true,
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'boomi' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Here you can create the content that will show next to the icon.', 'boomi' ),
			),	
			'border_radius' => array(
				'label'             => esc_html__( 'Border Radius', 'boomi' ),
				'type'              => 'range',
				'option_category'   => 'layout',
				'tab_slug'          => 'advanced',
			),
			'border_bottom_width' => array(
				'label'             => esc_html__( 'Border Bottom Width', 'boomi' ),
				'type'              => 'range',
				'option_category'   => 'layout',
				'tab_slug'          => 'advanced',
				'description'     => esc_html__( 'If set (not 0) it will override the regular border width.', 'boomi' ),
			),			
			'admin_title' => array(
				'label'       => esc_html__( 'Admin Label', 'boomi' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the item in the builder for easy identification.', 'boomi' ),
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
		$icon='';
		$module_id = $this->shortcode_atts['module_id'];
		$module_class = $this->shortcode_atts['module_class'];
		$icon_url = $this->shortcode_atts['icon_url'];
		$icon_class = $this->shortcode_atts['icon_class'];
		$icon_size = $this->shortcode_atts['icon_size'];
		$icon_color = $this->shortcode_atts['icon_color'];
		$title_text = $this->shortcode_atts['title_text'];
		$title_color = $this->shortcode_atts['title_color'];
		$border_radius = $this->shortcode_atts['border_radius'];
		$border_bottom_width = $this->shortcode_atts['border_bottom_width'];
		
		// part of core border //
		$border_style = $this->shortcode_atts['border_style'];
		$border_color =	'' !== $this->shortcode_atts['border_color'] ? $this->shortcode_atts['border_color'] : $this->fields_unprocessed['border_color']['default'];
		$important = isset( $settings['css']['important'] ) ? '!important' : '';

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$this->shortcode_content = et_builder_replace_code_content_entities( $this->shortcode_content );
		
		// check url/class //
		if ($icon_url != '') :
			$icon=$output = sprintf(
				'<img src="%1$s" class="%2$s" />',
				esc_url( $icon_url ),
				'icon'
			);
		else :
			$icon='<i class="'.esc_attr($icon_class).' icon"></i>';
		endif;

		// border radius //
		if ( ! empty( $border_radius ) && $this->defaults['border_radius'] !== $border_radius ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .process-list-item-wrap',
				'declaration' => sprintf(
					'-moz-border-radius: %1$s; -webkit-border-radius: %1$s; border-radius: %1$s;',
					esc_html( et_builder_process_range_value( $border_radius ) )
				),
			) );
		}
		
		// border bottom width //
		if ( ! empty( $border_bottom_width ) && $border_bottom_width !== 0 ) {		
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .process-list-item-wrap',
				'declaration' => sprintf(
					'border-bottom: %1$s %3$s %2$s %4$s;',
					esc_attr( et_builder_process_range_value( $border_bottom_width ) ),
					esc_attr( $border_color ),
					esc_attr( $border_style ),
					esc_attr( $important )
				),
			) );
		}
		
		// set triangle color //
		ET_Builder_Element::set_style( $function_name, array(
			'selector'    => '%%order_class%% .process-list-item-wrap .process-triangle',
			'declaration' => sprintf(
				'border-left-color: %1$s;',
				esc_attr( $border_color )
			),
		) );
		
		// icon size //
		if ( '' !== $icon_size ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .icon',
				'declaration' => sprintf(
					'font-size: %1$spx;
					width: %1$spx;
					height: %1$spx;
					%2$s',
					esc_html( $icon_size ),
					( '' !== $icon_color ? sprintf( 'color: %1$s', esc_html( $icon_color ) ) : '' )
				),
			) );
		}	

		// title color //
		if ( '' !== $title_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .text-wrap .item-title',
				'declaration' => sprintf(
					'%1$s',
					( '' !== $title_color ? sprintf( 'color: %1$s', esc_html( $title_color ) ) : '' )
				),
			) );
		}	
		
		// output //
		$output = sprintf(
			'<div%4$s class="et_pb_process_list_item%5$s">
				<div class="process-list-item-wrap">
					<div class="icon-wrap">%1$s</div>
					<div class="text-wrap">
						%2$s
						%3$s
					</div>
					<div class="process-triangle"></div>
				</div>
			</div> <!-- .et_pb_process_list_item -->',
			$icon,
			( '' !== $title_text ? sprintf( '<h2 class="item-title">%1$s</h2>', esc_attr( $title_text ) ) : '' ),
			$this->shortcode_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}

}
new BoomiProcessListItem();
?>