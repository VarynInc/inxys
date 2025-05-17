<?php
/**
 * Conference object
 * User: jf
 * Date: 12/25/2016
 */
require_once(SERVICE_ROOT . '/dto.php');

class Conference extends dto
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

    /**
     * Return a list of conferences the logged in user is a member of.
     */
    public static function list($tags, $startDate, $endDate, $startItem, $numItems) {
        global $enginesis;
        $includePublic = false;
        return $enginesis->conferenceList($tags, $startDate, $endDate, $startItem, $numItems, $includePublic);
    }

    /**
     * Return a list of public conferences.
     */
    public static function listPublic($tags, $startDate, $endDate, $startItem, $numItems) {
        global $enginesis;
        $includePublic = true;
        return $enginesis->conferenceList($tags, $startDate, $endDate, $startItem, $numItems, $includePublic);
    }

    /**
     * Render an HTML template for a single conference.
     * { ["conference_id"]=> int(2) ["visible_id"]=> string(4) "C103" ["site_id"]=> int(109) ["title"]=> string(14) "Murray's Place" ["description"]=> string(20) "Commentary by Murray" ["tags"]=> string(24) "Murray/Turoff/Technology" ["conference_category_id"]=> int(4) ["category_name"]=> string(10) "technology" ["category_description"]=> string(10) "Technology" ["owner_user_id"]=> int(10591) ["owner_user_name"]=> string(6) "Murray" ["group_id"]=> int(0) ["num_topics"]=> int(0) ["last_topic_update"]=> NULL ["num_comments"]=> int(0) ["last_comment_id"]=> int(0) ["last_comment_update"]=> NULL ["num_replies"]=> int(0) ["last_comment"]=> NULL ["last_reply"]=> NULL ["is_private"]=> int(1) ["view_count"]=> int(0) ["last_access_date"]=> NULL ["icon"]=> string(0) "" ["thumbnail"]=> string(0) "" ["cover_image"]=> string(0) "" ["num_members"]=> int(1) }
     */
    public static function renderConferenceCard($conferenceDetails) {
        $conferenceId = $conferenceDetails->conference_id;
        $lastUpdateDate = empty($conferenceDetails->last_topic_update) ? 'never' : MySQLDateToHumanDate($conferenceDetails->last_topic_update);
        if (empty($conferenceDetails->thumbnail)) {
            $thumbnail = './default-thumbnail.jpg';
        } else {
            $thumbnail = $conferenceDetails->thumbnail;
        }
        $topicURL = '/conf/view/?id=' . $conferenceId;
        $html = '<div class="row"><div class="card p-0" data-conf-id="' . $conferenceId . '">';
        $html .= '<div class="card-header"><div class="row"><div class="col-4"><a href="' . $topicURL . '"><img class="conf-thumbnail img-fluid" src="' . $thumbnail . '"/></a></div>';
        $html .= '<div class="col-8"><h4 class="card-title"><a href="' . $topicURL . '">' . $conferenceDetails->title . '</a></h4>';
        $html .= '<p class="conf-attributes">' . $conferenceDetails->visible_id . ': (' . $conferenceDetails->category_description. ') ' . $conferenceDetails->num_members . ' members, ' . $conferenceDetails->num_topics . ' topics, last updated on ' . $lastUpdateDate . '</p>';
        $html .= '<p class="conf-description">' . $conferenceDetails->description . '</p>';
        $html .= '</div></div></div><div class="card-body">Show most recent topic, most recent comment...</div><div class="card-footer"><div class="row">';
        $html .= '<div class="conf-tag-list col-6">' . $conferenceDetails->tags . '</div>';
        $html .= '<div class="btn-group conf-action-buttons col-6" role="group" aria-label="Conference actions"><button type="button" class="btn btn-secondary">Read</button><button type="button" class="btn btn-secondary">Skip</button><button type="button" class="btn btn-secondary">Comment</button></div>';
        $html .= '</div></div></div>';
        return $html;
    }

    public function get($id) {

    }

    public function save() {
        if ($this->_id < 1) {

        } elseif ($this->_has_changed) {

        }
    }
}