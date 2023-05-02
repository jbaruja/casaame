<?php
/**
 * Customizer Base Control.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Villar_Customize_Control' ) ) {
	/**
	 * Base Control
	 *
	 * @since 1.0.0
	 */
	class Villar_Customize_Control extends \WP_Customize_Control {

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @return void
		 * @see WP_Customize_Control::to_json()
		 * @since 1.0.0
		 */
		public function to_json() {
			parent::to_json();

			// Default value.
			if ( is_object( $this->setting ) ) {
				$this->json['default'] = $this->setting->default;
			}

			if ( isset( $this->default ) ) {
				$this->json['default'] = $this->default;
			}

			// Settings
			foreach ( $this->json['settings'] as $key => $setting ) {
				$this->json[ $key ]              = $this->value( $key );
				$this->json[ $key . '_link' ]    = $this->get_link( $key );
				$this->json[ $key . '_default' ] = $this->settings[ $key ]->default;
			}

			// input_attrs
			$this->json['input_attrs'] = $this->input_attrs;

			// Value.
			$this->json['value'] = $this->value();

			// Choices.
			$this->json['choices'] = $this->choices;

			// The link.
			$this->json['link'] = $this->get_link();

			// The ID.
			$this->json['id'] = $this->id;

			// The ajaxurl in case we need it.
			$this->json['ajaxurl'] = admin_url( 'admin-ajax.php' );
		}

		/**
		 * Show template for control title and description.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function label_template() {
			?>
            <label class="customizer-text">
                <# if ( data.label ) { #><span class="customize-control-title">{{{data.label }}}</span><# } #>
                <# if ( data.description ) { #><p class="description">{{{data.description }}}</p><# } #>
            </label>
			<?php
		}

		/**
		 * Show control title and description.
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function label_content() {
			?>
            <label class="customizer-text">
				<?php if ( isset( $this->label ) && '' !== $this->label ): ?>
                    <span class="customize-control-title">
                        <?php echo esc_html( $this->label ); ?>
                    </span>
				<?php endif; ?>

				<?php if ( isset( $this->description ) && '' !== $this->description ): ?>
                    <p class="description">
						<?php echo esc_html( $this->description ); ?>
                    </p>
				<?php endif; ?>
            </label>
			<?php
		}

		/**
		 * Render the control's content.
		 *
		 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
		 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
		 *
		 * @return void
		 * @since 1.0.0
		 */
		protected function render_content() {
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
		}
	}
}