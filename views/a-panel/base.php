<!DOCTYPE html>
<html>
  <head>
    <title><?php echo isset($title) ? $title : 'A-panel' ?></title>
    <link rel="stylesheet" type="text/css" href="/css/a-panel/style.css">
    <link rel="stylesheet" type="text/css" href="/css/plugins.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="/js/a-panel/script.js"></script>
    <script type="text/javascript" src="/js/plugins.js"></script>
    <script type="text/javascript">
      tinymce.init({
        selector: '.tinymce',
        plugins: [
          'advlist autolink lists link image charmap print preview hr anchor pagebreak',
          'searchreplace wordcount visualblocks visualchars code fullscreen',
          'insertdatetime media nonbreaking save table contextmenu directionality',
          'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'ltr rtl | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | fontsizeselect forecolor backcolor emoticons',
        height : '480'
      });
    </script>
  </head>
  <body>
    <div id="top-wrapper">
      <div id="top">
        <div id="site-information">
          <div>Module</div>
          <div>Administration panel</div>
        </div>
        <a id="logout" href="/a-panel/logout">Exit</a>
      </div>
    </div>
    <div id="wrapper">
      <div id="sidebar">
        <ul>
          <li class="header">Sections</li>
          <li>
            <a href="/a-panel/cuttingTypes"<?php if (preg_match('/^\/a-panel\/cuttingTypes/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Cutting types</a>
          </li>
          <li>
            <a href="/a-panel/materialSizes"<?php if (preg_match('/^\/a-panel\/materialSizes/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Material sizes</a>
          </li>
          <li>
            <a href="/a-panel/materialCategories"<?php if (preg_match('/^\/a-panel\/materialCategories/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Material categories</a>
          </li>
<!--          <li>
            <a href="/a-panel/materials"<?php //if (preg_match('/^\/a-panel\/materials/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php //endif; ?>>Materials</a>
          </li>-->
          <li>
            <a href="/a-panel/options"<?php if (preg_match('/^\/a-panel\/options/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Options</a>
          </li>
          <li>
            <a href="/a-panel/specialties"<?php if (preg_match('/^\/a-panel\/specialties/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Specialties</a>
          </li>
          <li>
            <a href="/a-panel/orders"<?php if (preg_match('/^\/a-panel\/orders/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Orders</a>
          </li>
          <li>
            <a href="/a-panel/bids"<?php if (preg_match('/^\/a-panel\/bids/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Not payed bids</a>
          </li>
          <li>
            <a href="/a-panel/publicFiles"<?php if (preg_match('/^\/a-panel\/publicFiles/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Public files</a>
          </li>
          <li>
            <a href="/a-panel/mailing"<?php if (preg_match('/^\/a-panel\/mailing/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Mailing</a>
          </li>
          <li>
            <a href="/a-panel/couponMailing"<?php if (preg_match('/^\/a-panel\/couponMailing/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Coupon mailing</a>
          </li>
          <li>
            <a href="/a-panel/deliverTime"<?php if (preg_match('/^\/a-panel\/deliverTime/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Deliver time</a>
          </li>
          <li>
            <a href="/a-panel/users"<?php if (preg_match('/^\/a-panel\/users/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Users</a>
          </li>
          <li>
            <a href="/a-panel/prompts"<?php if (preg_match('/^\/a-panel\/prompts/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Prompts</a>
          </li>
          <li>
            <a href="/a-panel/emailEvents"<?php if (preg_match('/^\/a-panel\/emailEvents/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Email events</a>
          </li>
          <li>
            <a href="/a-panel/smsEvents"<?php if (preg_match('/^\/a-panel\/smsEvents/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Sms events</a>
          </li>
          <li>
            <a href="/a-panel/cities"<?php if (preg_match('/^\/a-panel\/cities/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>Cities</a>
          </li>
          <li>
            <a href="/a-panel/ipData"<?php if (preg_match('/^\/a-panel\/ipData/', $_SERVER['REQUEST_URI'])) : ?> class="active"<?php endif; ?>>IP data</a>
          </li>
        </ul>
      </div>
      <div id="content">
        <?php if (isset($content)) : ?><?php echo $content ?><?php endif; ?>
      </div>
      <div class="clear"></div>
    </div>
  </body>
</html>