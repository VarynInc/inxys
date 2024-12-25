<?php
include_once('../../services/inxys_common.php');
$pageId = 'about';
$pageTitle = 'About The Information Exchange';
$pageDescription = 'The Information Exchange: To facilitate the free exchange of ideas and a strong sense of community. Encourage diversity, inclusion, and respect for all.';
$loggedIn = false;

if ( ! $loggedIn) {
    $allToActionButton = ' <a class="btn btn-lg btn-primary" href="/signup/" role="button">Join us &raquo;</a>';
} else {
    $allToActionButton = '';
}

include(VIEWS_ROOT . 'page-header.php');
?>
<body>
<?php include(VIEWS_ROOT . 'top-nav.php');?>
<div class="container main-container">
    <h1>Markdown content formatting</h1>
    <div class="panel">
        <p>We only support markdown for content formatting. HTML tags will be stripped out. Use in content, abstract, description input fields. This is a brief help guide to the markdown syntax. Note that our markdown flavor is mostly similar to standard markdown but we support a few extensions.</p>
        <div class="panel-indent">
            <h2>Titles and headers</h2>
            <p>Define header elements or titles with a leading # at the beginning of a line followed by a space. All text to the end of the line is used for the title.</p>
            <p>
<pre>
# Header 1 title sample
## Header 2 title sample
### Header 3 title sample
#### Header 4 title sample
##### Header 5 title sample
###### Header 6 title sample
</pre>
            </p>
            <div class="md-example">
                <h1>Header 1 title sample</h1>
                <h2>Header 2 title sample</h2>
                <h3>Header 3 title sample</h3>
                <h4>Header 4 title sample</h4>
                <h5>Header 5 title sample</h5>
                <h6>Header 6 title sample</h6>
            </div>
            <p>
                Any header may include attributes `id`, `class`, `attribute` by following the header text with the same level and enclosing the attributes in braces, as follows:
                ## Header 2 ## {#id .class attribute=value}
            </p>
            <h2>Inline text</h2>
            <p>
<pre>
*normal emphasis*
**strong emphasis**
_underline_
~strikeout~
+inserted+
^larger^
$smaller$
> block-quote
`code or fixed-size font`
```language
   /* multi-line code section */
   return $result;
```
</pre>
            </p>
            <div class="md-example">
                <p>This is <em>emphasized text</em> marked by <code>*</code></p>
                <p>This is <strong>emphasized text</strong> marked by <code>**</code></p>
                <p>This is <u>underlined text</u> marked by <code>_</code></p>
                <p>This is <del>deleted text</del> marked by <code>~</code></p>
                <p>This is <ins>inserted text</ins> marked by <code>+</code></p>
                <p>This is <span class="font-size-2">larger text</span> marked by <code>^</code></p>
                <p>This is <span class="small">smaller text</span> marked by <code>$</code></p>
                <p>This is <code>code or fix-font text</code> marked by <code>`</code></p>
                <blockquote>
                    This is a blockquote section marked with <code>&gt;</code> at the beginning of a line.
                </blockquote>
<pre><code class="php">
   /* multi-line code section */
   return $result;
</code></pre>
            </div>
            <h2 id="hyper-links">Hyper-links</h2>
            <p>
<pre>
    [link text](link-url-href "link title")
    [link text](link-url-href "link title"){#id .class attribute=value}
    [link text][link-id]
    [link-id]: https://inxys.net/about/ "Link title"
</pre>
            </p>
            <div class="md-example">
                <p>This is an example <a href="#hyper-links" title="link title">link text</a> hyper-link to another page.</p>
            </div>
            <p>
                Link must be properly enclosed and must be all on a single line.
            </p>
            <h4>Linking to other objects</h4>
            <p>Link to internal objects using the <code>#</code> and dot-syntax. For example:</p>
            <p><code>#C-varyn-1</code> creates a link to conference <code>varyn-1</code>.</p>
            <p><code>#C-varyn-1.14</code> creates a link to topic 14 in conference <code>varyn-1</code>.</p>
            <p><code>#C-varyn-1.14.22</code> creates a link to comment number 22 of topic number 14 in conference <code>varyn-1</code>.</p>
            <h2>Images</h2>
            <p>
                Images are similar to links and indicated with <code>![</code> and the necessary closing tag. Markdown also allows the reference link concept for images.
            </p>
<pre>
    ![img alt text](img-link-url-src "img title")
    ![img alt text](img-link-url-src "img title"){#id .class attribute=value}
    ![img alt text][img-id]
    [img-id]: https://inxys.net/assets/inxys-logo-32.png "Img title"
</pre>
            <div class="md-example">
                <p>This is an example image <img src="https://inxys.net/assets/inxys-logo-32.png" title="Img title" alt="img alt text"> link.</p>
            </div>
            <h2>Lists</h2>
            <p>
            <pre>
- simple
+ simple
* simple
* simple with indented nested list
   * indented nested list
   * indented nested list
* [ ] simple with checkbox
* [X] simple with checked checkbox
1. Numbered
2. [ ] Numbered with checkbox
Definition list term
:   definition description. Note the colon must start at the same indent as the term.
            </pre>
            </p>
            <h2>Tables</h2>
            <p>Tables are setup using the "pipe" <code>|</code> character to delineate the table cells. A table row must begin with <code>|</code>
                and each table row should have the same number of divisions. In the header designation a <code>:</code> character
                indicates the cell justification:
            <ul>
                <li><code>----:</code> right justification</li>
                <li><code>:----</code> left justification</li>
                <li><code>:----:</code> center justification</li>
            </ul>
            <pre>
| Header | Col-2 | Col-3 |
|--------|------:|:------|
| **item-1** | $0.00 | product-id |
| **item-2** | $99 | product-id |
| **item-3** | $22.44 | product-id |
            </pre>
            </p>
            <h2>Footnotes</h2>
            <p>
                That's some text with a footnote.[^1]

                [^1]: And that's the footnote.
            </p>
        </div>
    </div>
</div>
<?php include(VIEWS_ROOT . 'footer.php');?>
</body>
</html>