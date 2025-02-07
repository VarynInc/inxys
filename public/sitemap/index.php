<?php
include_once('../../services/inxys_common.php');
$pageId = 'home';
$pageTitle = 'Site Map';
$pageDescription = 'Site map index for inXys.net';
include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <div class="card p-4 g-2">
        <div id="sitemap">
<h2>inXys.net Site Map</h2>
<div id="section-inxys">
  <h3>inxys</h3>
  <ul>
<li><a href="/">About The Information Exchange</a> The Information Exchange: To facilitate the free exchange of ideas and a strong sense of community. Encourage diversity, inclusion, and respect for all. </li>

<li><a href="/about/">About The Information Exchange</a> The Information Exchange: To facilitate the free exchange of ideas and a strong sense of community. Encourage diversity, inclusion, and respect for all. </li>

<li><a href="/contact/">About The Information Exchange</a> The Information Exchange: To facilitate the free exchange of ideas and a strong sense of community. Encourage diversity, inclusion, and respect for all. </li>

<li><a href="/privacy/">Privacy policy | inXys.net</a> Privacy policy for inXys.net </li>

<li><a href="/terms/">Terms of use | Inxys.net</a> Terms of use for Inxys.net </li>
  </ul>
</div>
<div id="section-Conferences">
  <h3>Conferences</h3>
  <ul>
<li><a href="/conf/">inXys Conferences</a> The Information Exchange is a discussion forum to exchange ideas </li>

<li><a href="/profile/"></a> undefined</li>
  </ul>
</div>
</div>
    </div>
</div>
<?php
include_once(VIEWS_ROOT . 'footer.php');
?>
</body>
</html>
