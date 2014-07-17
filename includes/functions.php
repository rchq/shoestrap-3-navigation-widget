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

		echo $args['before_widget'];
		if ( ! has_action( 'shoestrap_navigation_top_navbar_override' ) ) : ?>
      <nav class="navbar-inverse" role="navigation">
        <div class="container">
          <?php global $woocommerce; ?>
          <ul class="nav nav-pills">
            <li>
              <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
                <i class="glyphicon glyphicon-shopping-cart"></i> <?php echo sprintf(_n('(%d)', '(%d)', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>
              </a>
            </li>
            <?php
              if (has_nav_menu('primary_navigation')) :
                wp_nav_menu(array( 'container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'tertiary_navigation', 'menu_class' => ''));
              endif;
            ?>
          </ul>		
        </div>		
      </nav>
		<?php endif;
		echo $args['after_widget'];
	}

} // class jb_navigation_widget

if ( ! function_exists( 'woocommerce_template_single_meta' ) ) :
	function woocommerce_template_single_meta() {
		wc_get_template( 'lib/cart.php' );
	}
endif;