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
		
		if ( !$nav_menu ) {
			return;
		} else {
			echo $args['before_widget'];
			if ( ! has_action( 'shoestrap_navigation_top_navbar_override' ) ) {
			?>
				<nav class="navbar-inverse" role="navigation">
					<div class="<?php echo apply_filters( 'shoestrap_navbar_container_class', 'container' ); ?>">
          	<ul class="nav nav-pills">
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
		 
		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
			return;
		} 
		?>
					
		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
				<?php
        foreach ( $menus as $menu ) {
					$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
					echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
				}
				?>
			</select>
		</p>
        
	<?php    
	}
	
	function update( $new_instance, $old_instance ) {
    $instance['nav_menu'] = (int) $new_instance['nav_menu'];
    return $instance;
  }

} // class jb_navigation_widget


// register jb_navigation_widget widget
function jb_navigation_widget_register() {
	register_widget( 'jb_navigation_widget' );
}
add_action( 'widgets_init', 'jb_navigation_widget_register' );

// add shopping cart menu item to navigation
//check if woocommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	if ( ! function_exists( 'jb_wc_cart_menu_item' ) ) {
		function jb_wc_cart_menu_item(){ 
			global $woocommerce;
			global $ss_settings;
			
			if ( shoestrap_getVariable( 'nav_widget_cart_toggle' ) == 1 ) {
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
