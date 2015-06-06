<?php
/*
 * template for taxonomy listings
 */
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php
  $nodeurl = 'node/' . $node->nid;
  $thisalias = drupal_get_path_alias($nodeurl);
  if (is_localhost()) {
    $thisurl = "/literarykicks/" . $thisalias;
  } else {
    $thisurl = "/" . $thisalias;
  }
  $titlelink = '<a href="' . $thisurl . '">' . $title . '</a>';
  $author = $node->name;
  $createdate = format_date($node->created, 'custom', "F jS, Y");
  if (empty($node->field_story_image)) {
    $img = '<a href="' . $thisurl . '"><img src="http://litkicks.com/images/pv_good.gif" width="190" height="120" /></a>';
  } else {
    $img = '<a href="' . $thisurl . '"><img src="http://litkicks.com/sites/default/files/' . $node->field_story_image['und'][0]['filename'] . '" /></a>';
  }
  ?>

  <div class="col-xs-12 col-sm-12 hidden-md hidden-lg hidden-xl lklisting-item">
    <div class="lklisting-title"><?php print $titlelink ?></div>
    <div class="lklisting-pic"><?php print $img ?></div>
    <div class="lklisting-date"><?php print $createdate ?></div>
    <div class="lklisting-author">by <?php print $author ?></div>
  </div>
  <div class="hidden-xs hidden-sm col-md-12 col-lg-12 col-xl-12 lklisting-item">
    <table>
      <tr>
        <td class="lklisting-pic">
          <?php print $img ?>
        </td>
        <td class="lklisting-desc">
          <div class="lklisting-title"><?php print $titlelink ?></div>
          <div class="lklisting-date"><?php print $createdate ?></div>
          <div class="lklisting-author">by <?php print $name ?></div>
        </td>
      </tr>
    </table>
  </div>
</div>
