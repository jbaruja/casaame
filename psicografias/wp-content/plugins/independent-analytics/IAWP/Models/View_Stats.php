<?php

namespace IAWP_SCOPED\IAWP\Models;

trait View_Stats
{
    protected $views;
    protected $prev_period_views;
    protected $visitors;
    protected $prev_period_visitors;
    protected $sessions;
    protected $prev_period_sessions;
    protected final function set_view_stats($row)
    {
        $this->views = isset($row->views) ? \intval($row->views) : null;
        $this->prev_period_views = isset($row->prev_period_views) ? \intval($row->prev_period_views) : null;
        $this->visitors = isset($row->visitors) ? \intval($row->visitors) : null;
        $this->prev_period_visitors = isset($row->prev_period_visitors) ? \intval($row->prev_period_visitors) : null;
        $this->sessions = isset($row->sessions) ? \intval($row->sessions) : null;
        $this->prev_period_sessions = isset($row->prev_period_sessions) ? \intval($row->prev_period_sessions) : null;
    }
    public final function views()
    {
        return $this->views;
    }
    public final function prev_period_views()
    {
        return $this->prev_period_views;
    }
    public final function views_growth()
    {
        $current = $this->views();
        $previous = $this->prev_period_views();
        if ($current == 0 || $previous == 0) {
            return 0;
        } else {
            return ($current - $previous) / $previous * 100;
        }
    }
    public final function visitors()
    {
        return $this->visitors;
    }
    public final function prev_period_visitors()
    {
        return $this->prev_period_visitors;
    }
    public final function visitors_growth()
    {
        $current = $this->visitors();
        $previous = $this->prev_period_visitors();
        if ($current == 0 || $previous == 0) {
            return 0;
        } else {
            return ($current - $previous) / $previous * 100;
        }
    }
    public final function sessions()
    {
        return $this->sessions;
    }
    public final function prev_period_sessions()
    {
        return $this->prev_period_sessions;
    }
    public final function sessions_growth()
    {
        $current = $this->sessions();
        $previous = $this->prev_period_sessions();
        if ($current == 0 || $previous == 0) {
            return 0;
        } else {
            return ($current - $previous) / $previous * 100;
        }
    }
}
