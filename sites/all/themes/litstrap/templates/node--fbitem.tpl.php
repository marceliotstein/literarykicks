<?php
//
// custom display for either sidebar or main content display of FBItem node (Facebook feed)
//
?>

<script type="text/javascript">
// for fbitem page type, don't show page title
jQuery(document).ready(function() {
  jQuery('#page-title').hide();
});
</script>

<article<?php print $attributes; ?>>

<?php
if (!$teaser) {
  // this is the main article byline display
  ?>
  <br />
  <footer class="submitted">From <i><a href="http://facebook.com/litkicks">Litkicks on Facebook</a></i> on <?php print $date; ?></footer>
  <?php
}
?>
<div class="fbitem-title" >
  <?php
  hide($content['comments']);
  hide($content['links']);
  hide($content['field_big_picture']);
  hide($content['field_little_picture']);
  hide($content['field_facebook_post_id']);
  hide($content['field_target_link']);
  print render($content);
  ?>
</div>

<?php
$fbtgt = null;
$abs_img_url = $node->field_big_picture['und'][0]['value'];

// quick and dirty relativization
global $base_url;
$abs_exp = explode("/sites/default/files",$abs_img_url);
if (!empty($abs_exp[1])) {
  $fbimg = "<img src=\"" . $base_url . "/sites/default/files" . $abs_exp[1];
}

if (!empty($node->field_target_link)) {
  $fbtgt = $node->field_target_link['und'][0]['value'];
  $fbtgtimg = "<center><a href=\"" . $fbtgt . "\">" .  $fbimg . "</a></center>";
} else {
  $fbtgtimg = "<center>" .  $fbimg . "</center>";
}
?>

<div<?php print $content_attributes; ?>>
<?php
print_r($fbtgtimg);
?>
<center><div id="fb-apres" width="500">
  <?php
  if ($fbtgt!=null) {
    ?>
    <br /><br />
    <h3><a href="<?php print $fbtgt ?>">Visit site</a></h3>
    <?php
  }
  ?>
  <hr width="100%" height="3px" noshade color="#000000">
  <i><b><a href="http://facebook.com/litkicks">Like us</a></b> to see these updates every day on Facebook.</i><br /><br />
  <hr width="100%" height="3px" noshade color="#000000">
</div>
</center>
</div>

</article>
