<div class="iawp-notice <?php esc_attr_e($notice); ?>">
    <div class="icon">
        <span class="dashicons dashicons-warning"></span>
    </div>
    <div class="message">
        <p><span class="message-text"><?php esc_html_e($notice_text); ?></span> <a href="<?php echo esc_url($url); ?>" class="link-white" target="_blank"><?php esc_html_e('Learn More', 'iawp'); ?></a></p>
    </div>
    <?php if ($button_text) : ?>
        <div>
            <button id="dismiss-notice" class="iawp-button white"><?php esc_html_e($button_text); ?></button>
        </div>
    <?php endif; ?>
</div>