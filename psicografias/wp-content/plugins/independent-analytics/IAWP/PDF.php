<?php

namespace IAWP_SCOPED\IAWP;

use IAWP_SCOPED\Dompdf\Dompdf;
use IAWP_SCOPED\Dompdf\Options;
use IAWP_SCOPED\IAWP\Queries\Country_Statistics;
use IAWP_SCOPED\IAWP\Queries\Referrers;
use IAWP_SCOPED\IAWP\Queries\Resources;
use IAWP_SCOPED\IAWP\Queries\Views;
use IAWP_SCOPED\IAWP\Utils\Relative_Range;
require_once \ABSPATH . 'wp-admin/includes/file.php';
class PDF
{
    public function create_and_save_pdf()
    {
        $html = $this->get_pdf_html();
        $pdf = $this->generate_pdf($html);
        $file_path = $this->save_pdf_file($pdf);
        return $file_path;
    }
    private function get_pdf_html()
    {
        $range = Relative_Range::range('LAST_MONTH');
        $views = new Views(Views::RESOURCES, null, $range->start, $range->end);
        $analytics_url = \add_query_arg(['page' => 'independent-analytics'], \admin_url('admin.php'));
        $style_url = \IAWP_SCOPED\iawp_url_to('dist/styles/pdf.css');
        $html = \IAWP_SCOPED\iawp()->templates()->render('pdf/site-overview', ['title' => \get_bloginfo('name'), 'date' => (new \DateTime('Last month'))->format('F Y'), 'stats' => (new Quick_Stats($views, null))->get_html(), 'chart_data' => (new Chart_SVG($views, 700, 300))->get_svg_data(), 'top_ten' => $this->get_top_ten(), 'analytics_url' => $analytics_url, 'style_url' => $style_url]);
        return $html;
    }
    private function generate_pdf($html) : string
    {
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', \true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->output();
    }
    private function save_pdf_file($pdf) : ?string
    {
        $upload = \wp_upload_bits('site-report.pdf', null, $pdf);
        if ($upload['error']) {
            return null;
        }
        $destination_file = \trailingslashit(\wp_upload_dir()['basedir']) . 'site-report.pdf';
        global $wp_filesystem;
        \WP_Filesystem();
        $success = $wp_filesystem->move($upload['file'], $destination_file, \true);
        if ($success) {
            return $destination_file;
        } else {
            return null;
        }
    }
    private function get_top_ten() : array
    {
        $start = new \DateTime('First day of last month');
        $end = new \DateTime('Last day of last month');
        $queries = ['pages' => 'title', 'referrers' => 'referrer', 'geo' => 'country'];
        $top_ten = [];
        foreach ($queries as $type => $title) {
            if ($type === 'pages') {
                $query = new Resources(['start' => $start, 'end' => $end]);
            } elseif ($type === 'referrers') {
                $query = new Referrers(['start' => $start, 'end' => $end]);
            } elseif ($type === 'geo') {
                $query = new Country_Statistics(['start' => $start, 'end' => $end]);
            } else {
                continue;
            }
            $data = $query->fetch();
            \usort($data, function ($a, $b) {
                $a = $a->views();
                $b = $b->views();
                if ($a < $b) {
                    return 1;
                } elseif ($a > $b) {
                    return -1;
                } else {
                    return 0;
                }
            });
            $data = \array_slice($data, 0, 10);
            $rows = \array_map(function ($row, $index) use($title) {
                $edited_title = $row->{$title}();
                $edited_title = \strlen($edited_title) > 26 ? \substr($edited_title, 0, 26) . '...' : $edited_title;
                return ['title' => $edited_title, 'views' => $row->views()];
            }, $data, \array_keys($data));
            $top_ten[$type] = $rows;
        }
        return $top_ten;
    }
}
