<div class="export-settings settings-container">
    <h2><?php esc_html_e('Export', 'iawp'); ?></h2>
    <div class="button-group">
        <button id="iawp-export-views"
                class="iawp-button ghost-purple"><?php esc_html_e('Export views', 'iawp'); ?></button>
        <button id="iawp-export-referrers"
                class="iawp-button ghost-purple"><?php esc_html_e('Export referrers', 'iawp'); ?></button>
        <button id="iawp-export-geo"
                class="iawp-button ghost-purple"><?php esc_html_e('Export geo', 'iawp'); ?></button>
        <?php if (iawp_is_pro()): ?>
            <button id="iawp-export-campaigns"
                    class="iawp-button ghost-purple"><?php esc_html_e('Export campaigns', 'iawp'); ?></button>
        <?php endif; ?>
    </div>
</div>