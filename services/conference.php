<?php

/**
 * Conference object
 * User: jf
 * Date: 12/25/2016
 */
class conference extends dto
{
    public $visible_id;
    public $category_id;
    public $title;
    public $description;
    public $tags;
    public $icon;
    public $thumbnail;
    public $cover_image;
    public $is_private;
    public $group_id;
    public $num_topics;
    public $num_comments;
    public $last_comment_id;
    public $last_comment_update;

    public $membership;
    public $comments;

    public function get($id) {

    }

    public function save() {
        if ($this->_id < 1) {

        } elseif ($this->_has_changed) {

        }
    }
}