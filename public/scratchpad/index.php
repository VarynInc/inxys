<?php
include_once('../../services/common.php');
$pageId = 'scratchpad';
$pageTitle = 'Scratchpad';
$hackerVerification = '';
?>
<!DOCTYPE html>
<?php include(VIEWS_ROOT . 'page-header.php');?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <form id="scratchpad-form" method="POST">
        <div class="form-group">
            <input name="title" type="text" placeholder="Subject" class="form-control" required aria-describedby="subject-form-help">
            <p id="subject-form-help" class="help-block">Enter a title or subject that summarizes your comment.</p>
        </div>
        <div class="form-group">
            <textarea name="content" class="form-control" data-provide="markdown" rows="20" data-autofocus="true"></textarea>
        </div>
        <div class="form-group">
            <input name="tags" type="text" placeholder="Tags" class="form-control" aria-describedby="tags-form-help">
            <p id="tags-form-help" class="help-block">Enter search keywords to quickly locate your comment with search. Separate each entry with a semi-colon (;).</p>
        </div>
        <div class="checkbox">
            <label>
                <input name="publish" type="checkbox"> Save as draft
            </label>
        </div>
        <button type="submit" class="btn btn-success btn-lg">Submit</button>
        </div>
    </form>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
<script src="/js/markdown.js"></script>
<script src="/js/to-markdown.js"></script>
<script src="/js/bootstrap-markdown.js"></script>
</body>
</html>