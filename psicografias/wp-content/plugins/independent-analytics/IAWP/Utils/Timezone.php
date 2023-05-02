<?php

namespace IAWP_SCOPED\IAWP\Utils;

class Timezone
{
    public static function utc_timezone()
    {
        return new \DateTimeZone('UTC');
    }
    public static function utc_offset()
    {
        return '+00:00';
    }
    public static function local_timezone()
    {
        return new \DateTimeZone(self::local_offset());
    }
    // Will return an offset using the WordPress timezone set by the user
    // Example return values: -04:00, +00:00, or +5:45
    public static function local_offset()
    {
        // Start with the offset such as -4, 0, or 5.75
        $offset_number = (float) \get_option('gmt_offset');
        // Build a string to represent the offset such as -04:00, +00:00, or +5:45
        $result = '';
        // Start with either - or +
        $result .= $offset_number < 0 ? '-' : '+';
        $whole_part = \abs($offset_number);
        $hour_part = \floor($whole_part);
        $minute_part = $whole_part - $hour_part;
        $hours = \strval($hour_part);
        $minutes = \strval($minute_part * 60);
        // Add hour part to result
        $result .= \str_pad($hours, 2, '0', \STR_PAD_LEFT);
        // Add separator
        $result .= ':';
        // Add minute part to result
        $result .= \str_pad($minutes, 2, '0', \STR_PAD_LEFT);
        return $result;
    }
}
