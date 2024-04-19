<?php
include_once('../../services/inxys_common.php');
$pageId = 'search';
$pageTitle = '';
$search = getPostOrRequestVar(['q', 'search'], '');
include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>The Information Exchange</h1>
    <h3>Search results for <?php echo($search);?>:</h3>
    <p class="text-danger">No results found for <em><?php echo($search);?></em>.</p>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>