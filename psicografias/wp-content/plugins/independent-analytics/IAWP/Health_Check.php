<?php

namespace IAWP_SCOPED\IAWP;

class Health_Check
{
    const REST_LAST_HEALTHY_AT = 'iawp_rest_last_healthy_at';
    private $error;
    public function __construct()
    {
        $this->error = $this->plugin_health_check();
        // Only run the rest check if the plugin checks have passed
        if (!isset($this->error) && $this->should_run_rest_health_check()) {
            $rest_error = $this->rest_health_check();
            if (isset($rest_error)) {
                $this->error = $rest_error;
                $this->update_wp_option(\false);
            } else {
                $this->update_wp_option(\true);
            }
        }
    }
    public function healthy() : bool
    {
        return empty($this->error);
    }
    public function error() : ?string
    {
        return $this->error;
    }
    private function update_wp_option($healthy)
    {
        if ($healthy) {
            $now = new \DateTime('now');
            \delete_option(self::REST_LAST_HEALTHY_AT);
            \add_option(self::REST_LAST_HEALTHY_AT, $now->format('c'));
        } else {
            \delete_option(self::REST_LAST_HEALTHY_AT);
        }
    }
    /**
     * @return string|null Returns a string error message if the health check fails
     */
    private function plugin_health_check() : ?string
    {
        $active_plugins = \get_option('active_plugins');
        if (\in_array('disable-wp-rest-api/disable-wp-rest-api.php', $active_plugins)) {
            return \__('The "Disable WP REST API" plugin needs to be deactivated because Independent Analytics uses the REST API to record visits.', 'iawp');
        }
        if (\in_array('all-in-one-wp-security-and-firewall/wp-security.php', $active_plugins)) {
            $settings = \get_option('aio_wp_security_configs', []);
            if (\array_key_exists('aiowps_disallow_unauthorized_rest_requests', $settings)) {
                if ($settings['aiowps_disallow_unauthorized_rest_requests'] == 1) {
                    return \__('The "All In One WP Security" plugin is blocking REST API requests, which Independent Analytics needs to record views. Please disable this setting via the WP Security > Miscellaneous menu.', 'iawp');
                }
            }
        }
        if (\in_array('disable-json-api/disable-json-api.php', $active_plugins)) {
            $settings = \get_option('disable_rest_api_options', []);
            if (\array_key_exists('roles', $settings)) {
                if ($settings['roles']['none']['default_allow'] == \false) {
                    if ($settings['roles']['none']['allow_list']['/iawp/search'] == \false) {
                        return \__('The "Disable REST API" plugin is blocking REST API requests for unauthenticated users, which Independent Analytics needs to record views. Please enable the /iawp/search route, so Independent Analytics can track your visitors.', 'iawp');
                    }
                }
            }
        }
        if (\in_array('disable-xml-rpc-api/disable-xml-rpc-api.php', $active_plugins)) {
            $settings = \get_option('dsxmlrpc-settings');
            if (\array_key_exists('json-rest-api', $settings)) {
                if ($settings['json-rest-api'] == 1) {
                    return \__('The "Disable XML-RPC-API" plugin is blocking REST API requests, which Independent Analytics needs to record views. Please visit the Security Settings menu and turn off the "Disable JSON REST API" option, so Independent Analytics can track your visitors.', 'iawp');
                }
            }
        }
        if (\in_array('wpo-tweaks/wordpress-wpo-tweaks.php', $active_plugins)) {
            return \__('The "WPO Tweaks & Optimizations" plugin needs to be deactivated because it is disabling the REST API, which Independent Analytics uses to record visits.', 'iawp');
        }
        if (\in_array('all-in-one-intranet/basic_all_in_one_intranet.php', $active_plugins)) {
            return \__('The "All-In-One Intranet" plugin needs to be deactivated because it is disabling the REST API, which Independent Analytics uses to record visits. You may want to try the "My Private Site" plugin instead.', 'iawp');
        }
        return null;
    }
    private function rest_health_check() : ?string
    {
        $url = \get_rest_url() . 'iawp/search';
        $request = \wp_remote_post($url);
        // Skip the health check if the REST API has been put behind authentication
        // This would only impact people who added custom code to block REST access and have a password-protected site
        if (\wp_remote_retrieve_response_code($request) === 401) {
            return null;
        }
        if (\is_wp_error($request) || \wp_remote_retrieve_response_code($request) !== 200 || \wp_remote_retrieve_header($request, 'X-IAWP') !== 'IAWP') {
            return \__('It looks like you\'re blocking REST API requests with a plugin or code snippet. The REST API needs to be enabled because this is how Independent Analytics records visits.', 'iawp');
        }
        return null;
    }
    private function should_run_rest_health_check() : bool
    {
        try {
            $last_healthy_at = \get_option(self::REST_LAST_HEALTHY_AT, \date('c', 0));
            $last_healthy_at = new \DateTime($last_healthy_at);
        } catch (\Exception $e) {
            return \true;
        }
        $now = new \DateTime();
        $diff = $last_healthy_at->diff($now);
        $hours_ago = $diff->h + $diff->days * 24;
        return $hours_ago >= 1;
    }
}
