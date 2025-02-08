<?php
    $pageId = isset($pageId) ? $pageId : 'inXys';
    if ( ! isset($pageTitle)) {
        $pageTitle = $pageId . ' | The Information Exchange';
    }
    if ( ! isset($pageDescription)) {
        $pageDescription = 'The Information Exchange is a discussion forum to exchange ideas';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo($pageTitle);?></title>
    <meta name="description" content="<?php echo($pageDescription);?> ">
    <meta name="author" content="">
    <meta name="keywords" content="inxys, The Information Exchange" />
    <link rel="icon" href="/favicon.ico">
    <link rel="shortcut icon" href="/assets/196.png">
    <link rel="icon" type="image/png" href="/assets/512.png" sizes="512x512">
    <link rel="icon" type="image/png" href="/assets/250.png" sizes="250x250">
    <link rel="icon" type="image/png" href="/assets/196.png" sizes="196x196">
    <link rel="icon" type="image/png" href="/assets/192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/assets/160.png" sizes="160x160">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/152.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/144.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/120.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/114.png">
    <link rel="icon" type="image/png" href="/assets/96.png" sizes="96x96">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/76.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/72.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/60.png">
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/57.png">
    <link rel="icon" type="image/png" href="/assets/32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/assets/16.png" sizes="16x16">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="msapplication-TileImage" content="/assets/144.png">
    <link href="/assets/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/main.css" rel="stylesheet">
    <?php if ($pageId == 'Scratchpad') { ?>
        <link href="/assets/bootstrap-markdown.min.css" rel="stylesheet">
    <?php } ?>
    <script src="/js/enginesis.js" type="module"></script>
    <script type="application/ld+json">
    {
      "@context" : "https://schema.org",
      "@type" : "WebSite",
      "name" : "The Information Exchange",
      "alternateName" : "inXys",
      "url" : "https://inxys.net/",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "https://inxys.net/search/?q={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ENBPFCKMEZ"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-ENBPFCKMEZ');
    </script>
</head>
