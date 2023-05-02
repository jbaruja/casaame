<?php
/**
 * Footer widgets.
 */

$column_classes = [
	1 => 'w-full lg:w-1/2 p-half-gutter',
	2 => 'w-full lg:w-1/2 p-half-gutter',
	3 => 'w-full lg:w-1/3 p-half-gutter'
];

if ( is_active_sidebar( 'footer-1' ) ||
     is_active_sidebar( 'footer-2' ) ||
     is_active_sidebar( 'footer-3' ) ) :
	?>
    <div class="border-t border-light-border dark:border-dark-border relative" role="complementary">
        <div class="absolute w-full h-full top-0 left-0 opacity-60 bg-light-highlight dark:bg-dark-highlight"></div>
        <div class="container relative z-10 lg:flex mx-auto">
			<?php
			$column_count = 0;
			for ( $i = 1; $i <= 3; $i ++ ) {
				if ( is_active_sidebar( 'footer-' . $i ) ) {
					$column_count ++;
				}
			}

			$column_class = $column_classes[ $column_count ];

			for ( $i = 1; $i <= 3; $i ++ ) {
				if ( is_active_sidebar( 'footer-' . $i ) ) {
					echo '<div class="' . esc_attr( $column_class ) . '"><div class="widgets">';
					dynamic_sidebar( 'footer-' . $i );
					echo '</div></div>';
				}
			}
			?>
        </div>
    </div>
<?php endif; ?>

