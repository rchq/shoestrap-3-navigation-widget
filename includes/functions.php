<?php
/**
 * Adds jb_navigation_widget widget.
 */
class jb_navigation_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'jb_navigation_widget', // Base ID
			__('Shoestrap: Navigation', 'text_domain'), // Name
			array( 'description' => __( 'navigation using twitter bootstraps navigation', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $ss_settings;
		// Get menu
		
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;
		$nav_style = apply_filters( 'jb_navigation_widget_menu_style', $instance['nav_style'] );
		
		if ( !$nav_menu ) {
			return;
		} else {
			echo $args['before_widget'];
			if ( ! has_action( 'shoestrap_navigation_top_navbar_override' ) ) {
			?>
				<nav class="<?php echo $nav_style; ?>" role="navigation">
					<div class="<?php echo apply_filters( 'shoestrap_navbar_container_class', 'container' ); ?>">
						<ul class="nav nav-pills <?php echo apply_filters( 'jb_navigation_widget_menu_class', '' )?>">
							<?php 
							do_action( 'jb_pre_nav_menu_item' );
							
							wp_nav_menu( array( 'menu' => $nav_menu, 'container' => false, 'items_wrap' => '%3$s', 'fallback_cb' => false, 'menu_class' => '' ) );
							do_action( 'jb_post_nav_menu_item' );
							?>
						</ul>		
					</div>		
				</nav>
			<?php
			}
			echo $args['after_widget'];
		}
		
	}
	
	function form($instance) {
		
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		// Check values
		if( $instance) {
			$nav_style = esc_attr( $instance['nav_style'] ); 
		} else {
			$nav_style = '';
		}
		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
			return;
		} 
		?>
					
		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
				<?php
				foreach ( $menus as $menu ) {
					$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
					echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('nav_style'); ?>"><?php _e('Select Menu Style:'); ?></label>
			<select class='widefat' id="<?php echo $this->get_field_id('nav_style'); ?>" name="<?php echo $this->get_field_name('nav_style'); ?>" type="text">
				<?php
        $style_options = array(
					'navbar-default',
					'navbar-inverse'
				);
        foreach ($style_options as $option) {
        	echo '<option value="' . $option . '" id="' . $option . '"', $nav_style == $option ? ' selected="selected"' : '', '>', $option, '</option>';
        }
        ?>
			</select>                
		</p>
        
	<?php    
	}
	
	function update( $new_instance, $old_instance ) {
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		$instance['nav_style'] = $new_instance['nav_style'];
		return $instance;
	}

} // class jb_navigation_widget


// register jb_navigation_widget widget
function jb_navigation_widget_register() {
	register_widget( 'jb_navigation_widget' );
}
add_action( 'widgets_init', 'jb_navigation_widget_register' );

/**
 * Modify the nav class.
 */
function jb_navigation_widget_pull_class() {
	global $ss_settings;

	if ( $ss_settings['nav_widget_right'] == '1' ) {
		return 'pull-right';
	} else {
		return '';
	}
}
add_filter( 'jb_navigation_widget_menu_class', 'jb_navigation_widget_pull_class' );

/**
 * Register shoestrap jb_header_widget widget less styles
 */ 
function jb_navigation_widget_styles( $bootstrap ) {
	global $ss_settings;
	
	$bg					= $ss_settings['nav_widget_inverse_bg'];
	$link_color = $ss_settings['nav_widget_inverse_pill_color'];
	
	return $bootstrap . '
	//== Pills
	@navbar-inverse-bg:									' .$bg. ';
	@navbar-inverse-link-color:					' .$link_color['regular']. ';
	@navbar-inverse-link-hover-color:		' .$link_color['hover']. ';
	@navbar-inverse-link-active-color:	' .$link_color['active']. ';
	
	@nav-inverse-pills-active-link-color:					' .$link_color['regular']. ';
	@nav-inverse-pills-active-link-bg:						' .$bg. ';
	@nav-inverse-pills-active-link-active-color:	' .$link_color['active']. ';
	@nav-inverse-pills-active-link-active-bg:			@nav-inverse-pills-active-link-hover-bg;
	@nav-inverse-pills-active-link-hover-color:		' .$link_color['hover']. ';
	@nav-inverse-pills-active-link-hover-bg:			@nav-inverse-pills-active-link-bg;
	
	.navbar-inverse {
		.nav-pills {
			> li {
				& > a {
					color: @nav-inverse-pills-active-link-color;
					background-color: @nav-inverse-pills-active-link-bg;
					&:hover,
					&:focus {
						color: @nav-inverse-pills-active-link-hover-color;
						background-color: @nav-inverse-pills-active-link-hover-bg;
					}
				}
				// Active state
				&.active > a {
					&,
					&:hover,
					&:focus {
						color: @nav-inverse-pills-active-link-active-color;
						background-color: @nav-inverse-pills-active-link-hover-bg;
					}
				}
			}
		}
	}
	';
}
if ( is_active_widget( '', '', 'jb_navigation_widget' ) ) {
	add_filter( 'shoestrap_compiler', 'jb_navigation_widget_styles' );
}

/**
 * add shopping cart menu item to navigation
 */
//check if woocommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	if ( ! function_exists( 'jb_wc_cart_menu_item' ) ) {
		function jb_wc_cart_menu_item(){ 
			global $woocommerce;
			global $ss_settings;
			
			if ( $ss_settings['nav_widget_cart_toggle'] == 1 ) {
			?>
				<li>
					<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
						<i class="glyphicon glyphicon-shopping-cart"></i> <?php echo sprintf(_n('(%d)', '(%d)', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>
					</a>
				</li>
			<?php
			}
		}
	}
	add_action( 'jb_pre_nav_menu_item', 'jb_wc_cart_menu_item', 10 );
}// end check if woocommerce is active