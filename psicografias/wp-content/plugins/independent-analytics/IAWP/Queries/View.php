<?php

namespace IAWP_SCOPED\IAWP\Queries;

use IAWP_SCOPED\IAWP\Models\Page_Author_Archive;
use IAWP_SCOPED\IAWP\Models\Page_Date_Archive;
use IAWP_SCOPED\IAWP\Models\Page_Home;
use IAWP_SCOPED\IAWP\Models\Page_Not_Found;
use IAWP_SCOPED\IAWP\Models\Page_Post_Type_Archive;
use IAWP_SCOPED\IAWP\Models\Page_Search;
use IAWP_SCOPED\IAWP\Models\Page_Singular;
use IAWP_SCOPED\IAWP\Models\Page_Term_Archive;
use IAWP_SCOPED\IAWP\Models\Visitor;
use IAWP_SCOPED\IAWP\Query;
use IAWP_SCOPED\IAWP\Utils\String_Util;
use IAWP_SCOPED\IAWP\Utils\URL;
class View
{
    private $payload;
    private $referrer_url;
    private $visitor;
    private $campaign_fields;
    private $viewed_at;
    private $resource;
    private $session;
    /**
     * @param array $payload
     * @param string|null $referrer_url
     * @param Visitor $visitor
     * @param array $campaign_fields
     * @param null $viewed_at
     */
    public function __construct(array $payload, ?string $referrer_url, Visitor $visitor, array $campaign_fields, $viewed_at = null)
    {
        $this->payload = $payload;
        $this->referrer_url = \trim($referrer_url);
        $this->visitor = $visitor;
        $this->campaign_fields = $campaign_fields;
        $this->viewed_at = $viewed_at;
        $this->resource = $this->get_resource();
        $this->session = $this->get_session();
        $view_id = $this->create_view();
        $this->set_sessions_initial_view($view_id);
    }
    private function set_sessions_initial_view(int $view_id)
    {
        global $wpdb;
        $sessions_table = Query::get_table_name(Query::SESSIONS);
        $wpdb->query($wpdb->prepare("UPDATE {$sessions_table} SET initial_view_id = %d WHERE session_id = %d AND initial_view_id IS NULL", $view_id, $this->session));
    }
    private function create_view()
    {
        $date = \is_null($this->viewed_at) ? new \DateTime() : $this->viewed_at;
        $viewed_at = $date->format('Y-m-d H:i:s');
        return Query::query('create_view', ['resource_id' => $this->resource, 'viewed_at' => $viewed_at, 'page' => $this->payload['page'], 'session_id' => $this->session])->last_inserted_id();
    }
    private function get_resource() : ?int
    {
        global $wpdb;
        $resources_table = Query::get_table_name(Query::RESOURCES);
        $query = '';
        $payload = \array_merge($this->payload);
        unset($payload['page']);
        switch ($payload['resource']) {
            case 'singular':
                $query = $wpdb->prepare("SELECT * FROM {$resources_table} WHERE resource = %s AND singular_id = %d", $payload['resource'], $payload['singular_id']);
                break;
            case 'author_archive':
                $query = $wpdb->prepare("SELECT * FROM {$resources_table} WHERE resource = %s AND author_id = %d", $payload['resource'], $payload['author_id']);
                break;
            case 'date_archive':
                $query = $wpdb->prepare("SELECT * FROM {$resources_table} WHERE resource = %s AND date_archive = %s", $payload['resource'], $payload['date_archive']);
                break;
            case 'post_type_archive':
                $query = $wpdb->prepare("SELECT * FROM {$resources_table} WHERE resource = %s AND post_type = %s", $payload['resource'], $payload['post_type']);
                break;
            case 'term_archive':
                $query = $wpdb->prepare("SELECT * FROM {$resources_table} WHERE resource = %s AND term_id = %s", $payload['resource'], $payload['term_id']);
                break;
            case 'search':
                $query = $wpdb->prepare("SELECT * FROM {$resources_table} WHERE resource = %s AND search_query = %s", $payload['resource'], $payload['search_query']);
                break;
            case 'home':
                $query = $wpdb->prepare("SELECT * FROM {$resources_table} WHERE resource = %s ", $payload['resource']);
                break;
            case '404':
                $query = $wpdb->prepare("SELECT * FROM {$resources_table} WHERE resource = %s AND not_found_url = %s", $payload['resource'], $payload['not_found_url']);
                break;
        }
        $resource = $wpdb->get_row($query);
        if (\is_null($resource)) {
            $wpdb->insert($resources_table, $payload);
            $resource = $wpdb->get_row($query);
        }
        // Todo - This probably shouldn't happen here... A call should be make to the page and then the page should
        //  know if it's a page type that needs to be cached or not.
        switch ($resource->resource) {
            case 'singular':
                (new Page_Singular($resource))->update_cache();
                break;
            case 'author_archive':
                (new Page_Author_Archive($resource))->update_cache();
                break;
            case 'post_type_archive':
                (new Page_Post_Type_Archive($resource))->update_cache();
                break;
            case 'term_archive':
                (new Page_Term_Archive($resource))->update_cache();
                break;
            case 'home':
                (new Page_Home($resource))->update_cache();
                break;
            case 'date_archive':
                (new Page_Date_Archive($resource))->update_cache();
                break;
            case '404':
                (new Page_Not_Found($resource))->update_cache();
                break;
            case 'search':
                (new Page_Search($resource))->update_cache();
                break;
        }
        return $resource->id;
    }
    private function get_session() : int
    {
        $is_internal_referrer = $this->is_internal_referrer($this->referrer_url);
        $current_session = $this->get_current_session();
        if (isset($current_session) && $is_internal_referrer) {
            return $current_session;
        } else {
            return $this->create_session();
        }
    }
    /**
     * @param string|null $referrer_url
     * @return bool
     */
    private function is_internal_referrer(?string $referrer_url) : bool
    {
        return !empty($referrer_url) && String_Util::str_starts_with(\strtolower($referrer_url), \strtolower(\site_url()));
    }
    /**
     * Gets the current session not including any that might get created by the current view
     *
     * @return int|null
     */
    private function get_current_session() : ?int
    {
        $session = Query::query('get_current_session', ['visitor_id' => $this->visitor->id()])->row();
        if (isset($session)) {
            return $session->session_id;
        } else {
            return null;
        }
    }
    public function create_session() : int
    {
        $date = \is_null($this->viewed_at) ? new \DateTime() : $this->viewed_at;
        $created_at = $date->format('Y-m-d H:i:s');
        return Query::query('create_session', ['visitor_id' => $this->visitor->id(), 'referrer_id' => $this->get_referrer(), 'campaign_id' => $this->get_campaign(), 'created_at' => $created_at])->last_inserted_id();
    }
    private function get_referrer() : ?int
    {
        if (!isset($this->referrer_url) || \strlen($this->referrer_url) === 0) {
            return null;
        }
        $url = new URL($this->referrer_url);
        if (!$url->is_valid_url()) {
            return null;
        }
        if ($this->is_internal_referrer($this->referrer_url)) {
            return null;
        }
        $referrer = Query::query('get_referrer', ['domain' => $url->get_domain()])->row();
        if (!\is_null($referrer)) {
            return $referrer->id;
        }
        Query::query('create_referrer', ['domain' => $url->get_domain()]);
        $referrer = Query::query('get_referrer', ['domain' => $url->get_domain()])->row();
        if (!\is_null($referrer)) {
            return $referrer->id;
        } else {
            return null;
        }
    }
    private function get_campaign() : ?int
    {
        global $wpdb;
        $required_fields = ['utm_source', 'utm_medium', 'utm_campaign'];
        $valid = \true;
        foreach ($required_fields as $field) {
            if (!isset($this->campaign_fields[$field])) {
                $valid = \false;
            }
        }
        if (!$valid) {
            return null;
        }
        $campaigns_table = Query::get_table_name(Query::CAMPAIGNS);
        $campaign = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$campaigns_table} WHERE utm_source = %s AND utm_medium = %s AND utm_campaign = %s AND (utm_term = %s OR (%d = 0 AND utm_term IS NULL)) AND (utm_content = %s OR (%d = 0 AND utm_content IS NULL))", $this->campaign_fields['utm_source'], $this->campaign_fields['utm_medium'], $this->campaign_fields['utm_campaign'], $this->campaign_fields['utm_term'], isset($this->campaign_fields['utm_term']) ? 1 : 0, $this->campaign_fields['utm_content'], isset($this->campaign_fields['utm_content']) ? 1 : 0));
        if (!\is_null($campaign)) {
            return $campaign->campaign_id;
        }
        $wpdb->insert($campaigns_table, ['utm_source' => $this->campaign_fields['utm_source'], 'utm_medium' => $this->campaign_fields['utm_medium'], 'utm_campaign' => $this->campaign_fields['utm_campaign'], 'utm_term' => $this->campaign_fields['utm_term'], 'utm_content' => $this->campaign_fields['utm_content']]);
        $campaign = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$campaigns_table} WHERE utm_source = %s AND utm_medium = %s AND utm_campaign = %s AND (utm_term = %s OR (%d = 0 AND utm_term IS NULL)) AND (utm_content = %s OR (%d = 0 AND utm_content IS NULL))", $this->campaign_fields['utm_source'], $this->campaign_fields['utm_medium'], $this->campaign_fields['utm_campaign'], $this->campaign_fields['utm_term'], isset($this->campaign_fields['utm_term']) ? 1 : 0, $this->campaign_fields['utm_content'], isset($this->campaign_fields['utm_content']) ? 1 : 0));
        if (!\is_null($campaign)) {
            return $campaign->campaign_id;
        }
        return null;
    }
}
