<?php
$nav               = (! isset($nav)) ? 'documentation' : $nav;
$url_frontpage     = (! isset($url_frontpage)) ? 'http://phalconslayer.com' : $url_frontpage;
$url_documentation = (! isset($url_documentation)) ? 'http://phalconslayer.com/docs' : $url_documentation;
$url_slack         = (! isset($url_slack)) ? 'http://phalconslayer.slack.com' : $url_slack;
$url_roadmap       = (! isset($url_roadmap)) ? 'http://phalconslayer.com/roadmap' : $url_roadmap;
?>
<!-- Navigation Bar -->
<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ $url_frontpage }}">S.layer</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-link <?php echo ($nav === 'documentation') ? 'active-slayer' : '' ?>"><a href="{{ $url_documentation }}">Documentation</a></li>
                <li class="nav-link <?php echo ($nav === 'slack') ? 'active-slayer' : '' ?>"><a href="{{ $url_slack }}">Slack</a></li>
                <li class="nav-link <?php echo ($nav === 'roadmap') ? 'active-slayer' : '' ?>"><a href="{{ $url_roadmap }}">Road Map</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav>
