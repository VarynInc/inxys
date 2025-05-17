<?php /** scratchpad
 * Manage the logged in users scratchpads.
 * 
 */
include_once('../../../services/inxys_common.php');
require_once('../../../services/strings.php');
require_once('../../../services/scratchpad.php');
$pageId = 'profile';
$pageSubId = 'scratchpad';
$pageTitle = 'Scratchpad';
$hackerVerification = '';
$isNew = true;
$errorCode = EnginesisErrors::NO_ERROR;
include(VIEWS_ROOT . 'page-header.php');
redirectIfNotLoggedIn('/');

$action = getPostOrRequestVar('action', '');
$scratchpadId = getPostInt('scratchpadId', 0);
$sortOrder = getPostInt('sort-order', 0);
$title = getPostVar('title', '');
$tags = getPostVar('tags', '');
$content = getPostVar('content', '');
switch ($action) {
    case 'create':
        $errorCode = createScratchpad($title, $tags, $content, $scratchpadId);
        if ($scratchpadId !== 0) {
            $action = 'update';
        }
        break;
    case 'update':
        $errorCode = updateScratchpad($scratchpadId, $title, $tags, $sortOrder, $content);
        break;
    case 'edit':
        $scratchpadId = getPostOrRequestInt('id', 0);
        $errorCode = getScratchpad($scratchpadId, $title, $tags, $content, $sortOrder);
        if ($errorCode != EnginesisErrors::NO_ERROR) {
            $scratchpadId = 0;
        } else {
            $action = 'update';
        }
        break;
    case 'new':
    default:
        $scratchpadId = 0;
        $sortOrder = 0;
        $title = '';
        $tags = '';
        $content = '';
        $action = 'create';
        break;
}

$submitButtonLabel = $scratchpadId === 0 ? 'Create' : 'Update';
if ($action == '') {
    $action = strtolower($submitButtonLabel);
}
if ($errorCode != EnginesisErrors::NO_ERROR) {
    $informationMessage = $stringTable->lookup($errorCode, null);
    $messageClass = "bg-danger text-white p-2 m-2";
} else {
    $informationMessage = "Begin editing your draft and click create to save it.";
    $messageClass = "bg-info text-white p-2 m-2";
}
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <div class="row">
        <?php showInformationMessage($informationMessage, $messageClass); ?>
        <div class="col-12 col-lg-8">
            <form id="scratchpad-form" method="POST">
                <div class="form-group">
                    <input name="title" type="text" placeholder="Subject" class="form-control" required aria-describedby="subject-form-help" maxlength="80" value="<?php echo($title);?>">
                    <p id="subject-form-help" class="help-block">Enter a title or subject that summarizes your comment.</p>
                </div>
                <div class="form-group">
                    <textarea name="content" class="form-control" data-provide="markdown" rows="20" data-autofocus="true"><?php echo($content);?></textarea>
                </div>
                <div class="form-group">
                    <input name="tags" type="text" placeholder="Tags" class="form-control" aria-describedby="tags-form-help" value="<?php echo($tags);?>"/>
                    <p id="tags-form-help" class="help-block">Enter search keywords to quickly locate your comment with search. Separate each entry with a semi-colon (;).</p>
                </div>
                <button type="submit" class="btn btn-success btn-lg"><?php echo($submitButtonLabel);?></button>
                <input type="hidden" name="sort-order" id="sort-order" value="<?php echo($sortOrder);?>"/>
                <input type="hidden" name="scratchpadId" id="scratchpadId" value="<?php echo($scratchpadId);?>"/>
                <input type="hidden" name="action" id="action" value="<?php echo($action);?>"/>
            </form>
        </div>
        <div class="col-12 col-lg-4">
            <button class="btn btn-success btn-sm" id="new-scratchpad">New scratchpad</button></li>
            <?php listScratchpads(); ?>
        </div>
    </div>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
<script src="/js/markdown.js"></script>
<script src="/js/to-markdown.js"></script>
<script src="/js/scratchpad.js"></script>
</body>
</html>
