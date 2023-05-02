<?php

namespace IAWP_SCOPED\IAWP\Queries;

use IAWP_SCOPED\IAWP\Models\Geo;
use IAWP_SCOPED\IAWP\Query;
class City_Statistics extends Range_Query
{
    private $results;
    public function __construct($options = [])
    {
        parent::__construct($options);
    }
    public function fetch()
    {
        if (\is_null($this->results)) {
            $this->results = $this->query();
        }
        return $this->results;
    }
    private function query()
    {
        $is_using_woocommerce = \IAWP_SCOPED\iawp_using_woocommerce();
        $query = $is_using_woocommerce ? 'city_statistics_with_woocommerce' : 'city_statistics';
        $rows = Query::query($query, ['start' => $this->formatted_start(), 'end' => $this->formatted_end(), 'prev_start' => $this->prev_period_formatted_start(), 'prev_end' => $this->prev_period_formatted_end()])->rows();
        return self::rows_to_geos($rows);
    }
    private function rows_to_geos($rows)
    {
        return \array_map(function ($row) {
            $row->views = \intval($row->views);
            $row->visitors = \intval($row->visitors);
            $row->visitor_ids = \array_map(function ($id) {
                return $id;
            }, \explode(',', $row->visitor_ids));
            return new Geo($row);
        }, $rows);
    }
}
