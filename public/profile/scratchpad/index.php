<?php
include_once('../../../services/inxys_common.php');
$pageId = 'profile';
$pageSubId = 'scratchpad';
$pageTitle = 'Scratchpad';
$hackerVerification = '';
include(VIEWS_ROOT . 'page-header.php');
redirectIfNotLoggedIn('/');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <div class="row">
        <p>Information messages go here</p>
        <div class="col-12 col-lg-8">
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
                <button type="submit" class="btn btn-success btn-lg">Save</button>
            </form>
        </div>
        <div class="col-12 col-lg-4">
            <h3>Tools</h3>
            <ul>
                <li>Tool 1</li>
                <li>Tool 1</li>
                <li>Tool 1</li>
                <li>Tool 1</li>
            </ul>
            <h3>Drafts</h3>
            <ul>
                <li>Draft 1</li>
                <li>Draft 1</li>
                <li>Draft 1</li>
                <li>Draft 1</li>
            </ul>
        </div>
    </div>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
<script src="/js/markdown.js"></script>
<script src="/js/to-markdown.js"></script>
<script src="/js/bootstrap-markdown.js"></script>
</body>
</html>