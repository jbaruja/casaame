<?php
/**
 * Template part for admin welcome page.
 */

$theme_data = wp_get_theme();
?>

<div class="wrap villar-admin-page fs-section">
    <h2 class="nav-tab-wrapper">
        <a href="#"
           class="nav-tab fs-tab nav-tab-active home"><?php esc_html_e( 'Getting Started', 'villar' ); ?></a>
    </h2>

    <table class="form-table">
        <tbody>
        <tr>
            <td class="w-1/3">
                <h3><?php esc_html_e( "Theme Documentation", 'villar' ) ?></h3>
                <p>
					<?php
					esc_html_e( "It is highly recommended to start here and read the full theme documentation to learn the basics and even more details about how to use the Villar theme. It's worth spending 10 minutes to learn almost everything about this theme.", 'villar' );
					?>
                </p>
                <p class="submit">
                    <a class="button button-primary" href="https://www.wpmoose.com/docs/villar-theme-docs/"
                       target="_blank"><?php esc_html_e( 'Read Documentation', 'villar' ); ?></a>
                </p>
            </td>
            <td class="w-1/3">
                <h3><?php esc_html_e( "Theme Customizer", 'villar' ) ?></h3>
                <p>
					<?php
					esc_html_e( "All theme options are here, After reading theme Documentation we recommend you to open the Theme Customizer and play with some options.", 'villar' );
					?>
                </p>
                <p class="submit">
                    <a class="button button-primary"
                       href="<?php echo esc_url( network_admin_url( 'customize.php' ) ) ?>"
                       target="_blank"><?php esc_html_e( 'Customize Your Site', 'villar' ); ?></a>
                </p>
            </td>
            <td class="w-1/3">
                <h3><?php esc_html_e( "Theme URI", 'villar' ) ?></h3>
                <p>
					<?php
					esc_html_e( 'If you want to know more about this theme, you can also take a look at the URI of the theme.', 'villar' );
					?>
                </p>
                <p class="submit">
                    <a class="button button-primary"
                       href="<?php echo esc_url( $theme_data->get( 'ThemeURI' ) ) ?>"
                       target="_blank"><?php esc_html_e( 'Take a look', 'villar' ); ?></a>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
    <div>
        <h2><?php esc_html_e( 'Villar Pro Demos', 'villar' ); ?></h2>
        <p class="w-1/3">
			<?php esc_html_e( "Villa Pro has more powerful setup and provides 9 additional widgets with rich variants, Villar Pro allows you to easily create unique looking sites. Here are a few demos that can be installed with one click in the Pro Version.", 'villar' ); ?>
        </p>
        <p>
            <a href="<?php echo esc_url( $theme_data->get( 'ThemeURI' ) ) ?>" target="_blank">
				<?php esc_html_e( 'More Information', 'villar' ); ?>
            </a>
        </p>
    </div>

    <table class="form-table">
        <tbody>
        <tr>
            <td class="w-1/3">
                <div class="villar-demo-preview">
                    <img class="villar-demo-preview-img"
                         src="<?php echo esc_url( villar_asset_resolve( 'images/villar-minimal-blog-preview.jpg' ) ) ?>"
                         alt=""/>
                    <div class="villar-demo-preview-meta clearfix">
                        <h4 class="villar-demo-title"><?php esc_html_e( 'Minimal Blog', 'villar' ) ?></h4>
                        <a class="villar-demo-preview-link button-primary"
                           href="https://villar.ibllex.com/minimal-blog/"
                           target="_blank"><?php esc_html_e( 'Preview', 'villar' ) ?></a>
                    </div>
                </div>
            </td>
            <td class="w-1/3">
                <div class="villar-demo-preview">
                    <img class="villar-demo-preview-img"
                         src="<?php echo esc_url( villar_asset_resolve( 'images/villar-magazine-preview.jpg' ) ) ?>"
                         alt=""/>
                    <div class="villar-demo-preview-meta clearfix">
                        <h4 class="villar-demo-title"><?php esc_html_e( 'Fashion Magazine', 'villar' ) ?></h4>
                        <a class="villar-demo-preview-link button-primary" href="https://villar.ibllex.com/magazine/"
                           target="_blank"><?php esc_html_e( 'Preview', 'villar' ) ?></a>
                    </div>
                </div>
            </td>
            <td class="w-1/3">
                <div class="villar-demo-preview">
                    <img class="villar-demo-preview-img"
                         src="<?php echo esc_url( villar_asset_resolve( 'images/villar-e-commerce-preview.jpg' ) ) ?>"
                         alt=""/>
                    <div class="villar-demo-preview-meta clearfix">
                        <h4 class="villar-demo-title"><?php esc_html_e( 'E-Commerce', 'villar' ) ?></h4>
                        <a class="villar-demo-preview-link button-primary" href="https://villar.ibllex.com/ecommerce/"
                           target="_blank"><?php esc_html_e( 'Preview', 'villar' ) ?></a>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>

