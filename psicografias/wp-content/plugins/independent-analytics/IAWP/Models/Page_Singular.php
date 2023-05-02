<?php

namespace IAWP_SCOPED\IAWP\Models;

use IAWP_SCOPED\IAWP\Utils\String_Util;
class Page_Singular extends Page
{
    private $singular_id;
    private $comments;
    public function __construct($row)
    {
        $this->singular_id = $row->singular_id;
        $this->comments = $row->comments ?? 0;
        parent::__construct($row);
    }
    /**
     * Override comments method to add comments support for singular pages.
     *
     * @return int|null
     */
    public function comments() : ?int
    {
        return $this->comments;
    }
    protected function resource_key() : string
    {
        return 'singular_id';
    }
    protected function resource_value() : string
    {
        return $this->singular_id;
    }
    protected function calculate_is_deleted() : bool
    {
        $post = \get_post($this->singular_id);
        return \is_null($post) || \is_null(\get_post_type_object($post->post_type));
    }
    protected function calculate_url()
    {
        return \get_permalink($this->singular_id);
    }
    protected function calculate_title()
    {
        return \get_the_title($this->singular_id);
    }
    protected function calculate_type()
    {
        return \get_post_type($this->singular_id);
    }
    protected function calculate_type_label()
    {
        return \get_post_type_object(\get_post_type($this->singular_id))->labels->singular_name;
    }
    protected function calculate_icon()
    {
        $icon = null;
        if (!$this->calculate_is_deleted()) {
            $icon = \get_post_type_object($this->type(\true))->menu_icon;
        }
        $has_icon = !\is_null($icon);
        $is_url = \esc_url_raw($icon) == $icon;
        $html = '<div class="post-type-icon">';
        if ($has_icon && $is_url) {
            if (String_Util::str_contains($icon, 'svg')) {
                $html .= '<span class="custom-icon" style="display: block;-webkit-mask: url(' . \esc_url($icon) . ') no-repeat center;mask: url(' . \esc_url($icon) . ') no-repeat center;"></span>';
            } else {
                $html .= '<span><img src="' . \esc_url($icon) . '" width="20px" height="20px" /></span>';
            }
        } elseif ($has_icon) {
            $html .= '<span class="dashicons ' . \esc_attr($icon) . '"></span>';
        } else {
            $html .= '<span class="dashicons dashicons-admin-post"></span>';
        }
        $html .= '</div>';
        return $html;
    }
    protected function calculate_author_id()
    {
        return \get_post_field('post_author', $this->singular_id);
    }
    protected function calculate_author()
    {
        return \get_the_author_meta('display_name', $this->author_id());
    }
    protected function calculate_avatar()
    {
        return \get_avatar($this->author_id(), 20);
    }
    protected function calculate_date()
    {
        return \get_the_date('U', $this->singular_id);
    }
    protected function calculate_category()
    {
        $post_type_still_registered = \in_array($this->calculate_type(), \get_post_types());
        $categories = [];
        if (!$post_type_still_registered) {
            return [];
        }
        foreach (\get_the_category($this->singular_id) as $category) {
            $categories[] = $category->term_id;
        }
        return $categories;
    }
}
