<?php

class BoomiIconList extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Icon List', 'boomi' );
		$this->slug            = 'et_pb_icon_list';
		$this->child_slug      = 'et_pb_icon_list_item';
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
			'<div%2$s class="et_pb_module et_pb_icon_list%3$s">
				%1$s
			</div> <!-- .et_pb_icon_list -->',
			$list_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}

}
new BoomiIconList();

class BoomiIconListItem extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__( 'Item', 'et_builder' );
		$this->slug = 'et_pb_icon_list_item';
		$this->type = 'child';
		$this->child_title_var = 'admin_title';

		$this->whitelisted_fields = array(
			'icon_url',
			'icon_class',
			'icon_size',
			'icon_color',
			'icon_align',
			'use_icon_border',
			'icon_border_color',
			'icon_border_width',
			'icon_border_radius',
			'title_text',
			'content_new',
			'admin_title',
			'module_id',
			'module_class',
		);

		$this->fields_defaults = array(
			'icon_size' => array( 60 ),
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
				'label'             => esc_html__( 'Icon Color', 'et_builder' ),
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
			'icon_align' => array(
				'label'           => esc_html__( 'Icon Alignment', 'boomi' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options' => array(
					'left'   => esc_html__( 'Left', 'boomi' ),
					'top' => esc_html__( 'Top', 'boomi' ),
				),
				'description'       => esc_html__( 'Here you can choose the image alignment.', 'boomi' ),
			),		
			'use_icon_border' => array(
				'label'           => esc_html__( 'Show Border', 'boomi' ),
				'type'            => 'yes_no_button',
				'option_category' => 'layout',
				'options'         => array(
					'off' => esc_html__( 'No', 'boomi' ),
					'on'  => esc_html__( 'Yes', 'boomi' ),
				),
				'affects'           => array(
					'#et_pb_icon_border_color',
					'#et_pb_icon_border_radius',
					'#et_pb_icon_border_width',					
				),
				'description' => esc_html__( 'Here you can choose whether if the icon border should display.', 'boomi' ),
			),
			'icon_border_color' => array(
				'label'           => esc_html__( 'Border Color', 'boomi' ),
				'type'            => 'color',
				'description'     => esc_html__( 'Here you can define a custom color for the icon border.', 'boomi' ),
				'depends_default' => true,
			),
			'icon_border_width' => array(
				'label'           => esc_html__( 'Icon Border Width', 'boomi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'default'         => '2',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'depends_default' => true,
			),	
			// type
			'icon_border_radius' => array(
				'label'           => esc_html__( 'Icon Border Radius', 'boomi' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'default'         => '5',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'depends_default' => true,
			),				
			'title_text' => array(
				'label'           => esc_html__( 'Icon Title Text', 'boomi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'This defines the HTML Title text for the icon text field.', 'boomi' ),
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'boomi' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Here you can create the content that will show next to the icon.', 'boomi' ),
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
		$icon_align = $this->shortcode_atts['icon_align'];
		$title_text = $this->shortcode_atts['title_text'];
		$use_border = $this->shortcode_atts['use_icon_border'];
		$border_color = $this->shortcode_atts['icon_border_color'];
		$border_width = $this->shortcode_atts['icon_border_width'];
		$border_radius = $this->shortcode_atts['icon_border_radius'];								

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
		
		// icon size //
		if ( '' !== $icon_size ) {
			
			if ($use_border==='on') :
				$icon_size=$icon_size-($border_width*2);
			endif;
			
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
		
		// icon border //		
		if ($use_border==='on') {
			// icon url set border, otherwise it's before //
			if ($icon_url!='') :
				$before='';
			else: 
				$before=':before';
			endif;
			
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .icon'.$before,
				'declaration' => sprintf(
					'border: %1$s %3$s %2$s;
					border-radius: %4$spx;',
					esc_attr(et_builder_process_range_value($border_width)),
					esc_attr($border_color),
					esc_attr('solid'),
					esc_attr($border_radius)
				),
			) );
		}
				
		// alignment //
		$icon_wrap_class='icon-align-'.esc_html( $icon_align );
		
		// output //
		$output = sprintf(
			'<div%4$s class="et_pb_icon_list_item%5$s">
				<div class="icon-wrap %6$s">%1$s</div>
				<div class="text-wrap">
					%2$s
					%3$s
				</div>
			</div> <!-- .et_pb_icon_list -->',
			$icon,
			( '' !== $title_text ? sprintf( '<h4>%1$s</h4>', esc_attr( $title_text ) ) : '' ),
			$this->shortcode_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			$icon_wrap_class
		);

		return $output;
	}

}
new BoomiIconListItem();
?>