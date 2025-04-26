<?php
include_once('../../../services/inxys_common.php');
$pageId = 'profile';
$pageSubId = 'edit';
$pageTitle = 'Edit Profile';
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
            <form id="edit-profile-form" method="POST">
                user-name, email, real-name, bio
                <button type="submit" class="btn btn-success btn-lg">Update</button>
            </form>
        </div>
        <div class="col-12 col-lg-4">
            <h3>Profile</h3>
        </div>
    </div>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>
