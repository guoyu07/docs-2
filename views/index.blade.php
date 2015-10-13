<!DOCTYPE html>
<html>
  <head>
    <title>{{ $title }}{{ $base_title }}</title>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.5.0/styles/default.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-44448309-3', 'auto');
      ga('send', 'pageview');
    </script>
  </head>
  <body>
    @include('partials.modals.versions', ['versions' => $versions])
    @include('partials.modals.sidebar', ['sidebar' => $sidebar])
    @include('partials.nav')
    <div class="container docblock">
      <div style="margin-top:10px;" class="row">
        <div class="alert text-center alert-warning">
          <i class="fa fa-warning"></i> This page is currently under construction.<br/>We will update all the missing contents, ASAP!
        </div>
      </div>
      <div style="margin-top:10px;" class="col-sm-12">
        <div class="visible-xs visible-sm">
          <button type="button" class="btn btn-sm btn-default btn-block" data-toggle="modal" data-target="#versionsModal">
            Versions
          </button>
        </div>
      </div>
      <div style="margin-top:10px;" class="col-sm-12">
        <div class="visible-xs visible-sm">
          <button type="button" class="btn btn-sm btn-default btn-block" data-toggle="modal" data-target="#sidebarModal">
            Documentation Lists
          </button>
        </div>
      </div>
      <div class="row">
        <div class="hidden-xs hidden-sm col-md-3 version">
          @include('partials.drop-down-version', ['versions' => $versions])
        </div>
        <div class="col-md-9">
            <h1>{{ str_replace(' - ', '', $title) }}</h1>
        </div>
      </div>
      <div class="row">
        <div class="sidebar hidden-xs hidden-sm col-md-3">
            {!! $sidebar !!}
        </div>
        <div class="article col-md-9 col-sm-12">
            {!! $body !!}
            @include('partials.pagination')
        </div>
      </div>
    </div>
    @include('partials/footer')
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.5.0/highlight.min.js"></script>
    <script src="assets/js/highlightjs-line-numbers.js"></script>
    <script type="text/javascript">
      $(function() {
          $("table").addClass("table table-bordered table-hover");
          $("table").each(function (key, val) {
            $(val).wrapAll("<div class='table table-responsive'>");
          });

          $("pre").each(function (i, block) {
            hljs.highlightBlock(block);
            hljs.lineNumbersBlock(block);
          });

          $(".move-top").click(function(e) {
            e.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, 'fast');
          });
      });
    </script>
  </body>
</html>
