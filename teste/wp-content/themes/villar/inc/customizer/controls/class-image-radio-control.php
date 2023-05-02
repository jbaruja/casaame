<?php
/**
 * Customizer Control: villar-image-radio-button
 *
 * @since 1.0.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'Villar_Customize_Control' ) && ! class_exists( 'Villar_Image_Radio_Button_Customize_Control' ) ) {
	/**
	 * Radio Image control.
	 */
	class Villar_Image_Radio_Button_Customize_Control extends Villar_Customize_Control {
		/**
		 * Set the control type.
		 *
		 * @var string $type
		 */
		public $type = 'villar-image-radio-button';

		/**
		 * Controls of each option
		 *
		 * @var array
		 */
		public $subcontrols;

		/**
		 * Toggle subcontrols when control ready.
		 *
		 * @var bool
		 */
		public $should_init;

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @see WP_Customize_Control::to_json()
		 */
		public function to_json() {
			parent::to_json();

			$this->json['subcontrols'] = $this->subcontrols;
			$this->json['should_init'] = $this->should_init;
		}

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
		 *
		 * @return void
		 * @see WP_Customize_Control::print_template()
		 * @since 1.0.6
		 */
		protected function content_template() {
			$this->label_template();
			?>
            <div id="control_{{ data.id }}" class="villar-image-radio-button-control">
                <# for(key in data.choices) { #>
                <# var value = data.choices[key] #>
                <label for="{{ data.id }}{{ key }}" class="radio-button-label {{{ data.id + key }}}">
                    <input
                            type="radio" {{{ data.link }}}
                            id="{{ data.id }}{{ key }}"
                            name="_customize-image-radio-{{ data.id }}"
                            value="{{key}}" <# if ( data.value === key ) { #> checked="checked"<# } #>
                    />
                    <img src="{{value.image}}" alt="{{value.name}}" title="{{value.name}}"/>
                </label>
                <# } #>
            </div>
			<?php
		}
	}
}