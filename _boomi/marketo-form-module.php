<?php

class Marketo_Form_Module extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__( 'Marketo Form', 'boomi' );
		$this->slug = 'et_pb_marketo_form';

		$this->whitelisted_fields = array(
			'form_ids',
			'thank_you_url',
			'additional_forms_popup',
			'background_color',
			'align',
			'admin_label',
			'module_id',
			'module_class',
		);
		
		$this->fields_defaults = array(
			'align' => array( 'left' ),
		);		
		
		$this->advanced_options = array(
			'border' => array(),
		);		
	}

	function get_fields() {
		$fields = array(
			'form_ids' => array(
				'label'             => esc_html__('Form IDs', 'boomi'),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Enter the form IDs. For multiple IDs separate them by a comma (,)', 'boomi' ),
			),
			'thank_you_url' => array(
				'label'           => esc_html__( 'Thank You URL', 'boomi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Insert the URL of the thank you page. The default will be the one set in Marketo', 'boomi' ),
			),
			'additional_forms_popup' => array(
				'label'           => esc_html__( 'Additional Forms Popup', 'boomi' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'yes'   => esc_html__( 'Yes', 'et_builder' ),
				),
				'option_category' => 'configuration',
				'description'     => esc_html__( 'This will enable additional forms to popup in a lightbox.', 'boomi' ),
			),
			'background_color' => array(
				'label'             => esc_html__( 'Background Color', 'boomi' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'align' => array(
				'label'           => esc_html__( 'Form Alignment', 'boomi' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options' => array(
					'left'   => esc_html__( 'Left', 'boomi' ),
					'center' => esc_html__( 'Center', 'boomi' ),
					'right'  => esc_html__( 'Right', 'boomi' ),
				),
				'description'       => esc_html__( 'Here you can choose the form alignment.', 'boomi' ),
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
		$form_ids = $this->shortcode_atts['form_ids'];
		$background_color=$this->shortcode_atts['background_color'];
		$align=$this->shortcode_atts['align'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		
		$html='';
		
		// form bg color //
		if ('' !== $background_color) :
			ET_Builder_Element::set_style($function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html($background_color)
				),
			) );
		endif;	
		
		// align //
		if ( 'center' == $align ) :
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mktoForm',
				'declaration' => sprintf(
					'margin: 0 auto;'
				),
			) );
		elseif ($align=='right') :
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .mktoForm',
				'declaration' => sprintf(
					'float: right;'
				),
			) );
		endif;
		
		// padding if border //
		if ($this->shortcode_atts['use_border_color']=='on') :
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'padding: 15px;'
				),
			) );
		endif;	
		
		$html.='<div id="JSFormSection" class="form-section"></div>';
		$html.='<script src="//app-aba.marketo.com/js/forms2/js/forms2.min.js"></script>';
		$html.='<div class="" id="MarketoformIDs" style="display:none;">'.$form_ids.'</div>';

		// create output //
		$output = sprintf(
			'<div class="et_pb_marketo_form_wrapper">
				<div%3$s class="%1$s%4$s">
					%2$s
				</div>
			</div>',
			'clearfix et_pb_module et_pb_bg_layout_light',
			$html,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s ', esc_attr( $module_class ) ) : '' )
		);
		
		$args=array(
			'thankYouURL' => $this->shortcode_atts['thank_you_url'],
			'secondaryFormsLightbox' => $this->shortcode_atts['additional_forms_popup'],
		);
		wp_localize_script('boomi-cms-marketo-form-module', 'MarketoFormOpts', $args);
		
		wp_enqueue_script('boomi-cms-marketo-form-module');

		return $output;
	}

}

new Marketo_Form_Module();
?>