<?php

namespace IAWP_SCOPED\IAWP\Queries;

use IAWP_SCOPED\IAWP\Models\Campaign;
use IAWP_SCOPED\IAWP\Query;
class Campaigns extends Range_Query
{
    private $results;
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
        $query = $is_using_woocommerce ? 'get_campaigns_with_woocommerce' : 'get_campaigns';
        $rows = Query::query($query, ['start' => $this->formatted_start(), 'end' => $this->formatted_end(), 'prev_start' => $this->prev_period_formatted_start(), 'prev_end' => $this->prev_period_formatted_end()])->rows();
        return $this->rows_to_campaigns($rows);
    }
    private function rows_to_campaigns($rows)
    {
        return \array_map(function ($row) {
            $row->campaign_ids = \explode(',', $row->campaign_ids);
            return new Campaign($row);
        }, $rows);
    }
}
