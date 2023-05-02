<?php

namespace IAWP_SCOPED\IAWP;

use IAWP_SCOPED\IAWP\Queries\Views;
class Quick_Stats
{
    private $views;
    private $filtered_views;
    private $preview;
    /**
     * @param Views $views
     * @param Views|null $unfiltered_views
     * @param bool $preview
     */
    public function __construct(Views $views, ?Views $unfiltered_views, bool $preview = \false)
    {
        $this->preview = $preview;
        if (\is_null($unfiltered_views)) {
            $this->views = $views;
        } else {
            $this->views = $unfiltered_views;
            $this->filtered_views = $views;
        }
    }
    /**
     * @return bool
     */
    private function is_preview() : bool
    {
        return $this->preview;
    }
    /**
     * @return bool
     */
    private function is_full_view() : bool
    {
        return !$this->is_preview();
    }
    public function get_html()
    {
        $is_filtered = !\is_null($this->filtered_views);
        $views = $is_filtered ? $this->filtered_views : $this->views;
        $stats = [['title' => \__('Visitors', 'iawp'), 'class' => 'visitors', 'count' => \number_format($views->visitors()), 'growth' => $views->visitors_percentage_growth()], ['title' => \__('Views', 'iawp'), 'class' => 'views', 'count' => \number_format($views->views()), 'growth' => $views->views_percentage_growth()]];
        if ($this->is_full_view()) {
            $stats[] = ['title' => \__('Sessions', 'iawp'), 'class' => 'sessions', 'count' => \number_format($views->sessions()), 'growth' => $views->sessions_percentage_growth()];
        }
        if ($this->is_full_view() && \IAWP_SCOPED\iawp_using_woocommerce()) {
            $stats[] = ['title' => \__('Orders', 'iawp'), 'class' => 'orders', 'count' => \number_format($views->woocommerce_orders()), 'growth' => $views->woocommerce_orders_percentage_growth()];
            $stats[] = ['title' => \__('Net Sales', 'iawp'), 'class' => 'net-sales', 'count' => \strip_tags(\wc_price($views->woocommerce_net_sales())), 'growth' => $views->woocommerce_net_sales_percentage_growth()];
        }
        if ($this->is_full_view() && $is_filtered) {
            $stats[] = ['title' => \__('Total Visitors', 'iawp'), 'class' => 'visitors unfiltered', 'count' => \number_format($this->views->visitors()), 'growth' => $this->views->visitors_percentage_growth()];
            $stats[] = ['title' => \__('Total Views', 'iawp'), 'class' => 'views unfiltered', 'count' => \number_format($this->views->views()), 'growth' => $this->views->views_percentage_growth()];
            $stats[] = ['title' => \__('Total Sessions', 'iawp'), 'class' => 'sessions unfiltered', 'count' => \number_format($this->views->sessions()), 'growth' => $this->views->sessions_percentage_growth()];
        }
        if ($this->is_full_view() && $is_filtered && \IAWP_SCOPED\iawp_using_woocommerce()) {
            $stats[] = ['title' => \__('Total Orders', 'iawp'), 'class' => 'orders unfiltered', 'count' => \number_format($this->views->woocommerce_orders()), 'growth' => $this->views->woocommerce_orders_percentage_growth()];
            $stats[] = ['title' => \__('Total Net Sales', 'iawp'), 'class' => 'net-sales unfiltered', 'count' => \strip_tags(\wc_price($this->views->woocommerce_net_sales())), 'growth' => $this->views->woocommerce_net_sales_percentage_growth()];
        }
        return \IAWP_SCOPED\iawp()->templates()->render('quick_stats', ['is_filtered' => $is_filtered, 'stats' => $stats]);
    }
}
