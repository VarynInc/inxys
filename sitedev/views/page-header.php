<?php
    $pageId = isset($pageId) ? $pageId : 'inXys';
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo($pageId);?> | The Information Exchange</title>
    <meta name="description" content="The Information Exchange is a discussion forum to exchange ideas">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">
    <meta name="keywords" content="inxys, The Information Exchange" />
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152.png">
    <link rel="icon" type="image/png" href="/favicon-196.png" sizes="196x196">
    <link rel="icon" type="image/png" href="/favicon-160.png" sizes="160x160">
    <link rel="icon" type="image/png" href="/favicon-96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/favicon-16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/favicon-32.png" sizes="32x32">
    <link rel="shortcut icon" href="/favicon-196.png">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <?php if ($pageId == 'Scratchpad') { ?>
        <link href="/css/bootstrap-markdown.min.css" rel="stylesheet">
    <?php } ?>
</head>
