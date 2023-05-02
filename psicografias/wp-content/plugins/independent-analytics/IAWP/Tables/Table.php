<?php

namespace IAWP_SCOPED\IAWP\Tables;

use IAWP_SCOPED\IAWP\Dashboard_Options;
use IAWP_SCOPED\IAWP\Filters;
use IAWP_SCOPED\IAWP\Utils\Array_To_CSV;
use IAWP_SCOPED\IAWP\Utils\Date_Format;
use IAWP_SCOPED\IAWP\Utils\Number_Formatter;
use IAWP_SCOPED\IAWP\Utils\Relative_Range;
use IAWP_SCOPED\IAWP\Utils\Security;
abstract class Table
{
    /**
     * @return array<Column>
     */
    protected abstract function local_columns() : array;
    protected abstract function table_name() : string;
    private $filters;
    private $visible_columns;
    private $views;
    public function __construct($visible_columns = null)
    {
        $this->filters = new Filters();
        $this->visible_columns = $visible_columns;
    }
    public function get_columns() : array
    {
        if ($this->visible_columns === null) {
            return $this->local_columns();
        }
        return \array_map(function ($column) {
            if (\in_array($column->id(), $this->visible_columns)) {
                $column->set_visible(\true);
            }
            return $column;
        }, $this->local_columns());
    }
    public function visible_column_ids()
    {
        $visible_columns = [];
        foreach ($this->get_columns() as $column) {
            if ($column->visible()) {
                $visible_columns[] = $column->id();
            }
        }
        return $visible_columns;
    }
    public function get_table_markup()
    {
        $opts = new Dashboard_Options();
        $templates = \IAWP_SCOPED\iawp()->templates();
        return $templates->render('table/index', ['just_rows' => \false, 'table_name' => $this->table_name(), 'all_columns' => $this->get_columns(), 'visible_columns' => $this->get_visible_columns(), 'row_count' => 0, 'rows' => [], 'render_skeleton' => \true, 'page_size' => \IAWP_SCOPED\iawp()->pagination_page_size(), 'opts' => $opts]);
    }
    public function set_views($views)
    {
        $this->views = $views;
    }
    public function get_row_markup($rows)
    {
        return $this->get_rendered_template($rows, \true);
    }
    private function get_visible_columns() : int
    {
        $visible_columns = 0;
        foreach ($this->get_columns() as $column) {
            if ($column->visible()) {
                $visible_columns++;
            }
        }
        return $visible_columns;
    }
    private function get_rendered_template($rows, $just_rows = \false)
    {
        $opts = new Dashboard_Options();
        $templates = \IAWP_SCOPED\iawp()->templates();
        $templates->registerFunction('row_data_attributes', [$this, 'get_row_data_attributes']);
        $templates->registerFunction('cell_content', [$this, 'get_cell_content']);
        return $templates->render('table/index', ['just_rows' => $just_rows, 'table_name' => $this->table_name(), 'all_columns' => $this->get_columns(), 'visible_columns' => $this->get_visible_columns(), 'row_count' => \count($rows), 'rows' => $rows, 'render_skeleton' => \false, 'page_size' => \IAWP_SCOPED\iawp()->pagination_page_size(), 'opts' => $opts]);
    }
    public function get_row_data_attributes($row)
    {
        $html = '';
        foreach ($this->get_columns() as $column) {
            $id = $column->id();
            $data_val = $row->{$id}();
            $html .= ' data-' . \esc_attr($column->id()) . '="' . \esc_attr($data_val) . '"';
        }
        return $html;
    }
    public function get_cell_content($row, $column_id)
    {
        if (\is_null($row->{$column_id}())) {
            return null;
        }
        if ($column_id == 'title' && $row->is_deleted()) {
            return Security::string($row->{$column_id}()) . ' <span class="deleted-label">' . \esc_html__('(deleted)', 'iawp') . '</span>';
        } elseif ($column_id == 'views') {
            $views = \number_format($row->views(), 0);
            // Getting a divide by zero error from the line below?
            // It's likely an issue with $this->views which is an instance of Views. Make sure the queries there are working.
            $views_percentage = Number_Formatter::format($row->views() / $this->views->views() * 100, 'percent', 2);
            return Security::string($views) . ' <span class="percentage">(' . Security::string($views_percentage) . ')</span>';
        } elseif ($column_id == 'visitors') {
            $visitors = \number_format($row->visitors(), 0);
            $visitors_percentage = Number_Formatter::format($row->visitors() / $this->views->visitors() * 100, 'percent', 2);
            return Security::string($visitors) . ' <span class="percentage">(' . Security::string($visitors_percentage) . ')</span>';
        } elseif ($column_id == 'sessions') {
            $sessions = \number_format($row->sessions(), 0);
            $sessions_percentage = Number_Formatter::format($row->sessions() / $this->views->sessions() * 100, 'percent', 2);
            return Security::string($sessions) . ' <span class="percentage">(' . Security::string($sessions_percentage) . ')</span>';
        } elseif ($column_id === 'views_growth' || $column_id === 'visitors_growth' || $column_id === 'woocommerce_conversion_rate') {
            return Number_Formatter::format($row->{$column_id}(), 'percent', 2);
        } elseif ($column_id == 'url') {
            if ($row->is_deleted()) {
                return Security::string(\esc_url($row->url()));
            } else {
                return '<a href="' . Security::string(\esc_url($row->url(\true))) . '" target="_blank" class="external-link">' . Security::string(\esc_url($row->url())) . '<span class="dashicons dashicons-external"></span></a>';
            }
        } elseif ($column_id == 'author') {
            return Security::html($row->avatar()) . ' ' . Security::string($row->author());
        } elseif ($column_id == 'date') {
            return Security::string(\date(Date_Format::php(), $row->date()));
        } elseif ($column_id == 'type' && \method_exists($row, 'icon') && \method_exists($row, 'type')) {
            return $row->icon(0) . ' ' . Security::string($row->type());
        } elseif ($column_id == 'referrer' && !$row->is_direct()) {
            return '<a href="' . \esc_url($row->referrer_url()) . '" target="_blank" class="external-link">' . Security::string($row->referrer()) . '<span class="dashicons dashicons-external"></span></a>';
        } elseif ($column_id === 'country') {
            return '<img class="flag" alt="Country flag" src="' . Security::string($row->flag()) . '"/>' . Security::string($row->country());
        } elseif (\function_exists('wc_price') && ($column_id === 'wc_gross_sales' || $column_id === 'wc_refunded_amount' || $column_id === 'wc_net_sales' || $column_id === 'woocommerce_earnings_per_visitor' || $column_id === 'woocommerce_average_order_volume')) {
            return Security::string(\wc_price($row->{$column_id}()));
        } else {
            return Security::string($row->{$column_id}());
        }
    }
    private function filters()
    {
        return $this->filters;
    }
    public function output_toolbar()
    {
        $opts = new Dashboard_Options();
        ?>
        <div class="toolbar">
        <div class="buttons">
            <div class="modal-parent"
                 data-controller="dates"
                 data-dates-relative-range-id-value="<?php 
        echo $opts->relative_range();
        ?>"
                 data-dates-exact-start-value="<?php 
        echo $opts->start();
        ?>"
                 data-dates-exact-end-value="<?php 
        echo $opts->end();
        ?>"
                 data-dates-first-day-of-week-value="<?php 
        echo \absint(\IAWP_SCOPED\iawp()->get_option('iawp_dow', 0));
        ?>"
                 data-dates-css-url-value="<?php 
        echo \esc_url(\IAWP_SCOPED\iawp_url_to('dist/styles/easepick/datepicker.css'));
        ?>"
                 data-dates-format-value="<?php 
        echo \esc_attr(Date_Format::js());
        ?>"
            >
                <button id="dates-button"
                        class="iawp-button ghost-white"
                        data-action="dates#toggleModal"
                        data-dates-target="modalButton"
                >
                    <span class="dashicons dashicons-calendar-alt"></span>
                    <span><?php 
        echo $opts->date_label();
        ?></span>
                </button>
                <div id="modal-dates"
                     class="modal large flex"
                     data-dates-target="modal"
                >
                    <div class="modal-inner">
                        <div id="easepick-picker"
                             data-dates-target="easepick"
                             style="display: none;"
                        >
                        </div>
                        <div class="relative-dates">
                            <?php 
        foreach (Relative_Range::ranges() as $range) {
            ?>
                                <button class="iawp-button ghost-purple"
                                        data-dates-target="relativeRange"
                                        data-action="dates#relativeRangeSelected"
                                        data-relative-range-id="<?php 
            echo $range->id;
            ?>"
                                        data-relative-range-label="<?php 
            echo $range->label;
            ?>"
                                        data-relative-range-start="<?php 
            echo $range->start->format('Y-m-d');
            ?>"
                                        data-relative-range-end="<?php 
            echo $range->end->format('Y-m-d');
            ?>"
                                >
                                    <?php 
            echo $range->label;
            ?>
                                </button>
                            <?php 
        }
        ?>
                        </div>
                        <div>
                            <hr/>
                        </div>
                        <div>
                            <button class="iawp-button purple"
                                    data-dates-target="apply"
                                    data-action="dates#apply"
                            >
                                <?php 
        \esc_html_e('Apply', 'iawp');
        ?>
                            </button>
                            <button class="iawp-button ghost-purple"
                                    data-action="dates#closeModal"
                            >
                                <?php 
        \esc_html_e('Cancel', 'iawp');
        ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        $this->filters()->output_filters($this->get_columns());
        ?>
            <?php 
        $this->column_picker();
        ?>
        </div>
        <div class="buttons">
            <button class="iawp-button ghost-white"
                    data-controller="clipboard"
                    data-action="clipboard#copy"
            >
                <span class="dashicons dashicons-admin-page"></span>
                <span data-clipboard-target="statusTextElement">
                    <?php 
        \esc_html_e('Copy Dashboard URL', 'iawp');
        ?>
                </span>
            </button>
            <a class="learn-more"
               href="https://independentwp.com/knowledgebase/dashboard/save-reports-revisit-later/"
               target="_blank"><span class="dashicons dashicons-info-outline"></span></a>
        </div>
        </div><?php 
    }
    private function column_picker()
    {
        ?>

        <div class="customize-columns modal-parent small"
             data-controller="columns"
        >
            <button id="customize-columns"
                    class="iawp-button ghost-white"
                    data-action="columns#toggleModal"
                    data-columns-target="modalButton"
            >
                <span class="dashicons dashicons-columns"></span>
                <span><?php 
        \esc_html_e('Edit Columns', 'iawp');
        ?></span>
            </button>
            <div id="modal-columns"
                 class="modal small"
                 data-columns-target="modal"
            >
                <div class="modal-inner">
                    <div class="title-small">
                        <?php 
        \esc_html_e('Columns', 'iawp');
        ?>
                    </div>
                    <?php 
        foreach ($this->get_columns() as $column) {
            ?>
                        <?php 
            if ($column->id() === 'wc_orders') {
                ?>
                            <p class="title-small wc-title">
                                <?php 
                \esc_html_e('WooCommerce', 'iawp');
                ?>
                                <?php 
                if (\IAWP_SCOPED\iawp_is_free()) {
                    ?>
                                    <span class="pro-label"><?php 
                    \esc_html_e('PRO', 'iawp');
                    ?></span>
                                <?php 
                }
                ?>
                            </p>
                        <?php 
            }
            ?>

                        <label class="column-label"
                               for="iawp-column-<?php 
            echo \esc_attr($column->id());
            ?>"
                        >
                            <input id="iawp-column-<?php 
            echo \esc_attr($column->id());
            ?>"
                                <?php 
            if ($column->requires_woocommerce() && \IAWP_SCOPED\iawp_is_free()) {
                ?>
                                    <?php 
                \checked(\true, \false, \true);
                ?>
                                    disabled="disabled"
                                    data-locked-behind-pro="true"
                                <?php 
            } else {
                ?>
                                    <?php 
                \checked(\true, $column->visible(), \true);
                ?>
                                    data-columns-target="checkbox"
                                    data-action="columns#check"
                                <?php 
            }
            ?>
                                   type="checkbox"
                                   name="<?php 
            \esc_attr_e($column->id());
            ?>"
                                   data-test-visibility="<?php 
            echo $column->visible() ? 'visible' : 'hidden';
            ?>"
                            >
                            <span><?php 
            echo \esc_html($column->label());
            ?></span>
                        </label>
                    <?php 
        }
        ?>
                </div>
            </div>
        </div>
        <?php 
    }
    public final function csv($rows)
    {
        $columns = $this->get_columns();
        $csv_header = [];
        $csv_rows = [];
        foreach ($columns as $column) {
            if (!$column->exportable() || $column->requires_woocommerce() && \IAWP_SCOPED\iawp_is_free()) {
                continue;
            }
            $csv_header[] = $column->label();
        }
        foreach ($rows as $row) {
            $csv_row = [];
            foreach ($columns as $column) {
                if (!$column->exportable() || $column->requires_woocommerce() && \IAWP_SCOPED\iawp_is_free()) {
                    continue;
                }
                $column_id = $column->id();
                if ($column_id === 'date') {
                    $csv_row[] = \date(Date_Format::php(), $row->{$column_id}());
                } else {
                    $csv_row[] = $row->{$column_id}();
                }
            }
            $csv_rows[] = $csv_row;
        }
        $csv = \array_merge([$csv_header], $csv_rows);
        return Array_To_CSV::array2csv($csv);
    }
}
