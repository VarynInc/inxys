<?php
/**
 * User: jf
 * Date: 12/25/2016
 * Time: 10:01 AM
 */
class user extends dto
{
    public $user_name;
    public $alt_name;
    public $site_user_id;
    public $avatar_last_changed_at;
    public $site_currency_value;
    public $cash_balance;
    public $site_experience_points;
    public $source_site_id;
    public $real_name;
    public $dob;
    public $gender;
    public $zipcode;
    public $email_address;
    public $mobile_number;
    public $im_id;
    public $security_question_id;
    public $security_question;
    public $security_answer;
    public $tagline;
    public $city;
    public $state;
    public $country_code;
    public $agreement;
    public $reg_confirmed;
    public $last_login;
    public $login_count;
    public $view_count;
    public $img_url;
    public $about_me;
    public $additional_info;
    public $network_id;
    public $access_level;
    public $user_status_id;
    public $user_status_date;

    public function get($id) {

    }

    public function save() {
        if ($this->_id < 1) {

        } elseif ($this->_has_changed) {

        }
    }
}