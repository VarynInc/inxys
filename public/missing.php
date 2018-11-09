<?php
include_once('../services/common.php');
$pageId = '404';
$pageTitle = '';
?>
<!DOCTYPE html>
<?php include(VIEWS_ROOT . 'page-header.php');?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>Unknown Resource</h1>
    <p>You requested a page that is not available here. Please check your entry.</p>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>