<div class="btn-group">
  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    @foreach ($versions as $version => $content)
        @if ($content['active'])
            {{ $version }}
        @endif
    @endforeach
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    @foreach ($versions as $version => $content)
    <li><a href="{{ $content['url'] }}">{{ $version }}</a></li>
    @endforeach
  </ul>
</div>
