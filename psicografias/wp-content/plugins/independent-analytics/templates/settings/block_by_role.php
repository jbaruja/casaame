<div class="blocked-by-role-settings settings-container">
    <h2><?php esc_html_e('Block by User Role', 'iawp'); ?></h2>
    <p><?php esc_html_e('Block specific user roles from being tracked.', 'iawp'); ?> <a
                target="_blank"
                href="https://independentwp.com/knowledgebase/data/block-user-roles/"><?php esc_html_e('Learn more', 'iawp'); ?></a></p>
    <form method='post' action='options.php' id="block-by-role-form" class="block-by-role-form">
        <input type='hidden' name='option_page' value='iawp_block_by_role_settings'/>
        <input type="hidden" name="action" value="update"/>
        <input type="hidden" name="_wp_http_referer"
               value="/wp-admin/admin.php?page=independent-analytics&tab=settings">
        <?php wp_nonce_field('iawp_block_by_role_settings-options'); ?>
        <div class="inner">
            <div class="block-by-role duplicator">
                <div class="entry">
                    <select class="new-field select" value="">
                        <?php foreach ($roles as $role => $data) {
                            if (in_array($role, $blocked)) {
                                continue;
                            }
                            echo '<option value="' . esc_attr($role) . '">' . esc_html($data['name']) . '</option>';
                        } ?>
                    </select>
                    <button class="iawp-button purple duplicate-button"><?php esc_html_e('Block Role', 'iawp'); ?></button>
                </div>
                <div class="blueprint">
                    <div class="entry">
                        <input type="text" readonly 
                            name="iawp_blocked_roles[]" 
                            id="iawp_blocked_roles[]"
                            data-option="iawp_blocked_roles"
                            value="">
                        <button class="remove iawp-button ghost-purple"><?php esc_html_e('Unblock Role', 'iawp'); ?></button>
                    </div>
                </div>
                <p class="error-message empty"><?php esc_html_e('Input is empty', 'iawp'); ?></p>
                <p class="error-message exists"><?php esc_html_e('This user role is already blocked', 'iawp'); ?></p>
            </div>
            <div class="saved">
                <h3><?php esc_html_e('Blocked User Roles', 'iawp'); ?></h3>
                <?php for ($i = 0; $i < count($blocked); $i++): ?>
                    <div class="entry">
                        <input type="text" readonly
                               name="iawp_blocked_roles[<?php esc_attr_e($i); ?>]"
                               id="iawp_blocked_roles[<?php esc_attr_e($i); ?>]"
                               data-option="iawp_blocked_roles"
                               value="<?php esc_attr_e($blocked[$i]); ?>">
                        <button class="remove iawp-button ghost-purple"><?php esc_html_e('Unblock Role', 'iawp'); ?></button>
                    </div>
                <?php endfor; ?>
                <?php if (count($blocked) === 0): ?>
                    <p class="none"><?php esc_html_e('No blocked User Roles', 'iawp'); ?></p>
                <?php endif; ?>
            </div>
            <div class="save-button-container">
                <?php submit_button(esc_html__('Save Blocked Roles', 'iawp'), 'iawp-button purple', 'save-block-by-role-settings', false); ?>
                <p class="warning-message"><span class="dashicons dashicons-warning"></span> <?php esc_html_e('Unsaved changes', 'iawp'); ?></p>
            </div>
        </div>
    </form>
</div>