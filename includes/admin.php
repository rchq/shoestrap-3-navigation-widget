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
					'desc'			=> __('Turn this ON to display the woocommerce cart menu item in the navigation bar. Default: OFF', 'shoestrap_hw'),
					'id'				=> 'nav_widget_cart_toggle',
					'default'		=> 0,
					'type'			=> 'switch',
				);
			}
	
			$fields[] = array(
				'title'				=> __('Header Background Color', 'shoestrap_nw'),
				'desc'				=> __('Select the background color for your header. Default: #EEEEEE.', 'shoestrap_nw'),
				'id'					=> 'nav_widget_bg',
				'default'			=> '#EEEEEE',
				'type'				=> 'color',
				'compiler'		=> true,
			);
	
			$fields[] = array(
				'title'				=> __('Header Text Color', 'shoestrap_nw'),
				'desc'				=> __('Select the text color for your header. Default: #333333.', 'shoestrap_nw'),
				'id'					=> 'nav_widget_color',
				'default'			=> '#333333',
				'type'				=> 'color',
				'compiler'		=> true,
			);
			
		$section['fields'] = $fields;
	
		$section = apply_filters( 'shoestrap_nw_module_options_modifier', $section );
		
		$sections[] = $section;
		return $sections;
	}
	add_filter( 'redux/options/' . REDUX_OPT_NAME . '/sections', 'shoestrap_nw_module_options' );
}
