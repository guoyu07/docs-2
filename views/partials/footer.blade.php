<div class="footer">
  <div class="mail-stripe"></div>
  <div class="content col-md-12">
    <div class="row text-center">
      <div class="links">
        <ul class="links-ul list-inline">
          <li><a target="_blank" href="http://phalconphp.com">Phalcon</a></li>
          <li>|</li>
          <li><a target="_blank" href="http://www.roadmunk.com/">Roadmunk</a></li>
        </ul>
      </div>
      <hr>
      <div class="copyright">
        <span>Copyright &copy; 2016 <a target="_blank" href="https://daisoncarino.com">Daison Cariño</a></span>
      </div>
      <div class="designed-by">
        <span>Designed By: <a target="_blank" href="http://napoleon.vyew.me">Napoleon Cariño</a></span>
      </div>
      @if (defined('SLAYER_START'))
        <div class="processing-time">
          <span>Server Speed: <?php echo processing_time(SLAYER_START) ?></span>
        </div>
      @endif
    </div>
  </div>
</div>
