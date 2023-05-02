<?php

namespace IAWP_SCOPED\IAWP\Queries;

use IAWP_SCOPED\IAWP\Query;
use IAWP_SCOPED\IAWP\Utils\Timezone;
class Views extends Range_Query
{
    const REFERRERS = 'REFERRERS';
    const RESOURCES = 'RESOURCES';
    const GEO = 'GEO';
    const CAMPAIGNS = 'CAMPAIGNS';
    private $views;
    private $prev_period_views;
    private $daily_views;
    private $visitors;
    private $prev_period_visitors;
    private $daily_visitors;
    private $sessions;
    private $prev_period_sessions;
    private $daily_sessions;
    private $woocommerce_orders;
    private $prev_woocommerce_orders;
    private $woocommerce_net_sales;
    private $prev_woocommerce_net_sales;
    private $daily_woocommerce_orders;
    private $daily_woocommerce_net_sales;
    public function __construct($type, $allowed_ids = null, $start = null, $end = null)
    {
        parent::__construct(['start' => $start, 'end' => $end]);
        if ($type === self::RESOURCES || $type === self::REFERRERS || $type === self::GEO || $type === self::CAMPAIGNS) {
            $this->query($type, $allowed_ids);
        } else {
            throw new \Exception('IAWP_Views: Unsupported type');
        }
    }
    public function views()
    {
        return $this->views;
    }
    public function prev_period_views()
    {
        return $this->prev_period_views;
    }
    public function daily_views()
    {
        return $this->daily_views;
    }
    public function views_percentage_growth()
    {
        return $this->percentage_growth($this->views(), $this->prev_period_views());
    }
    public function visitors()
    {
        return $this->visitors;
    }
    public function visitors_percentage_growth()
    {
        return $this->percentage_growth($this->visitors(), $this->prev_period_visitors());
    }
    public function prev_period_visitors()
    {
        return $this->prev_period_visitors;
    }
    public function daily_visitors()
    {
        return $this->daily_visitors;
    }
    public function sessions()
    {
        return $this->sessions;
    }
    public function sessions_percentage_growth()
    {
        return $this->percentage_growth($this->sessions(), $this->prev_period_sessions());
    }
    public function prev_period_sessions()
    {
        return $this->prev_period_sessions;
    }
    public function daily_sessions()
    {
        return $this->daily_sessions;
    }
    public function woocommerce_orders() : int
    {
        return $this->woocommerce_orders;
    }
    public function prev_woocommerce_orders() : int
    {
        return $this->prev_woocommerce_orders;
    }
    public function woocommerce_orders_percentage_growth() : float
    {
        return $this->percentage_growth($this->woocommerce_orders(), $this->prev_woocommerce_orders());
    }
    public function woocommerce_net_sales() : float
    {
        return $this->woocommerce_net_sales;
    }
    public function prev_woocommerce_net_sales() : float
    {
        return $this->prev_woocommerce_net_sales;
    }
    public function woocommerce_net_sales_percentage_growth() : float
    {
        return $this->percentage_growth((int) $this->woocommerce_net_sales(), (int) $this->prev_woocommerce_net_sales());
    }
    public function daily_woocommerce_orders() : array
    {
        return $this->daily_woocommerce_orders;
    }
    public function daily_woocommerce_net_sales() : array
    {
        return $this->daily_woocommerce_net_sales;
    }
    private function percentage_growth(int $current_period, int $previous_period) : float
    {
        if ($current_period === 0 && $previous_period !== 0) {
            return -100;
        } elseif ($current_period === 0 || $previous_period === 0) {
            return 0;
        }
        $growth = ($current_period / $previous_period - 1) * 100;
        return \round($growth, 0);
    }
    private function query($type, $allowed_ids)
    {
        global $wpdb;
        $views_table = Query::get_table_name(Query::VIEWS);
        $visitors_table = Query::get_table_name(Query::VISITORS);
        $sessions_table = Query::get_table_name(Query::SESSIONS);
        if (\is_null($allowed_ids)) {
            $skip_in = 1;
            $allowed_ids = [0];
            $in = '%s';
        } elseif (\count($allowed_ids) === 0) {
            $skip_in = 0;
            $allowed_ids = [0];
            $in = '%s';
        } else {
            $skip_in = 0;
            $in = \implode(',', \array_fill(0, \count($allowed_ids), '%s'));
        }
        if ($type === self::RESOURCES) {
            $column = 'views.resource_id';
        } elseif ($type === self::REFERRERS) {
            $column = 'sessions.referrer_id';
        } elseif ($type === self::GEO) {
            $column = 'sessions.visitor_id';
        } else {
            $column = 'sessions.campaign_id';
        }
        $has_null_id = \false;
        foreach ($allowed_ids as $id) {
            if (\is_null($id)) {
                $has_null_id = \true;
                break;
            }
        }
        $null_check = '';
        if ($type === self::REFERRERS && $has_null_id) {
            $null_check = "OR {$column} IS NULL";
        }
        $wc_orders_table = Query::get_table_name(Query::WC_ORDERS);
        $wc_order_stats_table = $wpdb->prefix . 'wc_order_stats';
        $utc = Timezone::utc_offset();
        $local_offset = Timezone::local_offset();
        if (\IAWP_SCOPED\iawp_using_woocommerce()) {
            $query = $wpdb->prepare("\n            SELECT\n                DATE(CONVERT_TZ(views.viewed_at, '{$utc}', '{$local_offset}')) as date,\n                COUNT(*) as views,\n                COUNT(DISTINCT sessions.visitor_id) as visitors,\n                COUNT(DISTINCT sessions.session_id) as sessions,\n               COUNT(DISTINCT IF(wc_order_stats.total_sales >= 0, wc_order_stats.order_id, NULL)) AS wc_orders,\n               SUM(IF(wc_order_stats.total_sales >= 0, wc_order_stats.total_sales,\n                      0))                                                                         AS wc_gross_sales,\n               COUNT(DISTINCT IF(wc_order_stats.total_sales < 0, wc_order_stats.order_id,\n                                 NULL))                                                           AS wc_refunds,\n               ABS(SUM(IF(wc_order_stats.total_sales < 0, wc_order_stats.total_sales,\n                          0)))                                                                    AS wc_refunded_amount\n            FROM {$views_table} AS views\n            LEFT JOIN {$sessions_table} AS sessions ON views.session_id = sessions.session_id\n            LEFT JOIN {$visitors_table} AS visitors ON sessions.visitor_id = visitors.visitor_id\n            LEFT JOIN {$wc_orders_table} AS wc_orders ON wc_orders.view_id = views.id \n            LEFT JOIN {$wc_order_stats_table} AS wc_order_stats ON (wc_orders.order_id = wc_order_stats.order_id OR wc_orders.order_id = wc_order_stats.parent_id) AND wc_order_stats.status IN ('wc-completed', 'wc-processing', 'wc-refunded')\n            WHERE views.viewed_at BETWEEN %s AND %s\n                AND (%d = 1 OR {$column} IN ({$in}) {$null_check})\n                AND ('{$type}' != 'GEO' OR visitors.country_code IS NOT NULL)\n                AND ('{$type}' != 'CAMPAIGNS' OR sessions.campaign_id IS NOT NULL)\n            GROUP BY DATE(CONVERT_TZ(views.viewed_at, '{$utc}', '{$local_offset}'))", $this->formatted_start(), $this->formatted_end(), $skip_in, ...$allowed_ids);
        } else {
            $query = $wpdb->prepare("\n            SELECT\n                DATE(CONVERT_TZ(views.viewed_at, '{$utc}', '{$local_offset}')) as date,\n                COUNT(*) as views,\n                COUNT(DISTINCT sessions.visitor_id) as visitors,\n                COUNT(DISTINCT sessions.session_id) as sessions,\n                0                                                                   AS wc_orders,\n                 0                                                                   AS wc_gross_sales,\n                 0                                                                   AS wc_refunds,\n                 0                                                                   AS wc_refunded_amount\n            FROM {$views_table} AS views\n            LEFT JOIN {$sessions_table} AS sessions ON views.session_id = sessions.session_id\n            LEFT JOIN {$visitors_table} AS visitors ON sessions.visitor_id = visitors.visitor_id\n            WHERE views.viewed_at BETWEEN %s AND %s\n                AND (%d = 1 OR {$column} IN ({$in}) {$null_check})\n                AND ('{$type}' != 'GEO' OR visitors.country_code IS NOT NULL)\n                AND ('{$type}' != 'CAMPAIGNS' OR sessions.campaign_id IS NOT NULL)\n            GROUP BY DATE(CONVERT_TZ(views.viewed_at, '{$utc}', '{$local_offset}'))", $this->formatted_start(), $this->formatted_end(), $skip_in, ...$allowed_ids);
        }
        $rows = $wpdb->get_results($query);
        // This separate query for visitor counts is required
        // Without it, visitors visiting on separate days are counted twice in the quick stats
        $visitors_query = $wpdb->prepare("\n            SELECT\n                COUNT(DISTINCT sessions.visitor_id) as visitors,\n                COUNT(DISTINCT sessions.session_id) as sessions\n            FROM {$views_table} AS views\n            LEFT JOIN {$sessions_table} AS sessions ON views.session_id = sessions.session_id\n            LEFT JOIN {$visitors_table} AS visitors ON sessions.visitor_id = visitors.visitor_id\n            WHERE views.viewed_at BETWEEN %s AND %s\n                AND (%d = 1 OR {$column} IN ({$in}) {$null_check})\n                AND ('{$type}' != 'GEO' OR visitors.country_code IS NOT NULL)\n                AND ('{$type}' != 'CAMPAIGNS' OR sessions.campaign_id IS NOT NULL)\n            ", $this->formatted_start(), $this->formatted_end(), $skip_in, ...$allowed_ids);
        $visitors_results = $wpdb->get_row($visitors_query);
        $visitors = \intval($visitors_results->visitors);
        $sessions = \intval($visitors_results->sessions);
        if (\IAWP_SCOPED\iawp_using_woocommerce()) {
            $prev_period_query = $wpdb->prepare("\n            SELECT\n                COUNT(*) as views,\n                COUNT(DISTINCT sessions.visitor_id) as visitors,\n                COUNT(DISTINCT sessions.session_id) as sessions,\n                COUNT(DISTINCT IF(wc_order_stats.total_sales >= 0, wc_order_stats.order_id, NULL)) AS wc_orders,\n               SUM(IF(wc_order_stats.total_sales >= 0, wc_order_stats.total_sales,\n                      0))                                                                         AS wc_gross_sales,\n               COUNT(DISTINCT IF(wc_order_stats.total_sales < 0, wc_order_stats.order_id,\n                                 NULL))                                                           AS wc_refunds,\n               ABS(SUM(IF(wc_order_stats.total_sales < 0, wc_order_stats.total_sales,\n                          0)))                                                                    AS wc_refunded_amount\n            FROM {$views_table} AS views\n            LEFT JOIN {$sessions_table} AS sessions ON views.session_id = sessions.session_id\n            LEFT JOIN {$visitors_table} AS visitors ON sessions.visitor_id = visitors.visitor_id\n             LEFT JOIN {$wc_orders_table} AS wc_orders ON wc_orders.view_id = views.id \n            LEFT JOIN {$wc_order_stats_table} AS wc_order_stats ON (wc_orders.order_id = wc_order_stats.order_id OR wc_orders.order_id = wc_order_stats.parent_id) AND wc_order_stats.status IN ('wc-completed', 'wc-processing', 'wc-refunded')\n            WHERE views.viewed_at BETWEEN %s AND %s\n                AND (%d = 1 OR {$column} IN ({$in}) {$null_check})\n                AND ('{$type}' != 'GEO' OR visitors.country_code IS NOT NULL)\n                AND ('{$type}' != 'CAMPAIGNS' OR sessions.campaign_id IS NOT NULL);\n            ", $this->prev_period_formatted_start(), $this->prev_period_formatted_end(), $skip_in, ...$allowed_ids);
        } else {
            $prev_period_query = $wpdb->prepare("\n            SELECT\n                COUNT(*) as views,\n                COUNT(DISTINCT sessions.visitor_id) as visitors,\n                COUNT(DISTINCT sessions.session_id) as sessions,\n                0                                                                   AS wc_orders,\n                 0                                                                   AS wc_gross_sales,\n                 0                                                                   AS wc_refunds,\n                 0                                                                   AS wc_refunded_amount\n            FROM {$views_table} AS views\n            LEFT JOIN {$sessions_table} AS sessions ON views.session_id = sessions.session_id\n            LEFT JOIN {$visitors_table} AS visitors ON sessions.visitor_id = visitors.visitor_id\n            WHERE views.viewed_at BETWEEN %s AND %s\n                AND (%d = 1 OR {$column} IN ({$in}) {$null_check})\n                AND ('{$type}' != 'GEO' OR visitors.country_code IS NOT NULL)\n                AND ('{$type}' != 'CAMPAIGNS' OR sessions.campaign_id IS NOT NULL);\n            ", $this->prev_period_formatted_start(), $this->prev_period_formatted_end(), $skip_in, ...$allowed_ids);
        }
        $prev_period_results = $wpdb->get_row($prev_period_query);
        $prev_period_views = \intval($prev_period_results->views);
        $prev_period_visitors = \intval($prev_period_results->visitors);
        $prev_period_sessions = \intval($prev_period_results->sessions);
        $prev_woocommerce_orders = \intval($prev_period_results->wc_orders);
        $prev_woocommerce_net_sales = \floatval($prev_period_results->wc_gross_sales) - \floatval($prev_period_results->wc_refunded_amount);
        $views = 0;
        $woocommerce_orders = 0;
        $woocommerce_gross_sales = 0;
        $woocommerce_refunded_amount = 0;
        $daily_views = [];
        $daily_visitors = [];
        $daily_sessions = [];
        $daily_woocommerce_orders = [];
        $daily_woocommerce_net_sales = [];
        foreach ($rows as $row) {
            $row_views = \intval($row->views);
            $row_visitors = \intval($row->visitors);
            $row_sessions = \intval($row->sessions);
            $row_woocommerce_orders = \intval($row->wc_orders);
            $row_woocommerce_gross_sales = \floatval($row->wc_gross_sales);
            $row_woocommerce_refunded_amount = \floatval($row->wc_refunded_amount);
            $views += $row_views;
            $woocommerce_orders += $row_woocommerce_orders;
            $woocommerce_gross_sales += $row_woocommerce_gross_sales;
            $woocommerce_refunded_amount += $row_woocommerce_refunded_amount;
            $daily_views[] = [$row->date, $row_views];
            $daily_visitors[] = [$row->date, $row_visitors];
            $daily_sessions[] = [$row->date, $row_sessions];
            $daily_woocommerce_orders[] = [$row->date, $row_woocommerce_orders];
            $daily_woocommerce_net_sales[] = [$row->date, $row_woocommerce_gross_sales - $row_woocommerce_refunded_amount];
        }
        $this->views = $views;
        $this->prev_period_views = $prev_period_views;
        $this->visitors = $visitors;
        $this->prev_period_visitors = $prev_period_visitors;
        $this->sessions = $sessions;
        $this->prev_period_sessions = $prev_period_sessions;
        $this->woocommerce_orders = $woocommerce_orders;
        $this->prev_woocommerce_orders = $prev_woocommerce_orders;
        $this->woocommerce_net_sales = $woocommerce_gross_sales - $woocommerce_refunded_amount;
        $this->prev_woocommerce_net_sales = $prev_woocommerce_net_sales;
        $this->daily_views = $this->fill_in_partial_day_range($daily_views);
        $this->daily_visitors = $this->fill_in_partial_day_range($daily_visitors);
        $this->daily_sessions = $this->fill_in_partial_day_range($daily_sessions);
        $this->daily_woocommerce_orders = $this->fill_in_partial_day_range($daily_woocommerce_orders);
        $this->daily_woocommerce_net_sales = $this->fill_in_partial_day_range($daily_woocommerce_net_sales);
    }
    /**
     * @param array $partial_day_range
     * @return array
     */
    private function fill_in_partial_day_range(array $partial_day_range) : array
    {
        $interval = new \DateInterval('P1D');
        $user_timezone = new \DateTimeZone(Timezone::local_offset());
        $start = clone $this->start();
        $end = clone $this->end();
        $start->setTimezone($user_timezone);
        $end->setTimezone($user_timezone);
        $date_range = new \DatePeriod($start, $interval, $end);
        $filled_in_data = [];
        foreach ($date_range as $date) {
            $stat = $this->get_statistic_for_date($partial_day_range, $date);
            $filled_in_data[] = [$date, $stat];
        }
        return $filled_in_data;
    }
    /**
     * @param array $partial_day_range
     * @param \DateTime $datetime_to_match
     * @return int Defaults to 0
     */
    private function get_statistic_for_date(array $partial_day_range, \DateTime $datetime_to_match) : int
    {
        $user_timezone = new \DateTimeZone(Timezone::local_offset());
        $default_value = 0;
        foreach ($partial_day_range as $day) {
            $date = $day[0];
            $stat = $day[1];
            try {
                $datetime = new \DateTime($date, $user_timezone);
            } catch (\Exception $e) {
                return $default_value;
            }
            // Intentionally using non-strict equality to see if two distinct DateTime objects represent the same time
            if ($datetime == $datetime_to_match) {
                return $stat;
            }
        }
        return $default_value;
    }
}
