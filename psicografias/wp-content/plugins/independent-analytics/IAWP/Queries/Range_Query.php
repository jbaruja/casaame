<?php

namespace IAWP_SCOPED\IAWP\Queries;

use IAWP_SCOPED\IAWP\Utils\Timezone;
abstract class Range_Query
{
    private $start;
    private $end;
    const FORMAT_PATTERN = 'Y-m-d H:i:s';
    public function __construct($options = [])
    {
        $options = \IAWP_SCOPED\iawp_default_args($options, ['start' => new \DateTime('1991-01-06'), 'end' => new \DateTime(), 'convert_to_full_days' => \true]);
        $this->start = clone $options['start'];
        $this->end = clone $options['end'];
        if ($options['convert_to_full_days']) {
            $this->start = $this->start_of_locale_day($this->start);
            $this->end = $this->end_of_locale_day($this->end);
        }
    }
    private function start_of_locale_day(\DateTime $datetime) : \DateTime
    {
        $user_timezone = new \DateTimeZone(Timezone::local_offset());
        $utc_timezone = new \DateTimeZone('UTC');
        return $datetime->setTimezone($user_timezone)->setTime(0, 0, 0)->setTimezone($utc_timezone);
    }
    private function end_of_locale_day(\DateTime $datetime) : \DateTime
    {
        $user_timezone = new \DateTimeZone(Timezone::local_offset());
        $utc_timezone = new \DateTimeZone('UTC');
        return $datetime->setTimezone($user_timezone)->setTime(23, 59, 59)->setTimezone($utc_timezone);
    }
    public final function start()
    {
        return $this->start;
    }
    protected final function formatted_start()
    {
        return $this->start->format(self::FORMAT_PATTERN);
    }
    public final function end()
    {
        return $this->end;
    }
    protected final function formatted_end()
    {
        return $this->end->format(self::FORMAT_PATTERN);
    }
    private function range_size()
    {
        return $this->start->diff($this->end)->days + 1;
    }
    public final function prev_period_start()
    {
        $prev_start = clone $this->start;
        $range_size = $this->range_size();
        return $prev_start->modify("-{$range_size} days");
    }
    protected final function prev_period_formatted_start()
    {
        return $this->prev_period_start()->format(self::FORMAT_PATTERN);
    }
    public final function prev_period_end()
    {
        $prev_end = clone $this->end;
        $range_size = $this->range_size();
        return $prev_end->modify("-{$range_size} days");
    }
    protected final function prev_period_formatted_end()
    {
        return $this->prev_period_end()->format(self::FORMAT_PATTERN);
    }
}
