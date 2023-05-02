<?php

namespace IAWP_SCOPED\IAWP\AJAX;

use IAWP_SCOPED\IAWP\Capability_Manager;
use IAWP_SCOPED\IAWP\Queries\City_Statistics;
use IAWP_SCOPED\IAWP\Tables\Table_Geo;
class Export_Geo_AJAX extends AJAX
{
    protected function action_name() : string
    {
        return 'iawp_export_geo';
    }
    protected function action_callback() : void
    {
        if (!Capability_Manager::can_edit()) {
            return;
        }
        $geos = new City_Statistics();
        $rows = $geos->fetch();
        $table = new Table_Geo();
        $csv = $table->csv($rows);
        echo \wp_kses($csv, 'post');
    }
}
