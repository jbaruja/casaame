<?php

namespace IAWP_SCOPED\IAWP\AJAX;

use IAWP_SCOPED\IAWP\Chart;
use IAWP_SCOPED\IAWP\Chart_Geo;
use IAWP_SCOPED\IAWP\Filters;
use IAWP_SCOPED\IAWP\Models\Campaign;
use IAWP_SCOPED\IAWP\Models\Geo;
use IAWP_SCOPED\IAWP\Models\Referrer;
use IAWP_SCOPED\IAWP\Queries\Campaigns;
use IAWP_SCOPED\IAWP\Queries\City_Statistics;
use IAWP_SCOPED\IAWP\Queries\Country_Statistics;
use IAWP_SCOPED\IAWP\Queries\Referrers;
use IAWP_SCOPED\IAWP\Queries\Resources;
use IAWP_SCOPED\IAWP\Queries\Views;
use IAWP_SCOPED\IAWP\Quick_Stats;
use IAWP_SCOPED\IAWP\Tables\Table_Campaigns;
use IAWP_SCOPED\IAWP\Tables\Table_Geo;
use IAWP_SCOPED\IAWP\Tables\Table_Referrers;
use IAWP_SCOPED\IAWP\Tables\Table_Views;
use IAWP_SCOPED\IAWP\Utils\Exact_Range;
use IAWP_SCOPED\IAWP\Utils\Relative_Range;
class Filters_AJAX extends AJAX
{
    protected function action_name() : string
    {
        return 'iawp_filter';
    }
    protected function action_required_fields() : array
    {
        return ['table_type', 'columns'];
    }
    /**
     * The date info can be supplied in one of two ways.
     *
     * The first is to provide a relative_range_id which is converted into start, end, and label.
     *
     * The second is to provide explicit start and end fields which will be used as is.
     *
     * @return null|Relative_Range|Exact_Range
     */
    private function get_range_info()
    {
        $relative_range_id = $this->get_field('relative_range_id');
        $exact_start = $this->get_field('exact_start');
        $exact_end = $this->get_field('exact_end');
        if ($relative_range_id) {
            return Relative_Range::range($this->get_field('relative_range_id'));
        } elseif ($exact_start && $exact_end) {
            return new Exact_Range($exact_start, $exact_end);
        } else {
            return null;
        }
    }
    protected function action_callback() : void
    {
        $filters = $this->get_field('filters') ?? [];
        $columns = $this->get_field('columns');
        $table_type = $this->get_field('table_type');
        $is_views_table = $table_type === 'views';
        $is_referrers_table = $table_type === 'referrers';
        $is_geo_table = $table_type === 'geo';
        $is_campaigns_table = $table_type === 'campaigns';
        $range = $this->get_range_info();
        $sort_by = $this->get_field('sort_by') ?? 'visitors';
        $sort_direction = $this->get_field('sort_direction') ?? 'desc';
        $page = $this->get_field('page') ?? 1;
        $unfiltered_views = null;
        if (!$range || !$is_views_table && !$is_referrers_table && !$is_geo_table && !$is_campaigns_table) {
            return;
        }
        if ($is_views_table) {
            $table = new Table_Views($columns);
            $resources = new Resources(['start' => $range->start, 'end' => $range->end]);
            $rows = $resources->fetch();
            $viewed_resource_ids = $this->get_viewed_resource_ids($rows);
            $views = new Views(Views::RESOURCES, $viewed_resource_ids, $range->start, $range->end);
            if (!empty($filters)) {
                $unfiltered_views = $views;
                $rows = $this->get_filtered_rows($rows, $filters);
                $viewed_resource_ids = $this->get_viewed_resource_ids($rows);
                $views = new Views(Views::RESOURCES, $viewed_resource_ids, $range->start, $range->end);
            }
            $chart = new Chart($views, $range->label);
        } elseif ($is_referrers_table) {
            $table = new Table_Referrers($columns);
            $referrers = new Referrers(['start' => $range->start, 'end' => $range->end]);
            $rows = $referrers->fetch();
            $referrer_ids = Referrer::referrer_ids($rows);
            $views = new Views(Views::REFERRERS, $referrer_ids, $range->start, $range->end);
            if (!empty($filters)) {
                $unfiltered_views = $views;
                $rows = $this->get_filtered_rows($rows, $filters);
                $referrer_ids = Referrer::referrer_ids($rows);
                $views = new Views(Views::REFERRERS, $referrer_ids, $range->start, $range->end);
            }
            $chart = new Chart($views, $range->label);
        } elseif ($is_geo_table) {
            $table = new Table_Geo($columns);
            $geos = new City_Statistics(['start' => $range->start, 'end' => $range->end]);
            $rows = $geos->fetch();
            $geo_ids = Geo::geo_ids($rows);
            $views = new Views(Views::GEO, $geo_ids, $range->start, $range->end);
            if (!empty($filters)) {
                $unfiltered_views = $views;
                $rows = $this->get_filtered_rows($rows, $filters);
                $geo_ids = Geo::geo_ids($rows);
                $views = new Views(Views::GEO, $geo_ids, $range->start, $range->end);
            }
            $country_statistics = new Country_Statistics(['start' => $range->start, 'end' => $range->end]);
            $stats = $this->get_filtered_rows($country_statistics->fetch(), $filters);
            $chart = new Chart_Geo($stats, $range->label);
        } elseif ($is_campaigns_table) {
            $table = new Table_Campaigns($columns);
            $rows = (new Campaigns(['start' => $range->start, 'end' => $range->end]))->fetch();
            $campaign_ids = Campaign::campaigns_to_ids($rows);
            $views = new Views(Views::CAMPAIGNS, $campaign_ids, $range->start, $range->end);
            if (!empty($filters)) {
                $unfiltered_views = $views;
                $rows = $this->get_filtered_rows($rows, $filters);
                $campaign_ids = Campaign::campaigns_to_ids($rows);
                $views = new Views(Views::CAMPAIGNS, $campaign_ids, $range->start, $range->end);
            }
            $chart = new Chart($views, $range->label);
        } else {
            return;
        }
        $rows = $this->sort_rows($rows, $sort_direction, $sort_by);
        $page_size = \IAWP_SCOPED\iawp()->pagination_page_size();
        $paged_rows = \array_slice($rows, 0, $page_size * $page);
        $is_last_page = \count($rows) === \count($paged_rows);
        $table->set_views($views);
        $quick_stats = new Quick_Stats($views, $unfiltered_views);
        $html = $table->get_row_markup($paged_rows);
        \wp_send_json_success(['rows' => $html, 'totalRowCount' => \count($rows), 'chart' => $chart->get_html(), 'stats' => $quick_stats->get_html(), 'label' => $range->label, 'isLastPage' => $is_last_page]);
    }
    protected function get_viewed_resource_ids($rows)
    {
        return \array_map(function ($resource) {
            return $resource->id();
        }, $rows);
    }
    protected function get_filtered_rows($rows, $filters)
    {
        $filterer = new Filters();
        return $filterer->filter_views($rows, $filters);
    }
    protected function sort_rows($rows, $sort_direction, $sort_by)
    {
        \usort($rows, function ($a, $b) use($sort_direction, $sort_by) {
            if (\method_exists($a, $sort_by) && \method_exists($b, $sort_by)) {
                $a_val = $a->{$sort_by}();
                $b_val = $b->{$sort_by}();
                $switch = $sort_direction === 'asc' ? 1 : -1;
                // Null and empty values at bottom in asc and top in desc
                $a_empty = \is_null($a_val) || \strlen($a_val) === 0;
                $b_empty = \is_null($b_val) || \strlen($b_val) === 0;
                if ($a_empty && !$b_empty) {
                    return 1;
                } elseif ($b_empty && !$a_empty) {
                    return -1;
                } elseif ($a_empty && $b_empty) {
                    return 0;
                }
                // Numbers below letters
                $a_num = \is_numeric($a_val);
                $b_num = \is_numeric($b_val);
                if ($a_num && !$b_num) {
                    return $switch;
                } elseif ($b_num && !$a_num) {
                    return $switch * -1;
                }
                return (\strtolower($a_val) <=> \strtolower($b_val)) * $switch;
            } else {
                return 0;
            }
        });
        return $rows;
    }
}
