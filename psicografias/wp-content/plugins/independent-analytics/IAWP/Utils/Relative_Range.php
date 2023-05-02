<?php

namespace IAWP_SCOPED\IAWP\Utils;

class Relative_Range
{
    public $id;
    public $label;
    public $start;
    public $end;
    private function __construct($id)
    {
        $this->id = $id;
        list($start, $end, $label) = $this->{$id}();
        $this->label = $label;
        $this->start = $start;
        $this->end = $end;
    }
    private function today() : array
    {
        $tz = Timezone::local_timezone();
        $today = new \DateTime('now', $tz);
        return [$today, $today, \__('Today', 'iawp')];
    }
    private function yesterday() : array
    {
        $tz = Timezone::local_timezone();
        $yesterday = new \DateTime('-1 day', $tz);
        return [$yesterday, $yesterday, \__('Yesterday', 'iawp')];
    }
    private function last_seven() : array
    {
        $tz = Timezone::local_timezone();
        $today = new \DateTime('now', $tz);
        $seven_days_ago = new \DateTime('-6 days', $tz);
        return [$seven_days_ago, $today, \__('Last 7 Days', 'iawp')];
    }
    private function last_thirty() : array
    {
        $tz = Timezone::local_timezone();
        $today = new \DateTime('now', $tz);
        $thirty_days_ago = new \DateTime('-29 days', $tz);
        return [$thirty_days_ago, $today, \__('Last 30 Days', 'iawp')];
    }
    private function this_week() : array
    {
        $tz = Timezone::local_timezone();
        $today = new \DateTime('now', $tz);
        $firstDayOfWeek = \intval(\get_option('iawp_dow'));
        $currentDayOfWeek = \intval($today->format('w'));
        $startOfWeekDaysAgo = $currentDayOfWeek - $firstDayOfWeek;
        if ($startOfWeekDaysAgo < 0) {
            $startOfWeekDaysAgo += 7;
        }
        $startOfWeek = new \DateTime("-{$startOfWeekDaysAgo} days", $tz);
        $endOfWeek = (clone $startOfWeek)->modify('+6 days');
        return [$startOfWeek, $endOfWeek, \__('This Week', 'iawp')];
    }
    private function last_week() : array
    {
        list($start, $end) = $this->this_week();
        $startOfWeek = $start->modify('-7 days');
        $endOfWeek = $end->modify('-7 days');
        return [$startOfWeek, $endOfWeek, \__('Last Week', 'iawp')];
    }
    private function this_month() : array
    {
        $tz = Timezone::local_timezone();
        $today = new \DateTime('now', $tz);
        $day_of_month = \intval($today->format('d')) - 1;
        $days_in_month = \intval($today->format('t')) - 1;
        $start_of_month = (clone $today)->modify("-{$day_of_month} days");
        $end_of_month = (clone $start_of_month)->modify("+{$days_in_month} days");
        return [$start_of_month, $end_of_month, \__('This Month', 'iawp')];
    }
    private function last_month() : array
    {
        list($start, $end) = $this->this_month();
        $start_of_last_month = (clone $start)->modify('-1 month');
        $days_in_last_month = \intval($start_of_last_month->format('t')) - 1;
        $end_of_last_month = (clone $start_of_last_month)->modify("+{$days_in_last_month} days");
        return [$start_of_last_month, $end_of_last_month, \__('Last Month', 'iawp')];
    }
    private function this_year() : array
    {
        $tz = Timezone::local_timezone();
        $today = new \DateTime('now', $tz);
        $year = \intval($today->format('Y'));
        $start_of_year = (clone $today)->setDate($year, 1, 1);
        $end_of_year = (clone $today)->setDate($year, 12, 31);
        return [$start_of_year, $end_of_year, \__('This Year', 'iawp')];
    }
    private function last_year() : array
    {
        $tz = Timezone::local_timezone();
        $today = new \DateTime('now', $tz);
        $last_year = \intval($today->format('Y')) - 1;
        $start_of_last_year = (clone $today)->setDate($last_year, 1, 1);
        $end_of_last_year = (clone $today)->setDate($last_year, 12, 31);
        return [$start_of_last_year, $end_of_last_year, \__('Last Year', 'iawp')];
    }
    /**
     * Get a list of supported ranges including their id, text, start, and end date
     *
     * @return Relative_Range[] Supported ranges
     */
    public static function ranges() : array
    {
        return [new self('TODAY'), new self('YESTERDAY'), new self('LAST_SEVEN'), new self('LAST_THIRTY'), new self('THIS_WEEK'), new self('LAST_WEEK'), new self('THIS_MONTH'), new self('LAST_MONTH'), new self('THIS_YEAR'), new self('LAST_YEAR')];
    }
    /**
     * @param string $id
     * @return Relative_Range|null
     */
    public static function range(string $id) : ?Relative_Range
    {
        $ranges = self::ranges();
        $matching_ranges = \array_values(\array_filter($ranges, function ($range) use($id) {
            return $range->id === $id;
        }));
        if (\count($matching_ranges) > 0) {
            return $matching_ranges[0];
        } else {
            return null;
        }
    }
}
