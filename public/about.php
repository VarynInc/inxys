<?php
include_once('../sitedev/services/common.php');
$pageId = 'about';
$pageTitle = '';
?>
<!DOCTYPE html>
<?php include(VIEWS_ROOT . 'page-header.php');?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>About The Information Exchange</h1>
    <blockquote><i>
            To facilitate the free exchange of ideas
            and a strong sense of community.
            Encourage diversity, inclusion,
            and respect for all.
        </i></blockquote>
    <p>Create an account for free. You get one public conference with your free account.</p>
    <p>
        <a href="/terms.php" target="_new" class="right">Terms of service</a> |
        <a href="/privacy.php" target="_new" class="right">Privacy policy</a>
    </p>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>