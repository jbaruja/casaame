<?php

namespace IAWP_SCOPED\IAWP\Utils;

class Exact_Range
{
    public $label;
    public $start;
    public $end;
    public function __construct($start, $end)
    {
        $tz = Timezone::local_timezone();
        $this->start = new \DateTime($start, $tz);
        $this->end = new \DateTime($end, $tz);
        $this->label = $this->get_label();
    }
    private function get_label()
    {
        $formatted_start = $this->start->format(Date_Format::php());
        $formatted_end = $this->end->format(Date_Format::php());
        return $formatted_start . ' - ' . $formatted_end;
    }
}
