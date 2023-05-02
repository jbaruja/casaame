<?php

namespace IAWP_SCOPED\IAWP\Queries;

use IAWP_SCOPED\IAWP\Models\Page_Author_Archive;
use IAWP_SCOPED\IAWP\Models\Page_Date_Archive;
use IAWP_SCOPED\IAWP\Models\Page_Home;
use IAWP_SCOPED\IAWP\Models\Page_Not_Found;
use IAWP_SCOPED\IAWP\Models\Page_Post_Type_Archive;
use IAWP_SCOPED\IAWP\Models\Page_Search;
use IAWP_SCOPED\IAWP\Models\Page_Singular;
use IAWP_SCOPED\IAWP\Models\Page_Term_Archive;
use IAWP_SCOPED\IAWP\Query;
class Resources extends Range_Query
{
    private $results;
    public function fetch()
    {
        if (\is_null($this->results)) {
            $this->results = $this->query();
        }
        return $this->results;
    }
    private function query()
    {
        $rows = Query::query('get_resources', ['start' => $this->formatted_start(), 'end' => $this->formatted_end(), 'prev_start' => $this->prev_period_formatted_start(), 'prev_end' => $this->prev_period_formatted_end()])->rows();
        return $this->rows_to_pages($rows);
    }
    private function rows_to_pages($rows)
    {
        return \array_map(function ($row) {
            switch ($row->resource) {
                case 'singular':
                    return new Page_Singular($row);
                case 'author_archive':
                    return new Page_Author_Archive($row);
                case 'date_archive':
                    return new Page_Date_Archive($row);
                case 'post_type_archive':
                    return new Page_Post_Type_Archive($row);
                case 'term_archive':
                    return new Page_Term_Archive($row);
                case 'search':
                    return new Page_Search($row);
                case 'home':
                    return new Page_Home($row);
                case '404':
                    return new Page_Not_Found($row);
            }
        }, $rows);
    }
}
