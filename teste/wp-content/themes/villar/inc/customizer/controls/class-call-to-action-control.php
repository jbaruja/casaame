<?php
/**
 * Customizer Control: villar-call-to-action
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'Villar_Customize_Control' ) && ! class_exists( 'Villar_Call_To_Action_Customize_Control' ) ) {
	class Villar_Call_To_Action_Customize_Control extends Villar_Customize_Control {
		/**
		 * Set the control type.
		 *
		 * @var string $type
		 */
		public $type = 'villar-call-to-action';

		/**
		 * @var string
		 */
		public $action_label;

		/**
		 * @var string
		 */
		public $action_type;

		/**
		 * @var string
		 */
		public $action_target;

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @see WP_Customize_Control::to_json()
		 */
		public function to_json() {
			parent::to_json();

			$this->json['action_label']  = $this->action_label;
			$this->json['action_type']   = $this->action_type;
			$this->json['action_target'] = $this->action_target;
		}

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
		 *
		 * @return void
		 * @see WP_Customize_Control::print_template()
		 * @since 1.0.0
		 */
		protected function content_template() {
			?>
            <# if (data.action_type === 'customize') { #>
            <button type="button" data-target="{{{data.action_target}}}" class="villar-cta-button button">
                {{{data.action_label}}}
            </button>
            <# } else if (data.action_type === 'url') { #>
            <a href="{{{data.action_target}}}" target="_blank">{{{data.action_label}}}</a>
            <# } #>
			<?php
		}
	}
}