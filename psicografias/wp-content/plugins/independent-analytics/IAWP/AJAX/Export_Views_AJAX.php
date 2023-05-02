<?php

namespace IAWP_SCOPED\IAWP\AJAX;

use IAWP_SCOPED\IAWP\Capability_Manager;
use IAWP_SCOPED\IAWP\Queries\Resources;
use IAWP_SCOPED\IAWP\Tables\Table_Views;
class Export_Views_AJAX extends AJAX
{
    protected function action_name() : string
    {
        return 'iawp_export_views';
    }
    protected function action_callback() : void
    {
        if (!Capability_Manager::can_edit()) {
            return;
        }
        $resources = new Resources();
        $rows = $resources->fetch();
        $table = new Table_Views();
        $csv = $table->csv($rows);
        echo \wp_kses($csv, 'post');
    }
}
