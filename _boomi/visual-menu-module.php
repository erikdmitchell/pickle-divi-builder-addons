<?php

class BoomiVisualMenu extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Visual Menu', 'boomi' );
		$this->slug            = 'et_pb_visual_menu';
		$this->child_slug      = 'et_pb_visual_menu_item';
		$this->child_item_text = esc_html__( 'Item', 'boomi' );
		$this->fullwidth       = true;

		$this->whitelisted_fields = array(
			'admin_label',
			'module_id',
			'module_class',
		);
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
		global $visual_menu_slide_counter;
		global $visual_menu_slide_titles;
		
		$module_id = $this->shortcode_atts['module_id'];
		$module_class = $this->shortcode_atts['module_class'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		// build controls //
		$controls='';
		$i=0;
		
		if (!empty($visual_menu_slide_titles)) :
			foreach ($visual_menu_slide_titles as $title) :
				++$i;
				$controls.=sprintf('<a href="%4$s" class="%1$s%2$s">%3$s</a>',
					"vm-control-$i",
					(1==$i ? ' vm-active-control' : '' ),
					esc_html($title['title']),
					esc_url($title['url'])
				);
			endforeach;
		endif;

		// gen output //
		$output = sprintf(
			'<div%3$s class="visual-menu slider%4$s">
				<div class="vm-slides">
					%1$s
					
					<div class="vm-container controls clearfix">
						<div class="vm-controllers" style="display: block;">
							%2$s
						</div>
					</div>
					
				</div>
			</div> <!-- .visual-menu -->',
			$this->shortcode_content,
			$controls,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);
		
		wp_enqueue_script('boomi-cms-visual-menu-module');

		return $output;
	}

}
new BoomiVisualMenu();

class BoomiVisualMenuItem extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__( 'Item', 'et_builder' );
		$this->slug = 'et_pb_visual_menu_item';
		$this->type = 'child';
		$this->child_title_var = 'admin_title';

		$this->whitelisted_fields = array(
			'title',
			'content',
			'background_image_url',
			'background_position',
			'url',			
			'admin_title',
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
				'description'     => esc_html__( 'This defines the Title text for the icon text field.', 'boomi' ),
			),
			'content' => array(
				'label'           => esc_html__( 'Content', 'boomi' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Here you can create the content.', 'boomi' ),
			),
			'background_image_url' => array(
				'label'              => esc_html__( 'Image', 'et_builder' ),
				'type'               => 'upload',
				'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder' ),
			),			
			'background_position' => array(
				'label'           => esc_html__( 'Background Image Position', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options' => array(
					'default'       => esc_html__( 'Default', 'et_builder' ),
					'top_left'      => esc_html__( 'Top Left', 'et_builder' ),
					'top_center'    => esc_html__( 'Top Center', 'et_builder' ),
					'top_right'     => esc_html__( 'Top Right', 'et_builder' ),
					'center_right'  => esc_html__( 'Center Right', 'et_builder' ),
					'center_left'   => esc_html__( 'Center Left', 'et_builder' ),
					'bottom_left'   => esc_html__( 'Bottom Left', 'et_builder' ),
					'bottom_center' => esc_html__( 'Bottom Center', 'et_builder' ),
					'bottom_right'  => esc_html__( 'Bottom Right', 'et_builder' ),
				)
			),
			'background_size' => array(
				'label'           => esc_html__( 'Background Image Size', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'default' => esc_html__( 'Default', 'et_builder' ),
					'contain' => esc_html__( 'Fit', 'et_builder' ),
					'initial' => esc_html__( 'Actual Size', 'et_builder' ),
				)
			),
			'url' => array(
				'label'           => esc_html__( 'Link URL', 'boomi' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input the link or leave blank for no link.', 'boomi' ),
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
		global $visual_menu_slide_counter;
		global $visual_menu_slide_titles;
		
		$module_id = $this->shortcode_atts['module_id'];
		$module_class = $this->shortcode_atts['module_class'];
		$title = $this->shortcode_atts['title'];
		$content = $this->shortcode_atts['content'];
		$background_image_url = $this->shortcode_atts['background_image_url'];
		$background_position = $this->shortcode_atts['background_position']; // this does nothing //
		$background_size = $this->shortcode_atts['background_size']; // this does nothing //
		$url = $this->shortcode_atts['url'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
		
		$visual_menu_slide_counter++;
		
		$visual_menu_slide_titles[]=array(
			'title' => esc_attr($title),
			'url' => esc_url($url)
		);

		// background image //
		if ( '' !== $background_image_url) {		
			ET_Builder_Module::set_style( $function_name, array(
				'selector'    => '%%order_class%%',
				'declaration' => sprintf(
					'background-image: url(%1$s);',
					esc_html($background_image_url)
				),
			) );
		}

/*
		if ( 'default' !== $background_position) {
			$processed_position = str_replace( '_', ' ', $background_position );

			ET_Builder_Module::set_style( $function_name, array(
				'selector'    => '%%order_class%% .vm-slide',
				'declaration' => sprintf(
					'background-position: %1$s;',
					esc_html( $processed_position )
				),
			) );
		}
*/

/*
		if ( 'default' !== $background_size) {
			ET_Builder_Module::set_style( $function_name, array(
				'selector'    => '%%order_class%% .vm-slide',
				'declaration' => sprintf(
					'-moz-background-size: %1$s;
					-webkit-background-size: %1$s;
					background-size: %1$s;',
					esc_html( $background_size )
				),
			) );
		}
*/

		// output //
		$output = sprintf(
			'<div%1$s class="vm-slide%3$s%4$s%2$s">
				<div class="vm-container clearfix">
					<div class="vm-description">
						%5$s
						<div class="vm-content">
							%6$s
						</div>
						<a href="%7$s" class="vm-button more-button">Learn More</a>
					</div>
				</div>
			</div> <!-- .et_pb_process_list_item -->',
			('' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			('' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			(' vm-slide-'.$visual_menu_slide_counter),
			(1 == $visual_menu_slide_counter ? ' vm-active-slide' : '' ),
			( '' !== $text ? sprintf( '<h2 class="vm-title"><a href="%2$s">%1$s</a></h2>', esc_attr($title), esc_url($url) ) : ''),
			strip_tags($this->shortcode_content, '<h1><h4>'),
			esc_url($url)
		);

		return $output;
	}

}
new BoomiVisualMenuItem();
?>