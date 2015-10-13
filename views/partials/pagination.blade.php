<div style="margin-top:3em" class="row">
  <div class="col-md-4">
    @if (isset($link['previous']))
    <a class="btn btn-link pull-left"><i class="fa fa-angle-double-left"></i>&nbsp;Previous</a>
    @endif
  </div>
  <div class="text-center col-md-4">
    <a class="move-top" style="font-size:2.5em;" href="#"><i class="fa fa-arrow-circle-o-up"></i></a>
  </div>
  <div class="col-md-4">
    @if (isset($link['next']))
    <a class="btn btn-link pull-right">Next&nbsp;<i class="fa fa-angle-double-right"></i></a>
    @endif
  </div>
</div>
