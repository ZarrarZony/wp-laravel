    <div class="newsLetter">
      <div class="flexWrapper">
      <h4>Demo content</h4>
        <p>Demo content2</p>
        <div class="subscribeBox">
          <form>
            <input type="email" placeholder="Enter your valid email" required="">
            <button type="submit">Subscribe</button>
          </form>
          <p class="successful">Congratulations! You’ll be the first to receive our latest Vouchers & Deals.</p>
        </div>
      </div>
    </div>
    <footer class="footer">
      <div class="quickLinks">
        <div class="flexWrapper">
          <div class="footerLinks">
            <h5>SPECIALTY PAGES</h5>
            <ul>
            <li><a href="javascrip:;">link1</a></li>
            <li><a href="javascrip:;">link2</a></li>
            <li><a href="javascrip:;">link3</a></li>
            </ul>
          </div>
          <div class="footerLinks">
            <h5>CONNECT</h5>
            <ul>
            <li><a href="javascrip:;">link1</a></li>
            <li><a href="javascrip:;">link2</a></li>
            <li><a href="javascrip:;">link3</a></li>
            </ul>
          </div>
          <div class="footerLinks resFooterMenu">
            <h5>GENERAL</h5>
            <ul>
            <li><a href="javascript:;">link1</a></li>
            <li><a href="javascript:;">link2</a></li>
            <li><a href="javascript:;">link3</a></li>
            </ul>
          </div>
        </div>
        <div class="flexWrapper">
          <div class="social">
            <h5>Follow us</h5>
            <a href="javascript:;"><i class="lm_facebook"></i></a>
            <a href="javascript:;"><i class="lm_twitter"></i></a>
            <a href="javascript:;"><i class="lm_linkedin"></i></a>
            <a href="javascript:;"><i class="lm_pinterest"></i></a>
          </div>
          <div class="copyright">
            <p>© 2019 All Rights Reserved. Terms of Use Privacy Statement Licenses</p>
          </div>
        </div>
      </div>
    </footer>   
    </div>

    <script async src="{{ asset('build/js/all.js') }}"></script>
  </body>
</html>



<?php
$ob_get_clean_css = ob_get_clean();

$cssmain  = preg_replace(array('/ {2,}/','/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'),array(' ',''),$ob_get_clean_css);

echo $cssmain;
?>