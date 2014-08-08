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
				'id'					=> 'nav_widget_inverse_bg',
				'type'				=> 'color',
				'title'				=> __('Inverse Navigation Background Color', 'shoestrap_nw'),
				'desc'				=> __('Select the background color for your inverse navigation. Default: #EEEEEE.', 'shoestrap_nw'),
				'compiler'		=> true,
				'default'			=> '#EEEEEE',
			);
			
			$fields[] = array(
				'id'					 => 'nav_widget_inverse_pill_color',
				'type'				=> 'link_color',
				'title'				=> __('Inverse Pill Navigation Color Option', 'shoestrap_nw'),
				'compiler'		=> true,
				'default'			=> array(
						'regular'		=> '#428bca', // blue
						'hover'			=> '#2a6496', // red
						'active'		=> '#2a6496', // purple
						'visited'		=> '#2a6496'  // purple
				),
			);
			
		$section['fields'] = $fields;
	
		$section = apply_filters( 'shoestrap_nw_module_options_modifier', $section );
		
		$sections[] = $section;
		return $sections;
	}
	add_filter( 'redux/options/' . REDUX_OPT_NAME . '/sections', 'shoestrap_nw_module_options' );
}
