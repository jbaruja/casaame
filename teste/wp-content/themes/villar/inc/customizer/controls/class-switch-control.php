<?php
/**
 * Customizer Control: villar-switch
 *
 * @since 1.0.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'Villar_Customize_Control' ) && ! class_exists( 'Villar_Switch_Customize_Control' ) ) {
	/**
	 * Switch control
	 */
	class Villar_Switch_Customize_Control extends Villar_Customize_Control {
		/**
		 * Set the control type.
		 *
		 * @var string $type
		 */
		public $type = 'villar-switch';

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
		 *
		 * @see WP_Customize_Control::print_template()
		 *
		 * @access protected
		 */
		protected function content_template() {
			?>
            <div class="villar-switch-wrapper">
                <label>
                    <span class="villar-switch-label">{{{ data.label }}}</span>
                    <# if (data.value) { #>
                    <input class="villar-switch-control" {{{ data.link }}} type="checkbox"/>
                    <# } else { #>
                    <input class="villar-switch-control" {{{ data.link }}} checked="checked" type="checkbox"/>
                    <# } #>
                </label>
            </div>
			<?php
		}
	}
}
