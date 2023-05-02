<?php

namespace IAWP_SCOPED\IAWP;

use IAWP_SCOPED\IAWP\Models\Visitor;
use IAWP_SCOPED\IAWP\Utils\Request;
class WooCommerce_Order
{
    private $order_id;
    public function __construct(int $order_id)
    {
        $this->order_id = $order_id;
    }
    public function insert() : void
    {
        global $wpdb;
        $wc_orders_table = Query::get_table_name(Query::WC_ORDERS);
        $order_id = $this->order_id();
        $view_id = $this->view_id();
        if (\is_null($view_id)) {
            return;
        }
        $existing_wc_order = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wc_orders_table} WHERE order_id = %d", $order_id));
        if (!\is_null($existing_wc_order)) {
            return;
        }
        $wpdb->insert($wc_orders_table, ['view_id' => $view_id, 'order_id' => $order_id, 'created_at' => (new \DateTime())->format('Y-m-d H:i:s')]);
    }
    private function view_id() : ?int
    {
        $visitor = new Visitor(Request::ip(), Request::user_agent());
        return $visitor->most_recent_view_id();
    }
    private function order_id() : int
    {
        return $this->order_id;
    }
    public static function initialize_order_tracker()
    {
        \add_action('woocommerce_checkout_order_created', function ($order) {
            try {
                $woocommerce_order = new self($order->id);
                $woocommerce_order->insert();
            } catch (\Throwable $e) {
                \error_log('Independent Analytics was unable to track the analytics for a WooCommerce order. Please report this error to Independent Analytics. The error message is below.');
                \error_log($e->getMessage());
            }
        });
    }
}
