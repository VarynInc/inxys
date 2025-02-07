<?php
include_once('../../services/inxys_common.php');
$pageId = '{pagename}';
$pageTitle = '{pagetitle}';
$pageDescription = '{pagedescription}';
include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <div class="card p-4 g-2">
        {pagecontent}
    </div>
</div>
<?php
include_once(VIEWS_ROOT . 'footer.php');
?>
</body>
</html>
