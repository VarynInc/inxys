<?php
/**
 * Create a new conference.
 */
include_once('../../services/common.php');
$pageId = 'conferences';
$pageTitle = '';
$hackerVerification = '';
?>
<!DOCTYPE html>
<?php include(VIEWS_ROOT . 'page-header.php');?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>Create New Conference</h1>
    <p>Enter information about your new conference:</p>
    <div class="row">
    <form id="login-form" method="POST" action="index.php">
        <div class="create-conference-form">
            <div class="form-group">
                <label for="conference_category">Select a category:</label><br>
                <select id="conference_category" name="conference_category" class="form-control required">
                    <option>News</option>
                    <option>Politics</option>
                    <option>Science</option>
                    <option>Technology</option>
                    <option>Arts</option>
                    <option>Entertainment</option>
                    <option>Education</option>
                </select>
            </div>
            <div class="form-group">
                <label for="conference_title">Title:</label><br>
                <input type="text" id="conference_title" name="conference_title" tabindex="18" maxlength="255" class="form-control input-lg login-form-input required" />
            </div>
            <div class="form-group">
                <label for="conference_description">Description:</label><br>
                <textarea id="conference_description" name="conference_description" class="form-control required" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="conference_tags">Tags:</label><br>
                <input type="text" id="conference_tags" name="conference_tags" tabindex="18" maxlength="255" class="form-control login-form-input required" />
            </div>
            <div class="form-group">
                <label for="conference_icon">Icon:</label><br>
                <div class="form-inline">
                    <input type="text" id="conference_icon" name="conference_icon" tabindex="18" maxlength="255" class="form-control login-form-input" />
                    <button type="button" id="conference_icon_select" name="conference_icon_select" class="btn btn-default">Choose file</button>
                    <img src="/assets/img/inxys-logo-32.png" width="32" height="32">
                </div>
            </div>
            <div class="form-group">
                <label for="conference_image">Image:</label><br>
                <div class="form-inline">
                    <input type="text" id="conference_image" name="conference_image" tabindex="18" maxlength="255" class="form-control login-form-input" />
                    <button type="button" id="conference_image_select" name="conference_image_select" class="btn btn-default">Choose file</button>
                    <img src="/assets/img/inxys-logo-32.png" width="32" height="32">
                </div>
            </div>
            <div class="form-group">
                <label for="conference_cover_image">Cover image:</label><br>
                <div class="form-inline">
                    <input type="text" id="conference_cover_image" name="conference_cover_image" tabindex="18" maxlength="255" class="form-control login-form-input" />
                    <button type="button" id="conference_cover_select" name="conference_cover_select" class="btn btn-default">Choose file</button>
                    <img src="/assets/img/inxys-logo-32.png" width="32" height="32">
                </div>
            </div>
            <div class="form-group">
                <span id="private-container"><input type="checkbox" tabindex="20" checked="checked" name="is_private" id="is_private"><label for="is_private">Members by invitation only?</label></span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-success" value="loginButton" name="loginButton" id="loginButton">Create</button>
                <input type="hidden" name="all-clear" value="<?php echo($hackerVerification);?>" />
                <input type="hidden" name="action" value="create" />
            </div>
        </div>
    </form>
    <div class="modalMessageArea"></div>
</div>
    <?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>