<html>
  <head>
    <link rel="stylesheet" href="<?php echo esc_url($style_url); ?>">
  </head>
  <body>
    <div id="header">
        <div class="content">
            <div class="date"><?php esc_html_e($date); ?></div>
            <div class="title"><?php esc_html_e($title); ?></div>
            <div class="subtitle"><?php esc_html_e('Site Performance Report', 'iawp'); ?></div>
        </div>
    </div>
    <div id="main">
        <?php echo $stats; ?>
        <?php $chart = $this->fetch('pdf/chart', ['chart_data' => $chart_data]); ?>
        <div id="chart">
            <div class="labels">
                <span class="label-date"><?php esc_html_e($date); ?></span>
                <span class="label-visitors"><?php esc_html_e('Visitors', 'iawp'); ?></span>
                <span class="label-views"><?php esc_html_e('Views', 'iawp'); ?></span>
                <span class="label-sessions"><?php esc_html_e('Sessions', 'iawp'); ?></span>
            </div>
            <img src="data:image/svg+xml;base64,<?php echo base64_encode($chart); ?>">
        </div>
        <div id="top-results">
            <?php
            foreach ($top_ten as $title => $list) {
                $this->insert(
                    'pdf/top-ten',
                    [
                    'title' => ucfirst($title),
                    'items' => $list,
                ]
                );
            }
    ?>
        </div>
    </div>
    <div id="footer">
        <p><?php echo esc_html__('Performance report generated by Independent Analytics.', 'iawp') . ' <a href="' . esc_url($analytics_url) . '">' . esc_html('Explore more data', 'iawp') . '</a>.'; ?><p>
    <div>
  </body>
</html>