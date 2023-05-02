<?php

namespace IAWP_SCOPED\IAWP\Queries;

use IAWP_SCOPED\IAWP\Query;
class Visitors_Over_Time_Finder extends Range_Query
{
    private $interval;
    public function __construct($options)
    {
        parent::__construct($options);
        $options = \IAWP_SCOPED\iawp_default_args($options, ['interval' => null]);
        $this->interval = $options['interval'];
    }
    public function fetch()
    {
        $rows = Query::query($this->interval->get_query_name(), ['start' => $this->formatted_start(), 'end' => $this->formatted_end()])->rows();
        return $this->rows_to_class($rows);
    }
    private function rows_to_class(array $rows) : object
    {
        $date_interval = $this->interval->get_date_interval();
        $date_period = new \DatePeriod($this->start(), $date_interval, $this->end());
        $interval_data = [];
        $visitors_data = [];
        $views_data = [];
        foreach ($date_period as $index => $date) {
            $current_interval = $index;
            $current_visitors = 0;
            $current_views = 0;
            foreach ($rows as $row) {
                $row_interval = \intval($row->interval_ago);
                $row_visitors = \intval($row->visitors);
                $row_views = \intval($row->views);
                if ($row_interval === $index) {
                    $current_interval = $row_interval;
                    $current_visitors = $row_visitors;
                    $current_views = $row_views;
                    break;
                }
            }
            $interval_data[] = $current_interval;
            $visitors_data[] = $current_visitors;
            $views_data[] = $current_views;
        }
        return (object) ['visitors' => $visitors_data, 'views' => $views_data, 'interval_labels_short' => $this->interval->get_short_labels($interval_data), 'interval_labels_full' => $this->interval->get_full_labels($interval_data)];
    }
}
