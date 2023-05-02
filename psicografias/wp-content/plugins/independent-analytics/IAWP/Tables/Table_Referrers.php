<?php

namespace IAWP_SCOPED\IAWP\Tables;

class Table_Referrers extends Table
{
    protected function local_columns() : array
    {
        return [new Column(['id' => 'referrer', 'label' => \esc_html__('Referrer', 'iawp'), 'visible' => \true, 'sort_direction' => 'asc']), new Column(['id' => 'referrer_type', 'label' => \esc_html__('Referrer Type', 'iawp'), 'visible' => \true, 'sort_direction' => 'asc']), new Column(['id' => 'visitors', 'label' => \esc_html__('Visitors', 'iawp'), 'visible' => \true, 'sort_direction' => 'desc']), new Column(['id' => 'views', 'label' => \esc_html__('Views', 'iawp'), 'visible' => \true, 'sort_direction' => 'desc']), new Column(['id' => 'sessions', 'label' => \esc_html__('Sessions', 'iawp'), 'visible' => \true, 'sort_direction' => 'desc']), new Column(['id' => 'visitors_growth', 'label' => \esc_html__('Visitors Growth', 'iawp'), 'visible' => \false, 'sort_direction' => 'desc', 'exportable' => \false]), new Column(['id' => 'views_growth', 'label' => \esc_html__('Views Growth', 'iawp'), 'visible' => \false, 'sort_direction' => 'desc', 'exportable' => \false]), new Column(['id' => 'wc_orders', 'label' => \esc_html__('Orders', 'iawp'), 'visible' => \false, 'sort_direction' => 'desc', 'requires_woocommerce' => \true]), new Column(['id' => 'wc_gross_sales', 'label' => \esc_html__('Gross Sales', 'iawp'), 'visible' => \false, 'sort_direction' => 'desc', 'requires_woocommerce' => \true]), new Column(['id' => 'wc_refunds', 'label' => \esc_html__('Refunds', 'iawp'), 'visible' => \false, 'sort_direction' => 'desc', 'requires_woocommerce' => \true]), new Column(['id' => 'wc_refunded_amount', 'label' => \esc_html__('Refunded Amount', 'iawp'), 'visible' => \false, 'sort_direction' => 'desc', 'requires_woocommerce' => \true]), new Column(['id' => 'wc_net_sales', 'label' => \esc_html__('Net Sales', 'iawp'), 'visible' => \false, 'sort_direction' => 'desc', 'requires_woocommerce' => \true]), new Column(['id' => 'woocommerce_conversion_rate', 'label' => \esc_html__('Conversion Rate', 'iawp'), 'visible' => \false, 'sort_direction' => 'desc', 'requires_woocommerce' => \true]), new Column(['id' => 'woocommerce_earnings_per_visitor', 'label' => \esc_html__('Earnings Per Visitor', 'iawp'), 'visible' => \false, 'sort_direction' => 'desc', 'requires_woocommerce' => \true]), new Column(['id' => 'woocommerce_average_order_volume', 'label' => \esc_html__('Average Order Volume', 'iawp'), 'visible' => \false, 'sort_direction' => 'desc', 'requires_woocommerce' => \true])];
    }
    protected function table_name() : string
    {
        return 'referrers';
    }
}
