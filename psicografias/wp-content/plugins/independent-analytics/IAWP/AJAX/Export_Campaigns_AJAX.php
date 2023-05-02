<?php

namespace IAWP_SCOPED\IAWP\AJAX;

use IAWP_SCOPED\IAWP\Capability_Manager;
use IAWP_SCOPED\IAWP\Queries\Campaigns;
use IAWP_SCOPED\IAWP\Tables\Table_Campaigns;
class Export_Campaigns_AJAX extends AJAX
{
    protected function action_name() : string
    {
        return 'iawp_export_campaigns';
    }
    protected function action_callback() : void
    {
        if (!Capability_Manager::can_edit()) {
            return;
        }
        $campaigns = new Campaigns();
        $rows = $campaigns->fetch();
        $table = new Table_Campaigns();
        $csv = $table->csv($rows);
        echo \wp_kses($csv, 'post');
    }
}
