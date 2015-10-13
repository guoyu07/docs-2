<div id="versionsModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Versions</h4>
      </div>
      <div class="modal-body">
          <ul class="list-unstyled">
          @foreach ($versions as $alias => $version)
            <li style="margin-top:5px;">
              <a class="btn btn-sm btn-default btn-block" href="{{ $version['url'] }}">
                {{ ($version['active']) ? '*' : '' }}&nbsp;{{ $alias }}
              </a>
            </li>
          @endforeach
          </ul>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> --}}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
