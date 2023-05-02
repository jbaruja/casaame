<?php
/**
 * Customizer Control: villar-info
 *
 * @since 1.0.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'Villar_Customize_Control' ) && ! class_exists( 'Villar_Info_Customize_Control' ) ) {
	/**
	 * Tabs control
	 */
	class Villar_Info_Customize_Control extends Villar_Customize_Control {
		/**
		 * Set the control type.
		 *
		 * @var string $type
		 */
		public $type = 'villar-info';

		/**
		 * @var array
		 */
		public $messages = array();

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @see WP_Customize_Control::to_json()
		 */
		public function to_json() {
			parent::to_json();

			$this->json['messages'] = $this->messages;
		}

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
            <div class="villar-info">
                <# _.each(data.messages, function(msg) { #>
                <div class="villar-info-item">{{{msg}}}</div>
                <# }); #>
            </div>
			<?php
		}
	}
}
