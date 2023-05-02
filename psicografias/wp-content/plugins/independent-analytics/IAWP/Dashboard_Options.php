<?php

namespace IAWP_SCOPED\IAWP;

use IAWP_SCOPED\IAWP\Utils\Date_Format;
use IAWP_SCOPED\IAWP\Utils\Exact_Range;
use IAWP_SCOPED\IAWP\Utils\Relative_Range;
use IAWP_SCOPED\IAWP\Utils\Timezone;
/**
 * Dashboards support various options via the search query string portion of the URL.
 *
 * The Dashboard_Options class give you an interface for fetching any set values or falling back
 * to a default value as needed.
 */
class Dashboard_Options
{
    public function __construct()
    {
    }
    private function get_query_value($key)
    {
        $value = $_GET[$key] ?? null;
        if ($value === null) {
            return null;
        }
        return \sanitize_text_field($value);
    }
    private function has_exact_range()
    {
        return $this->get_query_value('start') !== null && $this->get_query_value('end') !== null;
    }
    public function start()
    {
        $start = $this->get_query_value('start');
        if (!$this->has_exact_range()) {
            return null;
        }
        return $start;
    }
    public function end()
    {
        $end = $this->get_query_value('end');
        if (!$this->has_exact_range()) {
            return null;
        }
        return $end;
    }
    /**
     * Prefer exact range over relative range if both are provided
     */
    public function relative_range()
    {
        $range = $this->get_query_value('relative_range');
        if (!$this->has_exact_range() && $range === null) {
            return 'LAST_THIRTY';
        } elseif ($this->has_exact_range()) {
            return null;
        } elseif (Relative_Range::range($range) === null) {
            return 'LAST_THIRTY';
        }
        return $range;
    }
    public function date_label()
    {
        if ($this->has_exact_range()) {
            $tz = Timezone::local_timezone();
            $format = Date_Format::php();
            $formatted_start = (new \DateTime($this->start(), $tz))->format($format);
            $formatted_end = (new \DateTime($this->end(), $tz))->format($format);
            return $formatted_start . ' - ' . $formatted_end;
        } else {
            return Relative_Range::range($this->relative_range())->label;
        }
    }
    public function date_range()
    {
        if ($this->has_exact_range()) {
            return new Exact_Range($this->start(), $this->end());
        } else {
            return Relative_Range::range($this->relative_range());
        }
    }
    public function columns()
    {
        $value = $_GET['cols'] ?? null;
        if ($value === null) {
            return null;
        }
        $columns = \explode(',', $value);
        \array_map(function ($column) {
            return \sanitize_text_field($column);
        }, $columns);
        return $columns;
    }
    public function filters()
    {
        $value = $_GET['filters'] ?? null;
        if ($value === null) {
            return [];
        } else {
            $value = \base64_decode($value);
            $filters = \json_decode($value);
            $sanitized_filters = [];
            foreach ($filters as $filter) {
                $sanitized_filter = [];
                foreach ($filter as $key => $value) {
                    $sanitized_filter[$key] = \sanitize_text_field($value);
                }
                $sanitized_filters[] = $sanitized_filter;
            }
        }
        return $sanitized_filters;
    }
    public function sort_by()
    {
        return $this->get_query_value('sort_by') ?? 'visitors';
    }
    public function sort_direction()
    {
        return $this->get_query_value('sort_direction') ?? 'desc';
    }
}
