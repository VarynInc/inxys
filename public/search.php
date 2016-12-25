<?php
include_once('../sitedev/services/common.php');
$pageId = 'Search';
$pageTitle = '';
$search = $_REQUEST['search'];
?>
<!DOCTYPE html>
<?php include(VIEWS_ROOT . 'page-header.php');?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>The Information Exchange</h1>
    <h3>Search results for <?php echo($search);?>:</h3>
    <p>Create an account for free. You get one public conference with your free account.</p>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>