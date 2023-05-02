<?php
/**
 * Template for admin notice.
 */

global $current_user;
$user_id = $current_user->ID;

if ( get_user_meta( $user_id, 'villar_dismissed_welcome' ) ) {
	return;
}
$dismiss_url = add_query_arg( array( 'villar_dismiss' => 'welcome', ), admin_url() );
?>

<div class="villar-notice notice notice-success is-dismissible">
    <div class="welcome-message">
        <h1><?php esc_html_e( 'Welcome to Villar Theme', 'villar' ); ?></h1>
        <p>
			<?php esc_html_e( "First time using our villar theme?", 'villar' ); ?>
            <br/>
			<?php esc_html_e( "We've provided some useful information to help you setup with this theme.", 'villar' ) ?>
        </p>

        <div class="action-buttons">
            <a href="<?php echo esc_url( admin_url( 'themes.php?page=villar' ) ); ?>"
               class="villar-btn">
				<?php esc_html_e( 'Get Started with Villar', 'villar' ); ?>
            </a>
            <a href="<?php echo esc_url( $dismiss_url ) ?>" class="villar-btn">
				<?php esc_html_e( 'Dismiss This Message', 'villar' ); ?>
            </a>
        </div>
    </div>
</div>
