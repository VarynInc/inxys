<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><img src="/assets/img/inxys-logo-96.png" alt="inxys"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
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
                    $activeClass = $pageId == $pageKey ? 'active' : '';
                    echo('<li class="' . $activeClass . '"><a href="' . $path . '">' . $pageName . '</a></li>');
                }
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li style="margin-top: 0.5em;">
                    <form class="form-inline" method="get" action="/search/">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="search" class="form-control" id="search" name="search" placeholder="search">
                                <span class="input-group-btn"><button type="submit" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button></span>
                            </div>
                        </div>
                    </form>
                </li>
                <?php
                $activeClass = $pageId == 'about' ? 'active' : '';
                echo('<li class="' . $activeClass . '"><a href="/about/">About</a></li>');
                ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
