<?php


/*
 * Shoestrap 3 Extra Widget areas options
 */
if ( !function_exists( 'shoestrap_nw_module_options' ) ) {
	function shoestrap_nw_module_options( $sections ) {
	
	
		$section = array(
			'title' => __( 'Navigation Widget', 'shoestrap_nw' ),
			'icon'  => 'el-icon-check-empty  '
		);
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				$fields[] = array(
					'title'			=> __('Cart Menu Item Toggle', 'shoestrap_hw'),
					'desc'      	=> __('Turn this ON to display the woocommerce cart menu item in the navigation bar. Default: OFF', 'shoestrap_hw'),
					'id'        	=> 'nav_widget_cart_toggle',
					'default'     => 0,
					'type'      	=> 'switch',
				);
			}
	
			$fields[] = array(
				'title'      => __('Display the Header.', 'shoestrap_nw'),
				'desc'      => __('Turn this ON to display the header. Default: OFF', 'shoestrap'),
				'id'        => 'header_widget_toggle',
				'customizer'=> array(),
				'std'       => 0,
				'type'      => 'switch'
			);
			
			$fields[] = array(
				'title'      => __('Display branding on your Header.', 'shoestrap_nw'),
				'desc'      => __('Turn this ON to display branding (Sitename or Logo)on your Header. Default: ON', 'shoestrap_nw'),
				'id'        => 'header_widget_branding',
				'customizer'=> array(),
				'std'       => 1,
				'type'      => 'switch',
				'fold'      => 'header_widget_toggle'
			);
	
			$fields[] = array(
				'title'      => __('Header Background Color', 'shoestrap_nw'),
				'desc'      => __('Select the background color for your header. Default: #EEEEEE.', 'shoestrap_nw'),
				'id'        => 'header_widget_bg',
				'std'       => '#EEEEEE',
				'customizer'=> array(),
				'type'      => 'color',
				'fold'      => 'header_widget_toggle'
			);
	
			$fields[] = array(
				'title'      => __('Header Text Color', 'shoestrap_nw'),
				'desc'      => __('Select the text color for your header. Default: #333333.', 'shoestrap_nw'),
				'id'        => 'header_widget_color',
				'std'       => '#333333',
				'customizer'=> array(),
				'type'      => 'color',
				'fold'      => 'header_widget_toggle'
			);
	
			$fields[] = array(
				'title'      => __('Display the Header Margins.', 'shoestrap_nw'),
				'desc'      => __('Turn this ON to display the header margins. Default: OFF', 'shoestrap'),
				'id'        => 'header_margin_widget_toggle',
				'customizer'=> array(),
				'std'       => 0,
				'type'      => 'switch'
			);
	
			$fields[] = array(
				'title'      => __('Header Top Margin', 'shoestrap_nw'),
				'desc'      => __('Select the top margin of header in pixels. Default: 0px.', 'shoestrap_nw'),
				'id'        => 'header_widget_margin_top',
				'std'       => 1,
				'min'       => 1,
				'max'       => 200,
				'type'      => 'slider',
				'fold'      => 'header_margin_widget_toggle'
			);
	
			$fields[] = array(
				'title'      => __('Header Bottom Margin', 'shoestrap_nw'),
				'desc'      => __('Select the bottom margin of header in pixels. Default: 0px.', 'shoestrap_nw'),
				'id'        => 'header_widget_margin_bottom',
				'std'       => 1,
				'min'       => 1,
				'max'       => 200,
				'type'      => 'slider',
				'fold'      => 'header_margin_widget_toggle'
			);
			
		$section['fields'] = $fields;
	
		$section = apply_filters( 'shoestrap_nw_module_options_modifier', $section );
		
		$sections[] = $section;
		return $sections;
	}
	add_filter( 'redux/options/' . REDUX_OPT_NAME . '/sections', 'shoestrap_nw_module_options' );
}
