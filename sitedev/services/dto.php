<?php

/**
 * Base object
 * User: jf
 * Date: 5/3/2017
 */
abstract class dto
{
    public $_is_deleted = false;    // bool used to track if the object is deleted from the database
    public $_is_new = true;         // bool used to track insert/update
    public $_has_changed = false;   // track any changes to the object so we know we need to save it or don't bother saving if it did not change
    public $_id = -1;               // every object has an id
    public $_site_id = -1;
    public $_language_code = 'en';
    public $_created_user_id = -1;
    public $_created_date = null;
    public $_edited_user_id = -1;
    public $_edited_date = null;
    public $_last_error_code = '';       // track most recent error code
    public $_last_error_message = '';    // track most recent error code

    abstract public function get($id);
    abstract public function save();
}