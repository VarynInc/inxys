
<?php
include_once('../../services/common.php');
$pageId = 'offline';
$pageTitle = '';
?>
<!DOCTYPE html>
<?php include(VIEWS_ROOT . 'page-header.php');?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <div class="jumbotron">
        <h1>The Information Exchange</h1>
        <?php echo(ADMIN_LOCK_MESSAGE);?>
    </div>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>