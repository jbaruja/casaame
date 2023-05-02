<?php
/**
 * Customizer Control: villar-sortable
 *
 * @since 1.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'Villar_Customize_Control' ) && ! class_exists( 'Villar_Sortable_Customize_Control' ) ) {
	/**
	 * Tabs control
	 */
	class Villar_Sortable_Customize_Control extends Villar_Customize_Control {
		/**
		 * Set the control type.
		 *
		 * @var string $type
		 */
		public $type = 'villar-sortable';

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @see WP_Customize_Control::to_json()
		 */
		public function to_json() {
			parent::to_json();
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
            <div class='villar-sortable'>
				<?php $this->label_template(); ?>
                <ul class="sortable">
                    <# _.each( data.value, function( id ) { #>
                    <# if ( data.choices[ id ] && ! data.choices[ id ][ 'disabled' ] ) { #>
                    <li {{{ data.inputAttrs }}} class='villar-sortable-item' data-value='{{ id }}'>
                        <i class="dashicons dashicons-visibility visibility"></i>
                        <span>{{{ data.choices[ id ]['label'] }}}</span>
                        <i class='dashicons dashicons-menu'></i>
                        <# if (data.choices[ id ][ 'description' ]) { #>
                        <div class="villar-sortable-item-description">{{ data.choices[ id ][ 'description' ] }}</div>
                        <# } #>
                    </li>
                    <# } #>
                    <# }); #>

                    <# _.each( data.choices, function( choiceLabel, id ) { #>
                    <# if ( Array.isArray(data.value) && (-1 === data.value.indexOf( id ) || data.choices[ id ][
                    'disabled' ]) ) { #>
                    <li {{{ data.inputAttrs }}}
                        class='villar-sortable-item invisible'
                        data-value='{{ id }}'
                        data-disabled="{{ data.choices[ id ][ 'disabled' ] }}">
                        <i class="dashicons dashicons-hidden visibility"></i>
                        <span>{{{ data.choices[ id ]['label'] }}}</span>
                        <i class='dashicons dashicons-menu'></i>
                        <# if (data.choices[ id ][ 'description' ]) { #>
                        <div class="villar-sortable-item-description">{{ data.choices[ id ][ 'description' ] }}</div>
                        <# } #>
                    </li>
                    <# } #>
                    <# }); #>
                </ul>
            </div>
			<?php
		}
	}
}
