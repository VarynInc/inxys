<?php
include_once('../../services/inxys_common.php');
$pageId = 'conferences';
$pageTitle = 'inXys Conferences';
include(VIEWS_ROOT . 'page-header.php');
?>
  <style>
    #profile-img {
      width: 100%;
      height: 100%;
      padding: 0;
      margin: 0;
    }

    .conference-panel {
    }

    .conference-panel h2 {
      margin: 0.5rem 0;
      font-weight: 600;
    }

    .conference-panel h3 {
      margin: 0.5rem 0;
      font-weight: 600;
    }

    .conference-panel h5 {
      margin: 0.5rem 0;
    }

    .conference-details {
      font-style: italic;
      font-size: 1rem;
      color: lightgray;
    }

    .comment-date {
      font-style: italic;
      font-size: 0.8rem;
      color: lightgray;
    }

    .conference-last-comment {
      background-color: #7da8d8;
    }

    .conference-last-comment h5 {
      font-style: italic;
      font-weight: 400;
    }

    .conference-last-comment p {
      margin: 0.5rem 0;
    }
  </style>

<body class="claro">
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
  <div class="grid-container">
    <div class="column-24">
      <h1 class="leader-1">Conferences</h1>
      <p>Conferences you are a member of and recent activity:</p>
      <div class="panel panel-default conference-group trailer-1">
        <h2>Your favorite conferences</h2>

        <div class="panel panel-light-blue conference-panel trailer-half text-white">
          <div class="column-6 tablet-column-4 phone-column-4">
            <a href="#"><img src="/img/power-of-maps.jpg" alt="The power of maps"/></a>
          </div>
          <div class="column-15 tablet-column-9 phone-column-5">
            <h2><a href="#" class="link-white">The power of maps</a></h2>
            <h5>The power of maps discusses cartography, map design, and styling maps. We plan to curate maps we find interesting, unique, or powerful.</p>
            <p class="conference-details">50 comments, 76 replies: 0 new</p>
          </div>
          <div class="column-20 conference-last-comment">
            <h5>Latest comment</h5>
            <p><img class="user-avatar-small" src="/img/avatars/user-f.png" /> <span class="user-name">Jane Dorchester</span> &middot; <span class="comment-date">22-Mar-2016 7:03 AM</span></p>
            <p>This is an abstract of the last comment by jane. We would put up to three lines of text here. This is an abstract of the last comment with to three lines of text here. This is an abstract of the last comment by user name. We would put up to three lines of text here. <a href="#">read more...</a></p>
          </div>
          <div class="column-20">
            <nav>
              <a class="icon-ui-arrow-right-circled btn btn-clear-white">Read</a> <a class="btn btn-clear-white">Mark All Read</a> <a class="btn btn-clear-white">Manage</a> <a class="btn btn-clear-white">New Comment</a> <a class="btn btn-clear-white">Leave</a>
            </nav>
          </div>
        </div>

        <div class="panel panel-blue conference-header trailer-half">
          <img class="left" src="/img/power-of-maps.jpg" alt="">
          <h2>Conference title</h2>
          <p class="conference-subtitle">Conference subtitle or a description of the conference purpose.</p>
          <p>50 comments, 76 replies</p>
          <h5>Last comment</h5>
          <p>by User name on 7/22/2016 at 7:03 AM</p>
          <p>Abstract of last comment by user name.</p>
        </div>
        <div class="panel panel-blue conference-header trailer-half">
          <img class="left" src="/img/power-of-maps.jpg" alt="">
          <h2>Conference title</h2>
          <p class="conference-subtitle">Conference subtitle or a description of the conference purpose.</p>
          <p>50 comments, 76 replies</p>
          <h5>Last comment</h5>
          <p>by User name on 7/22/2016 at 7:03 AM</p>
          <p>Abstract of last comment by user name.</p>
        </div>
      </div>
      <div class="panel panel-default conference-group trailer-1">
        <h2>Conferences you are a member of</h2>
        <div class="panel panel-blue conference-header trailer-half">
          <img class="left" src="/img/power-of-maps.jpg" alt="">
          <h2>Conference title</h2>
          <p class="conference-subtitle">Conference subtitle or a description of the conference purpose.</p>
          <p>50 comments, 76 replies</p>
          <h5>Last comment</h5>
          <p>by User name on 7/22/2016 at 7:03 AM</p>
          <p>Abstract of last comment by user name.</p>
        </div>
        <div class="panel panel-blue conference-header trailer-half">
          <img class="left" src="/img/power-of-maps.jpg" alt="">
          <h2>Conference title</h2>
          <p class="conference-subtitle">Conference subtitle or a description of the conference purpose.</p>
          <p>50 comments, 76 replies</p>
          <h5>Last comment</h5>
          <p>by User name on 7/22/2016 at 7:03 AM</p>
          <p>Abstract of last comment by user name.</p>
        </div>
        <div class="panel panel-blue conference-header trailer-half">
          <img class="left" src="/img/power-of-maps.jpg" alt="">
          <h2>Conference title</h2>
          <p class="conference-subtitle">Conference subtitle or a description of the conference purpose.</p>
          <p>50 comments, 76 replies</p>
          <h5>Last comment</h5>
          <p>by User name on 7/22/2016 at 7:03 AM</p>
          <p>Abstract of last comment by user name.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="panel panel-blue panel-no-border panel-no-padding">
    <div class="grid-container padding-leader-1">
      <div class="column-24">
        <h2 class="text-white text-rule padding-trailer-half">Public conferences</h2>
        <div class="block-group  block-group-4-up tablet-block-group-2-up phone-block-group-1-up">
          <div class="block trailer-1">
            <div class="panel panel-light-blue">
              <a href=""><img src="/img/power-of-maps.jpg" alt=""></a>
              <h5 class="leader-1">A project</h5>
              <a href="">Check it out <span class="icon-ui-right icon-ui-small"></span></a>
            </div>
          </div>
          <div class="block trailer-1">
            <div class="panel panel-light-blue">
              <a href=""><img src="/img/power-of-maps.jpg" alt="We Use GIS"></a>
              <h5 class="leader-1">Another Project</h5>
              <a href="">Check it out <span class="icon-ui-right icon-ui-small"></span></a>
            </div>
          </div>
          <div class="block trailer-1">
            <div class="panel panel-light-blue">
              <a href=""><img src="/img/power-of-maps.jpg" alt=""></a>
              <h5 class="leader-1">Sample Project</h5>
              <a href="">Check it out <span class="icon-ui-right icon-ui-small"></span></a>
            </div>
          </div>
          <div class="block trailer-1">
            <div class="panel panel-light-blue">
              <a href=""><img src="/img/power-of-maps.jpg" alt=""></a>
              <h5 class="leader-1">Go here</h5>
              <a href="">Go there <span class="icon-ui-right icon-ui-small"></span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>