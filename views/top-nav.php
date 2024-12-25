<div class="navbar navbar-default navbar-static-top navbar-expand-sm navbar-light bg-light" role="navigation">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="/assets/inxys-logo-96.png" alt="inxys"></a>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php
                foreach($allMenuPages as $menuItem) {
                    $pageKey = $menuItem['id'];
                    $pageName = $menuItem['name'];
                    $path = $menuItem['path'];
                    if ($pageKey == 'profile' && ! $isLoggedIn) {
                        $pageKey = 'signup';
                        $pageName = 'Sign up';
                        $path = '/' . $pageKey . '/';
                    }
                    $activeClass = $pageId == $pageKey ? ' active' : '';
                    echo('<li class="nav-item navbar-item' . $activeClass . '"><a class="nav-link" href="' . $path . '">' . $pageName . '</a></li>');
                }
            ?>
            </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li style="margin-top: 0.5em;">
                        <form class="form-inline" method="get" action="/search/">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="search" class="form-control" id="search" name="q" placeholder="search">
                                    <span class="input-group-btn"><button type="submit" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button></span>
                                </div>
                            </div>
                        </form>
                    </li>
                    <?php
                    $activeClass = $pageId == 'about' ? ' active' : '';
                    echo('<li class="nav-item navbar-item' . $activeClass . '"><a class="nav-link" href="/about/">About</a></li>');
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
