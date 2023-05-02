<?php

namespace IAWP_SCOPED\IAWP;

use IAWP_SCOPED\IAWP\Queries\Views;
use IAWP_SCOPED\IAWP\Utils\Relative_Range;
class Dashboard_Widget
{
    public function __construct()
    {
        \add_action('wp_dashboard_setup', [$this, 'add_dashboard_widget']);
    }
    public function add_dashboard_widget()
    {
        if (Migrations\Migration::is_migrating() || !Capability_Manager::can_view()) {
            return;
        }
        $url = \add_query_arg(['page' => 'independent-analytics'], \admin_url('admin.php'));
        \ob_start();
        ?>
        <span><?php 
        \esc_html_e('Analytics', 'iawp');
        ?></span>
        <span>
            <a href="<?php 
        echo \esc_url($url);
        ?>" class="iawp-button purple">
                <?php 
        \esc_html_e('Open Dashboard');
        ?>
            </a>
        </span>
        <?php 
        $title = \ob_get_contents();
        \ob_end_clean();
        \wp_add_dashboard_widget('iawp', $title, [$this, 'dashboard_widget']);
    }
    public function dashboard_widget()
    {
        $range = Relative_Range::range('LAST_THIRTY');
        $views = new Views(Views::RESOURCES, null, $range->start, $range->end);
        $chart = new Chart($views, null, \true);
        $stats = new Quick_Stats($views, null, \true);
        echo $chart->get_html();
        echo $stats->get_html();
    }
}
