<?php
include_once('../../../services/inxys_common.php');
$pageId = 'about';
$pageTitle = 'About The Information Exchange';
$pageDescription = 'The Information Exchange: To facilitate the free exchange of ideas and a strong sense of community. Encourage inclusion, diversity, and respect for all.';
include(VIEWS_ROOT . 'page-header.php');
?>
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
    <div class="md-example">
        <h1>Writing style and formatting</h1>
        <p>Listed here are the various writing styles, formatting helpers, and markdown syntax to help you take advantage of The Information Exchange styling.</p>
    </div>
    <div class="md-example">
        <h2>Contents</h2>
        <ul class="toc">
            <li><a href="#headings">Headings</a></li>
            <li><a href="#text">Text</a></li>
            <li><a href="#lists">Lists</a></li>
            <li><a href="#links">Links</a></li>
            <li><a href="#sections">Sections</a></li>
            <li><a href="#images">Images</a></li>
            <li><a href="#misc">Other</a></li>
        </ul>
    </div>
    <div class="md-example">
        <h3 id="headings">Headings</h3>
        <p>Headings begin at the first character of a line with #. The number of consecutive # determine the heading level, from 1 to 6. There must be a space between the last # and the heading text.</p>
        <h1>Heading level 1</h1>
        <h2>Heading level 2</h2>
        <h3>Heading level 3</h3>
        <h4>Heading level 4</h4>
        <h5>Heading level 5</h5>
        <h6>Heading level 6</h6>
    </div>
    <div class="md-example">
        <h3 id="text">Text</h3>
        <p>A paragraph begins with a blank line between lines of text.</p>
        <p>Quoted text, block quote: <q>This is a quote.</q></p>
        <p>Style bold: <strong>bold text</strong></p>
        <p>Style bold: __bold text__</p>
        <p>Style italic text: *italic text*</p>
        <p>Style italic text: _italic text_</p>
        <p>Style bold italic text: **_bold italic text_**</p>
        <p>Strike-through or deleted text: ~~deleted text~~</p>
        <p>Larger font text: ++increased font size++</p>
        <p>Smaller font text: --decreased font size--</p>
        <p class="text-primary">.text-primary</p>
        <p class="text-secondary">.text-secondary</p>
        <p class="text-success">.text-success</p>
        <p class="text-danger">.text-danger</p>
        <p class="text-warning">.text-warning</p>
        <p class="text-info">.text-info</p>
        <p class="text-light bg-dark">.text-light</p>
        <p class="text-dark">.text-dark</p>
        <p class="text-muted">.text-muted</p>
        <p class="text-white bg-dark">.text-white</p>
        <div class="p-3 mb-2 bg-primary text-white">.bg-primary</div>
        <div class="p-3 mb-2 bg-secondary text-white">.bg-secondary</div>
        <div class="p-3 mb-2 bg-success text-white">.bg-success</div>
        <div class="p-3 mb-2 bg-danger text-white">.bg-danger</div>
        <div class="p-3 mb-2 bg-warning text-dark">.bg-warning</div>
        <div class="p-3 mb-2 bg-info text-white">.bg-info</div>
        <div class="p-3 mb-2 bg-light text-dark">.bg-light</div>
        <div class="p-3 mb-2 bg-dark text-white">.bg-dark</div>
        <div class="p-3 mb-2 bg-white text-dark">.bg-white</div>
    </div>
    <div class="md-example">
        <h3 id="lists">Lists</h3>
        <p>Lists and nested lists.</p>
        <p>First character on the line is one of +, -, *, followed by a space and some text.</p>
        <p>Ordered (numbered) lists begin with a number followed by a period, followed by a space and some text.</p>
    </div>
    <div class="md-example">
        <h3 id="links">Links</h3>
        <p>A link is defined by including the link text inside [], and immediately followed by the link URL inside ().</p>
        <p>This is an example: [The Information Exchange](https://inxys.net/about.php)</p>
        <p>Link to another topic: [#topic-id]. The topic title will be automatically generated as the link text.</p>
        <p>Link to another topic'c comment: [#topic-id/comment-id]. The comment title will be automatically generated as the link text.</p>
        <p>Link to a user: @user-id. The user name will be automatically generated as the link text and linked to that user's profile page.</p>
    </div>
    <div class="md-example">
        <h3 id="sections">Sections</h3>
        <p>Include a section break</p>
        <p>Three dashes with a blank line before and after.</p>
    </div>
    <div class="md-example">
        <h3 id="images">Images</h3>
        <p>Images are similar to links only begin with !.</p>
        <p>This is an example: <code>![The image caption](https://inxys.net/images/inxys-logo-96.png)</code> <img src="https://inxys.net/images/inxys-logo-96.png"></p>
        <p>Use modifiers to indicate image justification and size.</p>
        <p>This is an example image left justified 50x50: <code>!l50x50[The image caption](https://inxys.net/images/inxys-logo-96.png)</code></p>
        <p>This is an example image right justified 50x100: <code>!r50x100[The image caption](https://inxys.net/images/inxys-logo-96.png)</code></p>
    </div>
    <div class="md-example">
        <h3 id="misc">Other formatting options</h3>
        <p>Mono-spaced text.</p>
        <p>Code.</p>
    </div>
    <div>
        <p>
            <a href="/terms.php" target="_new" class="right">Terms of service</a> |
            <a href="/privacy.php" target="_new" class="right">Privacy policy</a>
        </p>
    </div>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>
