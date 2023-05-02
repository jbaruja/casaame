<?php

namespace IAWP_SCOPED\IAWP\Utils;

class Number_Formatter
{
    public static function format($number, $format = 'decimal', $decimals = 0)
    {
        if ($format == 'percent') {
            if (\class_exists('\\NumberFormatter')) {
                $formatter = new \NumberFormatter(\get_locale(), \NumberFormatter::PERCENT);
                $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $decimals);
                return $formatter->format($number / 100);
            } else {
                return \number_format_i18n($number, $decimals) . '%';
            }
        } else {
            return \number_format_i18n($number, $decimals);
        }
    }
}
