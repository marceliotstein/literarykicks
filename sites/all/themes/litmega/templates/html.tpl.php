<?php print $doctype; ?>
<html lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf->version . $rdf->namespaces; ?>>
<head<?php print $rdf->profile; ?>>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>  
  <?php print $styles; ?>
  <!--blogads chapter teasers-->
  <!-- REMOVED wrong ad size 
  <link rel="stylesheet" type="text/css" href="http://cache.blogads.com/984341751/feed.css" />
  <script language="javascript" src="http://cache.blogads.com/984341751/feed.js"></script>
  -->
  <!--end blogads chapter teasers-->
  <?php print $scripts; ?>
  <script src="
  <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

  <script type="text/javascript">

    jQuery(document).ready(function() {

      // all links open new window
      jQuery('a[href^=http]').attr('target','_blank');

      // pretty round corners
      jQuery('blockquote').corner('7px');
      jQuery('#region-content').corner('14px');
      jQuery('#region-content article').corner('14px');
      jQuery('.front #region-content .block-lkfront-block').corner('14px');
      jQuery('#region-sidebar-second article').corner('14px');
      jQuery('#region-sidebar-second .commentfeed').corner('14px');
      jQuery('#region-sidebar-second .apfeed').corner('14px');
      jQuery('div#comments').corner('11px');

      // dumb hack because IE can't handle search form-text corner
      var browser_is_ie = false;
      jQuery.each(jQuery.browser, function(i, val) {
         //alert("browser is " + i + " = " + val);
         if (i=="msie") {
            browser_is_ie = true;
         }
      });
      if (browser_is_ie==false) {
         jQuery('#search-block-form .form-text').corner('9px');
      }

      // show stuff
      jQuery('#zone-branding').show();
      jQuery('#zone-header').show();
      jQuery('#zone-content').show();
      jQuery('#region-footer-first').show();
    });
  </script>

</head>
</head>
<body<?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
</html>
