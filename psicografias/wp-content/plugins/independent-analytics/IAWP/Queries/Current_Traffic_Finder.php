<?php

namespace IAWP_SCOPED\IAWP\Queries;

use IAWP_SCOPED\IAWP\Models\Current_Traffic;
use IAWP_SCOPED\IAWP\Query;
class Current_Traffic_Finder extends Range_Query
{
    public function fetch()
    {
        $row = Query::query('get_current_traffic', ['start' => $this->formatted_start(), 'end' => $this->formatted_end()])->row();
        return new Current_Traffic($row);
    }
}
