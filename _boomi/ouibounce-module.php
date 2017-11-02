<?php

class Ouibounce_Module extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__( 'Ouibounce Modal', 'boomi' );
		$this->slug = 'et_pb_ouibounce';

		$this->whitelisted_fields = array(
			'modal_id',
			'admin_label',
			'module_class',
		);
		
		$this->fields_defaults = array();		
		
		$this->advanced_options = array();		
	}

	function get_fields() {
		$fields = array(
			'modal_id' => array(
				'label'            => esc_html__( 'Modal', 'boomi' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options' 		   => boomi_et_builder_modals_option(),
				'description'      => esc_html__( 'Choose which modal you would like to use.', 'boomi' ),
			),			
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'boomi' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'boomi' ),
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
		$html='';
		$module_class = $this->shortcode_atts['module_class'];
		$modal_id = $this->shortcode_atts['modal_id'];
		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		$post=get_post($modal_id);

		// create output //
		$output = sprintf(
			'<div id="ouibounce-modal" class="%2$s">
				<div class="underlay"></div>
				<div class="modal">
					%1$s
				</div>
			</div>',
			apply_filters('the_content', $post->post_content),
			( '' !== $module_class ? sprintf( ' %1$s ', esc_attr( $module_class ) ) : '' )
		);
		
/*
		$args=array(
			'thankYouURL' => $this->shortcode_atts['thank_you_url'],
			'secondaryFormsLightbox' => $this->shortcode_atts['additional_forms_popup'],
		);
		wp_localize_script('boomi-cms-marketo-form-module', 'MarketoFormOpts', $args);
*/
		
		wp_enqueue_script('boomi-cms-ouibounce-module');

		return $output;
	}

}

new Ouibounce_Module();
?>