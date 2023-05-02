<?php

namespace IAWP_SCOPED\IAWP\Queries;

use IAWP_SCOPED\IAWP\Models\Referrer;
use IAWP_SCOPED\IAWP\Query;
class Referrers extends Range_Query
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
        $query = $is_using_woocommerce ? 'get_referrers_with_woocommerce' : 'get_referrers';
        $rows = Query::query($query, ['start' => $this->formatted_start(), 'end' => $this->formatted_end(), 'prev_start' => $this->prev_period_formatted_start(), 'prev_end' => $this->prev_period_formatted_end()])->rows();
        return self::rows_to_referrers($rows);
    }
    private function rows_to_referrers($rows)
    {
        return \array_map(function ($row) {
            $has_referrers = !\is_null($row->referrer_ids);
            if ($has_referrers) {
                $row->referrer_ids = \explode(',', $row->referrer_ids);
            }
            return new Referrer($row);
        }, $rows);
    }
}
